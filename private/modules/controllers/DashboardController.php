<?php
final class DashboardController
{
    public function index(): void
    {
        $prenom = mb_convert_case($_SESSION["firstname"], MB_CASE_TITLE, "UTF-8");
        $nom = mb_convert_case($_SESSION["lastname"], MB_CASE_TITLE, "UTF-8");
        $specialization = mb_convert_case($_SESSION["specialization"], MB_CASE_TITLE, "UTF-8");

        require __DIR__ . '/../views/dashboard.php';
    }
}