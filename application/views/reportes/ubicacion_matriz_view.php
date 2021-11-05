<style type="text/css">
	td{
		padding: 0px;
		margin-bottom: 0px;
	}
    #td_miembro{
        height:50%;
    }
</style>
<script type="text/javascript">
    $(function() {
        $('img.socios_piramide').popover({
            html: true,
            placement: "right",
            trigger: "hover",
            title: function () {
                return $("#pop-title").html();
            },
            content: function () {
                return $("#pop-content").html();
            }
        });
        $('img.socios_piramide').mouseover(function(event) {
            var filas_col = $(this).attr('id');
            var nombre =  $('#nombre_'+filas_col).val();
            var apellidos =  $('#apellidos_'+filas_col).val();
            var nivel =  $('#nivel_'+filas_col).val();
            var cedula =  $('#cedula_'+filas_col).val();
            var ubicacion =  $('#id_'+filas_col).val();
            var codigo_socio =  $('#codigo_socio_'+filas_col).val();
            var patrocinador =  $('#nombre_patrocinador_'+filas_col).val();
            var paquete =  $('#paquete_'+filas_col).val();
            var id =  $('#id_'+filas_col).val();
            $("#pop-title").html('<strong>Nombre:</strong> '+nombre+" "+apellidos);
            $("#pop-content").html('<strong>Nivel:</strong> '+nivel+''
                +'<br><strong>Cedula:</strong> '+cedula
                +'<br><strong>Codigo:</strong> '+codigo_socio
                +'<br><strong>Patrocinador:</strong> '+patrocinador
                //+'<br><strong>Estado:</strong> '+ 'ACTIVO'
                +'<br><strong>Paquete: $</strong> '+paquete
                +'<br><strong>Ubicación: </strong> '+ubicacion
                );
            $(this).popover('show');
        });
    })
</script>

<div class="row-fluid" id="table_datos">
    <div class="col-md-12" style="margin-bottom: 200px;">
    	<caption><h5>Mi Red Binaria: <?php echo '<strong>'.$nombre_socio.'</strong>'; ?></h5></caption>
    	<table class="table table-bordered" style="font-size: 0.8em;width: 200px;">
            <tr>
                <td style="width: 40px;background: #FFFFFF;color:#000000;font-family: Arial">Disponible</td>
                <td style="width: 40px;background: #9D9D9D;color:#FFFFFF;font-family: Arial">Inactivo</td>
                <td style="width: 40px;background: #8fd2ca;color:#FFFFFF;font-family: Arial">Paquete $85</td>
                <td style="width: 40px;background: #6a94b7;color:#FFFFFF;font-family: Arial">Paquete $112</td>
                <td style="width: 40px;background: #004075;color:#FFFFFF;font-family: Arial">Paquete $200</td>
                <td style="width: 40px;background: #a67cc5;color:#FFFFFF;font-family: Arial">Paquete $300</td>
                <td style="width: 40px;background: #ff8a00;color:#FFFFFF;font-family: Arial">Paquete $500</td>
                <td style="width: 40px;background: #22C61A;color:#FFFFFF;font-family: Arial">Paquete $1000</td>
            </tr>
    	</table>

        <table class="table table-bordered" style="font-size: 0.8em;width: 90px;position: fixed;top: 150px; right: 10px;float: right;">
            <tr>
                <td style="width: 20px;text-align: center;background-color:#4E5936;color: #FFFFFF;padding-top: 2px;padding-bottom: 2px;"><h5>Navegación:</h5></td>
            <tr>
                <td style="width: 20px;text-align: center;"><?php echo anchor("reportes/mi_red_binaria_nav/".$_SESSION['nodo_inicio'], 'Mi red', 'Mi red'); ?></td>
            </tr>
            <tr>
                <td style="width: 20px;text-align: center;"><?php echo anchor("reportes/mi_red_binaria_nav/".$_SESSION['nodo_atras'], 'Anterior', 'Mi red'); ?></td>
            </tr>
        </table>
        <?php
            $valor_span = array(
                '0' => 0,
                '1' => 2,
                '2' => 4,
                '3' => 8,
                '4' => 16,
                '5' => 32,
                '6' => 64,
                '7' => 128,
                '8' => 256,
                '9' => 512,
                '10' => 1024,
                '11' => 2048,
                '12' => 4096,
                '13' => 8192
            );
            foreach ($socios as $key => $value) {
                $miembros[$key]['idsocio'] = $value->idcodigo_socio_binario ;
                $miembros[$key]['nombres'] = $value->nombres ;
                $miembros[$key]['cedula'] = $value->cedula ;
                $miembros[$key]['codigo_socio']=$value->codigo_socio_binario ;
                $miembros[$key]['patrocinador']=$value->patrocinador ;
                $miembros[$key]['direccion']=$value->direccion ;
                $miembros[$key]['apellidos']=$value->apellidos ;
                $miembros[$key]['rango']=$value->rango;
                $miembros[$key]['rama']=$value->rama;
            }

            //Cambiar esto para que me de el último socio que no sea UNDEFINED
            //$posicion_max = $this->procesos_model->_get_last_valid_id();
            $posicion_max = 512;//(count($socios)*2)+1;

            $cont =0;
            if ($posicion_max >=0 && $posicion_max <= pow(2,0)) {
                    $fila = 1;
            }else if($posicion_max >=pow(2,0) && $posicion_max <= pow(2,1)){
                    $fila = 2;
            }else if($posicion_max >=pow(2,1) && $posicion_max <= pow(2,2)){
                    $fila = 3;
            }else if($posicion_max >=pow(2,2) && $posicion_max <= pow(2,3)){
                    $fila = 4;
                    $falta =  pow(2,3) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,3) && $posicion_max <= pow(2,4)){
                    $fila = 5;
                    $falta =  pow(2,4) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,4) && $posicion_max <= pow(2,5)){
                    $fila = 6;
                    $falta =  pow(2,5) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,5) && $posicion_max <= pow(2,6)){
                    $fila = 7;
                    $falta =  pow(2,6) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,6) && $posicion_max <= pow(2,7)){
                    $fila = 8;
                    $falta =  pow(2,7) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,7) && $posicion_max <= pow(2,8)){
                    $fila = 9;
                    $falta =  pow(2,8) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,8) && $posicion_max <= pow(2,9)){
                    $fila = 10;
                    $falta =  pow(2,9) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,9) && $posicion_max <= pow(2,10)){
                    $fila = 11;
                    $falta =  pow(2,10) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,10) && $posicion_max <= pow(2,11)){
                    $fila = 12;
                    $falta =  pow(2,11) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,11) && $posicion_max <= pow(2,12)){
                    $fila = 13;
                    $falta =  pow(2,12) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,12) && $posicion_max <= pow(2,13)){
                    $fila = 14;
                    $falta =  pow(2,13) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }else if($posicion_max >=pow(2,13) && $posicion_max <= pow(2,14)){
                    $fila = 15;
                    $falta =  pow(2,14) - $posicion_max;
                    $posicion_max = $posicion_max + $falta-1;
            }

            $nivel = $fila-4;

            $tam = 70;
            $table = '';
            $color = '';
            $width = 1080;
            $final_td = pow(2,$nivel);
			$ultimo_paquete = $this->procesos_model->_get_ultimo_paquete_codigo_binario($miembros[$cont]['idsocio']);
			
            for ($i=0; $i < $nivel ; $i++) {
                $num = pow(2, $i);
                $table .= '<table class="table_middle"><tr>';
                //echo $valor_span[$i];
                for ($j=0; $j < (pow(2,$i)); $j++) {

                    if (isset($miembros[$cont]['nombres'])) {
                        $table .= '<td class="td_miembro" colspan="'.$valor_span[$i].'" width="'.$width.'px">';
                        if ($cont >= ($posicion_max)) {
                            break;
                        }
                        // if ($miembros[$cont]['idsocio']==$this->session->userdata('id')) {
                        //     $color = 'color: red;';
                        // }
                        if ($miembros[$cont]['idsocio']==$idsocio) {
                            $paquete =  $this->procesos_model->_get_paquete_codigo_binario($miembros[$cont]['idsocio']);
                            $nombre_patrocinador = $this->procesos_model->_get_nombre_id_socio_binario($miembros[$cont]['patrocinador']);
							$ultimo_paquete =  $paquete;
                            

                            //Primero en la pirámide
                            if ($ultimo_paquete == 0) {
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_none.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 1){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 2){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_orange.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 3){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_green.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 4){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_300.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 5){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_85.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }else if($ultimo_paquete == 6){
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_112.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }
                            else{
                                $table .= '<div class="div_afiliado">
                                <img src="'.base_url().'/images/persons/person_none.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                            }
                            
                            /*Campos adicionales*/
                            if ($ultimo_paquete == 1) {
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="200" />';
                            }else if($ultimo_paquete == 2){
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="500" />';
                            }else if($ultimo_paquete == 3){
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="1000" />';
                            }else if($ultimo_paquete == 4){
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="300" />';
                            }else if($ultimo_paquete == 5){
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="85" />';
                            }else if($ultimo_paquete == 6){
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="112" />';
                            }
                            $table .= '<input type="hidden" id="nombre_'.$i.'_'.$j.'" value="'.$miembros[$cont]['nombres'].'" />';
                            $table .= '<input type="hidden" id="apellidos_'.$i.'_'.$j.'" value="'.$miembros[$cont]['apellidos'].'" />';
                            $table .= '<input type="hidden" id="nivel_'.$i.'_'.$j.'" value="'.$miembros[$cont]['rango'].'" />';
                            $table .= '<input type="hidden" id="cedula_'.$i.'_'.$j.'" value="'.$miembros[$cont]['cedula'].'" />';
                            $table .= '<input type="hidden" id="id_'.$i.'_'.$j.'" value="'.$miembros[$cont]['idsocio'].'" />';
                            $table .= '<input type="hidden" id="estado_'.$i.'_'.$j.'" value="'.$miembros[$cont]['idsocio'].'" />';
                            $table .= '<input type="hidden" id="patrocinador_'.$i.'_'.$j.'" value="'.$miembros[$cont]['patrocinador'].'" />';
                            $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="'.$paquete.'" />';
                            $table .= '<input type="hidden" id="codigo_socio_'.$i.'_'.$j.'" value="'.$miembros[$cont]['codigo_socio'].'" />';

                        }else{
                            if ($cont == 0) {
                                //Primero en la pirámide
                                $paquete =  $this->procesos_model->_get_paquete_codigo_binario($miembros[$cont]['idsocio']);
                                $nombre_patrocinador = $this->procesos_model->_get_nombre_id_socio_binario($miembros[$cont]['patrocinador']);
                                
								
                                if ($ultimo_paquete == 0) {
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person-gris.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 1){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 2){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person_orange.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 3){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person_green.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 4){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person_300.png" class="socios_piramide" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 5){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person_85.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else if($ultimo_paquete == 6){
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/person_112.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }else{
                                    $table .= '<div class="div_afiliado">
                                    <img src="'.base_url().'/images/persons/none_center.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">';
                                }


                                if ($ultimo_paquete == 1) {
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="200" />';
                                }else if($ultimo_paquete == 2){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="500" />';
                                }else if($ultimo_paquete == 3){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="1000" />';
                                }else if($ultimo_paquete == 4){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="300" />';
                                }else if($ultimo_paquete == 5){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="85" />';
                                }else if($ultimo_paquete == 6){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="112" />';
                                }

                                $table .= '<input type="hidden" id="nivel_'.$i.'_'.$j.'" value="'.$miembros[$cont]['rango'].'" />';
                                $table .= '<input type="hidden" id="cedula_'.$i.'_'.$j.'" value="'.$miembros[$cont]['cedula'].'" />';
                                $table .= '<input type="hidden" id="codigo_socio_'.$i.'_'.$j.'" value="'.$miembros[$cont]['codigo_socio'].'" />';
                                $table .= '<input type="hidden" id="nombre_'.$i.'_'.$j.'" value="'.$miembros[$cont]['nombres'].'" />';
                                $table .= '<input type="hidden" id="apellidos_'.$i.'_'.$j.'" value="'.$miembros[$cont]['apellidos'].'" />';
                                $table .= '<input type="hidden" id="id_'.$i.'_'.$j.'" value="'.$miembros[$cont]['idsocio'].'" />';
                                $table .= '<input type="hidden" id="patrocinador_'.$i.'_'.$j.'" value="'.$miembros[$cont]['patrocinador'].'" />';
                                $table .= '<input type="hidden" id="nombre_patrocinador_'.$i.'_'.$j.'" value="'.$nombre_patrocinador.'" />';
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="'.$paquete.'" />';
                            }else{
                                //RESTO DE LA PRAMIDE
                                $paquete = $this->procesos_model->_get_paquete_codigo_binario($miembros[$cont]['idsocio']);
                                
                                $ultimo_paquete =  $this->procesos_model->_get_ultimo_paquete_codigo_binario($miembros[$cont]['idsocio']);
                                if ($ultimo_paquete == 0) {
                                    $ultimo_paquete = $paquete;
                                }
                                $nombre_patrocinador = $this->procesos_model->_get_nombre_id_socio_binario($miembros[$cont]['patrocinador']);
                                $idcodigo_socio_binario = $miembros[$cont]['idsocio'];
                               
                                // echo $miembros[$cont]['nombres'].' = '.$paquete. ' - ' .$miembros[$cont]['rango'] . '<br>';
                                if ($miembros[$cont]['rama'] == 1) {
                                    if ($miembros[$cont]['nombres'] == 'UNDEFINED' && $ultimo_paquete == 0) {
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/empty_left.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 1){
                                         $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_blue_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 2){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_orange_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 3){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_green_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 4){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_300_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 5){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_85_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 6){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_112_left.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else{
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/none_left.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }

                                }else{
                                    if ($miembros[$cont]['nombres'] == 'UNDEFINED' && $ultimo_paquete == 0) {
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/empty_right.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 1){
                                         $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_blue_right.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 2){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_orange_right.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 3){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_green_right.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 4){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_300_right.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else if($miembros[$cont]['nombres'] != 'UNDEFINED' && $ultimo_paquete == 5){
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/person_85_right.png" class="socios_piramide"  width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }else{
                                        $table .= '<div class="div_afiliado">'.anchor("reportes/mi_red_binaria_nav/$idcodigo_socio_binario", '<img src="'.base_url().'/images/none_right.png" class="socios_piramide" width="'.$tam.'px" id="'.$i.'_'.$j.'">', 'title="Navegacion"');
                                    }
                                }
                                /*Campos adicionales*/

                                if ($ultimo_paquete == 1) {
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="200" />';
                                }else if($ultimo_paquete == 2){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="500" />';
                                }else if($ultimo_paquete == 3){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="1000" />';
                                }else if($ultimo_paquete == 4){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="300" />';
                                }else if($ultimo_paquete == 5){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="85" />';
                                }else if($ultimo_paquete == 6){
                                    $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="112" />';
                                }

                                $table .= '<input type="hidden" id="nivel_'.$i.'_'.$j.'" value="'.$miembros[$cont]['rango'].'" />';
                                $table .= '<input type="hidden" id="cedula_'.$i.'_'.$j.'" value="'.$miembros[$cont]['cedula'].'" />';
                                $table .= '<input type="hidden" id="codigo_socio_'.$i.'_'.$j.'" value="'.$miembros[$cont]['codigo_socio'].'" />';
                                $table .= '<input type="hidden" id="id_'.$i.'_'.$j.'" value="'.$miembros[$cont]['idsocio'].'" />';
                                $table .= '<input type="hidden" id="nombre_'.$i.'_'.$j.'" value="'.$miembros[$cont]['nombres'].'" />';
                                $table .= '<input type="hidden" id="apellidos_'.$i.'_'.$j.'" value="'.$miembros[$cont]['apellidos'].'" />';
                                $table .= '<input type="hidden" id="patrocinador_'.$i.'_'.$j.'" value="'.$miembros[$cont]['patrocinador'].'" />';
                                $table .= '<input type="hidden" id="nombre_patrocinador_'.$i.'_'.$j.'" value="'.$nombre_patrocinador.'" />';
                                $table .= '<input type="hidden" id="paquete_'.$i.'_'.$j.'" value="'.$paquete.'" />';
                            }
                        }
                        $cont++;
                        $table .= '</div></td>';
                        }
                    }
                $tam -= 8;
                $table .= '</tr></table>';
            }

        echo $table;
        ?>
    </div>
</div>

<div class="pop-div" >
    <div id="pop-title"></div>
    <div id="pop-content"></div>
</div>


