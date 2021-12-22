<div id="table_datos">
	<div class="col-md-12">
    	<h3>Compra de Producto - Uninivel</h3>
        <table class="table table-responsive" style="width: 40%;">
    	<?php
    	   echo form_open('compras/graba_compras');
    		if (isset($socio) && $socio != NULL && $socio != 0) {?>
                <tr>
                    <td>Nombre Socio:</td>
                    <td><?php echo $socio['nombres'].' '.$socio['apellidos'] ?></td>
                </tr>
                <tr>
                    <td>Códigos Vigentes:</td>
                    <td><input type="text" name="codigo_socio" value="<?php echo $codigo_socio; ?>" disabled="true"></td>
                    <input type="hidden" name="idsocio" value=" <?php echo $idsocio ?>">
                </tr>
                <tr>
                    <td>Paquetes: </td>
                    <td>
                        <select id="idpaquete" name="idpaquete" class="form-control">
                            <?php
                                foreach ($paquetes as $key => $value) {
                                    echo '<option value="'.$value->idpaquete.'">'.number_format($value->paquete, 2).'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Cédula:</td>
                    <td>
                        <?php echo $socio['cedula']; ?>
                        <input type="hidden" name="cedula" value=" <?php echo $socio['cedula']; ?>" id="cedula">
                    </td>
                </tr>
                <tr>
                    <td >
                        <button type="submit" class="btn btn-primary">Comprar</button>
                        <?php echo form_close(); ?>
                    </td>
                    <td colspan="2">
                        <?php
                            echo form_open('reportes/red_mis_codigos');
                            echo '<button type="submit" class="btn btn-primary">Regresar a Mis códigos</button>';
                            echo form_close();
                        ?>
                    </td>
                </tr>
        </table>
    </div>
</div>
        <?php }
            echo form_close();
            $url = base_url();
            echo '<script languaje="JavaScript">
                    var varjs="'.$url.'";
                    </script>';
        ?>
