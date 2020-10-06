# Tast 3


I never played Sudoku & it almost took 1 hour to understand gameplay and implement the solution.

i have included my first attempt as well, just to show how i was trying to solve it :)
please check `1st-attempt.php`
i tried to implement solution with [Wiki](https://en.wikipedia.org/wiki/Sudoku_solving_algorithms#Backtracking). but because I'm picking values randomly for each cell between 1 to 9. For one case value for current cell couldn't be changed
because row, column and corresponding grid already have taken all the values between 1 to 9. So some of my cell left blank(0) in result.


after trying for half hour 
i started to look into google for solutions and found that tutorial.[Tutorial for Sudoku Solver](https://toneus.co.uk/suduku-solver-php-part-1/)
& [Git Repo](https://github.com/kirilkirkov/Sudoku-Solver/blob/master/sudoku.php)
and decided to wind up with that.

> but I'll try to fix that bug with my 1st-attempt :)

## Usage

```php
$game = new Sudoku();
$game->solve($arr);
//$array = $game->getSolved();
$game->print();
```

## Explaining

`set_grids` method
used to create 3x3 grid for each cell
this function updates grid every new iteration!


```php
    private function set_grids() { 
        $grids = array();
        foreach ($this->arr as $k => $row) {
            if ($k <= 2) {
                $row_num = 1;
            }
            if ($k > 2 && $k <= 5) {
                $row_num = 2;
            }
            if ($k > 5 && $k <= 8) {
                $row_num = 3;
            }

            foreach ($row as $kk => $r) {
                if ($kk <= 2) {
                    $col_num = 1;
                }
                if ($kk > 2 && $kk <= 5) {
                    $col_num = 2;
                }
                if ($kk > 5 && $kk <= 8) {
                    $col_num = 3;
                }
                $grids[$row_num][$col_num][] = $r;
            }
        }
        $this->grids = $grids;
    }

```

`set_columns` method used to order array by column,
because our array is ordered by row, we need it to order by column for match search in column of current cell.

```php
    private function set_columns() { 
        $columns = array();
        $i = 1;
        foreach ($this->arr as $k => $row) {
            $e = 1;
            foreach ($row as $kk => $r) {
                $columns[$e][$i] = $r;
                $e++;
            }
            $i++;
        }
        
        $this->columns = $columns;
    }
```
`getPossibleValues` method
will return all possible values for current empty cell, by compare value into row, column and grid for current cell.
```php
    private function getPossibleValues($k, $kk) { 
        $values = array();
        if ($k <= 2) {
            $row_num = 1;
        }
        if ($k > 2 && $k <= 5) {
            $row_num = 2;
        }
        if ($k > 5 && $k <= 8) {
            $row_num = 3;
        }

        if ($kk <= 2) {
            $col_num = 1;
        }
        if ($kk > 2 && $kk <= 5) {
            $col_num = 2;
        }
        if ($kk > 5 && $kk <= 8) {
            $col_num = 3;
        }

        for ($n = 1; $n <= 9; $n++) {
            if (!in_array($n, $this->arr[$k]) && !in_array($n, $this->columns[$kk + 1]) && !in_array($n, $this->grids[$row_num][$col_num])) {
                $values[] = $n;
            }
        }
        return $values;
    }
```
