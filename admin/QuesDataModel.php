<?php 

    class Question{
        var $stat;
        var $opt_arr;
        var $img;
        var $table;

        function __construct($stat,$opt_arr,$img,$table){
            $this->stat = $stat;
            $this->opt_arr = $opt_arr;
            $this->img = $img;
            $this->table = $table;
        }

    }




?>