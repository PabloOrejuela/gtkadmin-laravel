<style type="text/css">
	table.table-responsive{
		max-width: 100%;
		margin: 0 auto;
	}
	h3{
		text-align: center;
	}
</style>

<table class="table table-responsive" id="table_datos">
	<tbody>
		<tr>
			<td id="td_resumen" colspan="4">
				<h3 style="text-align: left;font-weight: bold;">Mi Red1 </h3>
			</td>
		</tr>
		<tr>
			<td id="td_resumen"><strong>Cedula:</strong></td>
			<td id="td_resumen"><?php echo $socio['cedula'] ?></td>
			<td id="td_resumen"><strong></strong></td>
			<td id="td_resumen"><?php echo '';?></td>
		</tr>
		<tr>
			<td id="td_resumen"><strong>Apellidos:</strong></td>
			<td id="td_resumen"><?php echo $socio['apellidos'] ?></td>
			<td id="td_resumen"><strong>Nombres:</strong></td>
			<td id="td_resumen"><?php echo $socio['nombres'] ?></td>
		</tr>
		<tr>
			<td id="td_resumen"><strong>Dirección:</strong></td>
			<td colspan="3" id="td_resumen"><?php echo $socio['direccion'] ?></td>
		</tr>
	</tbody>
</table>
<br>
<h4 style="text-align: left;margin-left: 30px;"><strong>Codigos Activos: </strong> Escoja cual de sus códigos desea consultar</h4>
<table class="table table-striped" id="table_datos">
	<thead>
		<tr>
			<th id="td_resumen">Matriz</th>
			<th id="td_resumen">Código</th>
			<th id="td_resumen">Patrocinador</th>
			<th id="td_resumen">Fecha Incripción</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php

		if($codigos_binarios != NULL){
			foreach ($codigos_binarios as $key => $value) {
				echo '<tr>
				<td id="td_resumen">BINARIA</td>
				<td id="td_resumen">'.$value->codigo_socio_binario.'</td>
				<td id="td_resumen">'.$value->nombres.' '. $value->apellidos.'</td>
				<td id="td_resumen">'.$value->fecha_inscripcion.'</td>
				<td style="text-align: center; width: 50px;">';
					echo form_open('reportes/elige_resumen_financiero');
					echo form_hidden('idmatrices', 2);
					echo '<input type="hidden" name="id_codigo" id="id_codigo" value="'.$value->idcodigo_socio_binario.'">';
					echo '<input type="hidden" name="id_socio" id="id_socio" value="'.$value->codigo_socio_binario.'">';
					echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
					echo '<button type="submit" class="btn btn-primary">Ver datos</button>';
					echo form_close();
				echo '</td>';
				echo '<td style="text-align: center; width: 50px;">';
					echo form_open('compras/recompras_binarias');
					echo form_hidden('idmatrices', 2);
					echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$value->idcodigo_socio_binario.'">';
					echo '<input type="hidden" name="codigo_socio_binario" id="codigo_socio_binario" value="'.$value->codigo_socio_binario.'">';
					echo '<button type="submit" class="btn btn-primary">Comprar</button>';
					echo form_close();
				echo '</td></tr>';
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS REGISTRADOS BINARIO</td><td></td><td></td><td></td></tr>';
		}

		if ($codigos_uninivel != NULL) {
			foreach ($codigos_uninivel as $key => $value) {
				echo '<tr>
				<td id="td_resumen">UNINIVEL</td>
				<td id="td_resumen">'.$value->codigo_socio.'</td>
				<td id="td_resumen">'.$value->nombres.' '. $value->apellidos.'</td>
				<td id="td_resumen">'.$value->fecha_inscripcion.'</td>
				<td style="text-align: center; width: 50px;">';
					echo form_open('reportes/elige_resumen_financiero');
					echo form_hidden('idmatrices', 3);
					echo '<input type="hidden" name="id_codigo" id="id_codigo" value="'.$value->idcod_socio.'">';
					echo '<input type="hidden" name="id_socio" id="id_socio" value="'.$value->codigo_socio.'">';
					echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
					echo '<button type="submit" class="btn btn-primary">Ver datos</button>';
					echo form_close();
				echo '</td>';
				echo '<td style="text-align: center; width: 50px;">';
					echo form_open('compras/recompras');
					echo form_hidden('idmatrices', 3);
					echo '<input type="hidden" name="id_codigo" id="id_codigo" value="'.$value->idcod_socio.'">';
					echo '<input type="hidden" name="codigo_socio" id="codigo_socio" value="'.$value->codigo_socio.'">';
					echo '<input type="hidden" name="id_patrocinador" id="id_patrocinador" value="'.$value->patrocinador.'">';
					echo '<button type="submit" class="btn btn-primary">Comprar</button>';
					echo form_close();
					echo '</td></tr>';
			}
		}else{
			echo '<tr><td>NO TIENE CÓDIGOS REGISTRADOS UNINIVEL</td><td></td><td></td><td></td><td></td></tr>';
		}

		?>
	</tbody>
</table>