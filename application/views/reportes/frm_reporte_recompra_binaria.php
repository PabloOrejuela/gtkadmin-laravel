<div class="row" style="margin-left: 10px;">
	<div class="col-md-12">
		<h2>Reporte de Recompras</h2>
	</div>
	<div>
	<?php echo form_open('reportes/reporte_recompras'); ?>
	
	<?php form_close(); ?>
	<?php
		$litros_totales = 0;
		$litros_totales_mes_anterior = 0;
		if (!isset($recompras) || $recompras == NULL || $recompras == 0) {
			echo '
				<table class="table table-condensed" style="width: 40%;margin-top: 10px;margin-left: 10px;border: none;font-size: 1.2em;">
					<tr>
						<td>No hay recompras que mostrar</td>
					</tr>
				</table>';
			
		}else{

			echo '<table class="table table-bordered table-condensed" style="width: 60%;margin-top: 10px;margin-left: 10px;font-size: 0.8em;">';
			echo '<thead>';
			echo '<tr><td>Recompras mes actual</td></tr>';
			echo '<tr>';
			echo '<th>No.</th>';
			echo '<th>NOMBRE</th>';
			echo '<th>CODIGO</th>';
			echo '<th>FECHA</th>';
			echo '<th>PAQUETE</th>';
			echo '<th>LITROS</th>';
			echo '</tr>';
			echo '</thead>';
			foreach ($recompras as $key => $r) {
				echo '<tr>';
				echo '<td>'.($key+1).'</td>';
				echo '<td>'.$r->apellidos.' ' .$r->nombres.'</td>';
				echo '<td>'.$r->codigo_socio_binario.'</td>';
				echo '<td>'.$r->fecha.'</td>';
				echo '<td style="text-align: right;">'.$r->paquete.'</td>';
				echo '<td style="text-align: right;">'.$r->litros.' lts.</td>';
				$litros_totales += $r->litros;
			}
			echo '<tr>';
			echo '<th colspan="5" style="text-align: right;">TOTAL LITROS DEL MES:</th>';
			echo '<th style="text-align: right;">'.$litros_totales.' lts.</th>';
			echo '</tr>';
			echo '</table>';
			
			echo '<table class="table table-bordered table-condensed" style="width: 60%;margin-top: 10px;margin-left: 10px;font-size: 0.8em;">';
			echo '<thead>';
			echo '<tr><td>Recompras mes anterior</td></tr>';
			echo '<tr>';
			echo '<th>No.</th>';
			echo '<th>NOMBRE</th>';
			echo '<th>CODIGO</th>';
			echo '<th>FECHA</th>';
			echo '<th>PAQUETE</th>';
			echo '<th>LITROS</th>';
			echo '</tr>';
			echo '</thead>';

			if (!isset($recompras_anterior) || $recompras_anterior == NULL || $recompras_anterior == 0) {
				
			}else{
				foreach ($recompras_anterior as $key => $ra) {
					echo '<tr>';
					echo '<td>'.($key+1).'</td>';
					echo '<td>'.$ra->apellidos.' ' .$ra->nombres.'</td>';
					echo '<td>'.$ra->codigo_socio_binario.'</td>';
					echo '<td>'.$ra->fecha.'</td>';
					echo '<td style="text-align: right;">'.$ra->paquete.'</td>';
					echo '<td style="text-align: right;">'.$ra->litros.'</td>';
					$litros_totales_mes_anterior += $ra->litros;
				}
				echo '<tr>';
				echo '<th colspan="5" style="text-align: right;">TOTAL LITROS DEL MES:</th>';
				echo '<th style="text-align: right;">'.$litros_totales_mes_anterior.' lts.</th>';
				echo '</tr>';
				echo '</table>';
			}
		}
	?>
	</div>
</div>