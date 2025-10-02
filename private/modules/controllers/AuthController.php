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
        require dirname(__DIR__) . '/views/register.php';
    }

    public function login() {
        require dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Tente la connexion via un login (email OU username) + mot de passe.
     * Si succès: ouvre la session et REDIRIGE vers l'accueil connecté ('/').
     * Si échec: retourne un tableau d'erreurs (et ne redirige pas).
     */
    public function handleLoginAndRedirect(?string $login, ?string $password): array
    {
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
            $this->ensureSession();
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'user_id'        => (int)$user['id'],
                'firstname'      => $user['firstname'] ?? null,
                'lastname'       => $user['lastname'] ?? null,
                'username'       => $user['username'] ?? null,
                'email'          => $user['email'] ?? null,
                'specialization' => $user['specialization'] ?? null,
                'login_at'       => time(),
            ];

            header('Location: /'); // <- accueil connecté
            exit;

        } catch (Throwable $e) {
            // Log en prod: error_log($e->getMessage());
            $errors[] = "Erreur interne. Réessaie plus tard.";
        }

        return $errors;
    }

    public function handleLogoutAndRedirect(): void
    {
        $this->ensureSession();

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

        header('Location: /login.php');
        exit;
    }

    private function ensureSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;

        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    public function handleRegisterAndRedirect(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Méthode non autorisée';
            return;
        }

        // CSRF
        $csrfSession = $_SESSION['csrf_token'] ?? '';
        $csrfPost    = $_POST['csrf_token'] ?? '';
        if (!$csrfSession || !$csrfPost || !hash_equals($csrfSession, $csrfPost)) {
            $_SESSION['errors'] = ['Le formulaire a expiré. Merci de réessayer.'];
            $_SESSION['old'] = $_POST;
            redirect('/auth/register');
            return;
        }

        // Inputs
        $firstname      = trim($_POST['firstname'] ?? '');
        $lastname       = trim($_POST['lastname'] ?? '');
        $username       = trim($_POST['username'] ?? '');
        $email          = trim($_POST['email'] ?? '');
        $specialization = trim($_POST['specialization'] ?? '');
        $password       = $_POST['password'] ?? '';
        $password2      = $_POST['password_confirm'] ?? '';

        // Flash old
        $_SESSION['old'] = [
            'firstname'      => $firstname,
            'lastname'       => $lastname,
            'username'       => $username,
            'email'          => $email,
            'specialization' => $specialization,
        ];

        // Validations
        $errors = [];
        if ($firstname === '' || mb_strlen($firstname) < 2) {
            $errors[] = 'Le prénom est requis (≥ 2 caractères).';
        }
        if ($lastname === '' || mb_strlen($lastname) < 2) {
            $errors[] = 'Le nom est requis (≥ 2 caractères).';
        }
        if ($username === '' || !preg_match('/^[a-zA-Z0-9_.-]{3,32}$/', $username)) {
            $errors[] = 'Le nom d’utilisateur est requis (3–32, alphanumérique, ., -, _).';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }
        $allowedSpecs = ['development','clinical','work','health']; // adapte à ton métier
        if (!in_array($specialization, $allowedSpecs, true)) {
            $errors[] = 'Spécialisation invalide.';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }
        if (!hash_equals($password, $password2)) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            redirect('/auth/register');
            return;
        }

        // Appel au Model
        try {

            // Contrôle applicatif d’unicité avant INSERT
            $existsErr = [];
            if ($this->userModel->isUsernameTaken($username)) {
                $existsErr[] = 'Ce nom d’utilisateur est déjà utilisé.';
            }
            if ($this->userModel->isEmailTaken($email)) {
                $existsErr[] = 'Cet email est déjà utilisé.';
            }
            if ($existsErr) {
                $_SESSION['errors'] = $existsErr;
                redirect('/auth/register');
                return;
            }

            $userId = $this->userModel->createUser([
                'firstname'      => $firstname,
                'lastname'       => $lastname,
                'username'       => $username,
                'password_hash'  => password_hash($password, PASSWORD_DEFAULT),
                'email'          => $email,
                'specialization' => $specialization,
            ]);

            // Succès
            $_SESSION['success'] = 'Compte créé avec succès, vous pouvez vous connecter.';
            // Option: auto-login
            // $_SESSION['user_id'] = $userId;
            redirect('/auth/login');
            return;

        } catch (PDOException $e) {
            // Conflits d’unicité côté DB (au cas où l’état change entre la vérif et l’insert)
            if ($e->getCode() === '23505') { // unique_violation (PostgreSQL)
                $msg = $e->getMessage();
                $human = 'Ce nom d’utilisateur ou cet email est déjà utilisé.';
                if (stripos($msg, 'username') !== false) $human = 'Ce nom d’utilisateur est déjà utilisé.';
                if (stripos($msg, 'email') !== false)    $human = 'Cet email est déjà utilisé.';
                $_SESSION['errors'] = [$human];
                redirect('/auth/register');
                return;
            }

            error_log('[Register] DB error: ' . $e->getMessage());
            $_SESSION['errors'] = ['Erreur interne lors de la création du compte.'];
            redirect('/auth/register');
            return;

        } catch (Throwable $e) {
            error_log('[Register] Fatal: ' . $e->getMessage());
            $_SESSION['errors'] = ['Erreur interne inattendue.'];
            redirect('/auth/register');
            return;
        }
    }
}
