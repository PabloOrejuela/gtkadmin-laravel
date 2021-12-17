<div id="table_datos">
    <div class="col-md-12">
        <form action="ver_lista_compras" method="post" accept-charset="utf-8">
        <div class="col-md-12" id="grid_form">
            <h3>Compras por confirmar</h3>
            <div class="col-md-1">
                <label for="fecha_evento">Provincia:</label>
            </div>
            <?php
                $dropdown_provincia = array(
                    '0'  => 'Elegir...',
                );
                foreach ($provincias as $key => $value) {
                    $dropdown_provincia[$value->idprovincia] = $value->provincia;
                }
                $js = 'id="id_provincia"';
                echo '<div class="col-md-3">'.form_dropdown('id_provincia', $dropdown_provincia, set_value('id_provincia'), $js).'</div>';

                /*Paso el base_url() a una variable PHP
                 * y luego a una variable Javascript para
                 * poder usar el combo AJAX
                 */
                $url = base_url();
                echo '<script languaje="JavaScript">
                        var varjs="'.$url.'";
                        </script>';
            ?>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="lugar_evento">Ciudad:</label>
            </div>
            <div class="col-md-3">
                <select id="id_ciudad" name="ciudad" class="form-control" value="<?php echo set_value('ciudad'); ?>"></select>
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="descripcion_evento">Cédula:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="cedula" value="<?php echo set_value('cedula'); ?>">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        </form>
        <table class="table table-bordered table-striped table-condensed" id="table_resumen">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CEDULA</th>
                    <th>PROVINCIA</th>
                    <th>CIUDAD</th>
                    <th>PAQUETE</th>
                    <th>FECHA</th>
                    <th>MATRIZ</th>
                    <th>CONFIRMAR</th>
                    <th>CANCELAR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($rows) && $rows != NULL && $rows != 0) {
                        foreach ($rows as $value) {
                            echo '<tr>';
                            echo '<td>'.$value['codigo_socio'].'</td>';
                            echo '<td>'.$value['nombres'].' '.$value['apellidos'].'</td>';
                            echo '<td>'.$value['cedula'].'</td>';
                            echo '<td>'.$value['provincia'].'</td>';
                            echo '<td>'.$value['ciudad'].'</td>';
                            echo '<td style="text-align:right;">$'.number_format(($value['paquete']), 2).'</td>';
                            echo '<td>'.$value['fecha'].'</td>';
                            echo '<td>UNINIVEL</td>';
                            echo '<td>'.anchor('compras/confirma_compra/'.$value['idcompras'], '<i class="fa fa-check-circle-o" aria-hidden="true"> CONFIRMAR</i>', 'attributes').'</td>';
                            echo '<td>'.anchor('compras/elimina_compra/'.$value['idcompras'], '<span style="color:red;"><i class="fa fa-ban" aria-hidden="true"> CANCELAR</i>', 'attributes').'</span></td>';
                            echo '</tr>';
                        }
                    }
					if(isset($rows_binaria) && $rows_binaria != null && $rows_binaria != 0){
                        foreach ($rows_binaria as $value) {
                            echo '<tr>';
                            echo '<td>'.$value['codigo_socio_binario'].'</td>';
                            echo '<td>'.$value['nombres'].' '.$value['apellidos'].'</td>';
                            echo '<td>'.$value['cedula'].'</td>';
                            echo '<td>'.$value['provincia'].'</td>';
                            echo '<td>'.$value['ciudad'].'</td>';
                            echo '<td style="text-align:right;">$'.number_format(($value['paquete']), 2).'</td>';
                            echo '<td>'.$value['fecha'].'</td>';
                            echo '<td>BINARIA</td>';
                            echo '<td>'.anchor('compras/confirma_compra_binaria/'.$value['idcompras_binario'], '<i class="fa fa-check-circle-o" aria-hidden="true"> CONFIRMAR</i>', 'attributes').'</td>';
                            echo '<td>'.anchor('compras/elimina_compra_binaria/'.$value['idcompras_binario'], '<span style="color:red;"><i class="fa fa-ban" aria-hidden="true"> CANCELAR</i>', 'attributes').'</span></td>';
                            echo '</tr>';
                        }
                    }if(isset($rows_consumidor) && $rows_consumidor != null && $rows_consumidor != 0){
                        foreach ($rows_consumidor as $value) {
                            echo '<tr>';
                            echo '<td>N/A</td>';
                            echo '<td>'.$value['nombres'].' '.$value['apellidos'].'</td>';
                            echo '<td>'.$value['cedula'].'</td>';
                            echo '<td>'.$value['provincia'].'</td>';
                            echo '<td>'.$value['ciudad'].'</td>';
                            echo '<td style="text-align:right;">$'.number_format(($value['paquete']), 2).'</td>';
                            echo '<td>'.$value['fecha'].'</td>';
                            echo '<td>CONSUMIDOR</td>';
                            echo '<td>'.anchor('compras/confirma_compra_externa/'.$value['idcompras_consumo'], '<i class="fa fa-check-circle-o" aria-hidden="true"> CONFIRMAR</i>', 'attributes').'</td>';
                            echo '<td>'.anchor('compras/elimina_compra_externa/'.$value['idcompras_consumo'], '<span style="color:red;"><i class="fa fa-ban" aria-hidden="true"> CANCELAR</i>', 'attributes').'</span></td>';
                            echo '</tr>';
                        }
                    }

					if (!isset($result) || $result == NULL) {
						//No muestro nada
					}elseif (isset($result) && $result == 0) {
						echo '<tr><td>RESULTADO: </td><td colspan="5"><span id="resultado">Ha habido un error en la confirmación</span></td></tr>';
					}elseif (isset($result) && $result == 1) {
						echo '<tr><td>RESULTADO: </td><td colspan="5"><span id="resultado">La confirmación de la compra ha sido existosa</span></td></tr>';
					}
					?>
            </tbody>
        </table>
	</div>
</div>
