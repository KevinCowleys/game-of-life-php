<?php

declare(strict_types=1);

namespace Tests;

use GameOfLife\CellState;
use GameOfLife\Grid;

/**
 * Class GridTest
 * @covers \GameOfLife\Grid
 */
class GridTest
{
    private array $twoByTwoPattern = [[0, 1], [0, 1]];

    private function makeTwoByTwoGrid(): Grid
    {
        $rows = 2;
        $cols = 2;

        return new Grid($this->twoByTwoPattern, $rows, $cols);
    }

    public function testCreatingNewGridClass(): void
    {
        $rows = 0;
        $cols = 0;
        $grid = new Grid([], $rows, $cols);

        assert($grid->getColumnCount() === 0, 'Expect grid column count to be 0');
        assert($grid->getRowCount() === 0, 'Expect grid row count to be 0');
        assert($grid->toArray() === [], 'Expect grid to return an empty array');
    }

    public function testCreateEmptyGridWithoutValues(): void
    {
        $grid = Grid::create(0, 0);

        assert($grid->getColumnCount() === 0, 'Expect grid column count to be 2');
        assert($grid->getRowCount() === 0, 'Expect grid row count to be 2');
        assert($grid->toArray() === [], 'Expect grid to return an empty array');
    }

    public function testCreateEmptyGridWithValues(): void
    {
        $grid = Grid::create(2, 2);

        assert($grid->getColumnCount() === 2, 'Expect grid column count to be 2');
        assert($grid->getRowCount() === 2, 'Expect grid row count to be 2');
        assert($grid->toArray() === [[0, 0], [0, 0]], 'Expect grid to return an empty array');
    }

    public function testPatternFillsBiggerGrid(): void
    {
        $numRows = 5;
        $numCols = 5;

        $grid = Grid::create($numRows, $numCols, $this->twoByTwoPattern);

        // Manually create our expected outcome
        $rows = array_fill(0, $numRows, array_fill(0, $numCols, CellState::DEAD->value));
        $rows[0][1] = CellState::ALIVE->value;
        $rows[1][1] = CellState::ALIVE->value;

        assert($grid->getColumnCount() === 5, 'Expect grid column count to be 5');
        assert($grid->getRowCount() === 5, 'Expect grid row count to be 5');
        assert($grid->toArray() === $rows, 'Expect grid to equal our expected outcome of using the param sizes');
    }

    public function testPatternFillsSmallerGrid(): void
    {
        $numRows = 2;
        $numCols = 2;
        $pattern = [
            [0, 1, 1, 0, 1],
            [0, 1, 1, 0, 1],
            [0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1],
        ];

        $grid = Grid::create($numRows, $numCols, $pattern);

        assert($grid->getColumnCount() === 2, 'Expect grid column count to be 2');
        assert($grid->getRowCount() === 2, 'Expect grid row count to be 2');
        assert($grid->toArray() === $this->twoByTwoPattern, 'Expect grid to equal our expected outcome of using the param sizes');
    }

    public function testNextGeneration(): void
    {
        $numRows = 5;
        $numCols = 5;
        $pattern = [
            [0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 1, 0],
            [0, 1, 1, 1, 0],
            [0, 0, 0, 0, 0],
        ];
        $expectedPattern = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 1, 0, 1, 0],
            [0, 0, 1, 1, 0],
            [0, 0, 1, 0, 0],
        ];

        $grid = Grid::create($numRows, $numCols, $pattern);

        $grid->nextGeneration();

        assert($grid->toArray() === $expectedPattern, 'Expect grid to be the same as the expected next generation');
    }

    public function testIsAliveReturnsTrue(): void
    {
        $grid = $this->makeTwoByTwoGrid();

        $result = $grid->isAlive(0, 1);

        assert($result === true, 'Expect isAlive to return true when cell is alive.');
    }

    public function testIsAliveReturnsFalseForDeadCell(): void
    {
        $grid = $this->makeTwoByTwoGrid();

        $result = $grid->isAlive(0, 0);

        assert($result === false, 'Expect isAlive to return false when cell is dead.');
    }

    public function testIsAliveReturnsFalseForOutOfRange(): void
    {
        $grid = $this->makeTwoByTwoGrid();

        $result = $grid->isAlive(5, 5);

        assert($result === false, 'Expect isAlive to return false when cell is out of range.');
    }
}
