<?php

spl_autoload_register(function ($className) {
    if (!is_string($className)) return false;

    // Map the root namespace to folders
    $namespaceMap = [
        'GameOfLife' => __DIR__ . '/src/GameOfLife',
        'Tests'      => __DIR__ . '/tests',
    ];

    foreach ($namespaceMap as $namespace => $baseDir) {
        if (strpos($className, $namespace . '\\') === 0) {
            // Normalize the namespace separators for any OS
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

            // Replace the namespace prefix with its folder
            $relative = substr($file, strlen($namespace));
            $path = $baseDir . $relative;

            if (file_exists($path)) {
                require_once $path;
                return true;
            }
        }
    }

    echo "Class file for '$className' not found.";
    return false;
});
