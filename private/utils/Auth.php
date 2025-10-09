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

    public static function requireGuest(): void {
        if (self::check()) {
            Http::redirect('/dashboard/index');
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
    
    public static function autoLoginFromRememberCookie(): void
    {
        if (isset($_SESSION['user'])) {
            return; // déjà connecté
        }

        $cookie = $_COOKIE['MEDBOARD_REMEMBER'] ?? '';
        if (!$cookie || strpos($cookie, ':') === false) {
            return;
        }

        [$selector, $validator] = explode(':', $cookie, 2);
        if ($selector === '' || $validator === '') {
            return;
        }

        $rememberModel = new RememberTokenModel();
        $row = $rememberModel->findValidBySelector($selector); // doit vérifier expires_at > NOW()

        if (!$row) {
            return;
        }

        // Vérifications : hash validator + user_agent (optionnel mais conseillé)
        $uaOk = hash_equals($row['user_agent_hash'] ?? '', hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? ''));
        $validatorOk = hash_equals($row['validator_hash'] ?? '', hash('sha256', $validator));

        if (!$validatorOk || !$uaOk) {
            // Anti bruteforce: invalide ce selector
            $rememberModel->deleteBySelector($selector);
            return;
        }

        // Charger l'utilisateur
        $userModel = new UserModel();
        $user = $userModel->findById((int)$row['user_id']);
        if (!$user) {
            $rememberModel->deleteBySelector($selector);
            return;
        }

        // Rotation du token à chaque auto-login
        $rememberModel->deleteBySelector($selector);

        // Re-crée un nouveau token + cookie (même logique que dans store())
        $newSelector  = self::base64url(random_bytes(9));
        $newValidator = self::base64url(random_bytes(32));
        $rememberModel->create([
            'user_id'         => (int)$user['user_id'],
            'selector'        => $newSelector,
            'validator_hash'  => hash('sha256', $newValidator),
            'expires_at'      => date('Y-m-d H:i:s', time() + 30*24*60*60),
            'user_agent_hash' => hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? ''),
            'created_at'      => date('Y-m-d H:i:s'),
        ]);
        setcookie('MEDBOARD_REMEMBER', $newSelector . ':' . $newValidator, [
            'expires'  => time() + 30*24*60*60,
            'path'     => '/',
            'domain'   => $_SERVER['HTTP_HOST'] ?? '',
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);

        // Hydrate la session comme au login
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'user_id'   => (int)$user['user_id'],
            'firstname' => $user['firstname'] ?? null,
            'lastname'  => $user['lastname'] ?? null,
            'username'  => $user['username'] ?? null,
            'email'     => $user['email'] ?? null,
            'login_at'  => time(),
        ];
    }

    private static function base64url(string $bin): string
    {
        return rtrim(strtr(base64_encode($bin), '+/', '-_'), '=');
    }
}
