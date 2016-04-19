<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author cristiam
 */
class Form extends FormHtm {
    //put your code here
    private $action;
    private $table;
    private $table_orin;
    private $title;
    private $color;
    private $method;
    private $inputs = '';
    private $obj = null;
    private $name_images = '';
    
    public function __construct($id, $table = 'Form', $title = 'Formulario', $color = 'blue', $action = 'cud/save.html' , $method = 'POST') {   
        $this->action = $action;
        $this->method = $method;
        $this->table = 'form_' . $table;
        $this->table_orin = $table;
        $this->title = $title;
        $this->color = $color;
        $this->obj = new Model($table, $id);
    }

    public function input($label, $name, $valid = '',$equal_to = '',$minlength = 0,$maxlength = 0,  $mask = '', $value = ''){
        
        if($value == 'not_val'){
           $value = ''; 
        }else if($value === ''){
            $value = $this->obj->get($name);
        }
        
        $this->inputs .= $this->inputHtml($label, $name, $valid, $equal_to, $minlength, $maxlength, $mask, $value);
    }
    
    public function image($label, $name, $valid = '', $value = ''){
        
        if($value == 'not_val'){
           $value = ''; 
        }else if($value === ''){
            $value = $this->obj->get($name);
        }
        
        $this->addImage($name);
        $this->inputs .= $this->imageHtml($label, $name, $value, $valid);
    }
    
    public function password($label, $name, $valid = '', $equal_to = '',$minlength = 0,$maxlength = 0, $value = ''){
 
        if($value == 'not_val'){
           $value = ''; 
        }else if($value === ''){
            $value = $this->obj->get($name);
        }
        
        $this->inputs .= $this->passwordHtml($label, $name, $valid, $equal_to, $minlength, $maxlength, $value);
    }
    
    public function hidden($name, $value) {
        if($value === ''){
            $value = $this->obj->get($name);
        } 
        $this->inputs .= $this->hiddenHtml($name, $value);
    }
    
    public function textArea($label, $name, $valid = '', $value = ''){

        if($value === ''){
            $value = $this->obj->get($name);
        }
        
        $this->inputs .= $this->textAreaHtml($label, $name, $valid, $value);
    }
    
    public function select($label, $name, $column_value, $arr_options = array(), $valid = '',$functionJs = '', $selected = ''){
        
        if($selected === ''){
            $selected = $this->obj->get($name);
        }
        
        $this->inputs .= $this->selectHtml($label, $name, $column_value, $arr_options, $selected, $valid, $functionJs);
    }
    
    public function datePicker($label, $name, $valid = '', $mask = '', $value = ''){
        if($value === ''){
            $value = $this->obj->get($name);
        }
        
        $this->inputs .= $this->datePickerHtml($label, $name, $value, $valid, $mask);
    }
    
    public function md5Encript($name){
        $this->hidden('encript', $name);
    }
    
    public function formCode() {
        $this->hidden('table', $this->table_orin);
        $this->hidden('primary_key', $this->obj->primary_key());
        $this->hidden($this->obj->primary_key(), $this->obj->primary_value());
        $form = $this->formHtml($this->action, $this->table, $this->title, $this->color);
        $form = sprintf($form,$this->inputs);
        return $form; 
    }
    
    public function modalForm(){
        ?>
        <div id="modal-<?php echo $this->table?>" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
            aria-hidden="true" class="modal fade">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <!--button type="button" data-dismiss="modal" aria-hidden="true"
                               class="close">&times;</button-->
                       <!--h4 id="modal-default-label" class="modal-title"><div id="modal-tit">si</div></h4></div-->
                       <div class="modal-body">
                           <div id="modal_aler_<?php echo $this->table?>" class="note note-success">
                               <button type="button" data-dismiss="modal" aria-hidden="true"
                                   class="close">&times;</button>  
                               <h3 id="modal_tit_<?php echo $this->table?>">qwqwqw</h3>
                               <p id="modal_content_<?php echo $this->table?>">qwqwqw</p>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                           <!--button type="button" class="btn btn-primary">Save changes</button-->
                       </div>
                   </div>
               </div>
           </div>
       </div>
        <?php
    }
    
    public function funtionJs() {
        ?>
        <script type="text/javascript">
        
        $('#<?php echo $this->table?>').on("submit", function(e){
            e.preventDefault();
            var form = $(this);
            var html = 'Guardando, espere un momento...';
            $('#id_submit_<?php echo $this->table?>').html(html);
            $('#id_submit_<?php echo $this->table?>').attr("disabled", true);
            
            html = 'Ingrese &nbsp;<i class="fa fa-chevron-circle-right">';
            if (!form.valid()){
                $('#id_submit_<?php echo $this->table?>').html(html);
                $('#id_submit_<?php echo $this->table?>').attr('disabled', false);
                return false;  
            }
            /*var formData = new FormData(document.getElementById("<?php echo $this->table?>"));
            $.ajax({
                type: 'POST',
                url:    form.attr('action'),
                data:   formData,
                cache: false,
                contentType: false,
                processData: false
                })
                .done(function(response){
                    alert(response);

                }*/
                var formData = new FormData(document.getElementById("<?php echo $this->table?>"));
                //formData.append(f.attr("name"), $(this)[0].files[0]);
                $.ajax({
                    url: form.attr('action'),
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function(response){
                    var fixedResponse = response.replace(/\\'/g, "'");
                    var jsonObj = JSON.parse(fixedResponse);

                    var id = jsonObj.id;
                    var insert = jsonObj.insert;
                    var message = '';
                    var title = '';
                    var type_alert = '';
                    
                    if(typeof(jsonObj.message) != "undefined"){
                        message = jsonObj.message;
                    }
                    
                    if(typeof(jsonObj.title) != "undefined"){
                        title = jsonObj.title;
                    }
                    
                    if(typeof(jsonObj.type_alert) != "undefined"){
                        title = jsonObj.type_alert;
                    }

                    var modal_aler = '';
                    var modal_tit = '';
                    var modal_content = '';

                    if((!isNaN(id)) && (id != '') && (id > 0)){
                        modal_aler = 'note note-success';
                        if(insert === 'insert'){
                            modal_tit = 'Guardado exitoso!';
                            modal_content = 'El registro se guardo con exito.';
                        }else{
                            modal_tit = 'Actualizado exitoso!';
                            modal_content = 'El registro se actualizo con exito';
                        }
                    }else{
                        modal_aler = 'note note-danger';
                        modal_tit = 'Error!';
                        modal_content = 'Hubo un error en el sistema la peticion no se pudo completar, por favor intente de nuevo, si el problema persiste comuniquese administrador del sistemaa.';
                    }
                    
                    var arr_images = [<?php echo $this->name_images?>];
                    for(i=0;i<arr_images.length;i++){
                        var image = arr_images[i];
                        $.ajax({
                            type: 'POST',
                            url:  '<?php echo _APPLICACION_URL . _CURRENT_CONTROLLER_CLASS?>/imageLoader.html',
                            data:  'table=<?php echo $this->table_orin?>&field=' + image + '&id=' + id ,
                            success: function (response) {
                                var fixedResponse = response.replace(/\\'/g, "'");
                                var jsonObj = JSON.parse(fixedResponse);

                                if(jsonObj.image != ''){
                                    document.getElementById('image_img_' + image).src = '<?php echo _IMAGE_URL?>300x/' + jsonObj.image;
                                    $('#a_lightbox_img_' + image).attr('href', '<?php echo _IMAGE_URL?>600x/' + jsonObj.image);
                                    document.getElementById('image_div_' + image).style.display = 'block';
                                }
                            }
                        });
                    }
                    
                    if(title != ''){
                        modal_tit = title;
                    }
                    
                    if(message != ''){
                        modal_content = message;
                    }
                    
                    if(type_alert != ""){
                        modal_aler = type_alert;
                    }
                    
                    $('#<?php echo $this->obj->primary_key()?>').val(id);
                    $('#modal_aler_<?php echo $this->table?>').attr("class",modal_aler);
                    $('#modal_tit_<?php echo $this->table?>').html(modal_tit);
                    $('#modal_content_<?php echo $this->table?>').html(modal_content);
                    $('#modal-<?php echo $this->table?>').modal('show'); 
                    
                    html = 'Enviar';
                    $('#id_submit_<?php echo $this->table?>').html(html);
                    $('#id_submit_<?php echo $this->table?>').attr("disabled", false);
                });

                /*,
                error: function (xhr, ajaxOptions, thrownError) {
                    var modal_aler = 'note note-danger';
                    var modal_tit = 'Error!';
                    var modal_content = 'La solicitud se a demorado mucho, revise su conexion a internet y vuelva a intentarlo!!!';

                    $('#modal_aler').attr("class",modal_aler);;
                    $('#modal_tit').html(modal_tit);
                    $('#modal_content').html(modal_content);
                    $('#modal-default').modal('show'); 
                }
            });  */ 
            
            
            /*html = 'Enviar';
            $('#id_submit_<?php echo $this->table?>').html(html);
            $('#id_submit_<?php echo $this->table?>').attr("disabled", false);*/
        });
        </script>
        <?php
    }
    
    private function addImage($name){
        $separator = ($this->name_images == "") ? "" : ",";
        $this->name_images .= $separator . '"' . $name . '"';
    }
    
}
