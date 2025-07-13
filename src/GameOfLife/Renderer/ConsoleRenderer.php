<?php

declare(strict_types=1);

namespace GameOfLife\Renderer;

use GameOfLife\Grid;

class ConsoleRenderer implements RendererInterface
{
    private string $symbolAlive = '';
    private string $symbolDead = '';

    public function render(Grid $grid, int $generation): void
    {
        foreach ($grid->toArray() as $row) {
            $print_row = '';

            foreach ($row as $cell) {
                $print_row .= ($cell ? $this->symbolAlive : $this->symbolDead);
            }

            if ($print_row === '') continue;
            print $print_row . "\n";
        }
    }

    public function clear(): void
    {
        echo "\033[2J\033[H";
    }

    public function setAliveSymbol(string $symbol): void
    {
        $this->symbolAlive = $symbol;
    }

    public function setDeadSymbol(string $symbol): void
    {
        $this->symbolDead = $symbol;   
    }

    public function finish(int $generation): void
    {
        echo "The game has ended after $generation generations!";
    }
}
