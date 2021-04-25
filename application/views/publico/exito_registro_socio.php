<div style="text-align: center;margin: 0 auto;">
	<h1>Registro de Socios</h1>
	<?php if($filas>0){ ?>
		<div class="row" style="margin-top: 30px; ">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
				<h1><i class="fa fa-check" aria-hidden="true"></i>Sus datos han sido registrados exitosamente</h1>
				<?php if ($formulario_id=='1'){ ?>
								<a style="margin-right: 10px;" href="<?php echo base_url();?>inicio/miembros" /><i class="fa fa-home" aria-hidden="true"></i>Ir al Inicio</a>
								<a href="<?php echo base_url(); ?>inicio/formulario_inscripcion_miembro"><i class="fa fa-list-alt" aria-hidden="true"></i>Regresar al Formulario</a>
								<?php }else{ ?>
								<a style="margin-right: 10px;" href="<?php echo base_url();?>inicio/index" /><i class="fa fa-home" aria-hidden="true"></i>Ir al Inicio</a>
								<a href="<?php echo base_url(); ?>inicio/formulario_inscripcion"><i class="fa fa-list-alt" aria-hidden="true"></i>Regresar al Formulario</a>
								<?php } ?>
			</div>

		</div>
	<?php }else if($socio!=null){  ?>
	<div class="row" style="margin-top: 30px; ">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
				<h1><i class="fa fa-arrow-circle-right" aria-hidden="true" style="font-size: 35px;margin-right: 10px;"></i>El Socio ya se encuentra en la base de datos, por lo que se le creo un nuevo codigo</h1>
				<table class="table table-responsive">
					<tbody>
						<tr>
							<td>Cédula:</td>
							<td><?php echo $socio['cedula']; ?></td>
						</tr>
						<tr>
							<td>Nombres:</td>
							<td><?php echo $socio['nombres']; ?></td>
						</tr>
						<tr>
							<td>Apellido:</td>
							<td><?php echo $socio['apellidos']; ?></td>
						</tr>
						<tr>
							<td>Fecha de registro:</td>
							<td><?php echo date('Y-m-d'); ?></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: center;">
								<?php  if ($formulario_id=='1'){ ?>
								<a style="margin-right: 10px;" href="<?php echo base_url();?>inicio/miembros" /><i class="fa fa-home" aria-hidden="true"></i>Ir al Inicio</a>
								<a href="<?php echo base_url(); ?>inicio/formulario_inscripcion_miembro"><i class="fa fa-list-alt" aria-hidden="true"></i>Regresar al Formulario</a>
								<?php }else{ ?>
								<a style="margin-right: 10px;" href="<?php echo base_url();?>inicio/miembros" /><i class="fa fa-home" aria-hidden="true"></i>Ir al Inicio</a>
								<a href="<?php echo base_url(); ?>inicio/formulario_inscripcion"><i class="fa fa-list-alt" aria-hidden="true"></i>Regresar al Formulario</a>
								<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	<?php }else{ ?>
		<div class="row" style="margin-top: 30px; ">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
				<h1><i class="fa fa-times" aria-hidden="true"></i>La Operación No se completó</h1>
				<a href="<?php base_url();?>inicio"><i class="fa fa-home" aria-hidden="true"></i>Ir al Inicio</a>
			</div>
		</div>
	<?php } ?>
</div>