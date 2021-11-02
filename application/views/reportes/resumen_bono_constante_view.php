<div class="row" style="margin-left: 10px;">
	<h2>Resumen Bono constante del código: <?php echo '<strong>'.$codigo_socio_binario.'</strong>';?></h2>
	<p>Seleccione el código del que requiere generar el reporte de bonos constantes</p>
	<div class="col-md-6">
	<table class="table table-bordered table-hover" style="margin: 0px;margin-bottom: 20px;">
		<thead>
			<tr>
				<th>MATRIZ</th>
				<th>CODIGO</th>
				<th>PAQUETE</th>
				<th>BONO</th>
				<th>ESTADO</th>
			</tr>
		</thead>
		<tbody>
		<?php

		$total_bono_constante_binario = 0;
		$total_bono_constante_uninivel = 0;
		if($patrocinados != NULL){
			//echo '<pre>'.var_export($patrocinados,true).'</pre>';
			foreach ($patrocinados as $key => $value) {
				//bono constante
				$bono_constante = $this->procesos_model->_get_paquete_comprado_mes($value->idcodigo_socio_binario, $mes);
				
				if ($bono_constante['compra'] != 0) {
					echo '<tr>
					<td id="td_resumen">BINARIA</td>
					<td id="td_resumen">'.$value->codigo_socio_binario.'</td>';
					echo '<td id="td_resumen" style="text-align:right;">$ '.number_format($bono_constante['compra'], 2).'</td>
					<td style="text-align: center; width: 50px;">'.number_format($bono_constante['bono'], 2).'</td><td></td>';
					$total_bono_constante_binario += $bono_constante['bono'];
				}
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS DIRECTOS REGISTRADOS BINARIO</td><td></td><td></td><td></td><td></td></tr>';
		}

		
		echo '<tr><td colspan="5"></td></tr>';

		if ($uninivel != NULL) {
			//echo '<pre>'.var_export($uninivel,true).'</pre>';
			foreach ($uninivel as $key => $value) {
			
				//pablo aquí debo incluir el bono constante del mes
				echo '<tr>
				<td id="td_resumen">UNINIVEL</td>
				<td id="td_resumen">'.$value->codigo_socio.'</td>
				<td id="td_resumen">0.00</td><td>0.00</td><td></td></tr>';
				$total_bono_constante_uninivel += 0;
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS DIRECTOS REGISTRADOS UNINIVEL</td><td></td><td></td><td></td><td></td></tr>';
		}
		echo '<tr>
				<td></td>
				<td></td>
				<td>TOTAL: </td>
				<td>'.number_format($total_bono_constante_binario + $total_bono_constante_uninivel, 2).'</td>
				<td>Pendiente</td>
				</tr>';
		?>
		</tbody>
	</table>
	</div>
</div>