<?php

spl_autoload_register(function ($className) {
    // Changing the slashes for Linux
    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
        $className = str_replace('\\', '/', $className);
    }

    $file = __DIR__ . '/src/' . $className . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "Class file for '$className' not found.";
    }
});
