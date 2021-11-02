<div class="row-fluid">
    <div class="col-md-12">
        <form action="lista_socios_matriz" method="post" accept-charset="utf-8">
        <div class="col-md-12" id="grid_form">
            <h3>Ver lista de socios</h3>
            <div class="col-md-1">
                <label for="fecha_evento">Tipo Matriz:</label>
            </div>
            <div class="col-md-3">
                <?php 
                    foreach ($matrices as $m) {
                        echo '<input type="radio" name="matriz" value="'.$m->idmatrices.'" checked> '.$m->matriz.'   ';
                    }
                ?>
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="lugar_evento">Provincia:</label>
            </div>
            <div class="col-md-3">
                <?php 
                    $dropdown_provincia = array(
                        'opcion1'  => 'Elegir...',
                    );
                    foreach ($provincias as $key => $value) {
                        $dropdown_provincia[$value->idprovincia] = $value->provincia;
                    }
                    $js = 'id="id_provincia"';
                    echo form_dropdown('id_provincia', $dropdown_provincia, 'opcion1', $js);

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
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="descripcion_evento">Ciudad:</label>
            </div>
            <div class="col-md-3">
                <select id="id_ciudad" name="id_ciudad" class="form-control" disabled="disabled"></select>
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <button type="submit" class="btn btn-default">Enviar</button>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        </form>
	</div><!-- /.col-nd-12 --> 	
</div>