<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of HelperDb
 *
 * @author CristhiamStick
 */
class HelperDb extends ConectDb {
    //put your code here
    private $table = null; 
    private $echo  = false;
    
    public function __construct($table, $echo = false) {
        $this->table = $table;
        $this->echo  = $echo;
    }
    
    public function selectResult($where = '', $inner = '', $select = '*') {
        $query = '
            select ' . $select . ' 
            from ' . $this->table . ' 
                ' . $inner . '
            where 1=1 ' . $where . '                
        ';
        
        if($this->echo){
            echo '<br>' . $query . '<br>';
        }
        return $this->selectQuery($query);
    }
    
    public function selectObj($edit = true, $where = '', $inner = '', $select = '*'){
        $result = $this->selectResult($where, $inner, $select);
        $array_return = array();
        $edit = (trim($inner) == '') ? $edit : false;
        
        foreach ($result as $data) {
            array_push($array_return, new Model($this->table, $data, $edit));
        }
        
        return $array_return;
    }
    
    public function selectObjQuery($query, $edit = true){
        $result = $this->selectQuery($query);
        $array_return = array();
        foreach ($result as $data) {
            array_push($array_return, new Model($this->table, $data, $edit));
        }
        return $array_return;
    }
    
}
