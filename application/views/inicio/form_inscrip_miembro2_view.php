<style type="text/css">
	input[type="text"]{
		width: 80% !important;
	}
	select{
		width: 80% !important;
	}
	table td{
		width: 50%;
		padding-right: 10px;
	}
	.info_personal_row input,select{
		width: 80% !important;
	}
</style>

<div class="container-fluid">
	<div class="row" id="container" style="margin-left: 7px;margin-bottom: 100px;">
		<h2>Formulario de Inscripción</h2>
		<div>
		<?php echo form_open('inicio/recibe_datos_frm_registro');  ?>
			<table class="table-condensed table-responisve" width="80%">
			<thead>
				<tr>
					<th style="width: 50%"></th>
				</tr>
			</thead>
				<tbody>
				<tr>
				<td colspan="2"><h4>Información del nuevo distribuidor</h4></td>
				</tr>
					<tr id="main_info_tr">
		        		<td>
		        			<label for="cedula" style="color: red;">CI:</label>
		        			<br>
		        			<input type="text" name="cedula" maxlength="10" placeholder="CI" class="form-control" id="txt_cedula_socio" onkeypress="return valida(event)" required>
		        		</td>
		        		<td class="info_personal_row">
		        			<!-- <label for="fecha_nacimiento_socio" style="color: red;">Fecha de nacimiento:</label> -->
		        			
		        		</td>
		        	</tr>
					<tr id="main_info_tr">
		        		<td class="info_personal_row" colspan="4">
				            <?php echo form_error('cedula') ?>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="nombres" style="color: red;">Nombres:</label>
		        			<br>
		        			<input type="text" name="nombres" class="form-control" value="<?php set_value('nombres'); ?>" placeholder="nombres" id="nombres_socio" required>
		        		</td>
		        		<td>
		        			<label for="apellidos" style="color: red;">Apellidos:</label>
		        			<br>
		        			<input type="text" name="apellidos" class="form-control" value="<?php set_value('apellidos'); ?>" placeholder="apellidos" id="apellidos_socio" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td colspan="2">
		        			<label for="direccion">Dirección:</label>
		        			<br>
		        			<input type="text" name="direccion" class="form-control" placeholder="direccion" id="direccion_socio" value="<?php set_value('direccion'); ?>">
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
                        <td>
                            <label for="provincia" style="color: red;">Provincia:</label>
                                <br>
                                <?php
									$dropdown_provincia = array(
										'opcion1'  => 'Elegir...',
									);
									foreach ($provincias as $key => $value) {
										$dropdown_provincia[$value->idprovincia] = $value->provincia;
									}
									$js = 'id="id_provincia"; class="form-control"';
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
                        </td>
		        	<td>
	        			<label for="ciudad" style="color: red;">Ciudad:</label>
	        			<br>
	        			<select id="id_ciudad" name="ciudad" class="form-control" value="<?php set_value('ciudad'); ?>" required="required"></select>
	        		</td>
	        		</tr>
		        	<tr class="info_personal_row">
		        		<td>
							<label for="celular" style="color: red;">Celular:</label>
		        			<br>
		        			<input type="text" name="celular" class="form-control"  value="<?php set_value('celular');?>" placeholder="celular" id="celular_socio" >
		        		</td>
		        		<td>
							<label for="email">Email:</label>
		        			<br>
		        			<input type="email" class="form-control" name="email" id="email_socio" value="<?php set_value('email');?>" placeholder="jose@email.com">
		        		</td>
		        	</tr>
					<tr><td><h4></h4></td><td><hr></td></tr>
		        	<tr><td><h4>Información de la Cuenta</h4></td><td><hr></td></tr>
		        	<tr class="info_personal_row">

		        		<td>
		        			<label for="banco">Banco:</label>
		        			<br>
		        			<?php
		        				$arr_banco = array('' => 'Elija...' );
		        				foreach ($bancos as $key => $value) {
		        					$arr_banco[$value->idbanco] = $value->banco;
		        				}

		        				echo form_dropdown('banco', $arr_banco, '','id="id_banco" class="form-control info_patrocinador"');
		        			 ?>

		        		</td>
		        		<td>
		        			<label for="tipo_cuenta">Tipo de cta:</label>
		        			<br>
		        			<select name="tipo_cuenta" class="form-control info_patrocinador" id="tipo_cuenta">
				        		<option value="1" selected="">AHORROS</option>
				        		<option value="2">CORRIENTE</option>
				        	</select>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row" >
		        		<td>
		        			<label for="celular">Cuenta bancaria:</label>
		        			<br>
		        			<input type="text" class="form-control info_patrocinador" name="num_cta" placeholder="cuenta" id="cuenta_socio" value="<?php set_value('num_cta');?>">
		        		</td>
		        		<td></td>
		        	</tr>
					<tr><td><h4></h4></td><td><hr></td></tr>
		        	<tr><td><h4>Ubicacion en la red</h4></td><td><hr></td></tr>
		        	<tr>
		        		<td>
		        			<label for="idmatrices" style="color: red;">Tipo de Matriz:</label>
		        			<br>
				        	<?php

                                $dropdown_matriz = array(
                                    'opcion1'  => 'Elegir...'
                                );
                                foreach ($matrices as $key => $value) {
                                	$dropdown_matriz[$value->idmatrices] = $value->matriz;
                                }
                                $js = 'id="idmatrices"; class="form-control info_patrocinador;"';
                                echo form_dropdown('idmatrices', $dropdown_matriz, 'opcion1', $js);

                                /*Paso el base_url() a una variable PHP
                                 * y luego a una variable Javascript para
                                 * poder usar el combo AJAX
                                 */
                                $url = base_url();
                                echo '<script languaje="JavaScript">
                                        var varjs="'.$url.'";
                                        </script>';
                            ?>
		        		</td>
		        		<td>
		        		<label for="paquetes">Paquete:</label>
		        		<select id="paquetes" name="paquetes" class="form-control info_patrocinador" required="required"></select>
		        		</td>
		        	</tr>
		        	<tr id="tr_1" style="display:none;">
		        		<td></td>
						<td>
						<label style="color: red;text-align:right; font-weight: bold;">Ubicación en la red binaria</label>
							<input type="text" name="ubicacion" maxlength="5" placeholder="posicion" value="0" class="form-control" id="txt_ubicacion" onkeypress="return valida(event)">
						</td>
		        	</tr>
		        	<tr>
		        		<td>
		        			<button type="button" class="btn btn-default"  onClick="document.location.reload();">Refrescar</button>
		        			<button type="submit" class="btn btn-primary" id="btn_enviar">Enviar</button>
		        		</td>
		        		<td>
		        		</td>
		        	</tr>
		        	</tbody>
	        </table>
			<input type="hidden" name="patrocinador" value="<?php echo $idcodigo_binario; ?>">
			<input type="hidden" name="patrocinador_uninivel" value="<?php echo $idcodigo_uninivel; ?>">
	        <input type="hidden" name="formulario_id" value="1">
	        <?php echo form_close();?>
			<div id="tr_2" style="display:none;">
				<?php
				//Permite ver la ubicación
				//PABLO: hacer que esta función lleve a un gráfico que no muestre la info y nos permita ubicar al nuevo socio
				//PABLO hacer que este botón solo se active cuando se selecciona la red binaria
					echo form_open('reportes/mi_red_binaria');
					echo form_hidden('idmatrices', 2);
					echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$idcodigo_binario.'">';
					echo '<button type="submit" class="btn btn-primary" formtarget="_blank">VER MIS DIRECTOS</button></td></tr>';
					echo form_close();
				?>
			</div>
	    </div>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
	
//Valida campo solo numeros
function valida(e){
	tecla = (document.all) ? e.keyCode : e.which;

	//Tecla de retroceso para borrar, siempre la permite
	if (tecla==8){
	    return true;
	}

	// Patron de entrada, en este caso solo acepta numeros
	patron =/[0-9]/;
	tecla_final = String.fromCharCode(tecla);
	return patron.test(tecla_final);
}

$(function(){
    $('#idmatrices').on('change', function(){
        var disabled = $(this).val() == 2 ? true : false;
        //console.log("Disabled: " + disabled);

        if (disabled == true) {
        	$('#tr_1').css("display", "");
        	$('#tr_2').css("display", "");
        }else{
    		$('#tr_1').css("display", "none");
    		$('#tr_2').css("display", "none");
    	}
    });
});
</script>
