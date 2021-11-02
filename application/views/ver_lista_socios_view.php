<div id="table_datos">
    <div class="col-md-12">
        <form action="lista_socios_matriz" method="post" accept-charset="utf-8">
        <div class="col-md-12" id="grid_form">
            <h3>Ver lista de socios</h3>
            <table class="table table-bordered" id="table_resumen">
                <thead>
                    <tr>
                        <th>NOMBRES</th>
                        <th>CEDULA</th>
                        <th>CODIGO</th>
                        <th>PATROCINADOR</th>
                        <th>TELEFONO</th>
                        <th>CELULAR</th>
                        <th>EMAIL</th>
                        <th>UBICACION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if (isset($socios) && $socios != null) {
                            foreach ($socios as $socio) {
                                echo '<tr>';
                                echo '<td>'.$socio['nombres'].' '.$socio['apellidos'].'</td>';
                                echo '<td>'.$socio['cedula'].'</td>'; 
                                echo '<td>'.$socio['codigo_socio'].'</td>';  
                                
                                foreach ($patrocinador as $p) {
                                    echo '<td>'.$p['nombres'].' '. $p['apellidos'].'</td>';
                                }
                                echo '<td>'.$socio['telf_casa'].'</td>';
                                echo '<td>'.$socio['celular'].'</td>';
                                echo '<td>'.$socio['email'].'</td>';
                                echo '<td>'.$socio['ubicacion_fila'].' '.$socio['ubicacion_numero'].'</td>'; 
                                echo '</tr>';      
                            }
                        }else{
                            echo '<tr><td colspan="8">NO HAY DATOS QUE MOSTRAR</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
 
        
        </form>
	</div><!-- /.col-nd-12 --> 	
</div>