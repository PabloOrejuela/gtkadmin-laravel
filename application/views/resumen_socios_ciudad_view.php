<div class="row-fluid">
    <div class="col-md-12">
        <table class="table table-bordered table-condensed" id="table_resumen">
	    	<caption><h5>Reporte socios: <?php echo $ciudad; ?></h5></caption>
	    	<tbody>
	    		<tr>
	    			<th>Posición</th>
	    			<th>Nombre</th>
	    			<th>Cédula</th>
					<th>Primer Mes</th>
					<th>Socios patrocinados mes</th>
					<th>Recompra mensual</th>
					<th>Litros por cobrar</th>
					<th>Regalías</th>
					<th>Promoción</th>
					<th>Estado</th>
				</tr>

	    		<tr>
	    			<?php 
	    				if (!isset($cedulas)) {
	    					echo '<tr><td></td><td></td><td></td><td></td><td></td></tr>';
	    				}else{
	    					foreach ($cedulas as $value) {
	    						
	    						//ciclo para procesar todo esto con cada cedula
	    						$matriz = $this->procesos_model->_get_matriz_socio($value->cedula);
	    						$posicion = $this->procesos_model->_get_posicion($value->cedula, $matriz);
	    						$nombre_socio = $this->procesos_model->_get_nombre_socio($value->cedula);
	    						
	    						$primer_mes = $this->procesos_model->_es_primer_mes($value->cedula);
				                $patrocina_socios = $this->procesos_model->_es_patrocinador_mes($value->cedula, $matriz);
				                $litros_cobrar = $this->procesos_model->_litros_por_cobrar($value->cedula);
				                $recompra = $this->procesos_model->_get_recompras($value->cedula);
				                $regalias = $this->procesos_model->_calcula_regalias($value->cedula, $matriz);
				                $promociones = 'calcular';

				                echo '<td>'.$posicion.'</td>';
	    						echo '<td>'.$nombre_socio.'</td>';
	    						echo '<td>'.$value->cedula.'</td>';
	    						if ($primer_mes == 1) {
									echo '<td>SI <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>';
								}else{
									echo '<td>NO <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>';
								}

								if ($primer_mes == 1 && $patrocina_socios >= 2) {
									echo '<td>'.$patrocina_socios.' <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>';
								}elseif ($primer_mes == 0 && $patrocina_socios >= 1) {
									echo '<td>'.$patrocina_socios.' <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>';
								}else{
									echo '<td>'.$patrocina_socios.' <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>';
								}

								if ($recompra == 1) {
									echo '<td>SI <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>';
								}else{
									echo '<td>NO <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>';
								}

								echo '<td>'.$litros_cobrar.'</td>';
								echo '<td>$'.$regalias.'</td>';
		    					echo '<td>'.$promociones.'</td>';

		    					//Estado
								if ($primer_mes == 1) {
									if ($patrocina_socios >= 2 && $recompra == 1) {
										echo '<td><img src="'.base_url().'images/aprobado.png" id="img_estado_socio"/>Activo</td>';
									}else{
										echo '<td><img src="'.base_url().'images/negado.png" id="img_estado_socio"/>Inactivo</td>';
									}
								}else{
									if ($patrocina_socios >= 1 && $recompra == 1) {
										echo '<td><img src="'.base_url().'images/aprobado.png" id="img_estado_socio"/>Activo</td>';
									}else{
										echo '<td><img src="'.base_url().'images/negado.png" id="img_estado_socio"/>Inactivo</td>';
									}
								}
								echo '</tr>';
	    					}
	    					
	    				}
	    				
	    		?>
	    		<tr><td><button type="submit">Imprimir</button></td></tr>
	    	</tbody>
	    </table>      
	</div>	
</div>
