<?php
require_once __DIR__ . '/../app/Core/Helpers.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';$baseDir = __DIR__ . '/../app/';
    if (strncmp($prefix, $class, strlen($prefix)) === 0) {
        $relativeClass = substr($class, strlen($prefix));$file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

$router = require __DIR__ . '/../routes/web.php';$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);$router->dispatch($_SERVER['REQUEST_METHOD'],$uri);