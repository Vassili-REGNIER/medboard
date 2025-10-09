<?php
declare(strict_types=1);
final class SessionController
{
    private UserModel $userModel ;

    public function __construct()
    {
        $this->userModel  = new UserModel();
    }

    public function login() {
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

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            return $this->destroy();
        }
        else
        {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }
    }
    
    public function create(): void {
        Auth::requireGuest(); // Si l'utilisateur est deja connecté -> /dashboard/index

        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Tente la connexion via un login (email OU username) + mot de passe.
     */
    public function store(): void
    {
        if (!RateLimit::check('login', maxAttempts: 5, windowSeconds: 900)) {
            $remaining = RateLimit::getRemainingTime('login');
            $minutes = ceil($remaining / 60);
            Flash::set('errors', ["Trop de tentatives de connexion. Réessayez dans {$minutes} minutes."]);
            Http::redirect('/auth/login');
            exit;
        }

        Csrf::requireValid('/auth/login');

        $login    = trim((string) ($_POST['login'] ?? null));
        $password = (string) ($_POST['password'] ?? null);

        if ($login === '' || $password === '') {
            Flash::set('errors', ['Identifiants requis.']);
            Flash::set('old', ['login' => $login]);
            Http::redirect('/auth/login');
            exit;
        }

        $login = mb_strtolower($login);

        try {
            $user = $this->userModel->findByLogin($login);
            if (!$user) {
                Flash::set('errors', ['Identifiants invalides.']);
                Flash::set('old', ['login' => $login]);
                Http::redirect('/auth/login');
                exit;
            }

            $hash = (string)($user['password_hash'] ?? '');
            if ($hash === '' || !password_verify($password, $hash)) {
                Flash::set('errors', ['Identifiants invalides.']);
                Flash::set('old', ['login' => $login]);
                Http::redirect('/auth/login');
                exit;
            }

            // Succès
            RateLimit::reset('login');

            $this->userModel->maybeRehashPassword((int)$user['user_id'], $password, $hash);
            session_regenerate_id(true);

            // Récupération du libellé de spécialisation à partir de l'ID
            $specName = null;
            $specId = isset($user['specialization_id']) ? (int)$user['specialization_id'] : 0;

            if ($specId > 0) {
                try {
                    $specModel = new SpecializationModel();

                    // Vérifie que la spécialisation existe avant de chercher le libellé
                    if ($specModel->existsById($specId)) {
                        $pairs = $specModel->getPairs();
                        $specName = $pairs[(string)$specId] ?? null;

                        // Met en forme correctement (Cardiology -> "Cardiology", gère les accents)
                        if ($specName !== null) {
                            $specName = mb_convert_case($specName, MB_CASE_TITLE, 'UTF-8');
                        }
                    } else {
                        error_log("Specialization not found for ID: {$specId}");
                    }
                } catch (Throwable $e) {
                    error_log("Erreur lors de la récupération de la spécialisation (ID {$specId}): " . $e->getMessage());
                    $specName = null;
                }
            }
            
            $_SESSION['user'] = [
                'user_id'           => (int)$user['user_id'],
                'firstname'         => $user['firstname'] ?? null,
                'lastname'          => $user['lastname'] ?? null,
                'username'          => $user['username'] ?? null,
                'email'             => $user['email'] ?? null,
                'specialization_id' => $specId ?: null,
                'specialization'    => $specName,
                'login_at'          => time(),
            ];

            Http::redirect('/dashboard/index');
            exit;

        } catch (Throwable $e) {
            error_log($e->getMessage());
            Flash::set('errors', ['Erreur interne. Réessaie plus tard.']);
            Flash::set('old', ['login' => $login]);
            Http::redirect('/auth/login');
            exit;
        }
    }


    public function destroy(): void
    {
        // Pour un logout, vérifie le token CSRF du formulaire de logout,
        // pas celui de /auth/login.
        Csrf::requireValid('/auth/logout');

        Auth::logout();

        Flash::set('success', 'Vous êtes maintenant déconnecté.');
        Http::redirect('/auth/login');
        exit;
    }
}