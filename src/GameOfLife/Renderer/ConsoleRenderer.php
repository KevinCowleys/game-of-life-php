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
        $gridData = $grid->toArray();
        $rowCount = count($gridData);
        $colCount = count($gridData[0] ?? []);

        $toPrint = '';

        // go through all the first cols
        for ($col = 0; $col < $colCount; $col++) {
            // loop through the rows
            for ($row = 0; $row < $rowCount; $row++) {
                if (!isset($gridData[$row][$col])) continue;

                $toPrint .= ($gridData[$row][$col] ? $this->symbolAlive : $this->symbolDead);
            }

            // Skip if it's empty
            if ($toPrint === '') continue;

            $toPrint .= "\n";
        }

        echo $toPrint;
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
