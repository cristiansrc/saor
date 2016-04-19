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
class sucursal_controller extends app_controller {
    //put your code here
    protected $name_controller = 'sucursal';
    
    public function init() {
        $this->lista();
    }
    
    public function lista() {
        $this->sessionStart();
        $where = ' and id_eliminacion = 1 ';
        $where = (trim($_SESSION['id_restaurante']) !== "") ? $where . " and id_restaurante = " . $_SESSION['id_restaurante'] : $where;
        $table = $this->instanceTable(
            'view_sucursal', 
            'Lista de sucursales', 
            'id_sucursal',
            'Id:id_sucursal,Restaurante:nombre_restaurante,Nombre:nombre_sucursal', 
            $where,
            'sucursal/editar.html',
            'sucursal/eliminar.html',
            'sucursal'
        );
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de sucursales', 'url' => ''));
        $vars['labelNew'] = 'Agregar Sucursal';
        $vars['urlNew'] = 'sucursal/nuevo.html';
        $vars['table'] = $table;
        
        $this->includeViewController('lista', $vars,'Sucursales',$breadcrumb);
    }
    
    public function nuevo($id = '', $breadcrumb_label = 'Agregar', $titulo = 'Agregar Sucursal') {
        $this->sessionStart();
        $restaurante_helper = new HelperDb('restaurante');
        $restaurantes = $restaurante_helper->selectObj(false, ' and id_eliminacion = 1');
        
        $form = $this->instanceForm($id, 'sucursal', 'Sucursal', 'blue', 'sucursal/guardar.html');
        
        if(trim($_SESSION['id_restaurante']) !== ""){
            $form->hidden('id_restaurante', $_SESSION['id_restaurante']);
        }else{
            $form->select('Restaurante', 'id_restaurante', 'nombre_restaurante', $restaurantes, Form::$valid_required);
        }

        $form->input('Nombre', 'nombre_sucursal', Form::$valid_required);
        $form->input('Direccion', 'direccion_sucursal', Form::$valid_required);
        $form->textArea('Descripcion', 'descripcion_sucursal');
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de sucursales', 'url' => 'sucursal.html'));
        array_push($breadcrumb, array('label' => $breadcrumb_label, 'url' => ''));

        $vars['form'] = $form;
        $vars['titulo'] = $titulo;
        $this->includeViewController('formulario', $vars,'Sucursal',$breadcrumb);
    }
    
    public function editar() {
        $this->sessionStart();
        if(isset($_POST['id']) === true){
            $this->nuevo($_POST['id'], 'Editar', 'Editar sucursal');
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
}
