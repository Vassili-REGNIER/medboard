<?php
final class DashboardController
{
    public function index(): void
    {   
        $user = $_SESSION['user'] ?? null;

        $firstname = isset($user) ? ucfirst($user['firstname']) : '';
        $lastname = isset($user) ? ucfirst($user['lastname']) : '';
        $specialization = isset($user) ? ucfirst($user['specialization']) : '';

        require __DIR__ . '/../views/dashboard.php';
    }
}