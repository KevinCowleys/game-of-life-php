<?php

declare(strict_types=1);

namespace GameOfLife\Renderer;

use GameOfLife\Grid;

interface RendererInterface
{
    /**
     * Renders table.
     *
     * Used to render the table / game
     *
     * @param Grid $grid
     * @param int $generation
     *
     * @return void
     */
    public function render(Grid $grid, int $generation): void;

    /**
     * Clears the table.
     *
     * Used to clear the previous table.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Set the alive symbol for renderer.
     *
     * Used to set the symbol for alive cells.
     * If this doesn't get done then it'll be an empty string.
     *
     * @param string $symbol
     *
     * @return $symbol
     */
    public function setAliveSymbol(string $symbol): void;

    /**
     * Set the dead symbol for renderer.
     *
     * Used to set the symbol for dead cells.
     * If this doesn't get done then it'll be an empty string.
     *
     * @param string $symbol
     *
     * @return $symbol
     */
    public function setDeadSymbol(string $symbol): void;
}
