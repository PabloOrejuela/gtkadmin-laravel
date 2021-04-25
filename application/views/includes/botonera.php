<nav class="navbar" id="botonera">
  <div class="container-fluid">
    <div class="" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
              // echo '<li>
              //     <a href="'.base_url().'inicio/validate_credentials#no-back-button" role="button" aria-haspopup="true" aria-expanded="false">Inicio</a>
              //   </li>';
            if ($per['socios'] == 1) {
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestión de Distribuidores<span class="caret"></span></a>
                    <ul class="dropdown-menu">';
                        echo '<li><a href="'.base_url().'reportes/red_mis_codigos">Mis Códigos</a></li>';
                        echo '<li><a href="'.base_url().'reportes/red_mis_codigos_directos">Mi Organización</a></li>';
                        echo '<li><a href="'.base_url().'reportes/bono_constante">Bono constante del mes</a></li>';
                        echo '<li><a href="'.base_url().'inicio/formulario_inscripcion_miembro">Inscripción S/N</a></li>';
                        // echo '<li><a href="'.base_url().'compras/recompras">Comprar</a></li>';
                        echo '<li><a href="http://www.gtk-ecuador.com">Ir a la web</a></li>';
                echo '</ul></li>';
            }
            if ($per['socios'] == 1) {
              echo '<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compras<span class="caret"></span></a>
                  <ul class="dropdown-menu">';
                      echo '<li><a href="'.base_url().'compras/recompras">Comprar producto</a></li>';
              echo '</ul></li>';
          }
            if ($per['reportes'] == 1 && $per['administracion'] == 1) {
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes<span class="caret"></span></a>
                    <ul class="dropdown-menu">';

                      if ($per['administracion'] == 1) {

                        //echo '<li><a href="'.base_url().'reportes/socios">Reporte de Comisiones por socio</a></li>';
                        echo '<li><a href="'.base_url().'reportes/lista_codigos">Lista de códigos</a></li>';
                        echo '<li><a href="'.base_url().'reportes/reporte_inactivos" target="_blank">Reporte de Actividad</a></li>';
                        echo '<li><a href="'.base_url().'reportes/recompras_mes">Reporte de Recompras del mes</a></li>';
                        //echo '<li><a href="'.base_url().'reportes/reportes_ciudad">Reporte de Comisiones por ciudad</a></li>';
                        echo '</ul></li>';
                      }else{
                        echo '<li><a href="'.base_url().'reportes">Reporte de Comisiones Personal</a></li></ul></li>';
                      }
            }
            if ($per['administracion'] == 1) {
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="'.base_url().'compras">Compras por confirmar</a></li>
                      <li><a href="'.base_url().'compras/frm_recompra_binaria_admin">Recomprar (Admin)</a></li>
                      <li><a href="'.base_url().'compras/pago_bono_constante">Pago de bonos constantes</a></li>
                      <li><a href="'.base_url().'testimonios/nuevo_testimonio">Ingreso de Testimonios</a></li>
                      <li><a href="'.base_url().'respalda/exportarTablas">Exportar DB</a></li>';
                      //<li><a href="'.base_url().'inicio/completa_linea">Añade línea códigos</a></li>';
                      //echo '<li><a href="#">Registro de Pagos</a></li>';
                echo '<li><a href="'.base_url().'socios/form_elimina_socio">Eliminar socio</a></li>';
                      // echo '<li><a href="'.base_url().'testimonios/editar_testimonio">Editar Testimonio</a></li>';
                echo '</ul></li>';
            }
            if ($per['administracion'] == 1) {
                echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Agenda<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="'.base_url().'evento/nuevo_evento">Ingreso de Evento</a></li>
                      <li><a href="'.base_url().'inicio/edita_evento">Edición de Evento</a></li>
                    </ul>
                  </li>';
            }

            echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >Ayuda <strong>?</strong><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="https://youtu.be/V5Fe566NNDM" target="_blank">Como inscribir un Nuevo Socio</a></li>
                      <li><a href="https://youtu.be/XdDyKmova00" target="_blank">Como realizar una compra</a></li>
                      <li><a href="https://youtu.be/jsPwI74P_II" target="_blank">Cómo ingresar al Backoffice</a></li>
                    </ul>
                  </li>';


            echo '<li class="dropdown">
                    <a href="'.base_url().'inicio/logout" class="dropdown-toggle submit" onclick="" >Salir</a>
                  </li>';
        ?>
      </ul>
    </div>
  </div>
</nav>
