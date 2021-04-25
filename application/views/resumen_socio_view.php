<div class="row-fluid">
    <div class="col-md-12">
          <table class="table table-bordered" id="table_resumen">
	    	<caption><h5>Reporte socio: <?php echo $nombre_socio; ?></h5></caption>
	    	<tbody>
	    		<tr>
	    			<th>Codigo</th>
	    			<th>Matriz</th>
	    			<th>Nombres</th>
					<th>Primer Mes</th>
					<th>Socios patrocinados mes</th>
					<th>Recompra mensual</th>
					<th>Litros por cobrar</th>
					<th>Regalías</th>
					<th>Promoción</th>
					<th>Estado</th>
				</tr>
				<?php foreach ($datos as $key => $value) {?>
				<tr>
					<td><?php echo $value['codigo']; ?></td>
					<td><?php echo $value['nombre_matriz'] ?></td>
					<td><?php echo $value['nombre_socio']; ?></td>

					<?php if ($value['primer_mes'] == 1) { ?>
						<td>SI <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>
					<?php }else{ ?>
						<td>NO <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>
					<?php } ?>

					<?php if ($value['primer_mes'] == 1 && $value['patrocina_socios'] >= 2) { ?>
						<td><?php echo $value['patrocina_socios']; ?> <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>
					<?php }elseif ($value['primer_mes'] == 0 && $value['patrocina_socios'] >= 1) { ?>
						<td><?php echo $value['patrocina_socios']; ?> <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>
					<?php }else{ ?>
						<td><?php echo $value['patrocina_socios']; ?> <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>
					<?php } ?>

					<?php if ($value['recompra'] == 1) { ?>
						<td>SI <i class="fa fa-check-circle" aria-hidden="true" id="fa_aprobado"></i></td>
					<?php }else{ ?>
						<td>NO <i class="fa fa-times-circle" aria-hidden="true" id="fa_reprobado"></i></td>
					<?php } ?>

					<td><?php echo $value['litros_cobrar'] ?></td>
					<td><?php echo $value['regalias'] ?></td>
					<td><?php echo $value['promociones'] ?></td>

					<?php //Estado
					if ($value['primer_mes'] == 1) {
						if ($value['patrocina_socios'] >= 2 && $value['recompra'] == 1) {
							echo '<td><img src="'.base_url().'images/aprobado.png" id="img_estado_socio"/>Activo</td>';
						}else{
							echo '<td><img src="'.base_url().'images/negado.png" id="img_estado_socio"/>Inactivo</td>';
						}
					}else{
						if ($value['patrocina_socios'] >= 1 && $value['recompra'] == 1) {
							echo '<td><img src="'.base_url().'images/aprobado.png" id="img_estado_socio"/>Activo</td>';
						}else{
							echo '<td><img src="'.base_url().'images/negado.png" id="img_estado_socio"/>Inactivo</td>';
						}
					} 
					?>

					<?php  } ?>
				</tr>
	    	</tbody>
	    </table>      
	</div>	
</div>
