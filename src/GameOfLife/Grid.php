<?php

declare(strict_types=1);

namespace GameOfLife;

class Grid
{
    private array $rows;
    private int $numRows;
    private int $numCols;

    /**
     * @param array<array<int>> $rows
     * @param int $numRows
     * @param int $numCols
     */
    public function __construct(array $rows, int $numRows, int $numCols)
    {
        $this->rows = $rows;
        $this->numRows = $numRows;
        $this->numCols = $numCols;
    }

    /**
     * Creates an empty grid.
     *
     * It creates an empty grid with all the cells starting out as dead.
     *
     * @param int $numRows
     * @param int $numCols
     *
     * @return self
     */
    public static function createEmptyGrid(int $numRows, int $numCols): self
    {
        $rows = [];

        for ($i = 0; $i < $numRows; $i++) {
            $rows[$i] = array_fill(0, $numCols, 0);
        }

        return new self($rows, $numRows, $numCols);
    }

    /**
     * Creates a grid from a pattern.
     *
     * It creates a grid from a pattern. Patterns will always start from the top left.
     * Additionally, we will only create a grid the size of $numRows and $numCols.
     * Anything outside of that will be ignored in the pattern.
     *
     * @param array<array<int>> $pattern
     * @param int $numRows
     * @param int $numCols
     *
     * @return self
     */
    public static function createFromPattern(array $pattern, int $numRows, int $numCols): self
    {
        $rows = [];

        for ($i = 0; $i < $numRows; $i++) {
            $rows[$i] = array_fill(0, $numCols, 0);

            if (!isset($pattern[$i]) || !is_array($pattern[$i])) {
                continue;
            }

            foreach ($pattern[$i] as $col => $val) {
                // Avoid making grid bigger than what was asked for in $numCols
                if ($col > $numCols - 1) {
                    continue;
                }

                $rows[$i][$col] = (int)$val;
            }
        }

        return new self($rows, $numRows, $numCols);
    }

    public function nextGeneration()
    {

    }

    private function countAliveNeighbours()
    {
        
    }

    /**
     * Checks if a cell is alive
     *
     * This will return true or false if a cell is alive,
     * however, it will also return false if the given $row
     * or $col values aren't set.
     *
     * @param int $row
     * @param int $col
     *
     * @return bool
     */
    public function isAlive(int $row, int $col): bool
    {
        return (bool)($this->rows[$row][$col] ?? false);
    }

    /**
     * Returns the rows and cols
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->rows;
    }

    /**
     * Returns the number of rows
     *
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->numRows;
    }

    /**
     * Returns the number of columns
     *
     * @param int
     */
    public function getColumnCount(): int
    {
        return $this->numCols;
    }
}
