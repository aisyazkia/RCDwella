<?php

if(!function_exists('getDayIndo')){
    function getDayIndo($index){
        $days = [
          1 => 'Senin',  
          2 => 'Selasa',  
          3 => 'Rabu',  
          4 => 'Kamis',  
          5 => 'Jumat',  
          6 => 'Sabtu',  
          7 => 'Minggu',  
        ];
        return $days[$index];
    }
}