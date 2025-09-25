<?php
namespace modules\Site\Controllers;

final class HomeController
{
    /**
     * Action par défaut (accueil)
     */
    public function index(array $req): void
    {
        // Ici on charge simplement la vue d'accueil
        require __DIR__ . '/../../Views/home.php';
    }
}
