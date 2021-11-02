<style type="text/css">
	#table_socios{
		max-width: 600px;
		margin:0 auto;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('#table_resumen').dataTable();
	});
</script>
<div class="row-fluid">
    <div class="col-md-12">
<h1>Buscar Socio</h1>
<p>Digite un parte de la información del socio</p>
<?php echo form_open('reportes/buscar_resumen_socios_individual'); ?>
	
	<div class="form-group" style="max-width: 300px">
	<table class="table table-responsive">
		<tr>
			<td>Buscar:</td>
			<td>
				<input type="text" name="txt_criterio" placeholder="Cédula, Apellido o Nombre" class="form-control" /></td>
			<td>
				<button class="btn btn-primary" type="submit" style="margin: 0">Buscar</button>
			</td>
		</tr>
	</table>
	</div>

<?php echo form_close(); ?>
<table class="table table-bordered dataTable" id="table_resumen" >
	<thead>
		<tr>
			
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Ciudad</th>
			<th>Dirección</th>
			<th>Email</th>
			<th>Teléfono</th>
			<th>Celular</th>
		</tr>
	</thead>
	<tbody>
	<?php if( isset($socios) && $socios!=null){
		$i=1;
	foreach ($socios as $key => $value) {?>	
		<tr>
			
			<td><a href="<?php echo base_url(); ?>reportes/resumen_mensual_socio_individual/<?php echo $value->idsocio; ?>"><?php echo $value->cedula; ?></a></td>
			<td><?php echo $value->apellidos.' '. $value->nombres; ?></td>
			<td><?php echo $value->ciudad; ?></td>
			<td><?php echo $value->direccion; ?></td>
			<td><?php echo $value->email; ?></td>
			<td><?php echo $value->telf_casa; ?></td>
			<td><?php echo $value->celular; ?></td>
		</tr>
		
		<?php $i++;}}else{ ?>
		<tr>
			<td colspan="8" style="text-align: center;">
				<h3>Sin Información Cargada</h3>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
</div>
</div>