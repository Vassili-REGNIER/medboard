<?php
final class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return $_SESSION['user']['user_id'] ?? null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Http::redirect('/auth/login');
            exit;
        }
    }

    public static function logout(): void
    {
        // Purge de la session en mémoire
        $_SESSION = [];

        // Purge du cookie de session
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            // On réécrit le cookie expiré avec les mêmes attributs
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                // garde le même SameSite si dispo
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }

        // Destruction du stockage serveur
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
