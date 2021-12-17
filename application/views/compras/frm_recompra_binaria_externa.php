<style>
    #input_datos{
        text-transform: uppercase;
    }
</style>
<div class="row-fluid" id="contenido">
    <div class="container-fluid" id="contenido">
    	<h3>Compra de Producto</h3>
        <h5>Usuarios no registrados</h5>
        <table class="table table-bordered" style="width: 60%;border: 0px solid;">
    	<?php

            echo form_open('compras/registra_recompra_externa');
            echo '
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="nombres" placeholder="nombres" id="input_datos" required></td>
                </tr>
                <tr>
                    <td>Apellidos:</td>
                    <td><input type="text" name="apellidos" placeholder="apellidos" id="input_datos" required></td>
                </tr>
                <tr>
                    <td>Cedula:</td>
                    <td><input type="text" name="cedula" placeholder="cédula" id="input_datos" required></td>
                </tr>
                <tr>
                    <td>Celular:</td>
                    <td><input type="text" name="celular" placeholder="celular" id="input_datos" required></td>
                </tr>
                <tr>
                    <td>Paquete: </td>
                    <td>';
                        $arr_paquetes = array("0" => "Elija...");
                        foreach ($paquetes as $key => $value) {
                            $arr_paquetes[$value->idpaquete] = 'Paquete de '.$value->paquete;
                        }

                        echo form_dropdown('idpaquete', $arr_paquetes, '','id="idpaquete" class="form-control info_patrocinador" onChange="pagoOnChange(this)"');

            echo    '</td>
                </tr>
            </table>
            <div><input type="submit" class="btn btn-primary" name="comprar" value="Comprar"></div>';
            
            echo form_close();
            if (isset($exito)) {
                if ($exito == 0) {
                    echo '<div>
							<span style="color:#CA2222;font-size: 1.5em;margin-top: 20px;">
								Hubo un problema y no se pudo procesar la información, intente nuevamente o contacte al Administrador
							</span>
						</div>';
                }else{
                    echo '<div>
							<span style="color:#CA2222;font-size: 1.5em;margin-top: 20px;">La compra se ha registrado con éxito</span>
						</div>';
                }
            }
        
        ?>
        <br />
        <div><a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Volver al inicio</a></div>
    </div>
</div>
