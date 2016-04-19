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
                                <div class="caption">Estadisticas</div>
                            </div>
                            <div class="portlet-body">
                                <div class="panel panel-yellow">
                                    <form name="form1" id="form1" class="form-validate" method="post" action="<?php _APPLICACION_URL?>/sms/plano/smSubidos.html" novalidate="novalidate">
                                        <div class="form-body pal">
                                            <div class="form-group">
                                                <label class="control-label" for="ano">A&ntilde;o</label>
                                                <select name="ano" id="ano" class="form-control required">
                                                    <option value="">Seleccione</option>
                                                    <?php 
                                                    for ($year = date('Y'); (date('Y') - 2) > $year; $year--) {
                                                        $selected = ($year_select == $year) ? 'selected' : '';
                                                    ?>
                                                    <option <?php echo $selected?> value="<?php echo $year?>"><?php echo $year?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <option <?php echo ($year_select == date('Y') ? 'selected' : '')?> value="<?php echo date('Y')?>"><?php echo date('Y')?></option>
                                                    <option <?php echo ($year_select == (date('Y') - 1) ? 'selected' : '')?> value="<?php echo (date('Y') - 1)?>"><?php echo (date('Y') - 1)?></option>
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
                                            <button class="btn btn-primary" type="submit">Enviar</button>
                                        </div>
                                    </form>
                                    
                                </div>
                                
                                <div class="row mbm">
                                    
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="table_id"
                                                   class="table table-hover table-striped table-bordered table-advanced tablesorter display">
                                                <thead>
                                                <tr>
                                                    <th>Dia</th>
                                                    <th>Numero de registros</th>
                                                    <th>Estado de proceso de subida</th>
                                                    <th>Subir info</th> 
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $total = 0;
                                                $motrar_total = false;
                                                for ($index = 1; $index < $num_dias + 1; $index++) {
                                                    $motrar_total = true;
                                                    $dia = ($index < 10) ? '0' . $index : $index;
                                                    $estadistica = $this->smSubidosDia($year_select, $month_select, $dia);
                                                    $plano = 'FAC_' . $dia . '-' . $month_select . '-' . substr($year_select, -2) . '.DAT';
                                                    $num        = (isset($estadistica[0]['NO_IDENTY'])) ? $estadistica[0]['NO_IDENTY'] : 0;
                                                    $termino    = (isset($estadistica[0]['TERMINO_PROCESO'])) ? $estadistica[0]['TERMINO_PROCESO'] : -1;
                                                    $total += $num; 
                                                    $class = '';
                                                    $label = '';
                                                    
                                                    switch ($termino) {
                                                        case -1:
                                                            $class = 'label label-sm label-info';
                                                            $label = 'Pendiente';
                                                        break;
                                                        case 0:
                                                            $class = 'label label-sm label-warning';
                                                            $label = 'Subiendo informacion';
                                                        break;
                                                        case 1:
                                                            $class = 'label label-sm label-success';
                                                            $label = 'Termino';
                                                        break;
                                                    }
                                                ?>    
                                                <tr>
                                                    <td><?php echo ($dia. '-' . $month_select . '-' . $year_select)?></td>
                                                    <td><div id="num_reg_<?php echo ($dia . '-' . $month_select . '-' . $year_select)?>"><?php echo $num?></div></td>
                                                    <th><div id="message_<?php echo ($dia . '-' . $month_select . '-' . $year_select)?>"><span class="<?php echo $class?>"><?php echo $label?></span></div></th>
                                                    <th>
                                                        <button id="boton_subir_<?php echo ($dia. '-' . $month_select . '-' . $year_select)?>" onclick="subirInfoPlano('<?php echo $plano?>')" class="btn btn-default btn-xs" type="button"><i class="fa fa-upload"></i>&nbsp;
                                                            Subir sms del dia
                                                        </button>
                                                    </th>
                                                </tr>
                                                <?php 
                                                }
                                                if($motrar_total === true){
                                                ?>
                                                <td>Total mes</td>
                                                <td><div id="num_reg_total"><?php echo $total?></div></td>
                                                <th>-</th>
                                                <th>
                                                    <button id="boton_subir" onclick="subirInfoPlanoMes($('#ano').val(), $('#mes').val())" class="btn btn-default btn-xs" type="button"><i class="fa fa-upload"></i>&nbsp;
                                                        Subir sms todo el mes
                                                    </button>
                                                </th>
                                                <?php 
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                     aria-hidden="true" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!--button type="button" data-dismiss="modal" aria-hidden="true"
                                        class="close">&times;</button-->
                                <!--h4 id="modal-default-label" class="modal-title"><div id="modal-tit">si</div></h4></div-->
                            <div class="modal-body">
                                <div id="modal_aler" class="note note-success">
                                    <button type="button" data-dismiss="modal" aria-hidden="true"
                                        class="close">&times;</button>  
                                    <h3 id="modal_tit">qwqwqw</h3>
                                    <p id="modal_content">qwqwqw</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                                <!--button type="button" class="btn btn-primary">Save changes</button-->
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                function sleep(milliseconds) {
                    var start = new Date().getTime();
                        for (var i = 0; i < 1e7; i++) {
                            if ((new Date().getTime() - start) > milliseconds){
                                break;
                            }
                        }
                }

                function subirInfoPlano(plano){
                    $.ajax({
                        url: "<?php echo _APPLICACION_URL?>/sms/plano/creaCurlDia/" + plano,
                        type: 'GET',
                        dataType: "html",
                        success: function(response) {
                            var fixedResponse = response.replace(/\\'/g, "'");
                            var jsonObj = JSON.parse(fixedResponse);
                            
                            var modal_aler = '';
                            var modal_tit = '';
                            var modal_content = '';

                            var exitoso = false;
                            if(jsonObj.estado == 'proceso_activo'){
                                modal_aler = 'note note-warning';
                                modal_tit = 'Atencion!';
                                modal_content = 'El proceso no puede continuar, se detecto que en el sistema en este momento ya se esta ejecutando una instancia este proceso, por favor espere a que termine y vuelva a intentarlo.';
                                
                            }else if(jsonObj.estado == 'plano_no_encontrado'){
                                modal_aler = 'note note-danger';
                                modal_tit = 'Error!';
                                modal_content = 'El proceso no puede conttinuar debido a que el plano solicitado para subir no se encuentra en el sistema, por favor suba el archivo a la ruta "<?php echo _FOLDER_DAT?>" y ejecute el proceso de nuevo.';
                            }else if(jsonObj.estado == 'empezo'){
                                modal_aler = 'note note-success';
                                modal_tit = 'Exitoso!';
                                modal_content = 'El proceso solicitado comenzo correctamente, por favor recuerde que solo puede ejecutar un proceso de subida al tiempo, de nesecitar reprocesar esta informacion por favor espere a que este proceso termine.';
                                exitoso = true;
                            } 
                            
                            $('#modal_aler').attr("class",modal_aler);;
                            $('#modal_tit').html(modal_tit);
                            $('#modal_content').html(modal_content);
                            $('#modal-default').modal('show'); 
                            
                            if(exitoso == true){
                                sleep(3000);
                                location.href="<?php echo _APPLICACION_URL?>/plano/smSubidos/" + $('#ano').val() + "/" + $('#mes').val() + '.html';
                            }    
                                
                            
                        },
                        error: function() {
                            alert( "Ha ocurrido un error" );
                        }
                    });
                }

                function subirInfoPlanoMes(ano, mes){
                    $.ajax({
                        url: "<?php echo _APPLICACION_URL?>/sms/plano/creaCurlMes/" + ano + "/" + mes + ".html",
                        type: 'GET',
                        dataType: "html",
                        success: function(response) {
                            var fixedResponse = response.replace(/\\'/g, "'");
                            var jsonObj = JSON.parse(fixedResponse);
                            var modal_aler = '';
                            var modal_tit = '';
                            var modal_content = '';

                            var exitoso = false;
                            if(jsonObj.estado == 'proceso_activo'){
                                modal_aler = 'note note-warning';
                                modal_tit = 'Atencion!';
                                modal_content = 'El proceso no puede continuar, se detecto que en el sistema en este momento ya se esta ejecutando una instancia este proceso, por favor espere a que termine y vuelva a intentarlo.';
                                
                            }else if(jsonObj.estado == 'plano_no_encontrado'){
                                modal_aler = 'note note-danger';
                                modal_tit = 'Error!';
                                modal_content = 'El proceso no puede conttinuar debido a que el plano solicitado para subir no se encuentra en el sistema, por favor suba el archivo a la ruta "<?php echo _FOLDER_DAT?>" y ejecute el proceso de nuevo.';
                            }else if(jsonObj.estado == 'empezo'){
                                modal_aler = 'note note-success';
                                modal_tit = 'Exitoso!';
                                modal_content = 'El proceso solicitado comenzo correctamente, por favor recuerde que solo puede ejecutar un proceso de subida al tiempo, de nesecitar reprocesar esta informacion por favor espere a que este proceso termine.';
                                exitoso = true;
                            } 
                            
                            $('#modal_aler').attr("class",modal_aler);;
                            $('#modal_tit').html(modal_tit);
                            $('#modal_content').html(modal_content);
                            $('#modal-default').modal('show'); 
                            
                            if(exitoso == true){
                                sleep(3000);
                                location.href="<?php echo _APPLICACION_URL?>/planos/smSubidos/" + $('#ano').val() + "/" + $('#mes').val()
                            }    
                        },
                        error: function() {
                            alert( "Ha ocurrido un error" );
                        }
                    });
                }
                
                function pruebaModal(){
                    $('#modal-default').modal('show'); 
                }
                
                $(document).ready(function() {    
                    function actualizarInfo(){
                        if($('#ano').val() !== '' && $('#mes').val() !== ''){
                           var ano = $('#ano').val();
                           var mes = $('#mes').val();
                        
                            $.ajax({
                                url: "<?php echo _APPLICACION_URL?>/sms/plano/ajaxLogSubida/" + ano + "/" + mes + ".html",
                                type: 'GET',
                                dataType: "html",
                                success: function(response) {
                                    var fixedResponse = response.replace(/\\'/g, "'");
                                    var jsonObj = JSON.parse(fixedResponse);
                                    
                                    var total;
                                    for(i=0;i<jsonObj.length;i++){
                                        log = jsonObj[i];
                                        BR_GENERATE_TIME = log.BR_GENERATE_TIME;
                                        TERMINO = log.TERMINO_PROCESO;
                                        N_REGISTROS = log.N_REGISTROS;
                                        total = total + N_REGISTROS;
                                        message = '';
                                        
                                        if(TERMINO == 1){
                                            message = '<span class="label label-sm label-success">Termino</span>';
                                        }else{
                                            message = '<span class="label label-sm label-warning">Subiendo informacion</span>';
                                        }
                                        
                                        $('message_' + BR_GENERATE_TIME).html(message);
                                        $('num_reg_' + BR_GENERATE_TIME).html(N_REGISTROS);
                                    }
                                    
                                    $('num_reg_total').html(total);
                                    
                                },
                                error: function() {
                                    
                                }
                            });
                        }
                    }

                    setInterval(actualizarInfo, 30000);
                });
                </script>
            </div>
            