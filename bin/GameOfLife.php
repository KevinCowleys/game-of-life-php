<?php

declare(strict_types=1);

use GameOfLife\Game;
use GameOfLife\Renderer\ConsoleRenderer;

require __DIR__ . '/../autoload.php';

$configLocation =  __DIR__ . '/../config/config.php';

if (!file_exists($configLocation)) {
    echo "Config file '$configLocation' was not found.";
    return;
}

$config = require_once $configLocation;

$options = getopt('his::W::H::p::', [
    'help',
    'infinite',
    'speed::',
    'Width::',
    'Height::',
    'pattern::',
]);

$rules = [
    'speed' => ['min' => 1, 'max' => 10000],
    'Width' => ['min' => 18, 'max' => 50],
    'Height' => ['min' => 18, 'max' => 50],
    'pattern' => ['min' => 0, 'max' => 8],
];

$errors = [];
$validated = is_array($config) ? $config : [];

$help = <<<'EOD'
    Here's a list of available options:

    -h, --help      Shows available commands.
    -i, --infinite  Sets the grid to be toroidal, meaning it wraps around. This is not the default.
    -s, --speed     Set the speed in milliseconds of the world an how fast it should go. Expects integer value. Default=500
    -W, --Width     Sets the width of the grid. Only values between 18-50 are allowed. Default=25
    -H, --Height    Sets the height of the grid. Only values between 18-50 are allowed. Default=25
    -p, --pattern   Sets the pattern to use. The default pattern is the glider pattern. Default=0
                    Available patterns are:
                    0 - Glider (Default)
                    1 - Light-weight spaceship (LWSS) 
                    2 - Middle-weight spaceship (MWSS) 
                    3 - Heavy-weight spaceship (HWSS) 
                    4 - Blinker
                    5 - Toad
                    6 - Beacon
                    7 - Pulsar
                    8 - Penta-decathlon

    EOD;

if (isset($options['h']) || isset($options['help'])) {
    echo $help;
    exit(0);
}

foreach ($rules as $key => $rule) {
    // Match the short flag
    $short = substr($key, 0, 1);

    // Don't validate all keys, none are required
    if (!isset($options[$short]) && !isset($config[$key])) {
        continue;
    }

    $value = $options[$short] ?? $options[$key] ?? $config[$key];
    $value = (int)$value;

    if ($value < $rule['min'] || $value > $rule['max']) {
        $errors[] = "$key must be between {$rule['min']} and {$rule['max']}.";
    } else {
        $validated[$key] = $value;
    }
}

$validated['infinite'] = isset($options['i']) ?: isset($options['infinite']);

// Show errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        fwrite(STDERR, "Error: $error\n");
    }
    exit(1);
}

// There's only a console renderer now, but can be swapped in the future
// depending on where it's render. This script is only run in the console now
// so this is what we will always use.
$renderer = new ConsoleRenderer();

$game = new Game($renderer, $validated);

$game->run();
