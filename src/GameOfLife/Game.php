<?php

declare(strict_types=1);

namespace GameOfLife;

use GameOfLife\Renderer\RendererInterface;

class Game
{
    private const MICROSECONDS_IN_MILLISECOND = 1000;
    private const DEFAULT_SPEED_IN_MILLISECOND = 500;
    private const DEFAULT_PATTERN = 0;
    private const DEFAULT_GRID_SIZE = 25;
    private const PATTERNS_LOCATION = __DIR__ . '/../../config/patterns.php';

    private RendererInterface $renderer;
    private array $config;

    public function __construct(RendererInterface $renderer, array $config)
    {
        $this->config = $config;
        $this->renderer = $renderer;
        $this->renderer->setDeadSymbol($config['symbolDead'] ?? '');
        $this->renderer->setAliveSymbol($config['symbolAlive'] ?? '');
    }

    /**
     * Starts the Game of Life loop
     *
     * @return void
     */
    public function run(): void
    {
        $pattern = require_once self::PATTERNS_LOCATION;

        $grid = Grid::create(
            $this->config['Width'] ?? self::DEFAULT_GRID_SIZE,
            $this->config['Height'] ?? self::DEFAULT_GRID_SIZE,
            $pattern[$this->config['pattern'] ?? self::DEFAULT_PATTERN]
        );

        $grid->setInfinite($this->config['infinite'] ?? false);

        $generation = 0;
        $speed = self::MICROSECONDS_IN_MILLISECOND * ($this->config['speed'] ?? self::DEFAULT_SPEED_IN_MILLISECOND);

        while (true) {
            $this->renderer->clear();
            $this->renderer->render($grid, $generation);
            usleep($speed);
            $grid->nextGeneration();

            if ($grid->hasGameEnded()) {
                $this->renderer->finish($generation);
                return;
            }

            $generation++;
        }
    }
}
