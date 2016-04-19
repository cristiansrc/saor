<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author Cristhiampc
 */
class Table extends TableHtm {
    //put your code here
    
    protected $head = "";
    protected $body = "";
    protected $table;
    protected $label;
    protected $primary_key;
    protected $arr_arr;
    protected $url_update;
    protected $url_delete;
    protected $url_state;
    protected $columns;
    protected $fields;
    protected $labels;
    protected $table_origin;
    protected $functions;

    public function __construct($table, $label, $primary_key, $columns, $where = '', $url_update = '', $url_delete = '', $table_origin = '') {
        $this->table = $table;
        $this->label = $label;
        $this->primary_key = $primary_key;
        $this->columns = $columns;
        $this->url_update = ($url_update !== "") ? _APPLICACION_URL . $url_update : "";
        $this->url_delete = ($url_delete !== "") ? _APPLICACION_URL . $url_delete : "";
        $this->fields = array();
        $this->labels = array();
        $helper = new HelperDb($table);
        $this->arr_obj = $helper->selectResult($where);
        $this->table_origin = ($table_origin !== '') ? $table_origin : $table;
        $this->functions = array();
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
                           <button id="modal_cerrar<?php echo $this->table?>" type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                           <button id="modal_button<?php echo $this->table?>" onclick="deleteReg()" type="button" class="btn btn-primary">Eliminar</button>
                       </div>
                   </div>
               </div>
           </div>
       </div>
        <?php
    }
    
    public function funtionDeleteJs() {
        ?>
        <script type="text/javascript">
            var data = null;
            var parent = null;
            var id = null;
            
            $(document).ready(function()
            {
                    $('table#<?php echo $this->table?> td a.delete').click(function()
                    {
                        $('#modal_button<?php echo $this->table?>').attr('disabled', false);
                        $('#modal_cerrar<?php echo $this->table?>').attr('disabled', false);
                        id = $(this).parent().parent().attr('id');
                        data = 'id=' + id + '&table=<?php echo $this->table_origin?>';
                        parent = $(this).parent().parent();	
                        var modal_aler = 'note note-danger';
                        var modal_tit = 'Eliminacion!';
                        var modal_content = '¿Realmente desea eliminar el registro con id ' + id + '?';
                        
                        $('#modal_aler_<?php echo $this->table?>').attr("class",modal_aler);;
                        $('#modal_tit_<?php echo $this->table?>').html(modal_tit);
                        $('#modal_content_<?php echo $this->table?>').html(modal_content);
                        $('#modal-<?php echo $this->table?>').modal('show'); 

                    });

                    // style the table with alternate colors
                    // sets specified color for every odd row
                    //$('table#<?php echo $this->table?> tr:odd').css('background',' #FFFFFF');
            });
            
            function deleteReg(){
                var html = 'Consultando, espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader11.GIF">';
                $('#modal_button<?php echo $this->table?>').html(html);
                $('#modal_button<?php echo $this->table?>').attr('disabled', true);
                $('#modal_cerrar<?php echo $this->table?>').attr('disabled', true);

                html = 'Eliminar';
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->url_delete?>",
                    data: data,
                    cache: false,
                    success: function()
                    {
                        parent.fadeOut('slow', function() {$(this).remove();});
                        var modal_aler = 'note note-success';
                        var modal_tit = 'Eliminacion exitosa!';
                        var modal_content = 'El registro con id ' + id + ' fue eliminado con exito!!!';
                        
                        $('#modal_aler_<?php echo $this->table?>').attr("class",modal_aler);;
                        $('#modal_tit_<?php echo $this->table?>').html(modal_tit);
                        $('#modal_content_<?php echo $this->table?>').html(modal_content);
                        $('#modal_button<?php echo $this->table?>').html(html);
                        $('#modal_cerrar<?php echo $this->table?>').attr('disabled', false);
                    }
                 });
            }
        </script>
        <?php
    }
    
    public function codeTable(){
        $this->separedColumns();
        $this->createHead();
        $this->createBody();
        return $this->tableHtml($this->head, $this->body);
    }

    private function createBody(){
        $html = '';
        foreach ($this->arr_obj as $arr) {
            $column = '';
            
            //$column .= sprintf($this->tdHtml(), '<input type="checkbox"/>');
            foreach ($this->fields as $index) {
                $column .= sprintf($this->tdHtml(), $arr[$index]);
            }
            
            $column .= ($this->url_update !== '') ? sprintf($this->tdHtml(), $this->buttonUpdate($this->url_update, $arr[$this->primary_key])) : '';
            $column .= ($this->url_delete !== '') ? sprintf($this->tdHtml(), $this->buttonDelete($arr[$this->primary_key])) : '';
            $html   .= sprintf($this->trHtml(  'id="' . $arr[$this->primary_key] . '"'), $column);
        }
        
        $this->body = sprintf($this->bodyHtml(), $html);
    }
    
    private function createHead(){
        $html = '';
        //$html .= sprintf($this->thHtml(), '<input type="checkbox" class="checkall"/>');
        foreach ($this->labels as $label) {
            $html .= sprintf($this->thHtml(), $label);
        }
        $html .= ($this->url_update !== '') ? sprintf($this->thHtml(), 'Editar') : '';
        $html .= ($this->url_delete !== '') ? sprintf($this->thHtml(), 'Eliminar') : '';
        $this->head = sprintf($this->headTrHtml(), $html);
    }


    private function separedColumns() {
        $arr_columns = explode(',', $this->columns);
        
        foreach ($arr_columns as $column) {
            $arr_columns = explode(':', $column);
            array_push($this->labels,   $arr_columns[0]);
            array_push($this->fields,    $arr_columns[1]);
        }
    }
    
    
    
}
