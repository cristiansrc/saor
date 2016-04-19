

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
                                <div class="caption">
                                    
                                    <button type="button" onclick="orden(0)" id="id_crear_orden"
                                            data-toggle="modal" class="btn btn-info btn-outlined">Crear Orden
                                    </button>
                                </div>

                            </div>
                            <div class="portlet-body">
                                    <!--Modal Responsive-->
                                    <div id="modal-responsive" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label"
                                         aria-hidden="true" class="modal fade">
                                        
                                            <input type="hidden" name="orden_session_number" value="<?php echo $orden_session_number?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" onclick="closeOrden()" aria-hidden="true"
                                                            class="close">&times;</button>
                                                    <h4 id="modal-responsive-label" class="modal-title">Crear Orden</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <ul id="myTab" class="nav nav-tabs">
                                                                <li class="active"><a href="#productos" data-toggle="tab">Productos</a></li>
                                                                <li><a href="#productos_solicitados" data-toggle="tab">Productos solicitados</a></li>
                                                                <li><a href="#fin_creacion" data-toggle="tab">Informacion de la orden</a></li>
                                                            </ul>
                                                            <div id="myTabContent" class="tab-content">
                                                                <div id="productos" class="tab-pane fade in active">
                                                                    <div class="panel panel-yellow">
                                                                        <div class="panel-heading">Lista de productos</div>
                                                                        <div id="panel_productos" class="panel-body">
                                                                            
                                                                            <div id="no-more-tables">
                                                                                <table class="table table-bordered table-striped table-condensed cf">
                                                                                    <thead class="cf">
                                                                                    <tr>
                                                                                        <th>Producto</th>
                                                                                        <th>Descripcion</th>
                                                                                        <th>Valor</th>
                                                                                        <th>Valor con iva</th>
                                                                                        <th>Agregar</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <?php 
                                                                                    foreach ($productos as $producto) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td data-title="Producto">
                                                                                            <?php echo $producto->get('nombre_producto')?><br>
                                                                                            <a data-title="<?php echo $producto->get('nombre_producto')?>" data-lightbox="pefil" href="<?php echo _IMAGE_URL?>600x/<?php echo $producto->get('imagen_producto')?>">
                                                                                                <img src="<?php echo _IMAGE_URL?>200x/<?php echo $producto->get('imagen_producto')?>"/>
                                                                                            </a>
                                                                                        </td>
                                                                                        <td data-title="Descripcion"><?php echo $producto->get('descripcion_producto')?></td>
                                                                                        <td data-title="Valor">
                                                                                            $<?php echo $producto->get('varlor_s_iva_producto')?>
                                                                                        </td>
                                                                                        <td data-title="Valor con iva">
                                                                                            $<?php echo ($producto->get('varlor_s_iva_producto') * 1.16)?>
                                                                                        </td>
                                                                                        <td data-title="Agregar">
                                                                                            <button class="label label-sm label-success" onclick="addProduct(<?php echo $producto->get('id_producto')?>)" d="boton_add_Producto_<?php echo $producto->get('id_producto')?>" value="">
                                                                                                <i class="fa fa-edit"></i>Agregar
                                                                                            </button>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="productos_solicitados" class="tab-pane fade">
                                                                    <div class="panel panel-yellow">
                                                                        <div class="panel-heading">Productos de la orden</div>
                                                                        <div id="panel_orden" class="panel-body">
                                                                            
                                                                            <form method="POST" action="" id="form_orden" name="form_orden">
                                                                                <input type="hidden" value="" id="id_producto_new" name="id_producto_new"/>
                                                                                <input type="hidden" value="<?php echo $orden_session_number?>" id="orden_session_number" name="orden_session_number"/>
                                                                                <input type="hidden" value="" id="id_mesa" name="id_mesa"/>
                                                                                <input type="hidden" value="" id="id_cliente" name="id_cliente"/>
                                                                                <div id="listProdutsSelected">
                                                                                    
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="fin_creacion" class="tab-pane fade">
                                                                    <div class="panel panel-yellow">
                                                                        <div class="panel-heading">Informacion de la orden</div>
                                                                        <div id="panel_orden" class="panel-body">
                                                                            <div class="portlet-body">
                                                                                <form id="informacion_orden" class="form-validate">
                                                                                    <input value="" type="hidden" id="id_cliente_info_orden" name="id_cliente_info_orden"/>
                                                                                    <div class="form-group">
                                                                                        <label for="mesa" class="control-label">Mesa *</label>
                                                                                        <select id="mesa" name="mesa" class="form-control required">
                                                                                            <option value="">Seleccione</option>
                                                                                            <?php 
                                                                                            foreach ($mesas as $mesa) {
                                                                                            ?>
                                                                                            <option value="<?php echo $mesa->get('id_mesa')?>"><?php echo $mesa->get('nombre_mesa')?></option>
                                                                                            <?php 
                                                                                            }
                                                                                            ?>
                                                                                        </select>

                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="identificacion" class="control-label">Documento cliente</label>
                                                                                        <div class="input-group">
                                                                                            <input id="identificacion" type="text" class="form-control">
                                                                                            <span id="pageloader-img" class="input-group-btn">
                                                                                                <button id="buscarClienteB" onclick="buscarCliente()" class="btn btn-primary" type="button">
                                                                                                    Buscar Cliente!
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="nombre_cliente" class="control-label">Nombre del cliente</label>
                                                                                        <input readonly="readonly" type="text" id="nombre_cliente" name="nombre_cliente" class="form-control"/>
                                                                                    </div>
                                                                                    <button onclick="quitarCliente()" type="button" class="btn btn-yellow">Quitar cliente de la orden</button>
                                                                                    &nbsp;
                                                                                    <button onclick="agregarCliente()" type="button" class="btn btn-orange">Agregar Cliente</button>
                                                                                    &nbsp;
                                                                                    <button onclick="guardarOrden()" id="guardarOrdenB" type="button" class="btn btn-blue">Enviar a cocina</button>
                                                                                    &nbsp;

                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <button type="button" onclick="closeOrden()" id="id_crear_orden"
                                                                    data-toggle="modal" class="btn btn-info btn-outlined">Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--div class="modal-footer">
                                                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div-->
                                            </div>
                                        </div>
                                   
                                    </div>
                                    
                                    
                                    <!--Modal Agregar Cliente-->
                                    <div id="agregar_cliente" tabindex="-1" data-backdrop="static" data-keyboard="false" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" onclick="cerrarFormCliente()" aria-hidden="true"
                                                            class="close">&times;</button>
                                                    <h4 id="modal-responsive-label" class="modal-title">Crear cliente</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="portlet box portlet-yellow">
                                                        <div class="portlet-header">
                                                            <div class="caption">Nuevo cliente</div>
                                                            
                                                        </div>
                                                        <div class="portlet-body">
                                                            <form id="form_nuevo_cliente"  class="form-validate" novalidate="novalidate">
                                                                <div class="form-group">
                                                                    <label for="identificacion" class="control-label">Identificacion</label>
                                                                    <input name="identificacion" type="text" name="text" class="form-control required"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="primer_nombre" class="control-label">Primer Nombre</label>
                                                                    <input name="primer_nombre" type="text" name="text" class="form-control required"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="otros_nombre" class="control-label">Otros Nombres</label>
                                                                    <input name="otros_nombre" type="text" name="text" class="form-control"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="primer_apellido" class="control-label">Primer Apellido</label>
                                                                    <input name="primer_apellido" type="text" name="text" class="form-control required"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="otros_apellidos" class="control-label">Otros Apellidos</label>
                                                                    <input name="otros_apellidos" type="text" name="text" class="form-control"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="mail" class="control-label">Mail</label>
                                                                    <input name="mail" type="text" name="text" class="form-control required email"/>
                                                                </div>
                                                                
                                                                <button id="guardarClienteB" type="submit" class="btn btn-success">Guardar</button>
                                                                &nbsp;
                                                                <button onclick="cerrarFormCliente()" type="button" class="btn btn-default">Cancel</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--Modal Alert Crear Cliente-->
                                    <div id="modal-salvar-cliente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                                            aria-hidden="true" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <!--button type="button" data-dismiss="modal" aria-hidden="true"
                                                            class="close">&times;</button-->
                                                    <!--h4 id="modal-default-label" class="modal-title"><div id="modal-tit">si</div></h4></div-->
                                                    <div class="modal-body">
                                                        <div id="modal_aler_cliente" class="note note-success">
                                                            <button type="button"  onclick="cerrar_modal_cliente()"
                                                                class="close">&times;</button>  
                                                            <h3 id="modal_tit_cliente">qwqwqw</h3>
                                                            <p id="modal_content_cliente">qwqwqw</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" onclick="cerrar_modal_cliente()" class="btn btn-default">Cerrar</button>
                                                        <!--button type="button" class="btn btn-primary">Save changes</button-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--Modal Cerrar orden-->
                                    <div id="modal-cerrar-orden-n"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                                        aria-hidden="true" class="modal fade">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   
                                                   <h4 id="modal-full-width-label" class="modal-title">Descartar Orden</h4>
                                               </div>
                                               <div class="modal-body">Desea descartar la orden?</div>
                                               <div class="modal-footer">
                                                   <button onclick="cerrarModalOrden(true)" type="button" class="btn btn-default">Si</button>
                                                   <button onclick="cerrarModalOrden(false)" type="button" class="btn btn-primary">No</button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                    
                                   <!--Modal Confirmar orden sin cliente-->
                                    <div id="modal-confirmar_orden_s_cliente"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                                        aria-hidden="true" class="modal fade">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   
                                                   <h4 id="modal-full-width-label" class="modal-title">Guardar orden sin cliente</h4>
                                               </div>
                                               <div class="modal-body">Desea guardar la orden sin cliente?</div>
                                               <div class="modal-footer">
                                                   <button onclick="confirmarOrdenPaso(true)" type="button" class="btn btn-default">Si</button>
                                                   <button onclick="confirmarOrdenPaso(false)" type="button" class="btn btn-primary">No</button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   
                                   
                                   <!--Modal no productos-->
                                    <div id="modal-no_productos"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                                        aria-hidden="true" class="modal fade">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   <h4 id="modal-full-width-label" class="modal-title">No se an registrado productos</h4>
                                               </div>
                                               <div class="modal-body">Por favor agregue por lo menos un producto para continuar.</div>
                                               <div class="modal-footer">
                                                   <button onclick="cerrarNoProductos()" type="button" class="btn btn-default">Cerrar</button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   
                                   <!--Modal confirma orden-->
                                    <div id="modal-confirmar-orden"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-label"
                                        aria-hidden="true" class="modal fade">
                                       <div class="modal-dialog">
                                           <div class="modal-content">
                                               <div class="modal-header">
                                                   <h4 id="modal-full-width-label" class="modal-title">Confirme la orden para continuar.</h4>
                                               </div>
                                               <div id="modal_confirmar" class="modal-body">
                                                   
                                               </div>
                                               <div class="modal-footer">
                                                   <button onclick="guardarOrdenConfirmada(true)" type="button" class="btn btn-default">Si</button>
                                                   <button onclick="guardarOrdenConfirmada(false)" type="button" class="btn btn-primary">No</button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>


                            </div>
                        </div>
                        
                    </div>
                </div>
                <script>
                    var bandera_productos = false;
                    var cargar_lista = true;
                    var salvo_cliente = false;
            
                    function guardarOrdenConfirmada(respuesta){
                        if(respuesta){
                            
                        }else{
                            $('#modal-confirmar-orden').modal('hide');
                            $('#modal-responsive').modal('show');
                        }
                    }
                    
                    function cerrarNoProductos(){
                        $('#modal-no_productos').modal('hide'); 
                        $('#modal-responsive').modal('show');
                    }
                    
                    function confirmarOrden(){
                        if(bandera_productos){
                            var id_mesa = $('#mesa').val();
                            var id_cliente = $('#id_cliente_info_orden').val();
                            $('#id_mesa').val(id_mesa);
                            $('#id_cliente').val(id_cliente);
                            var form = $('#form_orden');
                            $.ajax({
                                url: '<?php echo _APPLICACION_URL?>orden/confirmarOrden.html',
                                type: 'POST',
                                data: form.serialize(),
                                success: function(response) {
                                    $('#modal_confirmar').html(response);
                                    $('#modal-confirmar_orden_s_cliente').modal('hide');
                                    $('#modal-responsive').modal('hide');
                                    $('#modal-confirmar-orden').modal('show');
                                }
                            });
                            
                        }else{
                            $('#modal-confirmar_orden_s_cliente').modal('hide');
                            $('#modal-no_productos').modal('show'); 
                        }
                        
                    }
                    
                    function confirmarOrdenPaso(respuesta){
                        if(respuesta){
                            confirmarOrden();
                        }else{
                            $('#modal-confirmar_orden_s_cliente').modal('hide'); 
                            $('#modal-responsive').modal('show'); 
                        }
                    }
                    
                    function guardarOrden(){
                        var form = $('#informacion_orden');
                        var html = 'Guardando, espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader11.GIF">';
                        var boton = $('#guardarOrdenB');
                        var id_cliente_info_orden = $.trim($('#id_cliente_info_orden').val());
                        boton.html(html);
                        html = 'Enviar a cocina';
                        boton.attr('disabled', true);

                        if (!form.valid()){
                            boton.html(html);
                            boton.attr('disabled', false);
                            return false;  
                        }
                        
                        $('#modal-responsive').modal('hide'); 
                        
                        if(id_cliente_info_orden !== ''){
                            confirmarOrden();
                        }else{
                            $('#modal-confirmar_orden_s_cliente').modal('show'); 
                        }
                        boton.html(html);
                        boton.attr('disabled', false);
                        return false;  
                    }
                    
                    function orden(id){
                        var boton = $('id_crear_orden');
                        var html_boton = 'espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>vendors/pageloader/images/loader11.GIF">';
                        boton.html(html_boton);
                        $('#modal-responsive').modal('show'); 
                    }
                    
                    function closeOrden(){
                        $('#modal-responsive').modal('hide'); 
                        if(bandera_productos){
                            $('#modal-cerrar-orden-n').modal('show');
                        }
                        
                        document.getElementById("informacion_orden").reset();
                        var validator = $("#informacion_orden").validate();
                        $('.state-error').removeClass('state-error');
                        $('.state-success').removeClass('state-success');
                        validator.resetForm();
                    }
                    
                    function cerrarModalOrden(cerrar){
                        if(cerrar){
                            bandera_productos = false;
                            $('#listProdutsSelected').html('');
                            $('#mesa').val('');
                            $('#identificacion').val('');
                            $('#nombre_cliente').val('');
                            $('#modal-cerrar-orden-n').modal('hide');
                            $.ajax({
                                url: '<?php echo _APPLICACION_URL?>orden/borrarOrden.html',
                                type: 'POST',
                                data: 'orden_session_number=<?php echo $orden_session_number?>',
                                success: function() {
                                  
                                }
                            });
                        }else{
                            $('#modal-cerrar-orden-n').modal('hide');
                            $('#modal-responsive').modal('show'); 
                        }
                    }
                    
                    function addProduct(id){
                        $('#id_producto_new').val(id);
                        //document.form_orden.submit();
                        
                        var form = $('#form_orden');
                        $.ajax({
                            url: '<?php echo _APPLICACION_URL?>orden/agregarProducto.html',
                            type: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                $('#listProdutsSelected').html(response);
                                bandera_productos = true;
                            }
                        });
                        return false;
                    }
                    
                    function cambiarTotal(numero_unidades,id_producto){
                        var valor = $('#' + id_producto + '_valor_producto').val();
                        var valor_total = valor * numero_unidades;
                        $('#' + id_producto + '_valor_total_producto').val(valor_total);
                    }

                    function buscarCliente(){
                        var html = 'espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader11.GIF">';
                        var boton = $('#buscarClienteB');
                        boton.html(html);
                        html = 'Buscar Cliente!';
                        boton.attr('disabled', true);
                        
                        var identificacion = $('#identificacion').val();
                        $.ajax({
                            url: '<?php echo _APPLICACION_URL?>orden/buscarCliente.html',
                            type: 'POST',
                            data: 'identificacion=' + identificacion,
                            success: function(response) {
                                var fixedResponse = response.replace(/\\'/g, "'");
                                var jsonObj = JSON.parse(fixedResponse);
                                $('#nombre_cliente').val(jsonObj.nombre_cliente);
                                $('#id_cliente_info_orden').val(jsonObj.id_cliente);
                                boton.html(html);
                                boton.attr('disabled', false);
                            }
                        });
                    }
                    
                    function quitarCliente(){
                        $('#nombre_cliente').val('');
                        $('#id_cliente_info_orden').val('');
                        $('#identificacion').val('');
                    }
                    
                    function agregarCliente(){
                        document.getElementById("form_nuevo_cliente").reset();
                        var validator = $("#form_nuevo_cliente").validate();
                        $('.state-error').removeClass('state-error');
                        $('.state-success').removeClass('state-success');
                        validator.resetForm();
                        $('#modal-responsive').modal('hide'); 
                        $('#agregar_cliente').modal('show');
                    }
                    
                    function cerrarFormCliente(){
                        $('#agregar_cliente').modal('hide');
                        $('#modal-responsive').modal('show'); 
                    }
                    
                    $("#form_nuevo_cliente").submit(function () {
                        var form = $(this);
                        var html = 'Guardando, espere un momento...  <img src="<?php echo _TEMPLATE_SCRIPTS?>/vendors/pageloader/images/loader11.GIF">';
                        var boton = $('#guardarClienteB');
                        boton.html(html);
                        html = 'Guardar';
                        boton.attr('disabled', true);

                        if (!form.valid()){
                            boton.html(html);
                            boton.attr('disabled', false);
                            return false;  
                        }
                        
                        $.ajax({
                            url: '<?php echo _APPLICACION_URL?>orden/guardarCliente.html',
                            type: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                var fixedResponse = response.replace(/\\'/g, "'");
                                var jsonObj = JSON.parse(fixedResponse);
                                boton.html(html);
                                boton.attr('disabled', false);
                                if(jsonObj.error == 0){
                                    $('#id_producto_new').val(jsonObj.id_cliente);
                                    $('#nombre_cliente').val(jsonObj.nombre_cliente);
                                    $('#identificacion').val(jsonObj.identificacion);
                                    salvo_cliente = true;
                                }
                                
                                $('#modal_aler_cliente').attr("class",jsonObj.modal_alert);
                                $('#modal_tit_cliente').html(jsonObj.modal_tit);
                                $('#modal_content_cliente').html(jsonObj.modal_content);
                                $('#agregar_cliente').modal('hide');
                                $('#modal-salvar-cliente').modal('show'); 
                            }
                        });
                        
                        return false;
                    });
                    
                    function cerrar_modal_cliente(){
                        $('#modal-salvar-cliente').modal('hide');
                        $('.state-success').removeClass('state-success');
                        if(salvo_cliente == false){ 
                            $('#agregar_cliente').modal('show');
                        }else{
                            salvo_cliente = false;
                            $('#modal-responsive').modal('show');
                        }
                    }
                </script>
               
            </div>

            
            