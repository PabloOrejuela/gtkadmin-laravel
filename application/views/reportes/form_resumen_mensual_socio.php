<div id="table_datos">
	<h2>Información de mi Red y mis patrocinados</h2>
	<p>Seleccione el código del que requiere generar el reporte</p>
	<div class="col-md-12">
	<table class="table table-striped table-hover" style="margin: 0px;margin-bottom: 20px;">
		<thead>
			<tr>
				<th>MATRIZ</th>
				<th>CODIGO</th>
				<th>FECHA DE INSCRIPCION</th>
				<th>BONO CONSTANTE DEL MES</th>
				<th>RED</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
		

		if($codigos_binarios != NULL){
			foreach ($codigos_binarios as $key => $value) {
				//bono constante
				$bono_constante = $this->procesos_model->_bono_constante($value->idcodigo_socio_binario);
				echo '<tr>
				<td id="td_resumen">BINARIA</td>
				<td id="td_resumen">'.$value->codigo_socio_binario.'</td>
				<td id="td_resumen">'.$value->fecha_inscripcion.'</td>
				<td id="td_resumen" style="text-align:right;">$ '.number_format($bono_constante, 2).'</td>
				<td style="text-align: center; width: 50px;">';
					echo form_open('reportes/mi_red_binaria');
					echo form_hidden('idmatrices', 2);
					echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$value->idcodigo_socio_binario.'">';
					echo '<input type="hidden" name="codigo_socio_binario" id="id_socio" value="'.$value->codigo_socio_binario.'">';
					echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
					echo '<button type="submit" class="btn btn-primary">MI RED</button>';
					echo form_close();
				echo '</td>';
				echo '<td style="text-align: center; width: 50px;">';
				echo form_open('reportes/mis_directos_binaria');
				echo form_hidden('idmatrices', 2);
				echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$value->idcodigo_socio_binario.'">';
				echo '<input type="hidden" name="codigo_socio_binario" id="id_socio" value="'.$value->codigo_socio_binario.'">';
				echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
				echo '<button type="submit" class="btn btn-primary">MIS DIRECTOS</button></td></tr>';
				echo form_close();
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS REGISTRADOS BINARIO</td><td></td><td></td><td></td><td></td></tr>';
		}

		echo "<tr><td></td></tr>";

		if ($codigos_uninivel != NULL) {
			foreach ($codigos_uninivel as $key => $value) {
				//pablo aquí debo incluir el bono constante del mes
				echo '<tr>
				<td id="td_resumen">UNINIVEL</td>
				<td id="td_resumen">'.$value->codigo_socio.'</td>
				<td id="td_resumen">'.$value->fecha_inscripcion.'</td>
				<td id="td_resumen">AQUI VA EL BIR del mes</td>
				<td style="text-align: center; width: 50px;">';
					echo form_open('reportes/mi_red');
					echo form_hidden('idmatrices', 3);
					echo '<input type="hidden" name="id_codigo" id="id_codigo" value="'.$value->idcod_socio.'">';
					echo '<input type="hidden" name="id_socio" id="id_socio" value="'.$value->codigo_socio.'">';
					echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
					echo '<button type="submit" class="btn btn-primary">MI RED</button>';
					echo form_close();
				echo '</td><td></td></tr>';
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS REGISTRADOS UNINIVEL</td><td></td><td></td><td></td><td></td></tr>';
		}

		?>
		</tbody>
	</table>
	</div>
</div>