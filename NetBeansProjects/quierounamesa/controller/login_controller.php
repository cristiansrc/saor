<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author crist
 */

class login_controller extends Controller {
    //put your code here
    protected $name_controller = 'login';
    
    public function init() {
        $this->login();
    }
    
    public function login(){
        if(defined('_TEMPLATE_SCRIPTS') === FALSE){
            define('_TEMPLATE_SCRIPTS', _APPLICACION_URL . 'template/app/');
        }
        $this->includeView('form');
    }
    
    public function initSession(){
        
        $dao = new DaoDb('view_persona');
        $objs = $dao->selectObj(true, ' and mail = "' . $_POST['mail_user'] . '" and contrasena = "' . md5($_POST['pass_user']) . '" and id_estado = 1 and id_eliminacion = 1');
        $array = array();
        $array["respuesta"] = "Si";
        
        if(count($objs) > 0){
            $obj = $objs[0];
            $array["respuesta"] = "Si";
            $_SESSION['id_persona']         = $obj->get('id_persona');
            $_SESSION['identificacion']     = $obj->get('identificacion');
            $_SESSION['primer_nombre']      = $obj->get('primer_nombre');
            $_SESSION['otros_nombres']      = $obj->get('otros_nombres');
            $_SESSION['primer_apellido']    = $obj->get('primer_apellido');
            $_SESSION['otros_apellidos']    = $obj->get('otros_apellidos');
            $_SESSION['id_tipo_persona']    = $obj->get('id_tipo_persona');
            $_SESSION['id_restaurante']     = $obj->get('id_restaurante');
            $_SESSION['id_sucursal']        = $obj->get('id_sucursal');
            $_SESSION['img']                = $obj->get('img');
            $_SESSION['menu_inicial']       = $obj->get('menu_inicial');

        }else{
            $array["respuesta"] = "No";
        }
        
        echo json_encode($array);
    }
    
    public function exitSession(){
        session_destroy();
        redirectInter();
    }
}