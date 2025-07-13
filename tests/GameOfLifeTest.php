<?php

declare(strict_types=1);

namespace Tests;

class GameOfLifeTest
{
    private string $script = '';

    public function __construct()
    {
        $this->script = escapeshellcmd(__DIR__ . '/../bin/GameOfLife.php');;   
    }

    public function testHelpShorthandCanBeCalled(): void
    {
        $output = shell_exec('php ' . $this->script . ' -h 2>&1');
        $output = rtrim($output);

        assert(str_contains($output, 'Here\'s a list of available options:'), 'Expect -h to return help commands');
    }

    public function testHelpLongCanBeCalled(): void
    {
        $output = shell_exec('php ' . $this->script . ' --help 2>&1');
        $output = rtrim($output);

        assert(str_contains($output, 'Here\'s a list of available options:'), 'Expect --help to return help commands');
    }

    public function testSpeedShortOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' -s=0 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: speed must be between 1 and 10000.', 'Expect -s option to require a minimum');
    }

    public function testSpeedShortOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' -s=1000000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: speed must be between 1 and 10000.', 'Expect -s option to require a max');
    }

    public function testSpeedLongOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' --speed=0 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: speed must be between 1 and 10000.', 'Expect --speed option to require a minimum');
    }

    public function testSpeedLongOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' --speed=1000000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: speed must be between 1 and 10000.', 'Expect --speed option to require a max');
    }

    public function testWidthShortOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' -W=1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: Width must be between 18 and 50.', 'Expect -W option to require a minimum');
    }

    public function testWidthShortOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' -W=1000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: Width must be between 18 and 50.', 'Expect -W option to require a max');
    }

    public function testWidthLongOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' --Width=1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: Width must be between 18 and 50.', 'Expect -Width option to require a minimum');
    }

    public function testWidthLongOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' --Width=1000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: Width must be between 18 and 50.', 'Expect -Width option to require a max');
    }

    public function testHeightShortOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' -H=1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: Height must be between 18 and 50.', 'Expect -H option to require a minimum');
    }

    public function testHeightShortOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' -H=1000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: Height must be between 18 and 50.', 'Expect -H option to require a max');
    }

    public function testHeightLongOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' --Height=1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: Height must be between 18 and 50.', 'Expect -Height option to require a minimum');
    }

    public function testHeightLongOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' --Height=1000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: Height must be between 18 and 50.', 'Expect -Height option to require a max');
    }

    public function testPatternShortOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' -p=-1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: pattern must be between 0 and 8.', 'Expect -p option to require a minimum');
    }

    public function testPatternShortOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' -p=10000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: pattern must be between 0 and 8.', 'Expect -p option to require a max');
    }

    public function testPatternLongOptionTooLow(): void
    {
        $output = shell_exec('php ' . $this->script . ' --pattern=-1 2>&1');
        $output = rtrim($output);

        assert($output === 'Error: pattern must be between 0 and 8.', 'Expect -pattern option to require a minimum');
    }

    public function testPatternLongOptionTooHigh(): void
    {
        $output = shell_exec('php ' . $this->script . ' --pattern=1000 2>&1');
        $output = rtrim($output);

        assert($output  === 'Error: pattern must be between 0 and 8.', 'Expect -pattern option to require a max');
    }
}
