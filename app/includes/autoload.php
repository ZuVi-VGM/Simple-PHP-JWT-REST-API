<?php
require_once __DIR__.'/../config/config.php';
spl_autoload_register(function ($className) {
    $classMap = array(
        'App\\Controllers\\' => 'controllers/',
        'App\\Models\\' => 'models/',
        'App\\Routing\\' => 'routing/',
        'App\\Utils\\' => 'utils/'
    );

    // Cerca la classe nel classMap
    foreach ($classMap as $namespace => $directory) {
        if (strpos($className, $namespace) === 0) {
            $directory = str_replace('/', DIRECTORY_SEPARATOR, $directory);
            $filePath = str_replace($namespace, $directory, $className) . '.php';
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


