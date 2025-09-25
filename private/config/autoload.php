<?php
// private/config/autoload.php
declare(strict_types=1);

// S'assurer que MODULES_PATH est défini (via config.php)
if (!defined('MODULES_PATH')) {
    throw new RuntimeException('MODULES_PATH is not defined. Load config.php first.');
}

spl_autoload_register(function (string $class): void {
    // On accepte les deux notations par tolérance
    static $prefixes = ['modules\\', 'Modules\\'];

    foreach ($prefixes as $prefix) {
        $len = strlen($prefix);
        if (strncmp($class, $prefix, $len) !== 0) {
            continue;
        }

        // Chemin relatif après le préfixe
        $relative = substr($class, $len); // ex: "Site\Controllers\HomeController"
        $path = MODULES_PATH . '/' . str_replace('\\', '/', $relative) . '.php';

        if (is_file($path)) {
            require $path;
            return;
        }
    }
    // Laisser d'autres autoloaders tenter leur chance si présents
});
