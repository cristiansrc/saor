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
                                <div class="caption">Reportes</div>
                            </div>
                            <div class="portlet-body">
                                <div class="panel panel-yellow">
                                    <form name="form1" id="form1" class="form-validate" method="post" action="<?php _APPLICACION_URL?>/sms/plano/empiezaReporte.html" novalidate="novalidate">
                                        <div class="form-body pal">
                                            <div class="form-group">
                                                <label class="control-label" for="ano">A&ntilde;o</label>
                                                
                                                <select name="ano" id="ano" class="form-control required">
                                                    <option value="">Seleccione</option>
                                                    <option  value="<?php echo date('y')?>"><?php echo date('Y')?></option>
                                                    <option  value="<?php echo (date('y') - 1)?>"><?php echo (date('Y') - 1)?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="mes">Mes</label>
                                                <select id="mes" name="mes" class="form-control required">
                                                    <option value="">Seleccione</option>
                                                    <?php 
                                                    for ($month = 1; $month < 13; $month++) {
                                                        $selected = ($month_select == $month) ? 'selected' : '';
                                                    ?>
                                                    <option  <?php echo $selected?> value="<?php echo $month?>"><?php echo $month?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions text-right pal">
                                           
                                            <button class="btn btn-primary" id="sudmit_boton_ajax" type="submit">Descargar </button>
                                        </div>
                                    </form>
                                    
                                </div>
                         
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                function nuevaPestana(url){
                    window.open(url, '_blank');
                }
                
                function existeReporte(ano, mes){
                    $.ajax(
                        {
                            url: "<?php echo _APPLICACION_URL?>/sms/plano/existeReporte/" + ano + "/" + mes + ".html",
                            type: 'GET',
                            dataType: "html",
                            success: function (jsonObj) {
                             
                                var fixedResponse = jsonObj.replace(/\\'/g, "'");
                                var jsonObj = JSON.parse(fixedResponse);
                                
                                if($.trim(jsonObj.respuesta) == 'Si'){
                                    var html = 'Descargar';
                                    $('#sudmit_boton_ajax').html(html);
                                    $('#sudmit_boton_ajax').attr('disabled', false);
                                    var url = '<?php echo _APPLICACION_URL?>/plano/descargarzip/' + ano + '/' + mes + '.html';
                                    location.href=url;
                                }else{
                                    setTimeout('existeReporte(' + ano + ',' + mes + ')', 3000);
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                setTimeout('existeReporte(' + ano + ',' + mes + ')', 3000);
                            }
                        });
                
                }
                
                $("#form1").submit(function () {
                    var html = 'Creando reportes, espere un momento...  <img src="<?php echo _APPLICACION_URL?>/vendors/pageloader/images/loader11.GIF">';
                    $('#sudmit_boton_ajax').html(html);
                    $('#sudmit_boton_ajax').attr('disabled', true);
                    var $form = $(this);
                    // check if the input is valid
                    if (!$form.valid()){
                        var html = 'Descargar';
                        $('#sudmit_boton_ajax').html(html);
                        $('#sudmit_boton_ajax').attr('disabled', false);
                        return false;  
                    }
                    
                    var ano = $('#ano').val();
                    var mes = $('#mes').val();
                    
                    $.ajax(
                        {
                            type: 'POST',
                            url: $form.attr('action'),
                            data: $form.serialize(),
                            success: function (response) {

                                var fixedResponse = response.replace(/\\'/g, "'");
                                var jsonObj = JSON.parse(fixedResponse);
                                
                                if($.trim(jsonObj.respuesta) == 'ok'){
                                    var url = '<?php echo _APPLICACION_URL?>/plano/descargarzip/' + ano + '/' + mes + '.html';
                                    //nuevaPestana(url);
                                    /*html = 'Descargar';
                                    $('#sudmit_boton_ajax').html(html);
                                    $('#sudmit_boton_ajax').attr('disabled', false);
                                    location.href=url;*/
                                    setTimeout('existeReporte(' + ano + ',' + mes + ')', 3000);
                                }else{
                                    html = 'Descargar';
                                    $('#sudmit_boton_ajax').html(html);
                                    $('#sudmit_boton_ajax').attr('disabled', false);
                                    alert('No hay informacion en la base de datos en la fecha seleccionada');
                                }     
                                
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                setTimeout('existeReporte(' + ano + ',' + mes + ')', 3000);
                            }
                        });

                    return false;
                });
                </script>
            </div>
            