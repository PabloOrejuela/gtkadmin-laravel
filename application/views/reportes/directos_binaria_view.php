<div class="row-fluid" id="table_datos">
    <div class="col-md-12">
    	<caption><h4>Mis Distribuidores Directos Red Binaria: <?php echo '<strong>'.$socio['nombres'].' '.$socio['apellidos'].'</strong>'; ?></h4></caption>
        <table class="table table-stripped table-bordered" style="width: 50%;">
            <thead>
                <th>No.</th>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>FECHA INSCRIPCION</th>
                <th>PAQUETE</th>
                <th>ESTADO</th>
            </thead>
    	<?php
            $n = 1;
            if (isset($patrocinados) && $patrocinados != NULL) {
                foreach ($patrocinados as $key => $value) {
                    $paquete =  $this->procesos_model->_get_paquete_codigo_binario($value->idcodigo_socio_binario);
					$compras_socio = $this->procesos_model->_get_cuentas_socio_binario_idcod($value->idcodigo_socio_binario);
					
                    echo '<tr><td>'.$n.'</td>';
                    echo '<td>'.$value->codigo_socio_binario.'</td>';
                    echo '<td>'.$value->nombres.' '.$value->apellidos.'</td>';
                    echo '<td>'.$value->fecha_inscripcion.'</td>';
					
                    if ($compras_socio != 0) {
                        echo '<td style="text-align: right;">'.$paquete.'</td>';
                        echo '<td style="text-align: center;"> ACTIVO</td></tr>';
                    }else{
                        echo '<td style="text-align: right;"> $0</td>';
                        echo '<td style="text-align: center;"> INACTIVO</td></tr>';
                    }
                    $n++;
                }
            }else{
            echo '<td style="width:90px;text-align:center;font-size:8px;line-height:1;height:150px;vertical-align:top"><br>NO TIENE DIRECTOS</td>';
                echo '</tr></table>';
            }

    	?>
        </table>
	</div>
</div>
<div class="pop-div" >
    <div id="pop-title"></div>
    <div id="pop-content"></div>
</div>

