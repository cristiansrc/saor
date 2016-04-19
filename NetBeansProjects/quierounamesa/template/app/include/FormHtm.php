<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formHtml
 *
 * @author crist
 */
class FormHtm {
    //put your code here
    
    static public $valid_required = ' required';
    static public $valid_mail = ' email';
    static public $valid_password = ' password';
    static public $valid_url = ' url';
    static public $valid_number = ' number';
    static public $not_val = 'not_val';
    static public $alert_success = 'note note-success';
    static public $alert_danger = 'note note-danger';
    static public $alert_warning = 'note note-warning';

    public function formHtml($action,  $id = 'Form', $title = 'Formulario', $color = 'blue') {
        $html = '
            <div class="panel panel-' . $color . '">
                <div class="panel-heading">' . $title . '</div>
                <div class="panel-body pan">
                    <form id="' . $id . '" class="form-validate form-bordered" action="' . _APPLICACION_URL . $action . '" novalidate="novalidate" autocomplete="off">
                        <div class="form-body">
                        %s
                        </div>
                        <div id="pageloader-img" class="form-actions text-right pal">
                            <button id="id_submit_' . $id . '" class="btn btn-primary" type="submit">Enviar</button>
                            <!--button class="btn btn-green" type="button">Cancelar</button-->
                        </div>
                    </from>
                </div>    
            </div>
        ';
        
        return $html;
    }
    
    private function groupDefaultHtml($label, $for) {
        $html = '
            <div class="form-group">
                <label class="col-md-3 control-label" for="' . $for . '">
                    ' . $label . '
                </label>
                <div class="col-md-9">
                    <div id="div_' . $for . '">
                        %s
                    </div>
                </div>
            </div>
        ';
        
        return $html;
    }
    
    public function inputHtml($label, $name, $valid = '',$equal_to = '',$minlength = 0,$maxlength = 0,  $mask = '', $value = '', $group = true){ 
        $minlength = (is_numeric($minlength) && $minlength > 0 ) ? 'minlength="' . $minlength . '"' : '';
        $maxlength = (is_numeric($maxlength) && $maxlength > 0 ) ? 'maxlength="' . $maxlength . '"' : '';
        $equal_to = ($equal_to !== '')?  'equalto="#' . $equal_to . '"': '';
        
        $html = '
            <input ' . $minlength . ' ' . $maxlength . ' ' . $equal_to . ' name="' . $name . '" id="' . $name . '" value="' . $value . '" class="form-control' . $valid . '" type="text" placeholder="' . $mask . '">
        ';
        
        if($group){
            $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        }
        
        return $html;
    }
    
    public function imageHtml($label, $name, $value = '', $valid = '', $group = true) {
        $html = '
            <input id="' . $name . '" accept="image/*" type="file" class="' . $valid . '" name="' . $name . '" placeholder="Seleccione la imagen"/>
        ';
        $display = ($value !== "") ? '' : 'display:none';
        $image = ($value !== "") ? _IMAGE_URL . '/300x/' . $value : '';
        $image_gra = ($value !== "") ? _IMAGE_URL . '/600x/' . $value : '';
        
        $html .= '
             <div style="' . $display . '" id="image_div_' . $name . '"><br><a id="a_lightbox_' . $name . '" data-title="imagen" data-lightbox="a_img_' . $name . '" href="' . $image_gra . '"><img id="image_img_' . $name . '" src="' . $image . '"/></a></div>
        ';
        
        if($group){
            $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        }
        
        return $html;
    }
    
    public function hiddenHtml($name, $value) {
        $html = '
            <input name="' . $name . '" id="' . $name . '" value="' . $value . '" type="hidden">
        ';
        return $html;
    }
    
    public function passwordHtml($label, $name, $valid = '', $equal_to = '',$minlength = 0,$maxlength = 0, $value = '', $group = true){
        
        $minlength = (is_numeric($minlength) && $minlength > 0 ) ? 'minlength="' . $minlength . '"' : '';
        $maxlength = (is_numeric($maxlength) && $maxlength > 0 ) ? 'maxlength="' . $maxlength . '"' : '';
        $equal_to = ($equal_to !== '')? $equal_to = 'equalto="#' . $equal_to . '"': '';
        
        $html = '
            <input ' . $minlength . ' ' . $maxlength . ' ' . $equal_to . ' name="' . $name . '" id="' . $name . '" value="' . $value . '" class="form-control' . $valid . '" type="password">
        ';
        
        if($group){
            $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        }
        
        return $html;
    }
    
    //<textarea class="form-control" rows="5"></textarea>
    
    public function textAreaHtml($label, $name,$valid = '',$value = '', $group = true){
        
        $html = '
            <textarea name="' . $name . '" id="' . $name . '" class="form-control ' . $valid . '" rows="5">' . $value . '</textarea>
        ';
        
        if($group){
            $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        }
        
        return $html;
    }
    
    
    public function selectHtml($label, $name, $column_value, $arr_options = array(), $selected = '', $valid = '', $functionJs = '', $group = true){
        
        $options = '<option value="">Seleccione</option>';
        $functionJs = ($functionJs !== '') ? 'onchange="' . $functionJs . '"' : '';

        foreach ($arr_options as $item) {
            $selected_string = (trim($item->get($name)) === trim($selected)) ? 'selected' : '';
            $options .= '<option ' . $selected_string . ' value="' . $item->get($name) . '">' . $item->get($column_value) . '</option>';
        }
        
        $html = '
            <select ' . $functionJs . ' class="form-control ' . $valid . '" name="' . $name . '" id="' . $name . '">%s</select>
        ';
        
        $html = sprintf($html, $options);
        
        if($group === true){
            $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        }else{
            echo $html;die();
        }
        
        return $html;
    }
    
    public function datePickerHtml($label, $name, $value = '', $valid = '', $mask = ''){
        $html = '
            <input name="' . $name . '" id="' . $name . '" value="' . $value . '" class="datepicker-default form-control' . $valid . '" type="text" placeholder="' . $mask . '" data-date-format="' . $mask . '">
        ';
        
        $html = '
            <input name="' . $name . '" id="' . $name . '" value="' . $value . '" readonly="readonly" class="datepicker-default form-control ' . $valid . '" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy">
        ';
        $html = sprintf($this->groupDefaultHtml($label, $name), $html);
        return $html;
    }
    
    public function checkboxHtml($label, $name, $options, $checkeds = array()){
        $html = '
            <div class="form-group">
                <label>%s</label>
                <div class="checkbox-list">
                    %s
                </div>
            </div>
        ';
        
        $optins_text = '';
        $index = 0;
        
        foreach ($options as $option) {
            $index++;
            $checked_ele = '';
            $option_key     = $option[0];
            $option_value   = $option[1];
            
            foreach ($checkeds as $checked) {
                $checked_ele = ($checked == $option) ? 'checked="checked"' : '';
            }
            
            $optins_text .= '
                <label class="checkbox-inline">
                    <input id="' . $name . $index . '" type="checkbox" ' . $checked_ele . ' value="' . $option_value . '"/>&nbsp; ' . $name . '
                </label>
            ';
        }
        
        $html = sprintf($html, $label, $optins_text);
        return $html; 
    }
    
    public function radioHtml($label, $name, $options) {
        
    }
    
}
