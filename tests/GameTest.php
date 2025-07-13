<?php

declare(strict_types=1);

namespace Tests;

use GameOfLife\Game;
use Tests\Stubs\TestRenderer;

class GameTest
{
    /**
     * Checks if the method has been called with param
     *
     * @param array $calls
     * @param string $method
     * @param string $value
     *
     * @return bool
     */
    private function hasBeenCalledWith(array $calls, string $method, string $value): bool
    {
        foreach ($calls as $call) {
            if (
                isset($call['method'])
                && $call['method'] === $method
                && isset($call['param'])
                && $call['param'] === $value
            ) {
                return true;
            }
        }
        return false;
    }

    public function testConstructorDefaultToEmptySymbols(): void
    {
        $renderer = new TestRenderer();

        new Game($renderer, []);
        $aliveSymbolSet = $this->hasBeenCalledWith($renderer->calls, 'setAliveSymbol', '');
        $deadSymbolSet = $this->hasBeenCalledWith($renderer->calls, 'setDeadSymbol', '');

        assert($aliveSymbolSet === true, 'Expect the alive symbol to be set to default');
        assert($deadSymbolSet === true, 'Expect the dead symbol to be set to default');
    }

    public function testConstructorSetsRendererSymbols(): void
    {
        $renderer = new TestRenderer();

        new Game($renderer, ['symbolAlive' => '1', 'symbolDead' => '0']);
        $aliveSymbolSet = $this->hasBeenCalledWith($renderer->calls, 'setAliveSymbol', '1');
        $deadSymbolSet = $this->hasBeenCalledWith($renderer->calls, 'setDeadSymbol', '0');

        assert($aliveSymbolSet === true, 'Expect the alive symbol to be set');
        assert($deadSymbolSet === true, 'Expect the dead symbol to be set');
    }

    public function testRunCanBeFinished(): void
    {
        $renderer = new TestRenderer();

        $game = new Game($renderer, ['speed' => '1']);
        $game->run();
        $lastEntry = end($renderer->calls);

        assert(array_key_exists('method', $lastEntry) && $lastEntry['method'] === 'finish', 'Expecting the finish call to be called');
    }
}
