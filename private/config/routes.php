<?php
// private/config/routes.php
declare(strict_types=1);

return [
    // Pages publiques
    'site/home'    => ['modules\\Site\\Controllers\\HomeController',   'index',   false],
    'site/sitemap' => ['modules\\Site\\Controllers\\StaticController', 'sitemap', false],
    'site/legal'   => ['modules\\Site\\Controllers\\StaticController', 'legal',   false],

    // Auth
    'auth/login'    => ['modules\\Auth\\Controllers\\AuthController', 'login',    false],
    'auth/register' => ['modules\\Auth\\Controllers\\AuthController', 'register', false],
    'auth/logout'   => ['modules\\Auth\\Controllers\\AuthController', 'logout',   true],

    // Espace protégé
    'dashboard/index' => ['modules\\Dashboard\\Controllers\\DashboardController', 'index', true],
];
