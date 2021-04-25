<?php
    foreach($socios as $i => $dato){
        echo '<option value="'.$dato['idcodigo_socio_binario'].'">';
        echo $dato['codigo_socio_binario'].' : '.$dato['nombres'].' '.$dato['apellidos'];
        echo '</option>';
    }
?>