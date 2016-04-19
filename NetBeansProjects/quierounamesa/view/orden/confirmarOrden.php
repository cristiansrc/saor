<div class="panel panel-yellow">
    <div class="panel-heading">
        Orden
    </div>
    <div class="panel-body">
            

    <div class="pull-left"><h2 class="text-green logo"><?php echo $nombre_restaurante?></h2>
        <!--address class="mbn">78183 Sweards Bluff Ave<br/>New York, CA 94107<br/><abbr
                title="Phone">P:</abbr>(123) 456-7890<br/><br/>info@email.com
        </address-->
    </div>
    <div class="clearfix"></div>
    <hr/>
    <div class="row">
        <div class="col-md-3">
            <address><strong>Ordenado por:</strong><br/><?php echo $cliente_nombre?><!--br/>Incorporesano Ltd.<br/>(123)
                456-7890-->
            </address>
        </div>
        <div class="col-md-3">
            <address><strong>Mesero:</strong><br/><?php echo $mesero?><!--br/>78183 Sweards Bluff
                Ave<br/>(123) 456-7890-->
            </address>
        </div>
        <div class="col-md-3">
            <address><strong>Fecha:</strong><br/><?php echo date('d/m/Y')?></address>
        </div>
        <div class="col-md-3">
            <address><strong>Valor de la orden:</strong><br/>

                <h3 class="text-green mtn"><strong>$<?php echo number_format($valor_total_con_iva)?></strong></h3></address>
        </div>
    </div>
    <hr/>
    <h4 class="block-heading">Resumen del pedido</h4>

    <div class="table-responsive">
        <table class="table table-condensed">
            <thead>
            <tr>
                <td><strong>Producto</strong></td>
                <td class="text-center"><strong>Precio</strong></td>
                <td class="text-center"><strong>Cantidad</strong></td>
                <td class="text-right"><strong>Total</strong></td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($productos as $id_producto => $info_producto) {
            ?>
            <tr>
                <td><?php echo $info_producto['nombre_producto']?></td>
                <td class="text-center">$<?php echo number_format($info_producto['varlor_s_iva_producto'])?></td>
                <td class="text-center"><?php echo $info_producto['cantidad']?></td>
                <td class="text-right">$<?php echo number_format(($info_producto['varlor_s_iva_producto'] * $info_producto['cantidad']))?></td>
            </tr>
            <?php 
            }
            ?>
            <tr>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line text-center"><strong>Total</strong></td>
                <td class="no-line text-right">$<?php echo number_format($valor_total)?></td>
            </tr>
            <tr>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line text-center"><strong>Iva</strong></td>
                <td class="no-line text-right">$<?php echo number_format($iva)?></td>
            </tr>
            <tr>
                <td class="no-line"></td>
                <td class="no-line"></td>
                <td class="no-line text-center"><strong>Total con iva</strong></td>
                <td class="no-line text-right">$<?php echo number_format($valor_total_con_iva)?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--hr class="mbm"/>
    <p>Thank you for your business. Please remit the total amount due within 30 days.</p-->
    </div>
</div>