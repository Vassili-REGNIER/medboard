<?php
final class HomeController
{
    /**
     * Action par défaut (accueil)
     */
    public function index(): void
    {
        // Ici on charge simplement la vue d'accueil
        require __DIR__ . '/../views/home.php';
    }
}
