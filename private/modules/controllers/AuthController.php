<?php
declare(strict_types=1);

final class AuthController
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
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
            $user = $this->users->findByLogin($login);
            if (!$user) {
                return ["Identifiants invalides."];
            }

            $hash = (string)($user['password_hash'] ?? '');
            if ($hash === '' || !password_verify($password, $hash)) {
                return ["Identifiants invalides."];
            }

            // Rehash éventuel en tâche courte (sécurité évolutive)
            $this->users->maybeRehashPassword((int)$user['id'], $password, $hash);

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
}
