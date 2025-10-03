<?php
declare(strict_types=1);

final class AuthController
{
    private UserModel $userModel ;

    public function __construct()
    {
        $this->userModel  = new UserModel();
    }

    public function register(): void
    {
        // Consomme les flashs
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));

        try {
            require_once __DIR__ . '/../models/SpecializationModel.php';
            $specModel = new SpecializationModel();
            $specializations = $specModel->getPairs();
        } catch (Throwable $e) {
            error_log('[AuthController::register] Failed to fetch specializations: ' . $e->getMessage());
            $errors = array_filter(array_merge((array)$errors, ['Impossible de charger la liste des spécialisations.']));
            $specializations = []; // la vue affichera au moins l’option vide
        }

        // Les variables $specializations, $old et $errors seront accessibles dans la vue ci-dessous
        require dirname(__DIR__) . '/views/register.php';
    }

    public function login() {
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Tente la connexion via un login (email OU username) + mot de passe.
     * Si succès: ouvre la session et REDIRIGE vers l'accueil connecté ('/').
     * Si échec: retourne un tableau d'erreurs (et ne redirige pas).
     */
    public function handleLoginAndRedirect(?string $login, ?string $password): array
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }

        Csrf::requireValid('/auth/login'); // si CSRF invalide → redirect direct

        $errors = [];

        $login    = trim((string)$login);
        $password = (string)$password;

        if ($login === '' || $password === '') {
            return ["Identifiants requis."];
        }

        // Normaliser en lowercase.
        $login = mb_strtolower($login);

        try {
            $user = $this->userModel ->findByLogin($login);
            if (!$user) {
                return ["Identifiants invalides."];
            }

            $hash = (string)($user['password_hash'] ?? '');
            if ($hash === '' || !password_verify($password, $hash)) {
                return ["Identifiants invalides."];
            }

            // Rehash éventuel en tâche courte (sécurité évolutive)
            $this->userModel ->maybeRehashPassword((int)$user['id'], $password, $hash);

            // Session + redirection
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'user_id'        => (int)$user['user_id'],
                'firstname'      => $user['firstname'] ?? null,
                'lastname'       => $user['lastname'] ?? null,
                'username'       => $user['username'] ?? null,
                'email'          => $user['email'] ?? null,
                'specialization' => $user['specialization'] ?? null,
                'login_at'       => time(),
            ];

            redirect('/dashboard/index'); // <- accueil connecté
            exit;

        } catch (Throwable $e) {
            error_log($e->getMessage());
            $errors[] = "Erreur interne. Réessaie plus tard.";
        }

        return $errors;
    }

    public function handleLogoutAndRedirect(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            echo 'Méthode non autorisée';
            return;
        }

        Csrf::requireValid('/auth/login');

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        Flash::set('success', 'Vous êtes maintenant déconnecté.');
        redirect('/auth/login');
        exit;
    }

    public function handleRegisterAndRedirect(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Méthode non autorisée';
            return;
        }

        Csrf::requireValid('/auth/register', true); // garde $_POST dans $_SESSION['old']

        $sess = $_SESSION['csrf_token'] ?? '';
        //$post = $_POST[$key] ?? '';
        //return $sess && $post && hash_equals($sess, $post);
    

        // -----------------------------
        // 1) Inputs + normalisation DB-like (trim + lower)
        // -----------------------------
        $firstnameRaw      = $_POST['firstname']      ?? '';
        $lastnameRaw       = $_POST['lastname']       ?? '';
        $usernameRaw       = $_POST['username']       ?? '';
        $emailRaw          = $_POST['email']          ?? '';
        $specializationRaw = $_POST['specialization'] ?? '';
        $password          = $_POST['password']       ?? '';
        $password2         = $_POST['password_confirm'] ?? '';

        // Trim
        $firstname = trim($firstnameRaw);
        $lastname  = trim($lastnameRaw);
        $username  = trim($usernameRaw);
        $email     = trim($emailRaw);
        $specName  = trim($specializationRaw);

        // Lowercase (comme les triggers SQL)
        $firstname = mb_strtolower($firstname, 'UTF-8');
        $lastname  = mb_strtolower($lastname, 'UTF-8');
        $username  = mb_strtolower($username, 'UTF-8');
        $email     = mb_strtolower($email, 'UTF-8');
        $specName  = mb_strtolower($specName, 'UTF-8');

        // Flash old (versions normalisées, car c’est ce qui sera stocké en DB)
        +Flash::set('old', [
            'firstname'      => $firstname,
            'lastname'       => $lastname,
            'username'       => $username,
            'email'          => $email,
            'specialization' => $specName,
        ]);

        // -----------------------------
        // 2) Validations alignées sur la DB (mêmes regex/longueurs)
        // -----------------------------
        $errors = [];

        // Longueurs max (colonnes)
        if (mb_strlen($firstname, 'UTF-8') === 0) {
            $errors[] = 'Le prénom est requis.';
        } elseif (mb_strlen($firstname, 'UTF-8') > 32) {
            $errors[] = 'Le prénom ne doit pas dépasser 32 caractères.';
        }

        if (mb_strlen($lastname, 'UTF-8') === 0) {
            $errors[] = 'Le nom est requis.';
        } elseif (mb_strlen($lastname, 'UTF-8') > 32) {
            $errors[] = 'Le nom ne doit pas dépasser 32 caractères.';
        }

        if (mb_strlen($username, 'UTF-8') === 0) {
            $errors[] = 'Le nom d’utilisateur est requis.';
        } elseif (mb_strlen($username, 'UTF-8') > 32) {
            $errors[] = 'Le nom d’utilisateur ne doit pas dépasser 32 caractères.';
        }

        if (mb_strlen($email, 'UTF-8') === 0) {
            $errors[] = 'L’email est requis.';
        } elseif (mb_strlen($email, 'UTF-8') > 254) {
            $errors[] = 'L’email ne doit pas dépasser 254 caractères.';
        }

        // Regex EXACTES des CHECK SQL
        $reName   = '/^[a-zà-öø-ÿ\' -]+$/u';                 // firstname / lastname
        $reUser   = '/^[a-z][a-z0-9_.-]*$/';                 // username
        $reEmail  = '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/';
        $reArgon2 = '/^\$argon2id\$v=\d+\$m=\d+,t=\d+,p=\d+\$[A-Za-z0-9+\/=]+\$[A-Za-z0-9+\/=]+$/';

        if ($firstname !== '' && !preg_match($reName, $firstname)) {
            $errors[] = 'Le prénom contient des caractères non autorisés.';
        }
        if ($lastname !== '' && !preg_match($reName, $lastname)) {
            $errors[] = 'Le nom contient des caractères non autorisés.';
        }

        // username : 3–32, commence par une lettre, alphanum + . _ -
        if ($username !== '') {
            if (mb_strlen($username, 'UTF-8') < 3 || mb_strlen($username, 'UTF-8') > 32) {
                $errors[] = 'Le nom d’utilisateur doit faire entre 3 et 32 caractères.';
            } elseif (!preg_match($reUser, $username)) {
                $errors[] = 'Le nom d’utilisateur doit commencer par une lettre et ne contenir que des lettres, chiffres, points, tirets et underscores.';
            }
        }

        if ($email !== '' && !preg_match($reEmail, $email)) {
            $errors[] = 'Format d’email invalide.';
        }

        // Spécialisation : on attend un ID (ou vide), on vérifie l'existence via SpecializationModel
        $specializationId = null;
        $specRaw = $_POST['specialization'] ?? '';
        $specRaw = trim((string)$specRaw);

        // On garde la valeur "old" telle que postée (utile pour re-sélectionner dans la vue)
        $oldNow = Flash::get('old', []);
        $oldNow['specialization'] = $specRaw;
        Flash::set('old', $oldNow);

        if ($specRaw === '') {
            // Colonne nullable → aucune spécialisation choisie
            $specializationId = null;
        } else {
            // Doit être un entier positif
            if (!ctype_digit($specRaw)) {
                $errors[] = 'Spécialisation invalide.';
            } else {
                $candidateId = (int)$specRaw;
                if ($candidateId <= 0) {
                    $errors[] = 'Spécialisation invalide.';
                } else {
                    try {
                        require_once __DIR__ . '/../models/SpecializationModel.php';
                        $specModel = new SpecializationModel();

                        if (!$specModel->existsById($candidateId)) {
                            $errors[] = 'Spécialisation invalide.';
                        } else {
                            $specializationId = $candidateId; // OK
                        }
                    } catch (Throwable $e) {
                        error_log('[Register] specialization exists check error: ' . $e->getMessage());
                        $errors[] = 'Erreur interne sur la spécialisation.';
                    }
                }
            }
        }

        // Mot de passe : règles applicatives (la DB ne connaît pas le plain)
        if (mb_strlen($password, '8bit') < 8) { // 8bit pour la longueur brute
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }
        if (!hash_equals($password, $password2)) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if ($errors) {
            Flash::set('errors', $errors);
            redirect('/auth/register');
            return;
        }

        // -----------------------------
        // 3) Unicité applicative (sur valeurs normalisées)
        // -----------------------------
        try {
            $existsErr = [];
            if ($this->userModel->isUsernameTaken($username)) {
                $existsErr[] = 'Ce nom d’utilisateur est déjà utilisé.';
            }
            if ($this->userModel->isEmailTaken($email)) {
                $existsErr[] = 'Cet email est déjà utilisé.';
            }
            if ($existsErr) {
                Flash::set('errors', $existsErr);
                redirect('/auth/register');
                return;
            }
        } catch (Throwable $e) {
            error_log('[Register] uniqueness check error: ' . $e->getMessage());
            $_SESSION['errors'] = ['Erreur interne lors de la vérification des doublons.'];
            redirect('/auth/register');
            return;
        }

        // -----------------------------
        // 4) Hash Argon2id + validation PHC (comme le CHECK SQL)
        // -----------------------------
        if (!defined('PASSWORD_ARGON2ID')) {
            Flash::set('errors', ['Le serveur ne supporte pas Argon2id.']);
            redirect('/auth/register');
            return;
        }

        $hash = password_hash($password, PASSWORD_ARGON2ID);
        if ($hash === false || !preg_match($reArgon2, $hash)) {
            // Si jamais l’implémentation retourne un format inattendu, on bloque (la DB refusera).
            error_log('[Register] Argon2id hash does not match PHC format: ' . var_export($hash, true));
            Flash::set('errors', ['Erreur interne lors du hachage du mot de passe.']);
            redirect('/auth/register');
            return;
        }

        // -----------------------------
        // 5) INSERT (valeurs validées et normalisées)
        // -----------------------------
        try {
            $userId = $this->userModel->createUser([
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'username'          => $username,
                'password_hash'     => $hash,
                'email'             => $email,
                'specialization_id' => $specializationId, // <- FK nullable
            ]);

            Flash::set('success', 'Compte créé avec succès, vous pouvez vous connecter.');
            // Option: auto-login
            // $_SESSION['user_id'] = $userId;
            redirect('/auth/login');
            return;

        } catch (PDOException $e) {
            // Gestion des conflits d'unicité DB (race conditions)
            if ($e->getCode() === '23505') { // unique_violation
                $msg = $e->getMessage();
                $human = 'Ce nom d’utilisateur ou cet email est déjà utilisé.';
                if (stripos($msg, 'username') !== false) $human = 'Ce nom d’utilisateur est déjà utilisé.';
                if (stripos($msg, 'email')    !== false) $human = 'Cet email est déjà utilisé.';
                Flash::set('errors', [$human]);
                redirect('/auth/register');
                return;
            }

            error_log('[Register] DB error: ' . $e->getMessage());
            Flash::set('errors', ['Erreur interne lors de la création du compte.']);
            redirect('/auth/register');
            return;

        } catch (Throwable $e) {
            error_log('[Register] Fatal: ' . $e->getMessage());
            Flash::set('errors', ['Erreur interne inattendue.']);
            redirect('/auth/register');
            return;
        }
    }

}
