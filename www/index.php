<?php
// medboard/index.php — Front Controller
declare(strict_types=1);

session_start();

/**
 * Chargements : autoloader (connait déjà "modules\"),
 * config générale (définit notamment MODULES_PATH),
 * et table des routes.
 */
require __DIR__ . '/../private/config/config.php';
require __DIR__ . '/../private/config/autoloader.php';
require BASE_PATH . '/vendor/autoload.php';

$routes = require __DIR__ . '/../private/config/routes.php';

Csrf::ensureToken();

/** ==================== Résolution de la route ====================
 * L'.htaccess doit réécrire /site/home -> index.php?route=site/home
 * Route par défaut : site/home
 */
$route = filter_input(INPUT_GET, 'route', FILTER_UNSAFE_RAW);
$route = $route ? trim($route, "/ \t\n\r\0\x0B") : 'site/home';

if (!isset($routes[$route])) {
    http_response_code(404);
    echo '404 — Page introuvable';
    require MODULES_PATH . 'views/not-found.php';
    exit;
}

[$class, $method, $requiresAuth] = $routes[$route];

if ($requiresAuth === true) {
    Auth::requireLogin();
}

/** ==================== Instanciation & exécution ==================== */
try {
    // Vérification du contrôleur
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

    $controller->{$method}();

} catch (Throwable $e) {
    // Réponse HTTP standard
    http_response_code(500);
    echo '500 — Erreur interne';

    // Journalisation complète
    $logMessage = sprintf(
        "[%s] Exception non interceptée\nType: %s\nMessage: %s\nFichier: %s:%d\nRoute: %s\nClasse: %s\nMéthode: %s\nTrace:\n%s\n",
        date('Y-m-d H:i:s'),
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $route ?? '(inconnue)',
        $class ?? '(inconnue)',
        $method ?? '(inconnue)',
        $e->getTraceAsString()
    );
    error_log($logMessage);
    exit;
}
