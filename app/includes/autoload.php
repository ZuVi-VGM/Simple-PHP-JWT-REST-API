<?php
require_once __DIR__.'/config/config.php';
spl_autoload_register(function ($className) {
    $classMap = array(
        'App\\Controllers\\' => 'Controllers',
        'App\\Models\\' => 'Models',
        'App\\Routing\\' => 'Routing',
        'App\\Utils\\' => 'Utils'
    );

    // Cerca la classe nel classMap
    foreach ($classMap as $namespace => $directory) {
        if (strpos($className, $namespace) === 0) {
            $filePath = str_replace($namespace, $directory.DIRECTORY_SEPARATOR, $className) . '.php';
            $fullPath = APP_PATH . $filePath;

            if (file_exists($fullPath)) {
                require_once $fullPath;
                return;
            } else {
                echo "FILE NOT EXIST ".$fullPath;
            }
        }
    }
});


