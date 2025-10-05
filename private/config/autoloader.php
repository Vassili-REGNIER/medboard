<?php

spl_autoload_register(function (string $class): void {
    $baseDir = BASE_PATH;
    $modulesPath = MODULES_PATH;

    $paths = [
        // Modules MVC
        $modulesPath . 'controllers/' . $class . '.php',
        $modulesPath . 'models/' . $class . '.php',

        // Outils internes
        $baseDir . 'private/utils/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

