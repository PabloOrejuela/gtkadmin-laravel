<div class="row-fluid">
    <div class="col-md-12">
          <table class="table table-bordered" id="table_resumen">
	    	<caption><h5>Reporte socio: <?php echo $nombre_socio; ?></h5></caption>
	    	<tbody>
	    		<tr>
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
	    		?>
	    	</tbody>
	    </table>      
	</div>	
</div>
