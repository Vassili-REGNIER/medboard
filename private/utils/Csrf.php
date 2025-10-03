<?php
declare(strict_types=1);

final class Csrf
{
    public static function ensureToken(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function checkFromPost(string $key = 'csrf_token'): bool
    {
        $sess = $_SESSION['csrf_token'] ?? '';
        $post = $_POST[$key] ?? '';
        return $sess && $post && hash_equals($sess, $post);
    }

    /**
     * Vérifie le token CSRF et sinon redirige vers $redirectUrl.
     * Permet d'éviter de dupliquer le bloc.
     */
    public static function requireValid(string $redirectUrl, bool $keepOld = false): void
    {
        if (!self::checkFromPost()) {
            Flash::set('errors', ['Le formulaire a expiré. Merci de réessayer.']);
            if ($keepOld) {
                Flash::set('old', $_POST);
            }
            redirect($redirectUrl);
            exit; // On sort tout de suite
        }
    }
}
