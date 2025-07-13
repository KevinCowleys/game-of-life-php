<?php

declare(strict_types=1);

namespace Tests\Renderer;

use GameOfLife\Grid;
use GameOfLife\Renderer\ConsoleRenderer;

class ConsoleRendererTest
{
    private array $testPattern = [[0, 1], [1, 0]];
    private string $expectedOutput = <<<'EOD'
    ⬛️🟩
    🟩⬛️

    EOD;
    private String $expectedOutputFxT = <<<'EOD'
    ⬛️🟩⬛️⬛️
    🟩⬛️⬛️⬛️

    EOD;
    private string $expectedOutputEmpty = "";

    public function testConsoleRenderingEmpty()
    {
        $renderer = new ConsoleRenderer();
        $grid = Grid::create(2, 2, $this->testPattern);

        ob_start();
        $renderer->render($grid, 0);
        $output = ob_get_clean();

        assert($output === $this->expectedOutputEmpty, 'Expect the rendered output to be empty when no symbols are given');
    }

    public function testConsoleRenderingHasSymbols()
    {
        $renderer = new ConsoleRenderer();
        $renderer->setAliveSymbol('🟩');
        $renderer->setDeadSymbol('⬛️');
        $grid = Grid::create(2, 2, $this->testPattern);

        ob_start();
        $renderer->render($grid, 0);
        $output = ob_get_clean();

        assert($output === $this->expectedOutput, 'Expect the rendered output to be filled when symbols are given');
    }

    public function testConsoleRenderUsesCorrectWidth()
    {
        $renderer = new ConsoleRenderer();
        $renderer->setAliveSymbol('🟩');
        $renderer->setDeadSymbol('⬛️');
        $grid = Grid::create(4, 2, $this->testPattern);

        ob_start();
        $renderer->render($grid, 0);
        $output = ob_get_clean();

        assert($output === $this->expectedOutputFxT, 'Expect the rendered output to have a longer width');
    }
}
