<?php

declare(strict_types=1);

namespace GameOfLife;

enum CellState: int
{
    case DEAD = 0;
    case ALIVE = 1;
}

class Grid
{
    /** @var array<array<int>> */
    private array $rows;
    private int $numRows;
    private int $numCols;
    private bool $hasGameEnded = false;
    private bool $isInfinite = false;

    private const NEIGHBOUR_MIN = 2;
    private const REVIVE_COUNT = 3;
    private const SURVIVE_COUNT = 3;

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
     * Creates a new grid
     *
     * It creates an empty grid with all the cells starting out as dead if a
     * pattern isn't given.
     *
     * Patterns will always start from the top left.
     * Additionally, we will only create a grid the size of $numRows and $numCols.
     * Anything outside of that will be ignored in the pattern.
     *
     * @param int $numRows
     * @param int $numCols
     * @param array<array<int>> $pattern
     *
     * @return self
     */
    public static function create(int $numRows, int $numCols, array $pattern = []): self
    {
        $rows = array_fill(0, $numRows, array_fill(0, $numCols, CellState::DEAD->value));

        foreach ($pattern as $rowIndex => $row) {
            if (!is_array($row) || $rowIndex >= $numRows) continue;

            foreach ($row as $colIndex => $value) {
                if ($colIndex < $numCols) {
                    $rows[$rowIndex][$colIndex] = (int)$value;
                }
            }
        }

        return new self($rows, $numRows, $numCols);
    }

    /**
     * Generates the next generation
     *
     * @return void
     */
    public function nextGeneration(): void
    {
        $cellsToRemove = [];
        $cellsToCreate = [];

        foreach ($this->rows as $rowIndex => $row) {
            foreach ($row as $colIndex => $cellAlive) {
                $alive = $this->countAliveNeighbours($rowIndex, $colIndex);

                // Cell is not alive, check if we should revive
                if ($cellAlive === CellState::DEAD->value && $alive === self::REVIVE_COUNT) {
                    $cellsToCreate[] = [$rowIndex, $colIndex];
                    continue;
                }

                // Cell is alive, check if we should remove it
                if (
                    $cellAlive === CellState::ALIVE->value
                    && ($alive < self::NEIGHBOUR_MIN || $alive > self::SURVIVE_COUNT)
                ) {
                    $cellsToRemove[] = [$rowIndex, $colIndex];
                    continue;
                }
            }
        }

        // The game has ended
        if (empty($cellsToRemove) && empty($cellsToCreate)) {
            $this->hasGameEnded = true;
        }

        // Remove dead cells
        foreach ($cellsToRemove as $deadCell) {
            $this->rows[$deadCell[0]][$deadCell[1]] = CellState::DEAD->value;
        }

        // Add new cells
        foreach ($cellsToCreate as $reviveCell) {
            $this->rows[$reviveCell[0]][$reviveCell[1]] = CellState::ALIVE->value;
        }
    }

    /**
     * Counts alive neighbours
     *
     * @param int $row
     * @param int $col
     *
     * @return int
     */
    private function countAliveNeighbours(int $row, int $col): int
    {
        $alive = 0;

        for ($offsetRow = -1; $offsetRow <= 1; $offsetRow++) {
            for ($offsetCol = -1; $offsetCol <= 1; $offsetCol++) {
                // Skip, we're at the cell we're checking for
                if ($offsetRow === 0 && $offsetCol === 0) continue;

                $rowIndex = $row + $offsetRow;
                $colIndex = $col + $offsetCol;

                if ($this->isInfinite) {
                    // Wrap around with modulo for toroidal behavior
                    $rowIndex = ($rowIndex + $this->numRows) % $this->numRows;
                    $colIndex = ($colIndex + $this->numCols) % $this->numCols;
                } else {
                    // Skip out-of-bounds
                    if (
                        $rowIndex < 0
                        || $rowIndex >= $this->numRows
                        || $colIndex < 0
                        || $colIndex >= $this->numCols
                    ) {
                        continue;
                    }
                }

                if ($this->isAlive($rowIndex, $colIndex)) {
                    $alive++;
                }
            }
        }

        return $alive;
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
     * @return int
     */
    public function getColumnCount(): int
    {
        return $this->numCols;
    }

    /**
     * Returns the active status
     *
     * @return bool
     */
    public function hasGameEnded(): bool
    {
        return $this->hasGameEnded;
    }

    /**
     * Sets it to toroidal / infinite.
     *
     * @param bool $setValue
     *
     * @return void
     */
    public function setInfinite(bool $setValue): void
    {
        $this->isInfinite = $setValue;
    }
}
