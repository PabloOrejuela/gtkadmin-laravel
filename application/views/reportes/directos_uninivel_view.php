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
<div class="row-fluid">
    <div class="col-md-12">
    	<caption><h4>Mis Socios Directos Uninivel: <?php echo '<strong>'.$socio['nombres'].' '.$socio['apellidos'].'</strong>'; ?></h4></caption>
    	<?php
            //var_dump($patrocinados);
    		$num = count($patrocinados);
    		$width = 100/($num+1);
    		$size = 80;
    		echo '<table class="table_middle" style="width:auto">';
    		echo '<tr><td colspan="'.$num.'" style="width:50px;text-align:center;" class="td" id="'.$socio['id'].'"><img src="../images/person.png" width="'.$size.'px" id="'.$socio['id'].'">';
            echo '<input type="hidden" id="nombre_'.$socio['id'].'" value="'.$socio['nombres'].'" />';
            echo '<input type="hidden" id="cedula_'.$socio['id'].'" value="'.$socio['cedula'].'" />';
            echo '<input type="hidden" id="cedula_'.$socio['id'].'" value="'.$socio['cedula'].'" />';
            echo '<input type="hidden" id="nivel_'.$socio['id'].'" value="'.$socio['rango'].'" />';
            echo '</td></tr><tr>';
    		if ($patrocinados != 0 && $patrocinados != NULL) {
                foreach ($patrocinados as $key => $value) {
                    echo '<td style="width:50px;" id="id_'.$value->idcod_socio.'" class="td">
                        <img src="../images/person_blue_center.png" width="'.($size-5).'px" id="'.$value->idcod_socio.'">';
                    echo '<input type="hidden" id="nombre_'.$value->idcod_socio.'" value="'.$value->nombres.'" />';
                    echo '<input type="hidden" id="cedula_'.$value->idcod_socio.'" value="'.$value->cedula.'" />';
                    echo '<input type="hidden" id="nivel_'.$value->idcod_socio.'" value="'.$value->rango.'" /></td>';
                }
            }
    		echo '<td style="width:'.$width.'px;text-align:left;"><img src="../images/none_center.png" width="'.$size.'px"></td>';
    		echo '</tr></table>';
    	?>

	</div>
</div>
<div class="pop-div" >
    <div id="pop-title"></div>
    <div id="pop-content"></div>
</div>

