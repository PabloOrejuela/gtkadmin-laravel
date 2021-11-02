<style type="text/css">
	.medio {
		margin: 0 auto !important;
	}
</style>
<div class="container-fluid">
	<div class="row" id="container">
<h2>Matriz Binaria</h2>
<p>Use los controles para filtrar los socios de los que necesita realizar la consulta</p>
<?php echo form_open('reportes/consultar_matriz_binaria_criterio'); ?>
<table class="table table-responsive medio"> 
<tbody>
	<tr>
		<td colspan="4">
			Información Socio
		</td>
	</tr>
	<tr>
		<td>Provincia:</td>
		<td>
			<select name="id_provincia" id="id_provincia" class="form-control">
				<option value="">Todas</option>
				<?php foreach ($provincias as $key => $value) { ?>
					<option value="<?php echo $value->idprovincia; ?>"><?php echo $value->provincia; ?></option>
				<?php } ?>
			</select>
		</td>
		<td>Ciudad:</td>
		<td>
			<select name="id_ciudad" id="id_ciudad" class="form-control">
				<option value="">Todas</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<td>Socio:</td>
		<td>
			<input type="text" name="criterio" id="criterio" class="form-control" placeholder="Cédula o Apellido">
		</td>
		<td>Codigo:</td>
		<td>
			<input type="text" name="codigo_socio" id="codigo_socio" class="form-control" placeholder="Código Socio">
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<button type="submit" class="btn btn-primary">Enviar</button>
		</td>
	</tr>
</tbody>
</table>
<?php echo form_close(); ?>

<?php if ( isset($codigos) && $codigos!=null){ ?>
	<table class="table table-responsive dataTable medio"> 
		<thead>
			<tr>
				
				<th>Cedula</th>
				<th>Socio</th>
				<th>Codigo</th>
				<th>Ciudad</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($codigos as $key => $value) {?>
			<tr>
				
				<td><?php echo $value->cedula; ?></td>
				<td><?php echo $value->apellidos.' '.$value->nombres; ?></td>
				<td><?php echo $value->codigo_socio; ?></td>
				<td><?php echo $value->ciudad; ?></td>
				<td>
					<a 
					href="<?php echo base_url(); ?>reportes/matriz_binaria_pago/<?php echo $value->idcod_socio; ?>">Ver</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>

	</table>
<?php }else{ ?>
	<h3 style="text-align: center;">Sin Datos encontrados</h3>
<?php } ?>

</div>
</div>