<style type="text/css">
	h3{
		text-align: center;
	}
</style>
<section id="table_datos">
	<h4 style="text-align: left;margin-left: 30px;"><strong>Codigos Activos: </strong> Escoja cual de sus códigos desea eliminar</h4>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th id="td_resumen">Nombre</th>
				<th id="td_resumen">CI.</th>
				<th id="td_resumen"></th>
			</tr>
		</thead>
		<tbody>
		<?php

			if($socios != NULL){
				foreach ($socios as $key => $value) {
					if($value->idsocio != 8){
						echo '<tr>
						<td id="td_resumen">'.$value->apellidos.' '. $value->nombres.'</td>
						<td id="td_resumen">'.$value->cedula.'</td>';
						echo '<td style="text-align: center; width: 50px;">';
							echo form_open('socios/elimina_socio');
							echo '<input type="hidden" name="idsocio" id="idsocio" value="'.$value->idsocio.'">';
							echo '<button type="submit" class="btn btn-primary">Eliminar Información</button>';
							echo form_close();
						echo '</td></tr>';
					}
				}
			}else{
				echo '<tr><td>No hay distribuidores regsitrados</td><td></td><td></td><td></td></tr>';
			}
			?>
		</tbody>
	</table>
</section>