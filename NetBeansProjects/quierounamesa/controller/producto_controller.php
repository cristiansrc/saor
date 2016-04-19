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
class producto_controller extends app_controller {
    //put your code here
    protected $name_controller = 'producto';
    
    
    public function init() {
        $this->lista();
    }
    
    public function lista() {
        $this->sessionStart();
        $where = ' and id_eliminacion = 1 ';
        $where = (trim($_SESSION['id_restaurante']) !== "") ? $where . " and id_restaurante = " . $_SESSION['id_restaurante'] : $where;
        
        $table = $this->instanceTable(
            'view_producto', 
            'Lista de sucursales', 
            'id_producto',
            'Id:id_producto,Restaurante:nombre_restaurante,Nombre:nombre_producto', 
            $where,
            'producto/editar.html',
            'producto/eliminar.html',
            'producto'
        );
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de productos', 'url' => ''));
        $vars['labelNew'] = 'Agregar Producto';
        $vars['urlNew'] = 'producto/nuevo.html';
        $vars['table'] = $table;
        
        $this->includeViewController('lista', $vars,'Productos',$breadcrumb);
    }
    
    public function nuevo($id = '', $breadcrumb_label = 'Agregar', $titulo = 'Agregar Producto') {
        $this->sessionStart();
        $restaurante_helper = new HelperDb('restaurante');
        $restaurantes = $restaurante_helper->selectObj(false, ' and id_eliminacion = 1 ');
        
        $estado_activo_helper = new HelperDb('estado_activo');
        $estados_activos = $estado_activo_helper->selectObj();
        
        $form = $this->instanceForm($id, 'producto', 'Producto', 'blue', 'producto/guardar.html');
        
        if(trim($_SESSION['id_restaurante']) !== ""){
            $form->hidden('id_restaurante', $_SESSION['id_restaurante']);
            
        }else{
            $form->select('Restaurante', 'id_restaurante', 'nombre_restaurante', $restaurantes, Form::$valid_required);
        }

        $form->input('Nombre', 'nombre_producto', Form::$valid_required);
        $form->input('Valor sin iva', 'varlor_s_iva_producto', Form::$valid_required . Form::$valid_number);
        $form->input('Valor en puntos', 'valor_puntos', Form::$valid_required . Form::$valid_number);
        $form->select('Estado', 'id_estado', 'nombre_estado', $estados_activos, Form::$valid_required);
        $form->textArea('Descripcion', 'descripcion_producto');
        $form->image('Imagen', 'imagen_producto', Form::$valid_required);
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de productos', 'url' => 'producto.html'));
        array_push($breadcrumb, array('label' => $breadcrumb_label, 'url' => ''));

        $vars['form'] = $form;
        $vars['titulo'] = $titulo;
        $this->includeViewController('formulario', $vars,'Producto',$breadcrumb);
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
        $imagen = $this->saveImage('imagen_producto');
        if($imagen !== ''){
            $_POST['imagen_producto'] = $imagen;
        }else{
            unset($_POST['imagen_producto']);
        }
        $this->save();
    }
    
    public function eliminar() {
        $this->sessionStart();
        $this->delete();
    }
}
