<script type="text/javascript">
	$(function() {
		$('i.td_miembro').popover({
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
		$('i.td_miembro').mouseover(function(event) {
			var filas_col = $(this).attr('id');
			var nombre =  $('#nombre_'+filas_col).val();
			var nivel =  $('#nivel_'+filas_col).val();
			var cedula =  $('#cedula_'+filas_col).val();
            $("#pop-title").html('<strong>Nombre:</strong> '+nombre);
            $("#pop-content").html('<strong>Paquete:</strong> '+nivel+''+'<br><strong>Cedula:</strong> '+cedula);
            $(this).popover('show');
		});
	})
</script>

<div class="row-fluid">
    <div class="col-md-12">
    	<caption><h5>Mi Red Binaria: <?php echo '<strong>'.$nombre_socio.'</strong>'; ?></h5></caption>
		
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

				foreach ($mis_frontales as $key => $value) {
					echo $miembros[$key]['idsocio'] = $value->idsocio.'<br>' ;
					if ($miembros[$key]['idsocio'] != $idsocio) {
						$hijos = $miembros[$key]['idsocio'];
					}
					
					$miembros[$key]['nombres'] = $value->nombres ;
					$miembros[$key]['cedula'] = $value->cedula ;
					$miembros[$key]['fecha_nacimiento']=$value->fecha_nacimiento ;
					$miembros[$key]['codigo_socio']=$value->codigo_socio ;
					$miembros[$key]['patrocinador']=$value->patrocinador ;
					$miembros[$key]['direccion']=$value->direccion ;
					$miembros[$key]['apellidos']=$value->apellidos ;
					$miembros[$key]['telf_casa']=$value->telf_casa ;
					$miembros[$key]['celular']=$value->celular ;
					$miembros[$key]['email']=$value->email ;
					$miembros[$key]['fecha_inscripcion']=$value->fecha_inscripcion ;
					$miembros[$key]['posicion']=$value->posicion ;
				}
			
				$cont =0;
				$tam =  80;
				$table = '';
				$color = 'black';				
				for ($i=0; $i < $ultima_fila ; $i++) { 
					$table .= '<table class="table_middle"><tr>';
					//echo $valor_span[$i];
					for ($j=0; $j < (pow(2,$i)); $j++) {
						if (isset($miembros[$cont]['nombres'])) {
							$table .= '<td class="td_miembro" colspan="'.$valor_span[$i].'">';
							if ($cont>=($posicion_max+2)) {
								$i = $nivel+1;
								break;
							}
							if ($cont == 0) {
								$color = '';
							}else{
								$color = 'black';
							}
							$table .= '<div class="div_afiliado">
					  			<i class="fa fa-user td_miembro" aria-hidden="true" id="'.$i.'_'.$j.'" style="font-size: '.($tam).'px;color:'.$color.'"></i><br>'.($cont+1).'</div>';
					  			/*Campos adicionales*/
					  			$table .= '<input type="hidden" id="nombre_'.$i.'_'.$j.'" value="'.$miembros[$cont]['nombres'].' '.$miembros[$cont]['apellidos'].'" />';
					  			$table .= '<input type="hidden" id="nivel_'.$i.'_'.$j.'" value="'.$miembros[$cont]['posicion'].'" />';
					  			$table .= '<input type="hidden" id="cedula_'.$i.'_'.$j.'" value="'.$miembros[$cont]['cedula'].'" />';			
							$cont++;
							$table .= '</td>';
						}
						foreach ($hijos as $key => $value) {
							echo $value;		
						}	
					}
					$tam -= 10;
				}
				$rest = 15 - $cont;

				$table .= '</tr></table>';
				echo $table;
			?>
	</div>	
</div>

<div class="pop-div" >
    <div id="pop-title"></div>
    <div id="pop-content"></div>
</div>


