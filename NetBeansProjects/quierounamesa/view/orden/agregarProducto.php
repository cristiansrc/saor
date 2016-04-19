<div id="no-more-tables">
        <table class="table table-bordered table-striped table-condensed cf">
            <thead class="cf">
            <tr>
                <th>Producto</th>
                <th>Observaciones</th>
                <th>Cantidad</th>
                <th>Valor con iva</th>
                <th>Valor total con iva</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($orden as $id_producto => $info_producto) {
            ?>
            <tr>
                <td data-title="Producto">
                    <?php echo $info_producto['nombre_producto']?><br>
                    <a data-title="<?php echo $info_producto['nombre_producto']?>" data-lightbox="pefil" href="<?php echo _IMAGE_URL?>600x/<?php echo $info_producto['imagen']?>">
                        <img src="<?php echo _IMAGE_URL?>200x/<?php echo $info_producto['imagen']?>"/>
                    </a>
                </td>
                <td data-title="Observaciones">
                    <textarea name="<?php echo $id_producto?>_observaciones" class="form-control" placeholder="Informacion Adicional" rows="8"><?php echo $info_producto['observaciones']?></textarea>
                </td>
                <td data-title="Cantidad">
                    <select name="<?php echo $id_producto?>_cantidad" onchange="
                            var valor = $('#<?php echo $id_producto?>_valor_producto').html();
                            var valor_total = ($.trim(valor))  * this.value;
                            $('#<?php echo $id_producto?>_valor_total_producto').html(valor_total);
                            " class="form-control">
                        <?php 
                        for ($index = 1; $index < 11; $index++) {  
                            $selected = (trim($info_producto['cantidad']) === trim($index)) ? 'selected="selected"' : '';
                        ?>
                        <option <?php echo $selected?> value="<?php echo $index?>"><?php echo $index?></option>
                        <?php 
                        }
                        ?>
                    </select>
                </td>
                <td id="<?php echo $id_producto?>_valor_producto" data-title="Valor con iva">
                    <?php echo ($info_producto['varlor_s_iva_producto'] * 1.16)?>
                </td>
                <td id="<?php echo $id_producto?>_valor_total_producto" data-title="Valor total con iva">
                    <?php echo (($info_producto['varlor_s_iva_producto'] * $info_producto['cantidad']) * 1.16)?>
                </td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        </table>

    </div>

