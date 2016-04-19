<?php 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Controller
 *
 * @author CristhiamStick
 */

class Controller  {
    protected $title_page;

    protected function instanceHelper($name) {
        $name = $name . '_helper';
        $locaction = _ROOT_HELPER . '/' . $name . '.php';
        if(file_exists($locaction)){
            include_once($locaction);       
        }else{
            die('Helper ' . $name . ' no encontrado');
        }

        return new $name();
    }
    
    protected function instanceModel($name) {
        $name = $name . '_model';
        $locaction = _ROOT_MODEL . '/' . $name . '.php';
        if(file_exists($locaction)){
            include_once($locaction);       
        }else{
            die('Modelo ' . $name . ' no encontrado');
        }

        return new $name();
    }
    
    protected function instanceDao($name) {
        $name = $name . '_dao';
        $locaction = _ROOT_DAO . '/' . $name . '.php';
        if(file_exists($locaction)){
            include_once($locaction);       
        }else{
            die('Dao ' . $name . ' no encontrado');
        }

        return new $name();
    }
    
    protected function instanceController($name) {
        $name = $name . '_controller';
        $locaction = _ROOT_CONTROLLER . '/' . $name . '.php';
        if(file_exists($locaction)){
            include_once($locaction);       
        }else{
            die('Controller ' . $name . ' no encontrado');
        }

        return new $name();
    }
    
    protected function includeView($name,$vars = array()) {
        $locaction = _ROOT_VIEW . '/' . $name . '.php';
  
        if(isset($this->name_controller)){
            $locaction = _ROOT_VIEW . '/' . $this->name_controller . '/' . $name . '.php';
        }
       
        if(file_exists($locaction)){
            foreach ($vars as $key => $value){
                $$key = $value;
            }
            include_once($locaction);       
        }else{
            die('View ' . $name . ' no encontrado');
        }
    }
    
    protected function includeTemplate($name, $vars = array()) {
        $locaction = _ROOT_VIEW . '/templates/' . $name . '.php';
        
        if(isset($this->template)){
            $locaction = _ROOT_VIEW . '/templates/' . $this->template . '/' . $name . '.php';
        }
        
        if(file_exists($locaction)){
            foreach ($vars as $key => $value){
                $$key = $value;
            }
            include_once($locaction);       
        }else{
            die('View template ' . $name . ' no encontrado');
        }
    }
    
    protected function alert($text){
        $_SESSION['alert_text'] = $text;
    }
    
    protected function printAlert(){
        if(isset($_SESSION['alert_text'])){
            echo $_SESSION['alert_text'];
            unset($_SESSION['alert_text']);
        }
        
    }
    
    protected function redirect($url) {
        header('Location: ' . $url);
    }

    protected function  includeForm() {   
        include_once(_TEMPLATE_SCRIPTS_ROOT . 'FormHtm.php');
        include_once(_ZELO_CLASS . '/Form.class.php');
    }
    
    protected function  instanceForm($id, $table = 'Form', $title = 'Formulario', $color = 'blue', $action = 'cud/save.html' , $method = 'POST') {   
        include_once(_TEMPLATE_SCRIPTS_ROOT . 'FormHtm.php');
        include_once(_ZELO_CLASS . '/Form.class.php');
        $this->scriptsValidateForms();
        return new Form($id, $table, $title, $color, $action, $method);
    }
    
    protected function  instanceTable($table, $label, $primary_key, $columns, $where = '', $url_update = '', $function_delete = '', $table_origin = '') {   
        $this->scriptsTable();
        include_once(_TEMPLATE_SCRIPTS_ROOT . 'TableHtml.php');
        include_once(_ZELO_CLASS . '/Table.class.php');
        return new Table($table, $label, $primary_key, $columns, $where, $url_update, $function_delete, $table_origin);
    }
  
    public function save() {

        $model = new Model($_POST['table'], (trim($_POST[$_POST['primary_key']]) == '')  ? null : $_POST[$_POST['primary_key']] );
        foreach ($_POST as $key => $value) {
            $model->set($key, $value);
        }
        $insert = (is_numeric($model->primary_value()) && ($model->primary_value() > 0)) ? 'UPDATE' : 'insert';
        
        $model->save();
        $json = array('id' => $model->primary_value(), 'insert' => $insert); 
        
        echo json_encode($json);
    }
    
    public function saveNJson($table, $id) {

        $model = new Model($table, $id);
        explodeObject($model);die();
        foreach ($_POST as $key => $value) {
            $model->set($key, $value);
        }
        
        $model->save();

        return $model;
    }
    
    protected function deletedeFinitely() {
        $model = new Model($_POST['table'], $_POST['id']);
        $model->delete();
        $json = array('confirm' => true);
        echo json_decode($json);
    }
    
    protected function delete() {
        $model = new Model($_POST['table'], $_POST['id']);
        $model->set('id_eliminacion', 2);
        $model->save();
        $json = array('confirm' => true);
        echo json_decode($json);
    }
    
    public function image(){
        if(!isset($_GET[0]))
            header("HTTP/1.0 404 Not Found");
        
        $imagen = _ZELO_IMAGES . '/' . $_GET[0];
        viewImage($imagen);
    }
    
    public function redImage(){
        if(!isset($_GET[0]) || !isset($_GET[1]))
            header("HTTP/1.0 404 Not Found");
        
        $imagen = _ZELO_IMAGES . '/' . $_GET[1];
        $dimensions = (isset($_GET[0])) ? $_GET[0] : null;
        viewImage($imagen,$dimensions);
    }
    
    public function imageLoader() {
        $array_return = array();
        $table = trim($_POST['table']);
        $field = $_POST['field'];
        $id = $_POST['id'];
        $model = new Model($table, $id);
        $name_image = $model->get($field);
        $json = array('image' => $name_image);
        echo json_encode($json);
    }
    
    protected function saveImage($name) {
        if(isset($_FILES[$name])){
            $file_name_origin = $_FILES[$name]['name'];
            $arr_name = explode('.', $file_name_origin);
            $file_ext = $arr_name[1];
            $file_name_new = uniqid();
            $file_name_new .= '.' . $file_ext;
            $image_ori = _ZELO_IMAGES . '/original/' . $file_name_new;
            move_uploaded_file($_FILES[$name]['tmp_name'], $image_ori);
            $image_folder = opendir(_ZELO_IMAGES);
            
            while ($element = readdir($image_folder)){
                if( $element !== "." && $element !== ".."){
                    
                    if($element !== 'original' && is_dir(_ZELO_IMAGES . '/' . $element) ){
                        $thumbnailImage = _ZELO_IMAGES . '/' . trim($element) . '/' . $file_name_new;
                        saveImage($image_ori, $element, $thumbnailImage);
                    } 
                }
            }
            
            closedir($image_folder);
            
            return $file_name_new;
        }else{
            return '';
        }
    }
}
?>