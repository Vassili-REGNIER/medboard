<?php
declare(strict_types=1);

final class PasswordsController
{
    private UserModel $userModel ;

    public function __construct()
    {
        $this->userModel  = new UserModel();
    }

    public function forgotPassword() {
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

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            return $this->update();
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            return $this->edit();
        }
        else
        {
            http_response_code(405);
            return ['Méthode non autorisée.'];
        }
    }

    public function create()
    {
        Auth::requireGuest();
        
        [$old, $errors, $success] = array_values(Flash::consumeMany(['old','errors','success']));

        // Les variables $specializations, $old et $errors seront accessibles dans la vue ci-dessous
        require dirname(__DIR__) . '/views/forgot-password.php';
    }

    public function store() 
    {    
        Csrf::requireValid('/auth/register', true);
        
        // Envoyer le lien de reset
    }

    public function edit() 
    {
        // Afficher reset
    }

    public function update() 
    {
        Csrf::requireValid('/auth/register', true);
        
        // Valider reset
    }
}
