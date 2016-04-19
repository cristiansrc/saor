<div class="row">
    <div class="col-md-12">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Productos</a></li>
            <li><a href="#profile" data-toggle="tab">Productos solicitados</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="panel panel-yellow">
                    <div class="panel-heading">Lista de productos</div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Descripcion</th>
                                <th>Agregar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            foreach ($productos as $producto) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $producto->get('nombre_producto')?><br>
                                    <img src="<?php echo _APPLICACION_URL?>orden/redImage/70x/<?php echo $producto->get('imagen_producto')?>"/>
                                </td>
                                <td><?php echo $producto->get('descripcion_producto')?></td>
                                <td><span class="label label-sm label-success">Agregar</span></td>
                            </tr>
                            <?php 
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="profile" class="tab-pane fade"><p>Food truck fixie locavore, accusamus
                mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore
                velit, blog sartorial PBR leggings next level wes anderson artisan four loko
                farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft
                beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud
                organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS
                salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio
                cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa
                terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero
                sint qui sapiente accusamus tattooed echo park.</p>
            </div>

        </div>
    </div>
</div>