<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of conectDb
 *
 * @author CristhiamStick
 */
class ConectOraDb {
    
    private $link = null;
    private $queryFormat;
    
    public function __construct() {
        $this->connect();
    }
            
    public function __destruct(){
        $this->close();
    }
    
    private function connect(){ 
        return $this->link = oci_connect(_USER_DB, _PASS_DB, _HOST_DB . "/" . _DB)
        or die('No se pudo conectar: ' . oci_error());
    }
    
    private function close(){
        oci_close($this->link);
    }
    
    /*protected function selectQuery($query){        
        //$result = mysqli_query($query) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);
        $stid = oci_parse($this->link, $query);
        oci_execute($stid) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);
        //$return = oci_fetch_array($stid, OCI_ASSOC);
        oci_fetch_all($stid, $return);
        
        echo '<pre>';
        print_r($return);
        echo '</pre>';die();
        return $return;
    }*/
    
    protected function selectQueryResult($query) {
        $stid = oci_parse($this->link, $query);
        oci_execute($stid) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);
        return $stid;
    }
    
    
    protected function selectQuery($query){        
        //$result = mysqli_query($query) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);

        $stid = oci_parse($this->link, $query);
        oci_execute($stid) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);
        $return = $stid;
        $array_return = array();
        while (($row = oci_fetch_assoc($stid)) != false) {
            $srr_temp = array();
            foreach ($row as $key => $value) {
                $srr_temp[$key] = $value; 
            }
            
            array_push($array_return, $srr_temp);
        }
        
       
        
        return $array_return;
    }
    
    protected function selectFechQuery($query) {
        oci_fetch_array($this->selectQuery($query), OCI_ASSOC);
    }
    
    protected function executeQuery($query){
        //mysql_query($query) or die('Consulta fallida: ' . oci_error());ç
        $stid = oci_parse($this->link, $query);
        oci_execute($stid) or die('Consulta fallida: ' . oci_error() . '<br>' . $query);
    }
    
    protected function parceQuery($query){
        //$this->queryFormat = oci_parse($this->link, $query); 
        return oci_parse($this->link, $query);
    }
    
    protected  function parceAllParams($params){
        foreach ($params as $key => $value) {
            $this->parceParam($key, $value);
        }
    }
    
    protected function parceParam($key, $value) {
        oci_bind_by_name($this->queryFormat, $key, $value);
    }
    
    protected function parceSelectQuery($parceQuery){
        oci_execute($parceQuery) or die('Consulta fallida: ' . oci_error());
        return oci_fetch_array($parceQuery, OCI_ASSOC); 
    }
    
}
?>