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
require __DIR__ . '/../private/utils/Flash.php';
require __DIR__ . '/../private/utils/Csrf.php';
require __DIR__ . '/../private/utils/Auth.php';
require __DIR__ . '/../private/utils/Http.php';
require __DIR__ . '/../private/utils/Inputs.php';

require_once BASE_PATH . '/vendor/autoload.php';

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
    exit;
}

[$class, $method, $requiresAuth] = $routes[$route];

/** ==================== Garde d'auth si requis ==================== */
if ($requiresAuth === true) {
    Auth::requireLogin();
}

/** ==================== Instanciation & exécution ==================== */
try {
    // Chargement automatique via autoloader (sans namespace).
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

    // Appel simple sans paramètres
    $controller->{$method}();

} catch (Throwable $e) {
    // Réponse HTTP standard
    http_response_code(500);
    echo '500 — Erreur interne';

    // ==== Debug en DEV (à désactiver en prod) ====
    echo '<hr><strong>[Debug Exception]</strong><br>';
    echo 'Type : ' . get_class($e) . '<br>';
    echo 'Message : ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>';
    echo 'Fichier : ' . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . '<br>';
    echo 'Ligne : ' . $e->getLine() . '<br>';
    echo '<pre>Trace : ' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
    
    // Affichage de la route qui a été résolue :
    echo '<hr><strong>[Debug Route]</strong><br>';
    echo 'Route demandée : ' . htmlspecialchars($route, ENT_QUOTES, 'UTF-8') . '<br>';
    echo 'Classe attendue : ' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '<br>';
    echo 'Méthode attendue : ' . htmlspecialchars($method, ENT_QUOTES, 'UTF-8') . '<br>';
    echo 'Authentification requise : ' . ($requiresAuth ? 'oui' : 'non') . '<br>';

    exit;
}
