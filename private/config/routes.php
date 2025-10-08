<?php
// private/config/routes.php
declare(strict_types=1);

return [
    // Pages publiques
    'site/home'            => ['StaticPagesController',  'home',   false],
    'site/sitemap'         => ['StaticPagesController',  'sitemap',  false],
    'site/legal'           => ['StaticPagesController',  'legal',    false],
    'site/privacy'         => ['StaticPagesController',  'privacy', false],
    'error/404'       => ['StaticPagesController',  'notFound', false],

    // Connexion / déco
    'auth/login'           => ['SessionController',      'login',    false],
    'auth/logout'          => ['SessionController',      'logout',   true],

    // Register
    'auth/register'        => ['RegistrationController', 'register', false],

    // Mdp oublié
    'auth/forgot-password' => ['PasswordsController',    'forgotPassword', false],
    'auth/reset-password'  => ['PasswordsController',    'resetPassword',  false],

    // Espace protégé
    'dashboard/index'      => ['DashboardController',    'index', true],
];
