<?php
final class DashboardController
{
    public function index(): void
    {
        $prenom = isset($_SESSION['firstname']) ? ucfirst($_SESSION['firstname']) : '';
        $nom = isset($_SESSION['lastname']) ? ucfirst($_SESSION['lastname']) : '';
        $specialization = isset($_SESSION['specialization']) ? ucfirst($_SESSION['specialization']) : '';

        require __DIR__ . '/../views/dashboard.php';
    }
}