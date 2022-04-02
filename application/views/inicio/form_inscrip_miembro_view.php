<style type="text/css">
	input[type="text"]{
		width: 90% !important;
	}
	input[type="email"]{
		width: 90% !important;
	}
	select{
		width: 90% !important;
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
		<h3><?php echo $mensaje; ?></h3>
		<div style="width: 100%;">
			<?php echo form_open('inicio/recibe_datos_frm_registro');  ?>
			<table class="table-condensed">
				<tr><td colspan="2"><h5>Información del nuevo distribuidor</h5></td></tr>
				<tr>
					<td>
					<div>
						<label for="cedula" class="form-label">CI:</label>
						<input type="text" class="form-control" id="form-control" placeholder="Cédula" name="cedula" required/>
						<?php echo form_error('cedula'); ?>
					</div>
					</td>
					<td>
					<div>
						<label for="cedula_patrocinador" class="form-label">Patrocinador <span style="color: red;">(opcional)</span>:</label>
						<input type="text" class="form-control" id="form-control" placeholder="Cédula patrocinador" name="cedula_patrocinador" required/>
						<?php echo form_error('cedula'); ?>
					</div>
					</td>
				</tr>
				<tr>
					<td>
					<div class="mb-3">
						<label for="nombres" class="form-label">Nombres:</label>
						<input type="text" class="form-control" name="nombres" id="form-control" placeholder="Nombres" required/>
						<?php echo form_error('nombres'); ?>
					</div>
					</td>
					<td>
					<div class="mb-3">
						<label for="apellidos" class="form-label">Apellidos:</label>
						<input type="text" class="form-control" name="apellidos" id="form-control" placeholder="Apellidos" required />
						<?php echo form_error('apellidos'); ?>
					</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<div class="mb-3">
						<label for="direccion" class="form-label">Dirección:</label>
						<input type="text" class="form-control" name="direccion" id="form-control" placeholder="Dirección" />
						<?php echo form_error('direccion'); ?>
					</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="mb-3">
							<label for="provincia" class="form-label">Provincia:</label>
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
						</div>
					</td>
					<td>
					<div class="mb-3">
						<label for="ciudad" class="form-label">Ciudad:</label>
						<select id="id_ciudad" name="ciudad" class="form-control" value="<?php set_value('ciudad'); ?>" required="required"></select>
					</div>
					</td>
				</tr>
				<tr>
					<td>
					<div class="mb-3">
						<label for="celular" class="form-label">Celular:</label>
						<input type="text" class="form-control" name="celular" id="form-control" placeholder="Celular"/>
						<?php echo form_error('celular') ?>
					</div>
					</td>
					<td>
					<div class="mb-3">
						<label for="email" class="form-label">Email:</label>
						<input type="email" class="form-control" name="email" id="form-control" placeholder="Email" />
						<?php echo form_error('email') ?>
					</div>
					</td>
				</tr>
				<tr>
					<td><h5>Información de la Cuenta</h5></td>
				</tr>
				<tr>
					<td>
					<div class="mb-3">
						<label for="banco">Banco:</label>
							<?php
								$arr_banco = array('' => 'Elija...' );
								foreach ($bancos as $key => $value) {
									$arr_banco[$value->idbanco] = $value->banco;
								}

								echo form_dropdown('banco', $arr_banco, '','id="id_banco" class="form-control info_patrocinador"');
							?>
					</div>
					</td>
					<td>
					<div class="mb-3">
						<label for="tipo_cuenta">Tipo de cta:</label>
						<select name="tipo_cuenta" class="form-control info_patrocinador" id="tipo_cuenta">
							<option value="1" selected="">AHORROS</option>
							<option value="2">CORRIENTE</option>
						</select>
					</div>
					</td>
				</tr>
				<tr>
					<td>
					<div class="mb-3" colspan="2">
						<label for="celular">Cuenta bancaria:</label>
						<input type="text" class="form-control info_patrocinador" name="num_cta" placeholder="cuenta" id="cuenta_socio" value="<?php set_value('num_cta');?>">
					</div>
					</td>
				</tr>
				<tr>
					<td><button type="submit" class="btn btn-primary">Enviar</button></td>
				</tr>
			</table>
			<?php echo form_close();?>
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
</script>
