# Game of Life

Game of Life was a game created by Conway in 1970. [View More](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life)

## Rules

The basic rules to the Game of Life are the following:

* Any live cell with fewer than two live neightbours dies as if caused by underpopulation.
* Any live cell with two or three live neighbours lives on to the next generation.
* Any live cell with more than three live neighbours dies, as if by overcrowding.
* Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.

Or to simplify in coding terms:

* Your alive cell dies if it has <> 3 neighbours;
* Your dead cell has = 3 it can then revive;

### What are your neighbours?

Your neighbours include the cells around your current cell. Below you can view a visual representation of what your neighbours are.

|    |    |    |
|----|----|----|
| ⬛️ | ⬛️ | ⬛️ |
| ⬛️ | 🟩 | ⬛️ |
| ⬛️ | ⬛️ | ⬛️ |
