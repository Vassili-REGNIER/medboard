<?php
// medboard/index.php — Front Controller
declare(strict_types=1);

session_start();

/**
 * Chargements : autoloader (connait déjà "modules\"),
 * config générale (définit notamment MODULES_PATH, BASE_URL éventuelle),
 * et table des routes.
 */
require __DIR__ . '/../private/config/config.php';
require __DIR__ . '/../private/config/autoloader.php';
$routes = require __DIR__ . '/../private/config/routes.php';

/** ==================== Helpers auth & nav ==================== */
function redirect(string $url): never {
    header('Location: ' . $url, true, 302);
    exit;
}
function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}
function guardAuth(): void {
    if (!isLoggedIn()) {
        // Adapte le chemin si besoin (ex: BASE_URL . '/auth/login')
        redirect('/auth/login');
    }
}

/** ==================== Résolution de la route ====================
 * L'.htaccess doit réécrire /site/home -> index.php?route=site/home
 * Route par défaut : site/home
 */
$route = filter_input(INPUT_GET, 'route', FILTER_UNSAFE_RAW);
$route = $route ? trim($route, "/ \t\n\r\0\x0B") : 'site/home';

if (!isset($routes[$route])) {
    http_response_code(404);
    echo '404 — Page introuvable';
    exit;
}

[$class, $method, $requiresAuth] = $routes[$route];

/** ==================== Garde d'auth si requis ==================== */
if ($requiresAuth === true) {
    guardAuth();
}

/** ==================== Instanciation & exécution ==================== */
try {
    // Le namespace "modules\" est autoloadé : pas de require manuel.
    if (!class_exists($class)) {
        http_response_code(500);
        echo '500 — Classe contrôleur introuvable : ' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8');
        exit;
    }

    $controller = new $class();

    if (!is_callable([$controller, $method])) {
        http_response_code(500);
        echo '500 — Méthode introuvable : ' . htmlspecialchars($class . '::' . $method, ENT_QUOTES, 'UTF-8');
        exit;
    }

    // Appel simple sans paramètres (ajoute-en si nécessaire)
    $controller->{$method}();

} catch (Throwable $e) {
    // Log applicatif possible ici (fichier, Sentry, etc.)
    http_response_code(500);
    echo '500 — Erreur interne';
    // Optionnel en dev :
    // echo '<pre>' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</pre>';
    exit;
}
