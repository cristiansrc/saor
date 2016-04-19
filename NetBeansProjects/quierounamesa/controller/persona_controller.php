<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_controller
 *
 * @author crist
 */
class persona_controller extends app_controller  {
    //put your code here
    protected $name_controller = 'persona';
    
    public function init(){
        $this->listPersonas();
    }
    
    public function listPersonas(){
        $this->sessionStart();
        $table = $this->instanceTable(
            'view_persona', 
            'Lista de personas', 
            'id_persona', 
            'Id:id_persona,Primer Nombre:primer_nombre,Primer Apellido:primer_apellido,Identificacion:identificacion,Mail:mail,Estado:nombre_estado', 
            '', 
            'persona/updatePersona.html', 
            ''
        );
        
        $vars['table'] = $table;
        $this->includeViewController('listPersonas', $vars);
    }
    
    public function updatePersona(){
        $this->sessionStart();
        if(count($_POST) === 0){
            $this->listPersonas();
        }else{
            $id = (isset($_POST['id'])) ? $_POST['id'] : '';
            $this->savePersona($id);
        }        
    }
    
    public function savePersona($id = ''){
        $tipo_persona_helper = new HelperDb('tipo_persona');
        $tipos_persona = $tipo_persona_helper->selectObj();
        
        $estado_activo_helper = new HelperDb('estado_activo');
        $estados_activo = $estado_activo_helper->selectObj();

        $form = $this->instanceForm($id, 'persona', 'Persona', 'blue', 'persona/saveForm.html');
        $form->input('Identificacion', 'identificacion', Form::$valid_required . Form::$valid_number);
        $form->input('Primer Nombre', 'primer_nombre', Form::$valid_required);
        $form->input('Otros Nombres', 'otros_nombres');
        $form->input('Primer Apellido', 'primer_apellido', Form::$valid_required);
        $form->input('Otros Apellidos', 'otros_apellidos');
        $form->select('Tipo de usuario', 'id_tipo_persona', 'nombre_tipo_persona', $tipos_persona, Form::$valid_required);
        $form->input('Mail', 'mail', Form::$valid_required . Form::$valid_mail);
        $form->password('Contraseña', 'contrasena', (($id == '') ? Form::$valid_required : ''), '', 6, 12,form::$not_val);
        $form->password('Confirmar contraseña', 'pass_confirm', (($id == '') ? Form::$valid_required : ''), 'contrasena', 0, 0, '', form::$not_val);
        $form->select('Estado', 'id_estado', 'nombre_estado', $estados_activo, Form::$valid_required);
        $form->image('Foto', 'img', (($id == '') ? Form::$valid_required : ''));
        //$form->hidden('estado', 1);
        //$form->input($label, $name, $value, $valid, $equal_to, $minlength, $maxlength, $mask);
        $vars['form'] = $form;
        $this->includeViewController('formUser', $vars);
    }
    
    public function saveForm(){

        $imagen = $this->saveImage('img');
        if($imagen !== ''){
            $_POST['img'] = $imagen;
        }else{
            unset($_POST['img']);
        }

        if(trim($_POST['contrasena']) !== ''){
            $_POST['contrasena'] = md5($_POST['contrasena']);
        }else{
            unset($_POST['contrasena']);
            unset($_POST['pass_confirm']);
        }

        $this->save();
    }
}
