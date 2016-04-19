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
class restaurante_controller extends app_controller {
    //put your code here
    protected $name_controller = 'restaurante';
    
    public function init() {
        $this->lista();
    }
    
    public function lista() {
        $this->sessionStart();
        $table = $this->instanceTable(
            'restaurante', 
            'Lista de restaurantes', 
            'id_restaurante',
            'Id:id_restaurante,Nombre:nombre_restaurante,Nit:nit_restaurante', 
            ' and id_eliminacion = 1 ',
            'restaurante/editar.html', 
            'restaurante/eliminar.html'
        );
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de restaurante', 'url' => ''));
        $vars['labelNew'] = 'Agregar Restaurante';
        $vars['urlNew'] = 'restaurante/nuevo.html';
        $vars['table'] = $table;
        
        $this->includeViewController('lista', $vars,'Restaurantes',$breadcrumb);
    }
    
    public function nuevo($id = '', $breadcrumb_label = 'Agregar', $titulo = 'Agregar Restaurante') {
        $this->sessionStart();
        $form = $this->instanceForm($id, 'restaurante', 'Restaurante', 'blue', 'restaurante/guardar.html');
        $form->input('Nombre', 'nombre_restaurante', Form::$valid_required);
        $form->input('Nit', 'nit_restaurante', Form::$valid_required);
        $form->textArea('Descripcion', 'descrip_restaurante');
        $form->image('Imagen', 'img_restaurante', (($id == '') ? Form::$valid_required : ''));
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de restaurante', 'url' => 'restaurante.html'));
        array_push($breadcrumb, array('label' => $breadcrumb_label, 'url' => ''));

        $vars['form'] = $form;
        $vars['titulo'] = $titulo;
        $this->includeViewController('formulario', $vars,'Restaurantes',$breadcrumb);
    }
    
    public function editar() {
        $this->sessionStart();
        if(isset($_POST['id']) === true){
            $this->nuevo($_POST['id'], 'Actualizar', 'Editar Restaurante');
        }else{
            $this->init();
        }
    }
    
    public function guardar() {
        $this->sessionStart();
        $_POST['id_eliminacion'] = 1;
        
        $imagen = $this->saveImage('img_restaurante');
        if($imagen !== ''){
            $_POST['img_restaurante'] = $imagen;
        }else{
            unset($_POST['img_restaurante']);
        }
        
        $this->save();
    }
    
    public function eliminar() {
        $this->sessionStart();
        $this->delete();
    }
}
