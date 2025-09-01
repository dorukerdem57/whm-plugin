<?php
require_once __DIR__ . '/config.php';

spl_autoload_register(function ($class) {
    $prefix = 'WHMWPManager\\Lib\\';
    if (str_starts_with($class, $prefix)) {
        $relative = substr($class, strlen($prefix));
        $path = __DIR__ . '/lib/' . $relative . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});
