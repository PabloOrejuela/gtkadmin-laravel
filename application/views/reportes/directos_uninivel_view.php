<script type="text/javascript">
    $(function() {
        $('img').popover({

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
        $('img').mouseover(function(event) {
            var id = $(this).attr('id');
            var nombre =  $('#nombre_'+id).val();
            var nivel =  $('#nivel_'+id).val();
            var cedula =  $('#cedula_'+id).val();
            //console.log($('#nombre_'+id).val());
            $("#pop-title").html('<strong>Nombre:</strong> '+nombre);
            $("#pop-content").html('<strong>Nivel:</strong> '+nivel+''+'<br><strong>Cedula:</strong> '+cedula);
            $(this).popover('show');
        });
    })
</script>
<div id="table_datos">
    <div class="col-md-12">
    	<caption><h4>Mis Socios Directos Uninivel: <?php echo '<strong>'.$socio['nombres'].' '.$socio['apellidos'].'</strong>'; ?></h4></caption>
    	<?php

    		echo '<table class="table table-bordered " style="width:auto"><tr>';
    		if ($patrocinados != 0 || $patrocinados != NULL) {
				$num = count($patrocinados);
				$width = 100/($num+1);
    			$size = 80;
                foreach ($patrocinados as $key => $value) {
					echo '<td>'.$value->idcod_socio.'</td>';
                    echo '<td>'.$value->nombres.'</td>';
					echo '<td>'.$value->apellidos.'</td>';
					echo '<td>'.$value->cedula.'</td>';
					echo '<td>'.$value->rango.'</td>';
                }
            }else{
				echo '<table class="table_middle" style="width:auto"><tr><td>No tiene distribuidores bajo su red</td></tr>';
			}
    		echo '</tr></table>';
    	?>

	</div>
</div>
<div class="pop-div" >
    <div id="pop-title"></div>
    <div id="pop-content"></div>
</div>

