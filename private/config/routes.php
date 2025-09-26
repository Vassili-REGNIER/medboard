<?php
// private/config/routes.php
declare(strict_types=1);

return [
    // Pages publiques
    'site/home'    => ['modules\\Controllers\\HomeController',   'index',   false],
    'site/sitemap' => ['modules\\Controllers\\StaticController', 'sitemap', false],
    'site/legal'   => ['modules\\Controllers\\StaticController', 'legal',   false],

    // Auth
    'auth/login'    => ['modules\\Controllers\\AuthController', 'login',    false],
    'auth/register' => ['modules\\Controllers\\AuthController', 'register', false],
    'auth/logout'   => ['modules\\Controllers\\AuthController', 'logout',   true],

    // Espace protégé
    'dashboard/index' => ['modules\\Controllers\\DashboardController', 'index', true],
];
