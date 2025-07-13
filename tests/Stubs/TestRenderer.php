<?php

declare(strict_types=1);

namespace Tests\Stubs;

use GameOfLife\Renderer\RendererInterface;
use GameOfLife\Grid;

class TestRenderer implements RendererInterface
{
    public array $calls = [];

    public function setDeadSymbol(string $symbol): void
    {
        $this->calls[] = ['method' => 'setDeadSymbol', 'param' => $symbol];
    }

    public function setAliveSymbol(string $symbol): void
    {
        $this->calls[] = ['method' => 'setAliveSymbol', 'param' => $symbol];
    }

    public function clear(): void
    {
        $this->calls[] = ['method' => 'clear'];
    }

    public function render(Grid $grid, int $generation): void
    {
        $this->calls[] = ['method' => 'render', 'param' => $generation];
    }

    public function finish(int $generation): void
    {
        $this->calls[] = ['method' => 'finish', 'param' => $generation];
    }
}