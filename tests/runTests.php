<?php

require __DIR__ . '/../autoload.php';

// Include all PHP files from the 'tests' directory
foreach (glob(__DIR__ . '/*Test.php') as $file) {
    require_once $file;
}

// Fetch all the declared classes so we can loop them
$classes = get_declared_classes();

foreach ($classes as $className) {
    // Only check classes if they end with 'Test' in the name
    if (!str_ends_with($className, 'Test')) {
        continue;
    }

    $reflection = new ReflectionClass($className);

    $instance = $reflection->newInstance();

    // Looping through the public methods of the class
    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if (!str_starts_with($method->name, 'test')) {
            continue;
        }

        echo "Running {$className}::{$method->name}: ";
        try {
            $method->invoke($instance);
            echo "✅ Passed\n";
        } catch (Throwable $e) {
            echo "❌ Failed - " . $e->getMessage() . "\n";
        }
    }
}
