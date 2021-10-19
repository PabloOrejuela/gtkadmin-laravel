<div class="row" style="margin-left: 10px;">
	<div class="col-md-12">
		<h2>Reporte de Lista de Códigos</h2>

	<?php
		
		if ($ordenar && $provincias) {
			foreach ($provincias as $key => $value) {
				$n = 1;
				$socios_provincia = $this->procesos_model->_get_socios_provincia($value->idprovincia);
				//var_dump($socios_provincia);
				if ($socios_provincia != null && $socios_provincia > 0) {
					echo '<h5 style="font-weight:bold;">'.$value->provincia.'</h5>';
						echo '<table class="table table-bordered table-striped" style="width: 80%;margin-top: 10px;margin-left: 10px;font-size:1em;">
						<thead>
							<tr>
								<th>#</th>
								<th>NOMBRE</th>
								<th>CEDULA</th>
								<th>CELULAR</th>
								<th>FECHA</th>
								<th>CODIGO</th>
							</tr>
						</thead>';
					foreach ($socios_provincia as $key => $socio) {
						
						echo '<tr>
								<td>'.$n.'</td>
								<td>'.$socio->apellidos.' '.$socio->nombres.'</td>
								<td>'.$socio->cedula.'</td>
								<td>'.$socio->celular.'</td>
								<td>'.$socio->fecha_inscripcion.'</td>
								<td>'.$socio->codigo_socio_binario.'</td>
							</tr>';
							$n++;
					}
					echo '<table>';
				}
			}
		}else{
			$n = 1;
			echo '<table class="table table-bordered table-striped" style="width: 80%;margin-top: 10px;margin-left: 10px;font-size:1em;">
				<thead>
					<tr>
						<th>#</th>
						<th>NOMBRE</th>
						<th>CEDULA</th>
						<th>CELULAR</th>
						<th>FECHA</th>
						<th>CODIGO</th>
					</tr>
				</thead>';
			if (isset($lista_codigos) || $lista_codigos != null) {
				foreach ($lista_codigos as $item) {
					echo '<tr>
							<td>'.$n.'</td>
							<td>'.$item->apellidos.' '.$item->nombres.'</td>
							<td>'.$item->cedula.'</td>
							<td>'.$item->celular.'</td>
							<td>'.$item->fecha_inscripcion.'</td>
							<td>'.$item->codigo_socio_binario.'</td>
						</tr>';
						$n++;
				}
			}else{
					echo '<tr>
						<td>'.$n.'</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>';
					$n++;
				}
			}
	?>

	</div>
</div>