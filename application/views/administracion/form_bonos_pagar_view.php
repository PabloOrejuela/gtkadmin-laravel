<div class="row-fluid">
    <div class="col-md-12" >
        <form action="compras/ver_lista_compras" method="post" accept-charset="utf-8" id="form_cabecera">
        <div class="col-md-12" id="grid_form">
            <h3>Bonos por pagar</h3>
            <h1>Subiendo archivos... contacte al administrador</h1>
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
                $js = 'id="id_provincia"; class="form-control"';
                echo '<div class="col-md-3">'.form_dropdown('id_provincia', $dropdown_provincia, '0', $js).'</div>';

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
                <select id="id_ciudad" name="ciudad" class="form-control"></select>
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="cedula">Cédula:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="cedula">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <button type="submit" class="btn btn-default">Enviar</button>
            </div>
        </div>
        </form>

        <table class="table table-bordered" id="table_resumen">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>CEDULA</th>
                    <th>PAQUETE</th>
                    <th>MATRIZ</th>
                    <th>BONO</th>
                    <th>CANCELAR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
	</div><!-- /.col-nd-12 --> 	
</div>