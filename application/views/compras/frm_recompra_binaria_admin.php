<div id="table_datos">
    <div class="col-md-12">
    	<h3>Recompra de Producto (ADMINISTRACION)</h3>
        <table class="table table-responsive table-bordered" style="width: 50%;">
    	<?php


           if (isset($datos) && $datos != NULL) {
            echo form_open('compras/registra_recompra_admin');
                foreach ($datos as $key => $d) {
                    echo '<tr>
                            <td>Cedula:</td>
                            <td>'.$cedula.'</td>
                        </tr>';
                    echo '<tr>
                            <td>Nombre:</td>
                            <td>'.$d->apellidos.' '.$d->nombres.'</td>
                        </tr>';
                }

                echo '<tr>';
                echo '<td>Códigos:</td>';
                echo '<td><select class="form-control" name="idcodigo_socio_binario">';
                foreach ($codigos as $key => $c) {
                    echo '<option value="'.$c->idcodigo_socio_binario.'">'.$c->codigo_socio_binario.'  -Fecha de inscripción: '.$c->fecha_inscripcion.'</option>';
                }
                echo '</select></td></tr>';

                echo '<tr>
                        <td>Fecha recompra:</td>
                        <td><input type="text"  name="fecha" value="0"  id="fecha"></td>
                    </tr>';

                echo '<tr>';
                echo '<td>Paquetes:</td>';
                echo '<td><select class="form-control" name="idpaquete">';
                foreach ($paquetes as $key => $p) {
                    echo '<option value="'.$p->idpaquete.'">'.$p->paquete.'</option>';
                }
                echo '</select></td></tr>';

                echo '<tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-primary" name="Hacer recompra" value="Hacer recompra"></td>
                    </tr>';
                echo form_close();

           }else{
                echo form_open('compras/get_datos_socio');
                echo '
                    <tr>
                        <td>Cedula:</td>
                        <td><input type="text" name="cedula" placeholder="cédula"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-primary" name="Consultar" value="Consultar"></td>
                    </tr>
                ';
                echo form_close();
                if (isset($exito)) {
                    if ($exito == 0) {
                        echo '<span style="color:#CA2222;">Hubo un problema y no se pudo procesar la información, intente nuevamente o contacte al Administrador</span>';
                    }
                }
           }
        ?>

        </table>
    </div>
</div>
