<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of model
 *
 * @author CristhiamStick
 */
class Model extends ConectDb {
    //put your code here
    private $table          = '';
    private $properties     = array();
    private $primary_key    = '';
    private $edit           = true;
    private $debug          = false;
            
    public function __construct($table, $data = null, $edit = true){
        $this->table = $table;
        $this->edit = $edit;
        if(is_array($data)){
            $this->writeProperties($data);
        } else if(is_numeric($data)){
            $this->writePropertiesId($data);
        }else {
            $this->propertiesTableDB();
        } 
        
    }
    
    public function debuging() {
       $this->debug = true;
    }
    
    
    private function propertiesTableDB(){
        $query = '
            SELECT 
                    c.COLUMN_NAME,
                    c.COLUMN_KEY
            FROM information_schema.COLUMNS c
            WHERE TABLE_SCHEMA = "' . _DB .'" AND 
                            TABLE_NAME = "' . $this->table . '"
        ';

        $result = $this->selectQuery($query);
        foreach ($result as $array) {
            
            $this->properties[trim($array['COLUMN_NAME'])] = '';
            
            if(trim($array['COLUMN_KEY']) == 'PRI'){
                $this->primary_key = $array['COLUMN_NAME'];
            }
            
        }
        
        if(count($this->properties) == 0){
            die('La tabla no existe');
        }
 
        if($this->primary_key == ''){
            die('La tabla no tiene llave primaria');
        }
            
    }
    
    private function writePropertiesId($id){
        $query = '
            SELECT 
                    c.COLUMN_NAME,
                    c.COLUMN_KEY
            FROM information_schema.COLUMNS c
            WHERE TABLE_SCHEMA = "' . _DB .'" AND 
                  TABLE_NAME = "' . $this->table . '" AND
                  c.COLUMN_KEY = "PRI"
        ';
        
        $result = $this->selectQuery($query);
        
        if(isset($result[0]['COLUMN_NAME'])){
            $this->primary_key = $result[0]['COLUMN_NAME'];
        }else{
            die('La tabla no tiene llave primaria');
        }
        
        $query = '
            SELECT 
                *
            FROM ' . $this->table . '
            WHERE ' . $this->primary_key . ' = ' . $id . '
        ';
        
        $result = $this->selectQuery($query);
        
        if((is_array($result[0]) > 0)){
            $this->writeProperties($result[0]);
        }else{
            $this->propertiesTableDB();
        }
        
    }
    
    private function writeProperties($array){
        $query = '
            SELECT 
                    c.COLUMN_NAME,
                    c.COLUMN_KEY
            FROM information_schema.COLUMNS c
            WHERE TABLE_SCHEMA = "' . _DB .'" AND 
                  TABLE_NAME = "' . $this->table . '" AND
                  c.COLUMN_KEY = "PRI"
        ';
        
        $result = $this->selectQuery($query);
        
        if(isset($result[0]['COLUMN_NAME'])){
            $this->primary_key = $result[0]['COLUMN_NAME'];
        }
        
        foreach ($array as $key => $value) {
            $this->properties[$key] = trim($value);
        }
    } 

    private function insert(){
        $columns = '';
        $values  = '';    
        $coma = '';
        
        foreach ($this->properties as $key => $value) {
            if($key != $this->primary_key ){
                $columns .= $coma . $key;
                $values  .= $coma . '"' . $value . '"';
                $coma = ',';
            }
            
        }
        
        $query = '
            insert into ' . $this->table . '(
                ' . $columns . '
            ) values(
                ' . $values . '
            )
        ';
        
        if($this->debug){
            echo $query . '<br>';
        }
        
        $this->properties[$this->primary_key] = $this->executeQuery($query);
    }
    
    private function update(){
        $set = '';
        $coma = '';
        foreach ($this->properties as $key => $value) {
            if($key != $this->primary_key ){
                $set .= $coma . $key . '=' . '"' . $value . '"';
                $coma = ',';
            }
            
        }
        
        $query = '
            update ' . $this->table . '
            set ' . $set . ' 
            where ' . $this->primary_key . ' = ' . $this->properties[$this->primary_key] . '
        ';
        
        if($this->debug){
            echo $query . '<br>';
        }
        
        $this->executeQuery($query);
    }
    
    public function save(){
        if($this->edit){
            if($this->properties[$this->primary_key] != '' && is_numeric($this->properties[$this->primary_key]) ){
                $this->update();
            }else{
                $this->insert();
            }
        }
    }
    
    public function primary_value(){
        return $this->properties[$this->primary_key];
    }
    
    public function primary_key(){
        return $this->primary_key;
    }
    
    public function get($key){
        if(isset($this->properties[$key]))
            return $this->properties[$key];
        else
            return '';
    }
    
    public function set($key,$value){
        if((isset($this->properties[$key])) && ($this->edit))
            $this->properties[$key] = trim($value);    
    }
    
    public function delete(){
        if(($this->properties[$this->primary_key] != '') && (is_numeric($this->properties[$this->primary_key])) && ($this->edit)){
            $query = '
                delete from ' . $this->table . ' where ' . $this->primary_key . ' = ' . $this->properties[$this->primary_key] . '
            ';
            
            if($this->debug){
                echo $query . '<br>';
            }
        
            $this->executeQuery($query);
            $this->propertiesTableDB();
        }
    }
            
}
