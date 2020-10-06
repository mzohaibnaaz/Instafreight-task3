<?php

$arr = array(
    array(0, 6, 0,   0, 0, 0,    0, 3, 0),
    array(0, 0, 0,   5, 0, 0,    0, 0, 4),
    array(4, 1, 0,   0, 0, 9,    0, 2, 0),
    
    array(0, 0, 4,   0, 0, 0,    0, 0, 0),
    array(0, 3, 6,   0, 0, 0,    4, 8, 9),
    array(0, 0, 2,   4, 8, 6,    0, 0, 0),
    
    array(0, 2, 7,   0, 0, 0,    0, 9, 0),
    array(6, 0, 1,   9, 0, 0,    3, 0, 7),
    array(9, 4, 0,   0, 0, 5,    0, 1, 0),
);

class Sudoku {

    private $arr = array();
    private $grids = array();
    private $columns = array();
    private $time_tracking = array();


    public function __construct() {
        $this->time_tracking['start'] = microtime(true);
    }

    // create grid of 3x3
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

    // create array with ORDER BY COLUMNS
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

    // get possible values for current cell
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

    public function solve($arr) {
        while (true) {
            $this->arr = $arr;

            $this->set_columns();
            $this->set_grids();

            $ops = array();
            foreach ($arr as $k => $row) {
                foreach ($row as $kk => $r) {
                    if ($r == 0) {
                        $pos_vals = $this->getPossibleValues($k, $kk);
                        $ops[] = array(
                            'rowIndex' => $k,
                            'columnIndex' => $kk,
                            'permissible' => $pos_vals
                        );
                    }
                }
            }

            if (empty($ops)) {
                return $arr;
            }

            usort($ops, array($this, 'sortOps'));

            if (count($ops[0]['permissible']) == 1) {
                $arr[$ops[0]['rowIndex']][$ops[0]['columnIndex']] = current($ops[0]['permissible']);
                continue;
            }

            foreach ($ops[0]['permissible'] as $value) {
                $tmp = $arr;
                $tmp[$ops[0]['rowIndex']][$ops[0]['columnIndex']] = $value;
                if ($result = $this->solve($tmp)) {
                    return $this->solve($tmp);
                }
            }

            return false;
        }
    }

    private function sortOps($a, $b) {
        $a = count($a['permissible']);
        $b = count($b['permissible']);
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    public function getSolved() {
        return $this->arr;
    }

    public function print() {
        echo "<br />";
        foreach ($this->arr as $k => $row) {
            foreach ($row as $kk => $r) {
                echo $r . ' ';
            }
            echo "<br />";
        }
    }

    public function __destruct() {
        $this->time_tracking['end'] = microtime(true);
        $time = $this->time_tracking['end'] - $this->time_tracking['start'];
        echo "\nExecution time : " . number_format($time, 3) . " sec\n\n";
    }


}

$game = new Sudoku();
$game->solve($arr);
//$array = $game->getSolved();
$game->print();

?>