<?php
final class DashboardController
{
    public function index(): void
    {   
        $user = $_SESSION['user'] ?? [];

        $firstname = mb_convert_case($user['firstname'] ?? '', MB_CASE_TITLE, 'UTF-8');
        $lastname = mb_convert_case($user['lastname'] ?? '', MB_CASE_TITLE, 'UTF-8');
        $specialization = mb_convert_case($user['specialization'] ?? '', MB_CASE_TITLE, 'UTF-8');

        require __DIR__ . '/../views/dashboard.php';
    }
}