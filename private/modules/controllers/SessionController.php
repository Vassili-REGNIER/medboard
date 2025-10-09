<?php
declare(strict_types=1);

final class SessionController
{
    private UserModel $userModel;
    private RememberTokenModel $rememberTokenModel;

    // 30 jours de persistance
    private const REMEMBER_DURATION_SECONDS = 30 * 24 * 60 * 60;
    private const REMEMBER_COOKIE_NAME = 'MEDBOARD_REMEMBER';

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->rememberTokenModel = new RememberTokenModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
            return $this->store();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->create();
        } else {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
            return $this->destroy();
        } else {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }
    }
    
    public function create(): void {
        Auth::requireGuest(); // Si déjà connecté -> /dashboard/index
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Connexion (email OU username) + Remember me optionnel.
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

        $login     = trim((string) ($_POST['login'] ?? null));
        $password  = (string) ($_POST['password'] ?? null);
        $remember  = isset($_POST['remember']) && ($_POST['remember'] === '1' || $_POST['remember'] === 'on');

        if ($login === '' || $password === '') {
            Flash::set('errors', ['Identifiants requis.']);
            Flash::set('old', ['login' => $login, 'remember' => $remember ? '1' : '0']);
            Http::redirect('/auth/login');
            exit;
        }

        $login = mb_strtolower($login);

        try {
            $user = $this->userModel->findByLogin($login);
            if (!$user) {
                Flash::set('errors', ['Identifiants invalides.']);
                Flash::set('old', ['login' => $login, 'remember' => $remember ? '1' : '0']);
                Http::redirect('/auth/login');
                exit;
            }

            $hash = (string)($user['password_hash'] ?? '');
            if ($hash === '' || !password_verify($password, $hash)) {
                Flash::set('errors', ['Identifiants invalides.']);
                Flash::set('old', ['login' => $login, 'remember' => $remember ? '1' : '0']);
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

                    if ($specModel->existsById($specId)) {
                        $pairs = $specModel->getPairs();
                        $specName = $pairs[(string)$specId] ?? null;
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
            
            // ————— Session en mémoire —————
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

            // ————— Remember me (cookie persistant + entrée DB) —————
            if ($remember) {
                // 1) Invalider d’anciens tokens du user (optionnel mais conseillé)
                $this->rememberTokenModel->deleteForUser((int)$user['user_id']);

                // 2) Générer selector + validator
                $selector  = self::base64url(random_bytes(9));   // 12 chars environ
                $validator = self::base64url(random_bytes(32));  // 43 chars environ

                $validatorHash = hash('sha256', $validator);
                $expiresAtTs   = time() + self::REMEMBER_DURATION_SECONDS;

                // 3) Persister
                $this->rememberTokenModel->create([
                    'user_id'         => (int)$user['user_id'],
                    'selector'        => $selector,
                    'validator_hash'  => $validatorHash,
                    'expires_at'      => date('Y-m-d H:i:s', $expiresAtTs),
                    'user_agent_hash' => hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? ''),
                    'created_at'      => date('Y-m-d H:i:s'),
                ]);

                // 4) Poser le cookie (selector:validator) — pas de hash côté cookie
                $cookieValue = $selector . ':' . $validator;
                // Important : secure/httponly/samesite cohérents avec ta prod (HTTPS + Strict/Lax)
                setcookie(
                    self::REMEMBER_COOKIE_NAME,
                    $cookieValue,
                    [
                        'expires'  => $expiresAtTs,
                        'path'     => '/',
                        'domain'   => $_SERVER['HTTP_HOST'] ?? '',
                        'secure'   => true,      // HTTPS en prod
                        'httponly' => true,      // non accessible JS
                        'samesite' => 'Strict',  // mets 'Lax' si tu as des retours cross-site
                    ]
                );
            } else {
                // Si la case n’est pas cochée, on s’assure de supprimer un éventuel ancien cookie
                if (!empty($_COOKIE[self::REMEMBER_COOKIE_NAME])) {
                    // Efface le cookie côté client
                    setcookie(
                        self::REMEMBER_COOKIE_NAME,
                        '',
                        [
                            'expires'  => time() - 3600,
                            'path'     => '/',
                            'domain'   => $_SERVER['HTTP_HOST'] ?? '',
                            'secure'   => true,
                            'httponly' => true,
                            'samesite' => 'Strict',
                        ]
                    );
                }
                // On peut aussi supprimer en DB les tokens de ce user si tu veux être strict
                $this->rememberTokenModel->deleteForUser((int)$user['user_id']);
            }

            Http::redirect('/dashboard/index');
            exit;

        } catch (Throwable $e) {
            error_log($e->getMessage());
            Flash::set('errors', ['Erreur interne. Réessaie plus tard.']);
            Flash::set('old', ['login' => $login, 'remember' => $remember ? '1' : '0']);
            Http::redirect('/auth/login');
            exit;
        }
    }

    public function destroy(): void
    {
        Csrf::requireValid('/auth/logout');

        // ————— Nettoyage Remember me —————
        // Si tu stockes plusieurs tokens par user, supprime-les tous pour ce user.
        if (isset($_SESSION['user']['user_id'])) {
            $this->rememberTokenModel->deleteForUser((int)$_SESSION['user']['user_id']);
        }

        // Efface le cookie côté client
        if (!empty($_COOKIE[self::REMEMBER_COOKIE_NAME])) {
            setcookie(
                self::REMEMBER_COOKIE_NAME,
                '',
                [
                    'expires'  => time() - 3600,
                    'path'     => '/',
                    'domain'   => $_SERVER['HTTP_HOST'] ?? '',
                    'secure'   => true,
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]
            );
        }

        Auth::logout();

        Flash::set('success', 'Vous êtes maintenant déconnecté.');
        Http::redirect('/auth/login');
        exit;
    }

    // ==== Helpers ====
    private static function base64url(string $bin): string
    {
        return rtrim(strtr(base64_encode($bin), '+/', '-_'), '=');
    }
}
