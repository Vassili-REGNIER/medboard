<?php

spl_autoload_register(function (string $class): void {
    $baseDir = MODULES_PATH;

    $paths = [
        $baseDir . 'controllers' . DIRECTORY_SEPARATOR . $class . '.php',
        $baseDir . 'models' . DIRECTORY_SEPARATOR . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

