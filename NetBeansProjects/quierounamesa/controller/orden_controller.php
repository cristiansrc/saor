<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orden_controller
 *
 * @author Cristhiampc
 */
class orden_controller extends app_controller {
    //put your code here
    
    protected $name_controller = 'orden';
    
    public function init() {
        $this->lista();
    }
    
    public function confirmarOrden(){
        $orden_session_number = $_POST['orden_session_number'];
        $arr_productos = $_SESSION['orden'][$_POST['orden_session_number']]['productos'];
        $restaurante = new Model('restaurante',$_SESSION['id_restaurante']);
        $sucursal = new Model('sucursal', $_SESSION['id_sucursal']);
        $mesa = new Model('mesa', $_POST['id_mesa']);
        $cliente = new Model('cliente',$_POST['id_cliente']);
        $view_persona_helper = new HelperDb('view_persona');
        $persona = $view_persona_helper->selectObj(false, ' and id_persona = ' . $cliente->get('id_persona'));
        $persona = $persona[0];
        $valor_total = 0;
        
        $_SESSION['orden'][$_POST['orden_session_number']]['info']['id_mesa'] = $_POST['id_mesa'];
        $_SESSION['orden'][$_POST['orden_session_number']]['info']['id_cliente'] = $_POST['id_cliente'];
        $_SESSION['orden'][$_POST['orden_session_number']]['info']['id_sucursal'] = $_SESSION['id_sucursal'];
        
        foreach ($arr_productos as $id_producto => $arr_info_producto) {
            $arr_info_producto['observaciones'] = $_POST[$id_producto . '_observaciones'];
            $arr_info_producto['cantidad'] = $_POST[$id_producto . '_cantidad'];
            $valor_total += $arr_info_producto['varlor_s_iva_producto'] * $_POST[$id_producto . '_cantidad'];
            $arr_productos[$id_producto] = $arr_info_producto;
        }
        $valor_total_con_iva = $valor_total * 1.16;
        $iva = $valor_total * 0.16;
        //$valor_total = number_format($valor_total);
        $_SESSION['orden'][$_POST['orden_session_number']]['productos'] = $arr_productos;
        
        $vars = array();
        $vars['productos'] = $arr_productos;
        $vars['id_mesa'] = $_POST['id_mesa'];
        $vars['nombre_mesa'] = $mesa->get('nombre_mesa');
        $vars['cliente_nombre'] = $persona->get('primer_nombre') . ' ' . $persona->get('primer_apellido');
        $vars['nombre_restaurante'] = $restaurante->get('nombre_restaurante');
        $vars['nombre_sucursal'] = $sucursal->get('nombre_sucursal');
        $vars['mesero'] = $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];
        $vars['valor_total'] = $valor_total;
        $vars['valor_total_con_iva'] = $valor_total_con_iva;
        $vars['iva'] = $iva;

        $this->includeView('confirmarOrden', $vars);
    }
    
    public function borrarOrden(){
        $_SESSION['orden'][$_POST['orden_session_number']]['productos'] = array();
        $_SESSION['orden'][$_POST['orden_session_number']]['info'] = array();
    }

    public function lista() {
        $this->scriptsValidateForms();
        $orden_session_number = uniqid();
        $_SESSION['orden'][$orden_session_number]['productos'] = array();
        $_SESSION['orden'][$orden_session_number]['info'] = array();
        $breadcrumb = array();
        $vars = array();
        array_push($breadcrumb, array('label' => 'Lista de ordenes', 'url' => ''));
        $producto_helper = new HelperDb('producto');
        $mesa_helper = new HelperDb('mesa');
        $productos = $producto_helper->selectObj('false', ' and id_restaurante = ' . $_SESSION['id_restaurante'] . ' and id_estado = 1 and id_eliminacion = 1');
        $mesas = $mesa_helper->selectObj(false, ' and id_sucursal = ' . $_SESSION['id_sucursal'] . ' and id_eliminacion = 1');
        $vars['productos'] = $productos;
        $vars['orden_session_number'] = $orden_session_number;
        $vars['mesas'] = $mesas;
        $this->includeViewController('lista', $vars,'Ordenes',$breadcrumb);
    }
    
    public function agregarProducto() {
        $orden_session_number = $_POST['orden_session_number'];
        $id_producto_new = $_POST['id_producto_new'];
        
        $arr_productos = $_SESSION['orden'][$orden_session_number]['productos'];

        $arr_info_producto = array();
        if(!isset($_SESSION['orden'][$orden_session_number]['productos'][$id_producto_new])){
            $producto = new Model('producto', $id_producto_new);
            $arr_info_producto['id_producto'] = $producto->get('id_producto');
            $arr_info_producto['nombre_producto'] = $producto->get('nombre_producto');
            $arr_info_producto['varlor_s_iva_producto'] = $producto->get('varlor_s_iva_producto');
            $arr_info_producto['imagen'] = $producto->get('imagen_producto');
            $arr_info_producto['observaciones'] = "";
            $arr_info_producto['cantidad'] = 1;
            $arr_productos[$id_producto_new] = $arr_info_producto;
        }
         
        foreach ($arr_productos as $id_producto => $arr_info_producto) {
            if(isset($_POST[$id_producto . '_observaciones'])){
                $arr_info_producto['observaciones'] = $_POST[$id_producto . '_observaciones'];
                $arr_info_producto['cantidad'] = $_POST[$id_producto . '_cantidad'];
                $arr_productos[$id_producto] = $arr_info_producto;
            }
            
        }
        
        $_SESSION['orden'][$orden_session_number]['productos'] = $arr_productos;
        $vars = array();
        $vars['orden'] = $_SESSION['orden'][$orden_session_number]['productos'];
        $vars['orden_session_number'] = $orden_session_number;
        $this->includeView('agregarProducto', $vars);
    }
    
    public function buscarCliente() {
        $identificacion = $_POST['identificacion'];
        $array = array();
        $array["nombre_cliente"] = 'Persona no encontrada';
        $array["id_cliente"] = '';

        if($identificacion !== ''){
            $persona_helper = new HelperDb('view_persona');
            $personas = $persona_helper->selectObj(false, ' and id_tipo_persona = 11 and identificacion = "' . $identificacion . '"');
           
            if(count($personas) > 0){
                $persona = $personas[0];
                $nombre = $persona->get('primer_nombre') . ' ' . $persona->get('otros_nombre') . ' ' . $persona->get('primer_apellido') . ' ' . $persona->get('otros_apellido');
                $cliente_helper = new HelperDb('cliente');
                $cliente = $cliente_helper->selectObj(false, ' and id_persona = ' . $persona->get('id_persona'));
                $array["nombre_cliente"] = $nombre;
                $array["id_cliente"] = $cliente[0]->get('id_cliente');
            }
        }
        
        echo json_encode($array);
    }
    
    public function guardarCliente(){
        $identificacion = $_POST['identificacion'];
        $mail = $_POST['mail'];
        $array = array();
        $array['error'] = 0;
        $array['modal_content'] = 'El cliente se almaceno con exito.';
        $array['modal_alert'] = 'note note-success';
        $array['modal_tit'] = 'Exitoso!';
        
        
        $persona_helper = new HelperDb('view_persona');
        $personas = $persona_helper->selectObj(false, ' and id_tipo_persona = 11 and identificacion = "' . $identificacion . '"');
        
        if(count($personas) > 0){
            $array['error'] = 1;
            $array['modal_alert'] = 'note note-warning';
            $array['modal_tit'] = 'Fallo!';
            $array['modal_content'] = 'El numero de identificacion ingresada, ya existe en la base de datos.';
        }else{
            $personas = $persona_helper->selectObj(false, ' and id_tipo_persona = 11 and mail = "' . $mail . '"');
            if(count($personas) > 0){
                $array['error'] = 1;
                $array['modal_alert'] = 'note note-warning';
                $array['modal_tit'] = 'Fallo!';
                $array['modal_content'] = 'El mail ingresado, ya existe en la base de datos.';
            }
        }
        
        if($array['error'] == 0){
            $persona = new Model('persona');
            foreach ($_POST as $key => $value) {
                $persona->set($key, $value);
            }
            $persona->set('id_tipo_persona', '11');
            $persona->set('id_eliminacion', '1');
            $persona->set('id_estado', 2);
            $persona->save();
            $cliente = new Model('cliente');
            $cliente->set('id_persona', $persona->primary_value());
            $cliente->save();
            $array['id_cliente'] = $cliente->primary_value();
            $array['nombre_cliente'] = $persona->get('primer_nombre') . ' ' . $persona->get('otros_nombres') . ' ' . $persona->get('primer_apellido') . ' ' . $persona->get('otros_apellidos');
            $array['identificacion'] = $persona->get('identificacion');
        }
        
        echo json_encode($array);
    }

}
