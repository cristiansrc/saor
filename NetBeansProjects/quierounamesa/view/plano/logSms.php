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
                                <!--div class="panel panel-yellow">
                                    <form class="form-validate" method="post" action="<?php _APPLICACION_URL?>/sms/plano/smSubidos.html" novalidate="novalidate">
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
                                    
                                </div-->
                                
                                <div class="row mbm">
                                    
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="table_id"
                                                   class="table table-hover table-striped table-bordered table-advanced tablesorter display">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Fecha inicial</th>
                                                    <th>Hora inicial</th>
                                                    <th>Fecha fin</th>
                                                    <th>Hora fin</th>
                                                    <th>Total Archivos</th>
                                                    <th>Archivos exitosos</th>
                                                    <th>Archivos erroneos</th>
                                                    <th>Total Lineas</th>
                                                    <th>Lineas exitosas</th>
                                                    <th>Lineas erroneas</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                foreach ($arr_log as $log) {
                                                ?>    
                                                <tr>
                                                    <td><?php echo $log['ID_LOG']?></td>
                                                    <td><?php echo $log['FECHA_INICIAL']?></td>
                                                    <td><?php echo $log['HORA_INICIAL']?></td>
                                                    <td><?php echo ( (isset($log['FECHA_FIN'])) ? $log['FECHA_FIN'] : '' )?></td>
                                                    <td><?php echo ( (isset($log['HORA_FIN'])) ? $log['HORA_FIN'] : '' ) ?></td>
                                                    <td><?php echo $log['TOTAL_ARCHIVOS']?></td>
                                                    <td><?php echo $log['ARCHIVOS_EXITOSOS']?></td>
                                                    <td><?php echo $log['ARCHIVOS_ERRONEOS']?></td>
                                                    <td><?php echo $log['TOTAL_LINEAS']?></td>
                                                    <td><?php echo $log['LINEAS_EXITOSAS']?></td>
                                                    <td><?php echo $log['LINEAS_ERRONEAS']?></td>
                                                </tr>
                                                <?php 
                                                }
                                                ?>
                                                </tbody>
                                                </thead></table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
            