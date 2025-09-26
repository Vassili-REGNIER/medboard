<?php
// private/config/autoloader.php
declare(strict_types=1);

/**
 * Autoloader PSR-4 minimaliste
 *
 * Exemple : "modules\Controllers\HomeController"
 * sera recherché dans : MODULES_PATH . "/Controllers/HomeController.php"
 */

spl_autoload_register(function (string $class): void {
    // On ne traite que les classes qui commencent par "modules\"
    $prefix = 'modules\\';
    $baseDir = MODULES_PATH; // Défini dans config.php, ex: __DIR__ . '/../modules/'

    // Si la classe n'utilise pas ce préfixe, on ignore
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    // Supprimer le préfixe "modules\"
    $relativeClass = substr($class, strlen($prefix));

    // Transformer les "\" en "/" pour obtenir un chemin de fichier
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
    
    echo'$baseDir='. $baseDir .'<br>';
    echo'$class='. $class .'<br>';
    echo'$file='. $file .'<br>';
    
    // Inclure le fichier si trouvé
    if (file_exists($file)) {
        require $file;
    }
});
