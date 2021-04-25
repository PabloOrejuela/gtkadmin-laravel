<?php
    foreach($ciudades as $i => $dato){
        echo '<option value="'.$dato['idciudad'].'">';
        echo $dato['ciudad'];
        echo '</option>';
    }
?>