<table id="table_datos">
    <tbody>
        <tr>
            <td id="td_resumen" colspan="4">
                <h3 style="text-align: left;font-weight: bold;vertical-align: middle;">Mi Resumen financiero</h3>
            </td>
        </tr>
        <tr>
            <td id="td_resumen_cabecera_left">Cedula:</td>
            <td id="td_resumen"><?php echo $socio['cedula'] ?></td>
            <td id="td_resumen_cabecera_left"></td>
            <td id="td_resumen"><?php echo $this->benchmark->elapsed_time('code_start', 'code_end').' segundos';?></td>
        </tr>
        <tr>
            <td id="td_resumen_cabecera_left">Nombre:</td>
            <td id="td_resumen_cabecera_right"><?php echo $socio['apellidos'].' '.$socio['nombres']?></td>
            <td id="td_resumen_cabecera_left">Codigo Socio:</td>
            <td id="td_resumen_cabecera_right"><?php echo $socio['codigo_socio_binario'] ?></td>
        </tr>
        <tr>
            <td id="td_resumen_cabecera_left">Matriz:</td>
            <?php if ($idmatrices == 2){ ?>
            <td id="td_resumen_cabecera_right">BINARIA</td>
            <?php }else{ ?>
            <td id="td_resumen_cabecera_right">UNINIVEL</td>
            <?php } ?>

            <td id="td_resumen_cabecera_left">Total Patrocinados:</td>
            <?php if ($patrocinados == 0){ ?>
            <td id="td_resumen_cabecera_right"><?php echo '0'; ?></td>
            <?php }else{ ?>
            <td id="td_resumen_cabecera_right"><?php echo count($patrocinados); ?></td>
            <?php } ?>
        </tr>
    </tbody>
</table>
<?php  if ($idmatrices == 3) {?>
<table class="table table-responsive table-bordered" id="table_datos" style="font-size: 0.8em;color:#2A5A86;padding: 1px;">
  <tr><th><h4>Nomeclatura:</h4></th></tr>
  <tr>
      <th id="td_resumen">Bono extra:</th>
      <td id="td_resumen">Bono recibido si se ingresa en la semana 3 o 5 socios nuevos</td>
	 </tr>
  <tr>
      <th id="td_resumen">Litros movidos RED:</th>
      <td id="td_resumen">La suma de litros movidos por el sucio y su red en la semana</td>
      <th id="td_resumen">Semana seguida:</th>
      <td id="td_resumen">Número de semanas consecutivas que el socio supera la cantidad de litros del rango</td>
  </tr>
</table>
<?php }else{ ?>
<table class="table table-responsive table-bordered" id="table_datos" style="font-size: 0.8em;color:#2A5A86;padding: 1px;">
    <tr><th><h4>Nomeclatura:</h4></th></tr>
    <tr>
      <th id="td_resumen">Estado:</th>
      <td id="td_resumen">Activo si el socio y sus frontales han realizado compra en el período</td>
    </tr>
</table>
<?php } ?>

<br>
<table class="table table-responsive table-bordered" id="table_datos">
    <?php

        $regalias = 0;
        $porcentaje_gana_rango = 0;
        $num_socios_semana = $patrocinados;
        if ($idmatrices == 3) {
          //UNINIVEL
          $bono_socios_nuevos = $nuevos_socios_semana * 50;
          if ($nuevos_socios_semana >= 3 && $nuevos_socios_semana < 5) {
            $bono_extra = 130;
          }else if($nuevos_socios_semana >= 5){
            $bono_extra = 320;
          }else{
            $bono_extra = 0;
          }
          echo '<tbody><thead>
              <tr>
                  <th id="td_resumen">Socios nuevos sem.</th>
                  <th id="td_resumen">Bono Socios nuevos</th>
                  <th id="td_resumen">Bono extra</th>
                  <th id="td_resumen">Lts Movidos Socio</th>
                  <th id="td_resumen">Lts Movidos RED</th>
                  <th id="td_resumen">Total Litros Movidos</th>
                  <th id="td_resumen">Regalo</th>
                  <th id="td_resumen">TOTAL COBRAR</th>
              </tr>
          </thead>';

          echo '<tr>
              <td id="td_resumen_financiero">'.$nuevos_socios_semana.'</td>
              <td id="td_resumen_financiero">$'.$bono_socios_nuevos.'</td>';

              //Bono extra
              echo '<td id="td_resumen_financiero">'.$bono_extra.'</td>';
              echo '<td id="td_resumen_financiero">'.$compras_socio.'</td>';
              echo '<td id="td_resumen_financiero">'.$litros_movidos.'</td>';
              echo '<td id="td_resumen_financiero">'.$litros_movidos_totales.'</td>';
              if ($litros_movidos_totales >= $litros_rango) {
                echo '<td id="td_resumen_financiero">SI</td>';
              }else{
                echo '<td id="td_resumen_financiero">NO</td>';
              }
              $total_pagar = $bono_socios_nuevos + $bono_extra;
              echo '<td id="td_resumen_financiero">$ '.$total_pagar.'</td>';
          echo '</tr>';
        }else if($idmatrices == 2){
        //Matriz Binaria
        echo '<tbody><thead>
            <tr>
                <th id="td_resumen">Categoria</th>
                <th id="td_resumen">Estado</th>
                <th id="td_resumen">Socios nuevos Mes</th>
                <th id="td_resumen">Bono constante</th>
                
                <th style="border:none;"></th>
                <th id="td_resumen">Binario Izquierdo</th>
                <th id="td_resumen">Binario Derecho</th>
                <th id="td_resumen">Total Izquierdo</th>
                <th id="td_resumen">Total Derecho</th>
                <th id="td_resumen">BASE NIVEL</th>
                <th id="td_resumen">Saldo Izquierdo</th>
                <th id="td_resumen">Saldo Derecho</th>
                <th id="td_resumen" style="text-align: center;">Regalias</th>
            </tr>
        </thead>';
		}
		//fila 2
		if ($idmatrices == 3) {
      //MAtris UNINIVEL
      echo '	</tbody></table><br><table class="table table-responsive table-bordered" id="table_datos">';
      echo '<thead>
          <tr>
              <th id="td_resumen">Litros por Rango</th>
              <th id="td_resumen">Semana seguida</th>
              <th id="td_resumen">Sube categoria</th>
              <th id="td_resumen">Bono Semana</th>
          </tr>
      </thead>';
      echo '<tr>
          <td id="td_resumen_financiero">'.$litros_rango.'</td>
          <td id="td_resumen_financiero">'.$semana_seguida.'</td>';
          if ($semana_seguida >= 4) {
              echo '<td id="td_resumen_financiero">Sube de Nivel</td>';
          }else{
              echo '<td id="td_resumen_financiero"><strong>NO</strong></td>';
          }
          if ($semana_seguida != 0) {
              echo '<td id="td_resumen_financiero">$'.$bono_rango.'</td>';
          }else{
              echo '<td id="td_resumen_financiero">$ 0</td>';
          }
      echo '</tr><tbody>';
		}else if($idmatrices == 2){
            /*Matriz Binaria*/

            echo '<tr>
            <td id="td_resumen_financiero">'.$socio['rango'].'</td>';
            /*if ($compras_socio > 0 && $compras_frontales != 0 && $nuevos_socios_mes >= 2 || $socio['codigo_socio_binario'] == 'TUNCL-B01') {
                
                echo '<td id="td_resumen_financiero">Activo</td>';
            }*/
			if($compras_socio > 0){ //Ahora solo debe tener recompra para estar activo
				echo '<td id="td_resumen_financiero">Activo</td>';
			}else{
                echo '<td id="td_resumen_financiero" style="color:red;">Inactivo</td>';
            }
            echo '<td id="td_resumen_financiero">'.$nuevos_socios_mes.'</td>';
            echo '<td id="td_resumen_financiero">$ '.number_format($bono_constante, 2).'</td>';

            echo '<td style="border:none;"></td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['puntos_izq'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['puntos_der'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['sum_izq'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['sum_der'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['base'].'</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['saldo_izq'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">'.$registro_mes['saldo_der'].' Puntos</td>';
            echo '<td id="td_resumen_financiero">$ '.number_format($registro_mes['bono'],2).'</td>';
            //echo '<td id="td_resumen_financiero"> $ '.number_format($regalias, 2).'</td>';
            echo '</tr>';

    }
  ?>
</tbody>
</table>

<?php
  echo '<div style="margin-left:20px;">';
          echo form_open('reportes/print_historico_binario');
          echo form_hidden('idcod_socio', $idcod_socio);
          echo '<a href="print_historico_binario/'.$idcod_socio.'" type="submit" class="btn btn-secondary" value="print" target="_blank">Ver resumen histórico</a>';
          echo form_close();
          echo '<div>';
?>

