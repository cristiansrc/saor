<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of restaurante_controller
 *
 * @author Cristhiampc
 */
class mesa_controller extends app_controller {
    //put your code here
    protected $name_controller = 'mesa';
    
    public function init() {
        $this->lista();
    }
    
    public function lista() {
        $this->sessionStart();
        $where = ' and id_eliminacion = 1 ';
        $where = (trim($_SESSION['id_restaurante']) !== "") ? $where . " and id_restaurante = " . $_SESSION['id_restaurante'] : $where;
        $where = (trim($_SESSION['id_sucursal']) !== "") ? $where . " and id_sucursal = " . $_SESSION['id_sucursal'] : $where;
        
        $table = $this->instanceTable(
            'view_mesa', 
            'Lista de mesas', 
            'id_mesa',
            'Id:id_mesa,Restaurante:nombre_restaurante,Sucursal:nombre_sucursal,Nombre:nombre_mesa', 
            $where,
            'mesa/editar.html',
            'mesa/eliminar.html',
            'mesa'
        );
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de mesas', 'url' => ''));
        $vars['labelNew'] = 'Agregar Mesa';
        $vars['urlNew'] = 'mesa/nuevo.html';
        $vars['table'] = $table;
        
        $this->includeViewController('lista', $vars,'Mesas',$breadcrumb);
    }
    
    public function nuevo($id = '', $breadcrumb_label = 'Agregar', $titulo = 'Agregar Mesa') {
        $this->sessionStart();
        $restaurante_helper = new HelperDb('restaurante');
        $restaurantes = $restaurante_helper->selectObj(false, ' and id_eliminacion = 1');

        $estado_activo_helper = new HelperDb('estado_activo');
        $estados = $estado_activo_helper->selectObj();
        $sucursales = array();
        
        $id_restaurante = trim($_SESSION['id_restaurante']);
        if($id !== ''){
            $view_mesa_helper = new HelperDb('view_mesa');
            $view_mesas = $view_mesa_helper->selectObj(false, ' and id_mesa = ' . $id);
            
            if(count($view_mesas) == 1){
                $id_restaurante = $view_mesas[0]->get('id_restaurante');
            }
            
            $sucursal_helper = new HelperDb('sucursal');
            $sucursales = $sucursal_helper->selectObj(false, ' and id_eliminacion = 1 and id_restaurante = ' . $id_restaurante);
        }
        
        
        $form = $this->instanceForm($id, 'mesa', 'Mesa', 'blue', 'mesa/guardar.html');
        
        
        if(trim($_SESSION['id_restaurante']) !== ""){
            $form->hidden('id_restaurante', $_SESSION['id_restaurante']);
            $sucursal_helper = new HelperDb('sucursal');
            $sucursales = $sucursal_helper->selectObj(false, ' and id_eliminacion = 1 and id_restaurante = ' . $_SESSION['id_restaurante']);
        }else{
            $form->select('Restaurante', 'id_restaurante', 'nombre_restaurante', $restaurantes, Form::$valid_required, 'sucursalAjax(this.value)',$id_restaurante);
        }
        
        if(trim($_SESSION['id_sucursal']) !== ""){
            $form->hidden('id_sucursal', $_SESSION['id_sucursal']);
        }else{
            $form->select('Sucursal', 'id_sucursal', 'nombre_sucursal', $sucursales, Form::$valid_required);
        }
        
        $form->input('Nombre', 'nombre_mesa', Form::$valid_required);
        $form->select('Activo', 'id_estado', 'nombre_estado', $estados, Form::$valid_required);
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de mesas', 'url' => 'mesa.html'));
        array_push($breadcrumb, array('label' => $breadcrumb_label, 'url' => ''));

        $vars['form'] = $form;
        $vars['titulo'] = $titulo;
        $this->includeViewController('formulario', $vars,'Mesa',$breadcrumb);
    }
    
    public function editar() {
        $this->sessionStart();
        if(isset($_POST['id']) === true){
            $this->nuevo($_POST['id'], 'Editar', 'Editar mesa');
        }else{
            $this->init();
        }
    }
    
    public function guardar() {
        $this->sessionStart();
        $_POST['id_eliminacion'] = 1;
        $this->save();
    }
    
    public function eliminar() {
        $this->sessionStart();
        $this->delete();
    }
    
    public function ajaxSucursal() {
        $this->sessionStart();
        $id_restaurante = $_POST['id_restaurante'];
        $sucursal_helper = new HelperDb('sucursal');
        $sucursales = $sucursal_helper->selectObj(false, ' and id_eliminacion = 1 and id_restaurante = ' . $id_restaurante);
        $formHtml = $this->instanceForm('', 'sucursal');
        $formHtml->selectHtml('', 'id_sucursal', 'nombre_sucursal', $sucursales, '', Form::$valid_required, '', false);
    }
}
