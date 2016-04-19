<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test_controller
 *
 * @author Cristhiampc
 */
class test_controller extends app_controller  {
    //put your code here
    
    protected $name_controller = 'test';
    
    public function init() {
        $vars = array();
        $this->includeView("form", $vars);
    }
    
    public function imageTest(){
           
        $this->saveImage('uno');
        
        
    }
}
