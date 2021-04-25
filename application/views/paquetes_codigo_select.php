<?php
    foreach($paquetes as $i => $dato){
        echo '<option value="'.$dato['idpaquete'].'">';
        echo '$ '.$dato['paquete'];
        echo '</option>';
    }
?>