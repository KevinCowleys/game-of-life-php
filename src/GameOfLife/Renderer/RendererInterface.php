<?php

declare(strict_types=1);

namespace GameOfLife\Renderer;

interface RendererInterface
{
    public function render(): void;
    public function clear(): void;
}
