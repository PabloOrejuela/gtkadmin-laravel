<div class="row-fluid" id="contenido">
    <div class="container-fluid" id="contenido">
        <div class="col-md-12" id="contenido">
            <h1>Niveles de acceso</h1>
            <?php echo form_open('acl/cambiar_permisos');?>
                <table class="table table-bordered">
                    <tr id="tabla_permisos">
                        <td id="tabla_permisos_iz" width="120px" style="font-weight:bold;">Permisos</td>
                        <td id="tabla_permisos" style="font-weight:bold;">SUPERADMIN</td>
                        <td id="tabla_permisos" style="font-weight:bold;">SOCIO</td>
                    </tr>
                    <?php
                        $permisos = array('Administracion','Inicio','Reportes','Socios');

                        for ($i = 1; $i <=4 ; $i++) {

                            echo '<tr id="tabla_permisos">
                                        <td id="tabla_permisos">'.$permisos[$i-1].'</td>
                                        <td id="tabla_permisos">'.form_checkbox('superadmin'.$i, 1, $superadmin[$i]).'</td>
                                        <td id="tabla_permisos">'.form_checkbox('socio'.$i, 1, $socio[$i]).'</td>
                                    </tr>';
                        }
                    ?>
                </table>
            <?php echo form_submit('submit', 'Guardar');?>
            <?php echo form_close();?>
        </div>
    </div>
</div>