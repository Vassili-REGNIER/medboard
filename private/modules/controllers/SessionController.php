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
    
    public function create() {
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));
        require dirname(__DIR__) . '/views/login.php';
    }

    /**
     * Tente la connexion via un login (email OU username) + mot de passe.
     * Si succès: ouvre la session et REDIRIGE vers l'accueil connecté ('/').
     * Si échec: retourne un tableau d'erreurs (et ne redirige pas).
     */
    public function store(): array
    {
        Csrf::requireValid('/auth/login'); // si CSRF invalide → redirect direct

        $errors = [];

        $login    = trim((string) ($_POST['login'] ?? null));
        $password = (string) ($_POST['password'] ?? null);

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

            Http::redirect('/dashboard/index'); // <- accueil connecté
            exit;

        } catch (Throwable $e) {
            error_log($e->getMessage());
            $errors[] = "Erreur interne. Réessaie plus tard.";
        }

        return $errors;
    }

    public function destroy(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            echo 'Méthode non autorisée';
            return;
        }

        // Pour un logout, vérifie le token CSRF du formulaire de logout,
        // pas celui de /auth/login.
        Csrf::requireValid('/auth/logout');

        Auth::logout(); // <-- point unique de vérité

        Flash::set('success', 'Vous êtes maintenant déconnecté.');
        Http::redirect('/auth/login');
        exit;
    }
    

}