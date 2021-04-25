<div class="row-fluid">
    <div class="col-md-12">
    	<caption><h4>Mis Socios Directos Binaria: <?php echo '<strong>'.$socio['nombres'].' '.$socio['apellidos'].'</strong>'; ?></h4></caption>
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
                    echo '<tr><td>'.$n.'</td>';
                    echo '<td>'.$value->codigo_socio_binario.'</td>';
                    echo '<td>'.$value->nombres.' '.$value->apellidos.'</td>';
                    echo '<td>'.$value->fecha_inscripcion.'</td>';
                    if ($paquete == 1) {
                        echo '<td style="text-align: right;"> $200</td>';
                        echo '<td style="text-align: center;"> ACTIVO</td></tr>';
                    }else if($paquete == 2){
                        echo '<td style="text-align: right;"> $500</td>';
                        echo '<td style="text-align: center;"> ACTIVO</td></tr>';
                    }else if($paquete == 3){
                        echo '<td style="text-align: right;"> $1000</td>';
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

