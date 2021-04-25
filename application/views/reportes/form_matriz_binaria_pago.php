<style type="text/css">
	.icono {
		font-size: 60px;
		text-align: center;
	}

	.fa{
		margin-right: 10px;
		margin-left: 10px;
	}

	.centrado{
		text-align: center;
	}
	.results td{
		text-align: center;
	}
	.results{
		font-size: 20px;
	}
	.tbcentro{
		margin: 0 auto !important;
	}
</style>
<div class="container-fluid">
	<div class="row" id="container">
<h2>Reporte de Pago</h2>
<table class="table table-responsive tbcentro">
	<tbody>
		<tr>
			<td rowspan="3" style="text-align: center;padding: 10px">
				<i class="fa fa-user icono" aria-hidden="true" style="font-size: 60px"></i>
			</td>
		</tr>
		<tr>
			<td>Socio:</td>
			<td><?php echo $socio['apellidos'].' '.$socio['nombres']; ?></td>
			<td>Código:</td>
			<td><?php echo $codigo['codigo']; ?></td>
		</tr>
		<tr>
			<td>Dirección:</td>
			<td><?php echo $socio['direccion']; ?></td>
			<td>Teléfono:</td>
			<td><?php echo $socio['telf_casa']; ?></td>
		</tr>
	</tbody>
</table>

<?php 
	
	$p_mayor =0;
	$p_menor =0;
	$rama_pago;
	$puntos=0;
	if ($pago['puntos_izq']>=$pago['puntos_der']) {
		$p_mayor =$pago['puntos_izq'];
		$p_menor =$pago['puntos_der'];
		$rama_pago = 'Derecha <i class="fa fa-arrow-left" aria-hidden="true"> ';
		$puntos= $pago['puntos_der'];
	}else{
		$p_mayor =$pago['puntos_der'];
		$p_menor =$pago['puntos_izq'];
		$rama_pago = '<i class="fa fa-arrow-left" aria-hidden="true"> Izquierda';
		$puntos= $pago['puntos_izq'];
	}

?>

<table class="table table-responsive tbcentro">
	<tbody>
		<tr>
			<td class="centrado">
			<i class="fa fa-arrow-left" aria-hidden="true"></i>Patricinados Rama Izquierda</td>
			<td class="centrado">Patricinados Rama Derecha<i class="fa fa-arrow-right" aria-hidden="true"></i></td>
			
		</tr>
		<tr>
			<td class="centrado"><?php echo $pago['patrocinados_i']; ?><i class="fa fa-users" aria-hidden="true"></i></td>
			<td class="centrado"><?php echo $pago['patrocinados_d']; ?><i class="fa fa-users" aria-hidden="true"></i></td>
		</tr>
		<tr>
			<td class="centrado"><i class="fa fa-arrow-left" aria-hidden="true"></i>Puntos Rama Izquierda:</td>
			<td class="centrado">Puntos Rama Derecha:<i class="fa fa-arrow-right" aria-hidden="true"></i></td>
		</tr>
		<tr>
			<td class="centrado"><?php echo $pago['puntos_izq']; ?><i class="fa fa-line-chart" aria-hidden="true"></i></td>
			<td class="centrado"><?php echo $pago['puntos_der']; ?><i class="fa fa-line-chart" aria-hidden="true"></i></td>
		</tr>
		<tr class="results">
			<td>
				<label>Rama Pago:</label><br>
				<?php echo $rama_pago; ?><br>
				<label>Puntos Pago:</label><br>
				<?php echo $puntos; ?>
			</td>
			<td class="centrado" >
				<br><label>Puntos para el mes siguiente</label><br>
				<?php echo $p_mayor-$p_menor; ?></td>
		</tr>
		<tr >
			<td colspan="2" style="text-align: right;"><button class="btn btn-primary">Pagar</button></td>
		</tr>
	</tbody>
</table>
</div>
</div>
