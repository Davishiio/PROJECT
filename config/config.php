<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'biblioteca');
define('DB_USER', 'root');
define('DB_PASS', '');

spl_autoload_register(function ($class) {
    $paths = ['controllers', 'models', 'core'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
