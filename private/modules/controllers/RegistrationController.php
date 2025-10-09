<?php
declare(strict_types=1);

final class RegistrationController
{
    private UserModel $userModel ;

    public function __construct()
    {
        $this->userModel  = new UserModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            return $this->store();
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            return $this->create();
        }
        else
        {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }
    }

    public function create(): void
    {
        Auth::requireGuest();

        // Consomme les flashs
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));

        try {
            require_once __DIR__ . '/../models/SpecializationModel.php';
            $specModel = new SpecializationModel();
            $specializations = $specModel->getPairs();
        } catch (Throwable $e) {
            error_log('[RegistrationController::create] Failed to fetch specializations: ' . $e->getMessage());
            $errors = array_filter(array_merge((array)$errors, ['Impossible de charger la liste des spécialisations.']));
            $specializations = []; // la vue affichera au moins l’option vide
        }

        // Les variables $specializations, $old et $errors seront accessibles dans la vue ci-dessous
        require dirname(__DIR__) . '/views/register.php';
    }

    public function store(): void
    {
        Csrf::requireValid('/auth/register', true);

        // 1) Inputs + normalisation via Inputs
        $firstname = Inputs::sanitizeName($_POST['firstname'] ?? '');
        $lastname  = Inputs::sanitizeName($_POST['lastname'] ?? '');
        $username  = Inputs::sanitizeUsername($_POST['username'] ?? '');
        $email     = Inputs::sanitizeEmail($_POST['email'] ?? '');

        // La spécialisation est un ID (nullable)
        $specializationId = Inputs::sanitizeIntId($_POST['specialization'] ?? '');

        // On n'enregistre JAMAIS le mot de passe en "old"
        $password  = (string)($_POST['password'] ?? '');
        $password2 = (string)($_POST['password_confirm'] ?? '');
        $termsAccepted = isset($_POST['terms']) && $_POST['terms'] === 'on';

        // Flash old (versions normalisées, car c'est ce qui sera stocké en DB)
        +Flash::set('old', [
            'firstname'      => $firstname,
            'lastname'       => $lastname,
            'username'       => $username,
            'email'          => $email,
            'specialization' => $_POST['specialization'] ?? '', // garder la valeur brute pour le <select>
        ]);

        // 2) Validations alignées sur la BD (via Inputs)
        $errors = [];

        // Vérifier l'acceptation des conditions
        if (!$termsAccepted) {
            $errors[] = 'Vous devez accepter les conditions d\'utilisation et la politique de confidentialité.';
        }

        if ($msg = Inputs::validateName($firstname, max: 32, label: 'Le prénom'))  $errors[] = $msg;
        if ($msg = Inputs::validateName($lastname,  max: 32, label: 'Le nom'))     $errors[] = $msg;
        if ($msg = Inputs::validateUsername($username, min: 3, max: 32))           $errors[] = $msg;
        if ($msg = Inputs::validateEmail($email, max: 254))                        $errors[] = $msg;


        // Spécialisation (nullable, mais si fournie doit être un ID valide et exister)
        if ($msg = Inputs::validateIntId($specializationId, 'Spécialisation')) {
            $errors[] = $msg;
        } elseif ($specializationId !== null) {
            try {
                require_once __DIR__ . '/../models/SpecializationModel.php';
                $specModel = new SpecializationModel();
                if (!$specModel->existsById($specializationId)) {
                    $errors[] = 'Spécialisation invalide.';
                }
            } catch (Throwable $e) {
                error_log('[Register] specialization exists check error: ' . $e->getMessage());
                $errors[] = 'Erreur interne sur la spécialisation.';
            }
        }

        // Mot de passe
        if ($msgs = Inputs::validatePasswordStrength($password)) {
            foreach ($msgs as $msg) {
                $errors[] = $msg;
            }
        }
        if ($msg = Inputs::validatePasswordConfirmation($password, $password2)) $errors[] = $msg;

        if ($errors) {
            Flash::set('errors', $errors);
            Http::redirect('/auth/register');
            return;
        }

        // 3) Unicité
        try {
            $existsErr = [];
            if ($this->userModel->isUsernameTaken($username)) $existsErr[] = 'Ce nom d’utilisateur est déjà utilisé.';
            if ($this->userModel->isEmailTaken($email))       $existsErr[] = 'Cet email est déjà utilisé.';
            if ($existsErr) {
                Flash::set('errors', $existsErr);
                Http::redirect('/auth/register');
                return;
            }
        } catch (Throwable $e) {
            error_log('[Register] uniqueness check error: ' . $e->getMessage());
            Flash::set('errors', ['Erreur interne lors de la vérification des doublons.']);
            Http::redirect('/auth/register');
            return;
        }

        // 4) Hash Argon2id + validation PHC
        if (!defined('PASSWORD_ARGON2ID')) {
            Flash::set('errors', ['Le serveur ne supporte pas Argon2id.']);
            Http::redirect('/auth/register');
            return;
        }

        $hash = password_hash($password, PASSWORD_ARGON2ID);
        if ($hash === false || ($msg = Inputs::validateArgon2idPHC($hash))) {
            if ($hash === false) error_log('[Register] password_hash returned false');
            Flash::set('errors', [$msg ?: 'Erreur interne lors du hachage du mot de passe.']);
            Http::redirect('/auth/register');
            return;
        }

        // 5) INSERT
        try {
            $userId = $this->userModel->createUser([
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'username'          => $username,
                'password_hash'     => $hash,
                'email'             => $email,
                'specialization_id' => $specializationId,
            ]);

            Flash::set('success', 'Compte créé avec succès, vous pouvez vous connecter.');
            Http::redirect('/auth/login');
            return;

        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $msg = $e->getMessage();
                $human = 'Ce nom d’utilisateur ou cet email est déjà utilisé.';
                if (stripos($msg, 'username') !== false) $human = 'Ce nom d’utilisateur est déjà utilisé.';
                if (stripos($msg, 'email')    !== false) $human = 'Cet email est déjà utilisé.';
                Flash::set('errors', [$human]);
                Http::redirect('/auth/register');
                return;
            }
            error_log('[Register] DB error: ' . $e->getMessage());
            Flash::set('errors', ['Erreur interne lors de la création du compte.']);
            Http::redirect('/auth/register');
            return;

        } catch (Throwable $e) {
            error_log('[Register] Fatal: ' . $e->getMessage());
            Flash::set('errors', ['Erreur interne inattendue.']);
            Http::redirect('/auth/register');
            return;
        }
    }

}
