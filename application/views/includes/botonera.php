<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <div class="container-fluid">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" 
          aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <?php
            if ($per['socios'] == 1) {
                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" 
                      id="navbarDarkDropdownMenuLink" role="button" 
                      data-bs-toggle="dropdown" aria-expanded="false">Gestión de Distribuidores </a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-secondary" aria-labelledby="navbarDarkDropdownMenuLink">';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/red_mis_codigos">Mis Códigos</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/red_mis_codigos_directos">Mi Organización</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/bono_constante">Bono constante del mes</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'inicio/formulario_inscripcion_miembro">Inscripción S/N</a></li>';
                        echo '<li><a class="dropdown-item" href="http://www.gtk-ecuador.com">Ir a la web</a></li>';
                echo '</ul></li>';
            }

            if ($per['reportes'] == 1 && $per['administracion'] == 1) {
                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" 
                    id="navbarDarkDropdownMenuLink" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">Reportes</a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-secondary" aria-labelledby="navbarDarkDropdownMenuLink">';

                      if ($per['administracion'] == 1) {

                        //echo '<li><a class="dropdown-item" href="'.base_url().'reportes/socios">Reporte de Comisiones por socio</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/lista_codigos">Lista de códigos</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/reporte_inactivos" target="_blank">Reporte de Actividad</a></li>';
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes/recompras_mes">Reporte de Recompras del mes</a></li>';
                        //echo '<li><a class="dropdown-item" href="'.base_url().'reportes/reportes_ciudad">Reporte de Comisiones por ciudad</a></li>';
                        echo '</ul></li>';
                      }else{
                        echo '<li><a class="dropdown-item" href="'.base_url().'reportes">Reporte de Comisiones Personal</a></li></ul></li>';
                      }
            }
            if ($per['administracion'] == 1) {
                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" 
                    id="navbarDarkDropdownMenuLink" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">Administración</a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-secondary" aria-labelledby="navbarDarkDropdownMenuLink">
                      <li><a class="dropdown-item" href="'.base_url().'compras">Compras por confirmar</a></li>
                      <li><a class="dropdown-item" href="'.base_url().'compras/frm_recompra_binaria_admin">Recomprar (Admin)</a></li>
                      <li><a class="dropdown-item" href="'.base_url().'compras/pago_bono_constante">Pago de bonos constantes</a></li>
                      <li><a class="dropdown-item" href="'.base_url().'testimonios/nuevo_testimonio">Ingreso de Testimonios</a></li>';
                //echo '<li><a class="dropdown-item" href="'.base_url().'respalda/exportarTablas">Exportar DB</a></li>';
                      //<li><a class="dropdown-item" href="'.base_url().'inicio/completa_linea">Añade línea códigos</a></li>';
                      //echo '<li><a class="dropdown-item" href="#">Registro de Pagos</a></li>';
                //echo '<li><a class="dropdown-item" href="'.base_url().'socios/form_elimina_socio">Eliminar socio</a></li>';
                      // echo '<li><a class="dropdown-item" href="'.base_url().'testimonios/editar_testimonio">Editar Testimonio</a></li>';
                echo '</ul></li>';
            }
            if ($per['administracion'] == 1) {
                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" 
                    id="navbarDarkDropdownMenuLink" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">Agenda</a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-secondary" aria-labelledby="navbarDarkDropdownMenuLink">
                      <li><a class="dropdown-item" href="'.base_url().'evento/nuevo_evento">Ingreso de Evento</a></li>
                      <li><a class="dropdown-item" href="'.base_url().'inicio/edita_evento">Edición de Evento</a></li>
                    </ul>
                  </li>';
            }

            echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" 
                    id="navbarDarkDropdownMenuLink" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">Ayuda <strong>?</strong></a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-secondary" aria-labelledby="navbarDarkDropdownMenuLink">
                      <li><a class="dropdown-item" href="https://youtu.be/V5Fe566NNDM" target="_blank">Como inscribir un Nuevo Socio</a></li>
                      <li><a class="dropdown-item" href="https://youtu.be/XdDyKmova00" target="_blank">Como realizar una compra</a></li>
                      <li><a class="dropdown-item" href="https://youtu.be/jsPwI74P_II" target="_blank">Cómo ingresar al Backoffice</a></li>
                    </ul>
                  </li>';


            echo '<li class="nav-item">
                    <a href="'.base_url().'inicio/logout" class="nav-link submit" onclick="" >Salir</a>
                  </li>';
        ?>
      </ul>
    </div>
  </div>
</nav>

