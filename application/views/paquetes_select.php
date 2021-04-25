<?php
    foreach($paquetes as $i => $dato){
        echo '<option value="'.$dato['idpaquete'].'">';
        echo '$ '.(number_format($dato['paquete'],2));
        echo '</option>';
    }
?>