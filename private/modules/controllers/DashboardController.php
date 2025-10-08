<?php
final class DashboardController
{
    public function index(): void
    {
        $prenom = ucfirst($_SESSION["firstname"], ' -' ?? '');
        $nom = ucfirst($_SESSION["lastname"], ' -' ?? '');
        $specialization = ucfirst($_SESSION["specialization"], ' -' ?? '');

        require __DIR__ . '/../views/dashboard.php';
    }
}