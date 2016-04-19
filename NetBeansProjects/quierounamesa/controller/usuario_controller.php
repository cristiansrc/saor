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
class usuario_controller extends app_controller {
    //put your code here
    protected $name_controller = 'usuario';
    
    public function init() {
        $this->lista();
    }
    
    public function lista() {
        $this->sessionStart();
        $where = ' and id_eliminacion = 1 ';
        $cliente = false;
        switch ($_SESSION["id_tipo_persona"]) {
            case 7:
            case 8:
            case 10:
                $where .= ' and (id_sucursal = ' . $_SESSION["id_sucursal"] . ' || id_tipo_persona = 11) ';
                $cliente = true;
            break;
            case 13:
                $where .= ' and (id_restaurante = ' . $_SESSION["id_restaurante"] . ' || id_tipo_persona = 11)';
                $cliente = true;
            break;
        }
        
     
        $table = $this->instanceTable(
            'view_persona',
            'Lista de usuarios', 
            'id_persona',
            'Id:id_persona,Primer Nombre:primer_nombre,Primer Apellido:primer_apellido,Identificacion:identificacion,Tipo:nombre_tipo_persona,Restaurante:nombre_restaurante,Sucursal:nombre_sucursal', 
            $where,
            'usuario/editar.html',
            'usuario/eliminar.html',
            'persona'
        );
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de usuario', 'url' => ''));
        $vars['labelNew'] = 'Agregar Usuario';
        $vars['urlNew'] = 'usuario/nuevo.html';
        $vars['table'] = $table;
        
        $this->includeViewController('lista', $vars,'Usuario',$breadcrumb);
    }
    
    public function nuevo($id = '', $breadcrumb_label = 'Agregar', $titulo = 'Agregar Usuario') {
        $this->sessionStart();
        $form = $this->instanceForm($id, 'persona', 'Usuario', 'blue', 'usuario/guardar.html');
        $funcion_tipo_persona = "";
        $funcion_restaurante = "";
        if($_SESSION["id_tipo_persona"] == 12){
            $funcion_tipo_persona = 'ajaxRestaurante(this.value)';
        }
        
        if($_SESSION["id_tipo_persona"] == 12 && $_SESSION["id_tipo_persona"] == 13){
            $funcion_tipo_persona = 'ajaxSucursal(this.value)';
        }
        
        
        $restaurantes = array();
        $sucursales = array();
        $id_sucursal = '';
        $id_restaurante = '';
        $where_tipo_personas = '';
        
        switch ($_SESSION['id_tipo_persona']) {
            case 13:
                $where_tipo_personas .= ' and id_tipo_persona <> 12 ';
            break;
            case 7:
                $where_tipo_personas .= ' and id_tipo_persona not in (12,13) ';
            break;
        }
        
        $where_tipo_personas .= ' order by nombre_tipo_persona';
        
        $tipo_personas_helper   = new HelperDb('tipo_persona');
        $tipo_personas          = $tipo_personas_helper->selectObj(false, $where_tipo_personas);
        $valid_retaurante   = '';
        $valid_sucursal     = '';
        $id_tipo_persona    = '';
        $usuario = new Model("persona");
        if($id !== ''){
            $vista_usuario = new HelperDb('view_persona');
            $usuario = $vista_usuario->selectObj(false, ' and id_persona = ' . $id)[0];

            $id_sucursal        = $usuario->get('id_sucursal');
            $id_restaurante     = $usuario->get('id_restaurante');
            $id_tipo_persona    = $usuario->get('id_tipo_persona');
            
            if($id_tipo_persona !== "12" && $id_tipo_persona !== "11"){
                $restaurante_helper = new HelperDb('restaurante');
                $restaurantes = $restaurante_helper->selectObj(false, ' and id_eliminacion = 1 order by nombre_restaurante');
                $valid_retaurante = Form::$valid_required;
            } 
            
            if($id_tipo_persona !== "12" && $id_tipo_persona !== "13" && $id_tipo_persona !== "11" ){
                $sucursal_helper = new HelperDb('sucursal');
                $sucursales = $sucursal_helper->selectObj(false, " and id_eliminacion = 1 and id_restaurante = " . $id_restaurante . " order by nombre_sucursal");
                $valid_sucursal = Form::$valid_required;
            }
        }
        
        $form = $this->instanceForm($id, 'persona', 'Usuario', 'blue', 'usuario/guardar.html');
        $form->select('Tipo de usuario', 'id_tipo_persona', 'nombre_tipo_persona', $tipo_personas, Form::$valid_required, $funcion_tipo_persona,$id_tipo_persona);
        
        if($_SESSION["id_tipo_persona"] == 12 ){
            $form->select('Restaurante', 'id_restaurante', 'nombre_restaurante', $restaurantes, $valid_retaurante, $funcion_tipo_persona, $id_restaurante);
        }else{
            $form->hidden("id_restaurante", $_SESSION["id_restaurante"]);
            $sucursal_helper = new HelperDb('sucursal');
            $sucursales = $sucursal_helper->selectObj(false, " and id_eliminacion = 1 and id_restaurante = " . $_SESSION["id_restaurante"] . " order by nombre_sucursal");
            $valid_sucursal = Form::$valid_required;
        }
        
        if(trim($_SESSION['id_sucursal']) !== ""){
            $form->hidden('id_sucursal', $_SESSION['id_sucursal']);
        }else{
            $form->select('Sucursal', 'id_sucursal', 'nombre_sucursal', $sucursales, $valid_sucursal, '', $id_sucursal);
        }

        $form->input('Identificacion', 'identificacion', Form::$valid_required);
        $form->input('Primer Nombre', 'primer_nombre', Form::$valid_required);
        $form->input('Otros Nombres', 'otros_nombres');
        $form->input('Primer Apellido', 'primer_apellido', Form::$valid_required);
        $form->input('Otros Apellidos', 'otros_apellidos');
        $form->input('Mail', 'mail', Form::$valid_required . Form::$valid_mail);
        $form->password('Contraseña', 'contrasena', (($id == "") ?  Form::$valid_required : ""), '', 6, 12, Form::$not_val);
        $form->password('Confirmar contrasena', 'valid_contrasena', "", 'contrasena', 6, 12);
        $form->image('Imagen', 'img');
        
        $breadcrumb = array();
        array_push($breadcrumb, array('label' => 'Lista de usuario', 'url' => 'usuario.html'));
        array_push($breadcrumb, array('label' => $breadcrumb_label, 'url' => ''));

        $vars['form'] = $form;
        $vars['titulo'] = $titulo;
        $this->includeViewController('formulario', $vars,'Usuario',$breadcrumb);
    }
    
    public function editar() {
        $this->sessionStart();
        if(isset($_POST['id']) === true){
            $this->nuevo($_POST['id'], 'Editar', 'Editar usuario');
        }else{
            $this->lista();
        }
    }
    
    public function guardar() {
        
        $this->sessionStart();
        $id = $_POST['id_persona'];
        $id = ($id == "") ? null : $id;
        $imagen = $this->saveImage('img');
        if($imagen !== ''){
            $_POST['img'] = $imagen;
        }

        $persona = new Model("persona", $id);
        $persona->set("primer_nombre", $_POST['primer_nombre']);
        $persona->set("otros_nombres", $_POST['otros_nombres']);
        $persona->set("primer_apellido", $_POST['primer_apellido']);
        $persona->set("otros_apellidos", $_POST['otros_apellidos']);
        $persona->set("identificacion", $_POST['identificacion']);
        $persona->set("mail", $_POST['mail']);
        $persona->set("img", $_POST["img"]);
        $persona->set("id_estado", 1);
        $persona->set("id_tipo_persona", $_POST['id_tipo_persona']);
        $persona->set("id_eliminacion",1);
        
        if($_POST['contrasena'] !== ""){
            $persona->set("contrasena", md5($_POST['contrasena']));
        }
        
        if($imagen !== ""){
            $persona->set("img", $imagen);
        }
        
        $persona->save();
       
        
        switch ($_POST['id_tipo_persona']) {
            case 12:
                $superadmin_helper = new HelperDb("superadmin");
                $superadmin = $superadmin_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $superadmin = (count($superadmin) > 0) ? $superadmin[0] : new Model("superadmin");
                $superadmin->set("id_persona",$persona->get("id_persona"));
                $superadmin->save();
            break;
            case 13:
                $administrador_restaurante_helper = new HelperDb("administrador_restaurante");
                $administrador_restaurante = $administrador_restaurante_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $administrador_restaurante = (count($administrador_restaurante) > 0) ? $administrador_restaurante[0] : new Model("administrador_restaurante");
                $administrador_restaurante->set("id_persona",$persona->get("id_persona"));
                $administrador_restaurante->set("id_restaurante",$_POST["id_restaurante"]);
                $administrador_restaurante->save();
            break;  
            case 7:
                $administrador_sucursal_helper = new HelperDb("administrador_sucursal");
                $administrador_sucursal = $administrador_sucursal_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $administrador_sucursal = (count($administrador_sucursal) > 0) ? $administrador_sucursal[0] : new Model("administrador_sucursal");
                $administrador_sucursal->set("id_persona",trim($persona->get("id_persona")));
                $administrador_sucursal->set("id_restaurante",trim($_POST["id_restaurante"]));
                $administrador_sucursal->set("id_sucursal",trim($_POST["id_sucursal"]));
                $administrador_sucursal->save();
            break;
            case 8:
                $mesero_helper = new HelperDb("mesero");
                $mesero = $mesero_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $mesero = (count($mesero) > 0) ? $mesero[0] : new Model("mesero");
                $mesero->set("id_persona",$persona->get("id_persona"));
                $mesero->set("id_restaurante",$_POST["id_restaurante"]);
                $mesero->set("id_sucursal",$_POST["id_sucursal"]);
                $mesero->save();
            break;
            case 9:
                $cocinero_helper = new HelperDb("cocinero");
                $cocinero = $cocinero_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $cocinero = (count($cocinero) > 0) ? $cocinero[0] : new Model("cocinero");
                $cocinero->set("id_persona",$persona->get("id_persona"));
                $cocinero->set("id_restaurante",$_POST["id_restaurante"]);
                $cocinero->set("id_sucursal",$_POST["id_sucursal"]);
                $cocinero->save();
            break;
            case 10:
                $cajero_helper = new HelperDb("cajero");
                $cajero = $cajero_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $cajero = (count($cajero) > 0) ? $cajero[0] : new Model("cajero");
                $cajero->set("id_persona",$persona->get("id_persona"));
                $cajero->set("id_restaurante",$_POST["id_restaurante"]);
                $cajero->set("id_sucursal",$_POST["id_sucursal"]);
                $cajero->save();
            break;
            case 11:
                $cliente_helper = new HelperDb("cliente");
                $cliente = $cliente_helper->selectObj(true, " and id_persona = " . $persona->get("id_persona"));
                $cliente = (count($cliente) > 0) ? $cliente[0] : new Model("cliente");
                $cliente->set("id_persona",$persona->get("id_persona")); 
                $cliente->save();
            break;
        }
        
        $insert = ($_POST["id_persona"] !== "") ? "UPDATE" : "insert";
        $json = array('id' => $persona->get("id_persona"), 'insert' => $insert); 
        
        echo json_encode($json);
    }
    
    public function eliminar() {
        $this->sessionStart();
        $this->delete();
    }
    
    public function ajaxRestaurante(){
        $this->sessionStart();
        $id_tipo_usuario = $_POST['id'];
        $restaurantes = array();
        $this->includeForm();
        $valid = "";
        if($id_tipo_usuario !== "12" && $id_tipo_usuario !== "11"){
            $restaurante_helper = new HelperDb('restaurante');
            $restaurantes = $restaurante_helper->selectObj(false, " and id_eliminacion = 1  order by nombre_restaurante");
            $valid = Form::$valid_required;
        }
        $formHtml = new FormHtm("");
        echo $formHtml->selectHtml("", "id_restaurante", "nombre_restaurante", $restaurantes, "", $valid, "ajaxSucursal(this.value)", false);
    }
    
    public function ajaxSucursal(){
        $this->sessionStart();
        $id_tipo_usuario = $_POST['id_tipo_persona'];
        $id_restaurante  = $_POST['id'];
        $id_restaurante = ($id_restaurante == "") ? 0 : $id_restaurante;
        $sucursales = array();
        $this->includeForm();
        $valid = "";

        if($id_tipo_usuario !== "12" && $id_tipo_usuario !== "13" && $id_tipo_usuario !== "11"){
            $sucursales_helper = new HelperDb('sucursal');
            $sucursales = $sucursales_helper->selectObj(false," and id_eliminacion = 1 and id_restaurante = " . $id_restaurante . " order by nombre_sucursal");
            $valid = Form::$valid_required;
        }
        $formHtml = new FormHtml("");
        echo $formHtml->selectHtml("", "id_sucursal", "nombre_sucursal", $sucursales, "", $valid, "", false);
    }
}
