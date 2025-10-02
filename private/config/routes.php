<?php
// private/config/routes.php
declare(strict_types=1);

return [
    // Pages publiques
    'site/home'    => ['HomeController',   'index',   false],
    'site/sitemap' => ['StaticController', 'sitemap', false],
    'site/legal'   => ['StaticController', 'legal',   false],

    // Auth
    'auth/login'           => ['AuthController', 'login',                     false],
    'auth/register'        => ['AuthController', 'register',                  false],
    'auth/register/submit' => ['AuthController', 'handleRegisterAndRedirect', false],
    'auth/logout'          => ['AuthController', 'logout',                    true],

    // Espace protégé
    'dashboard/index' => ['DashboardController', 'index', true],
];
