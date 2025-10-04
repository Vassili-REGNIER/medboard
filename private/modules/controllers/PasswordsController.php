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

    public function create() {
        // Affiche "mdp oublié"
    }

    public function store() {
        // Envoyer le lien de reset
    }

    public function edit() {
        // Afficher reset
    }

    public function update() {
        // Valider reset
    }
}
