<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of conectDb
 *
 * @author Cristhiam Stick Reina Cabrejo
 */
class ConectDb  {
    
    private $db;

    private function connect(){
        $this->db     = adoNewConnection(_DB_DRIVER);
        $this->db->connect(_HOST_DB,_USER_DB,_PASS_DB,_DB);
    }
    
    private function close(){
        $this->db->Close();
    }
    
    protected function selectQuery($sql){
        $this->connect();
        $this->db->SetFetchMode(ADODB_FETCH_ASSOC); // Return associative array
        $rs = $this->db->Execute($sql);
        $result = false;
        
        if (!$rs) {
            if(_VIEW_ERRORS === true){
                echo 'La consulta no se pudo ejecutar <br>';  
                echo $sql . '<br>';
                print $this->db->ErrorMsg().'<br>'; // Displays the error message if no results could be returned
                die($rs);
            }
        } else {
            $result = array();
            while (!$rs->EOF) {
                array_push($result,$rs->fields);
                $rs->MoveNext();  //  Moves to the next row
            }  // end while
        } // end else
        $this->close();
        return $result;
    }
    
    protected function executeQuery($query){
        $this->connect();
        $ok = $this->db->Execute($query);
        $id = 0;
        
        if($ok){
            $id = $this->db->_connectionID->insert_id;
        }
        
        $this->close();
        return $id;
    }
    
    
}
?>