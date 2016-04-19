<!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <!--div class="col-lg-12">
                        <div class="note note-success"><h4 class="box-heading">Datatables</h4>

                            <p>Main features from datatables: paging, search, sorter, filter</p>

                           <p>Export tool work on Flash Environment, check other <a href="table-export.html"
                                                                                     target="_blank">Table Export</a>
                            </p>

                            <p>To use "Edit" feature, please check it <a href="table-editable.html" target="_blank">Editable</a>
                            </p></div>
                    </div-->
                    <div class="col-lg-12">
                        <div class="portlet box">
                            <div class="portlet-header">
                                <div class="caption"><?php echo $titulo?></div>
                            </div>
                            <div class="portlet-body">
                                   <?php echo $form->formCode()?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php -$form->modalForm()?>
                <?php $form->funtionJs()?>
               <script type="text/javascript">
                   function ajaxRestaurante(id){
                        var html = 'Cargando informacion, espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader2.GIF">';
                        $('#div_id_restaurante').html(html);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo _APPLICACION_URL?>usuario/ajaxRestaurante.html",
                            data: "id=" + id,
                            cache: false,
                            success: function(response)
                            {
                                $('#div_id_restaurante').html(response);
                            }
                        });
                   }
                   
                   function ajaxSucursal(id){
                        var html = 'Cargando informacion, espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader2.GIF">';
                        $('#div_id_sucursal').html(html);
                        var id_tipo_persona = $('#id_tipo_persona').val();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo _APPLICACION_URL?>usuario/ajaxSucursal.html",
                            data: "id=" + id + "&id_tipo_persona=" + id_tipo_persona,
                            cache: false,
                            success: function(response)
                            {
                                $('#div_id_sucursal').html(response);
                            }
                        });
                   }
               </script>
            </div>

            
            