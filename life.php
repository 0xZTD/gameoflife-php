<?php




function createGrid($x, $y, $value = 0)
{
    return array_fill(0, $x, array_fill(0, $y, $value));
}

function setup($grid)
{
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            $grid[$i][$j] = rand(0, 1);
        }
    }
    return $grid;
}

function draw($grid)
{
    $rows = count($grid);
    $cols = count($grid[0]);

    for ($i = 0; $i < $rows; $i++) {
        echo "\n";
        for ($j = 0; $j < $cols; $j++) {
            $char = $grid[$i][$j] == 1 ? "\u{2588}\u{2588}" : "\u{2591}\u{2591}";
            echo $char;
        }
    }
    echo "\n";
}

function gameOfLife($grid)
{
    $rows = count($grid);
    $cols = count($grid[0]);

    for ($row = 0; $row < $rows; $row++) {
        for ($col = 0; $col < $cols; $col++) {
            $alive = -$grid[$row][$col]; // dont count self

            for ($x = $row - 1; $x < $row + 2; $x++) {
                for ($y = $col - 1; $y < $col + 2; $y++) {
                    if (0 <= $x && $x < $rows && 0 <= $y && $y < $cols && $grid[$x][$y] > 0) {
                        $alive++;
                    }
                }
            }

            /**
             *  Any live cell with fewer than two live neighbors dies, as if by underpopulation.
             *  Any live cell with two or three live neighbors lives on to the next generation.
             *  Any live cell with more than three live neighbors dies, as if by overpopulation.
             *  Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.
             */
            if ($grid[$row][$col] == 1 && ($alive < 2 || $alive > 3)) {
                $grid[$row][$col] = 2;
            }
            if ($grid[$row][$col] == 0 && ($alive == 3)) {
                $grid[$row][$col] = -1;
            }
        }
    }
    for ($row = 0; $row < $rows; $row++) {
        for ($col = 0; $col < $cols; $col++) {
            if ($grid[$row][$col] == 2) {
                $grid[$row][$col] = 0;
            } elseif ($grid[$row][$col] == -1) {
                $grid[$row][$col] = 1;
            }
        }
    }
    return $grid;
}

function play(int $times)
{
    // initial
    $grid = createGrid(20, 20, 0);
    $grid = setup($grid);
    draw($grid);

    for ($i = 0; $i < $times; $i++) {
        $grid = gameOfLife($grid);
        draw($grid);
    }
}

play(10);