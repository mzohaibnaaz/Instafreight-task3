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


class Sudoku{
    
    private $arr = [];
    private $col = [];
    private $row = [];
    private $grid = [];
    private $grids = [];
    
    function __construct($arr){
        $this->arr = $arr;
    }
    
    private function setCol($i){
        $column = [];    
        for($j = 0; $j < 9; $j++){
            $column[] = $this->arr[$j][$i]; 
        }
        $this->col = $column;
    }
    
    private function setRow($i){
        $this->row = $this->arr[$i];
    }
    
    function solve(){
        
        for($i = 0; $i < 9; $i++){
            $row = $this->arr[$i];
            
            //echo "<hr/>";
            
            for($j = 0; $j < 9; $j++){
                
                $current = $row[$j];
                
                
                $this->setRow($i);
                $this->setCol($j);
                
                //echo $i." - ".$j." : ".$current."<br />";
                //echo "<pre>".print_r($this->grid,1)."</pre>";                                
                 
                if($current == 0){
                    for($k = 1; $k < 10; $k++){
                        
                        if(!(in_array($k, $this->row) || in_array($k, $this->col) || $this->checkSquare($i, $j, $k) )){
                            $this->arr[$i][$j] = $k;
                        }
                            
                    }
                }
            }
            
        }
        
        for($x=0;$x<9;$x++){
            echo implode(",", $this->arr[$x])."<br />";
        }
    }
    
    private function checkSquare($row, $column, $value){
        $boxRow = floor($row / 3) * 3;
        $boxCol = floor($column / 3) * 3;
        
        for ($r = 0; $r < 3; $r++){
            for ($c = 0; $c < 3; $c++){
                if ($this->arr[$boxRow + $r][$boxCol + $c] === $value)
                    return true;
            }
        }
    
        return false;
    }
    
}

$sudoku = new Sudoku($arr);
$sudoku->solve();

?>