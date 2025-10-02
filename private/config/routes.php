<?php
// private/config/routes.php
declare(strict_types=1);

return [
    // Pages publiques
    'site/home'    => ['modules\\controllers\\HomeController',   'index',   false],
    'site/sitemap' => ['modules\\controllers\\StaticController', 'sitemap', false],
    'site/legal'   => ['modules\\controllers\\StaticController', 'legal',   false],

    // Auth
    'auth/login'    => ['modules\\controllers\\AuthController', 'login',    false],
    'auth/register' => ['modules\\controllers\\HomeController', 'register', false],
    'auth/logout'   => ['modules\\controllers\\AuthController', 'logout',   true],

    // Espace protégé
    'dashboard/index' => ['modules\\controllers\\DashboardController', 'index', true],
];
