<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    private $pin = 0;
    private $seccion = 'inicio';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('acl_model');
        $this->load->model('procesos_model');
        $this->load->model('administracion_model');
        $this->load->model('compras_model');
    }

    function index(){
        
        $is_logged = $this->session->userdata('is_logged_in');
        $data['title']='Ingreso al sistema';
        $data['main_content']='inicio/login_view';
        $this->load->view('includes/template_login', $data);
    }

    function exito_registro($data){
        $data['title']='Registro de Socios';
        $data['main_content']='publico/exito_registro_socio';
        $this->load->view('includes/template_login', $data);
    }

    function recuperar_password(){
        $data['message'] = null;
        $data['title']='Recuperar contraseña';
        $data['main_content']='publico/form_recuperar_password';
        $this->load->view('includes/template_login', $data);
    }

    /**
     * Recibe el email del cliente y envía un correo con el password y el código del usuario
     *
     * @param 
     * @return void
     * @throws 
     **/
    public function recupera_password(){
        $data['email'] = $this->input->post('email');
        //$data['cedula'] = $this->input->post('cedula');
        $anio = date('y');

        $datos_usuario = $this->administracion_model->_get_data_usuario($data);
        //pablo Esta función hay que mejorar pues si uno no tiene código Binario devuelve NULL
        if ($datos_usuario[0]) {

            //Nuevo password
            $aleatorio = array('a','b','c','d','e');
            $random = random_int(0, 4);

            $nuevo_password = $datos_usuario->cedula.$anio.$aleatorio[$random];
            $data['cedula'] = $datos_usuario->cedula;
            //Grabar nuevo password
            $this->administracion_model->_set_password($nuevo_password, $data);

            //Enviar email
            $this->email_recuperacion($data, $datos_usuario);
            $data['message'] = 'Un email para recuperar su contraseña ha sido enviado con éxito';

            $data['title']='Recuperar contraseña';
            $data['main_content']='publico/form_recuperar_password';
            $this->load->view('includes/template_login', $data);

        }else{
            $data['message']  = 'El email no está asignado a nigún distribuidor, 
                    por favor contácte a la adminstación de GTK Ecuador';

            $data['title']='Recuperar contraseña';
            $data['main_content']='publico/form_recuperar_password';
            $this->load->view('includes/template_login', $data);
        }
    }

    public function email_recuperacion($data, $datos_usuario){
		
		$this->email->from('desarrollo@appdvp.com', 'Pablo');
		$this->email->to($data['email']);
		
		$this->email->subject('Recuperación de contraseña');
		$this->email->message(
            '<p>Este email ha sido enviado por que ha solicitado recuperar su contraseña y su código</p> 
            <p>Si no ha sido usted quien realizzó el intento de recuperación por favor contacte a la administración de GTK Ecuador</p>
            <br>
            <label>Nueva Contraseña: </label>'.$datos_usuario->clave_socio.'
            <label>Código: </label>'.$datos_usuario->codigo_socio_binario
        );
		
		$this->email->send();
		
		//echo $this->email->print_debugger();
    }
    
    public function email_confirmacion($data, $datos_usuario){
		
		$this->email->from('desarrollo@appdvp.com', 'Pablo');
		$this->email->to($data['email']);
		
		$this->email->subject('Recuperación de contraseña');
		$this->email->message(
            '<p>Este email ha sido enviado por que ha solicitado recuperar su contraseña y su código</p> 
            <p>Si no ha sido usted quien realizzó el intento de recuperación por favor contacte a la administración de GTK Ecuador</p>
            <br>
            <label>Nueva Contraseña: </label>'.$datos_usuario->clave_socio.'
            <label>Código: </label>'.$datos_usuario->codigo_socio_binario
        );
		
		$this->email->send();
		
		//echo $this->email->print_debugger();
	}

    function email_pin($data, $datos_usuario){
		
		$this->email->from('desarrollo@appdvp.com', 'Admin');
		$this->email->to($datos_usuario->email);
		
		$this->email->subject('Código de verificación');
		$this->email->message(
            '<p>Este email ha sido enviado por que ha solicitado ingresar al sistema de Gtk Ecuador</p>
            <br>
            <label>Pin de confirmación: </label>'.$data['pin']
        );
		
		$this->email->send();
		//echo $this->email->print_debugger();
    }

    function form_confirmacion($socio){
        
        $is_logged = $this->session->userdata('is_logged_in');
        $data['socio'] = $socio;
        $data['title']='Ingreso al sistema';
        $data['main_content']='inicio/confirmacion_view';
        $this->load->view('includes/template_login', $data);
    }

    function validate_credentials(){

        $data['user'] = $this->input->post('user');
        $data['password'] = $this->input->post('password');
        $socio = $this->login_model->_validate_credentials($data);
        
        if (isset($socio) && $socio != null) {
            if($socio['idrol'] == 1){

                $datos_usuario = $this->administracion_model->_get_data_usuario_ci($data);
                
                //Creo pin de confirmación
                $inicia = date('Y-m-d H:i:s');
                $data['expira'] = strtotime('+5 minute', strtotime($inicia));
                $this->pin = random_int(100000, 999999);
                $data['pin'] = $this->pin;
                $data['id'] = $socio['idsocio'];

                //guardo en db pin y expiración
                $this->login_model->_set_pin($data);

                //Enviar email y mostrar form de confirmación
                $this->email_pin($data, $datos_usuario);
                $this->form_confirmacion($socio);
                

            }else{
                $permiso = $this->acl_model->_verificaRol($socio, $this->seccion);
                $nombre = $this->acl_model->_get_name($data['user']);
                if ($permiso == 1){
                    $data = array(
                        'user' => $data['user'],
                        'nombre' => $nombre ,
                        'password' => $data['password'],
                        'rol' => $socio['idrol'],
                        'id' => $socio['idsocio'],
                        'is_logged_in' => true
                    );
                    $this->session->set_userdata($data);
                    $this->miembros($this->session->userdata('user'));
                }
                else{
                    $this->index();
                }
            }
            
        }else{
            $this->index();
        }
    }

    function miembros(){
        $rol = $this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');

        if (isset($is_logged) == true || isset($is_logged) == 1) {

            /*REVISO SI YA SE HA REALIZADO LA COMPRA DE LOS PRINCIPALES DE CARLOS*/
            for($i = 1; $i <=8; $i++){
                $r = $this->administracion_model->_get_compras_principales($i);
                $fecha = $this->administracion_model->_get_fecha_inscripcion($i);
                $fecha_inscripcion_dia = date('d', strtotime($fecha));
                $fecha_mes = date('m');
                $data['fecha_recompra'] = '2019-'.$fecha_mes.'-'.$fecha_inscripcion_dia;
                $data['idcodigo_socio_binario'] = $i;
                $data['idpaquete'] = 3;
                
                if ($r == 0) {
                    ## Hago la recompra con paquete de 1000
                    $this->compras_model->_graba_compra_binaria($data);
                    $this->compras_model->_confirmar_compra_binaria_principal($data['idcodigo_socio_binario']);
                }else{
                    $this->compras_model->_confirmar_compra_binaria_principal($data['idcodigo_socio_binario']);
                }
            }
            
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='inicio/inicio_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }


    /**
     * Recibe el pin de usuario admin, lo comprueba y accede
     *
     * @param Type int
     * @return type void
     * @author conditon
     * @date 19-07-2021
     **/

    public function miembro_admin(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');

        //Recibo el pin
        $pin = $this->input->post('pin');
        $socio = $this->input->post('socio');
        
        //Verifico que no haya caducado
		if (isset($socio) && $socio != NULL) {
			$estado = $this->login_model->_verifica_pin($pin, $socio['idsocio']);
		}
        
        if (!$pin || $estado === 0) {
            $this->form_confirmacion($socio);
        }else{
            $permiso = $this->acl_model->_verificaRol($socio, $this->seccion);
            $nombre = $socio['nombres'].' '.$socio['apellidos'];
            if ($permiso == 1){
                $data = array(
                    'user' => $socio['cedula'],
                    'nombre' => $nombre ,
                    'password' => $socio['clave_socio'],
                    'rol' => $socio['idrol'],
                    'id' => $socio['idsocio'],
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                $this->miembros();
            }
            else{
                $this->index();
            }
        }
        
    }


    function actividad_usuario(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='inicio/elige_socio_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    function lista_socios(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['version'] = $this->config->item('system_version');
            $data['matrices'] = $this->administracion_model->_get_matrices();
            $data['provincias'] = $this->administracion_model->_get_provincias();
            $data['ciudades'] = $this->administracion_model->_get_ciudades();

            $data['title']='GTK Admin';
            $data['main_content']='lista_socios_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->miembros();
        }
    }

    function lista_socios_matriz(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['matriz'] = $this->input->post('matriz');
            $data['id_provincia'] = $this->input->post('id_provincia');
            $data['id_ciudad'] = $this->input->post('id_ciudad');

            $data['socios'] = $this->administracion_model->_obten_socios($data);
            if (isset($data['socios']) && $data['socios'] != null) {
                foreach ($data['socios'] as $d) {
                    $data['patrocinador'] = $this->administracion_model->_obten_patrocinador($d['patrocinador']);
                }
            }else{
                $data['socios'] = 0;
            }

            $data['title']='GTK Admin';
            $data['main_content']='ver_lista_socios_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->lista_socios();
        }
    }

    /**
     * Función para registrar un nuevo usuario sin ingresar al sistema
     *
     * Sirve para cuando alguien desea realizar una inscripción pero no 
     * pertenece ala organización o no se acuerda su código
     * 
     * @param Type 
     * @return type void
     * @throws conditon
     * Creado por Pablo Orejuela
     **/
    public function form_nuevo_distribuidor_externo(){
        $data['provincias'] = $this->administracion_model->_get_provincias();
        $data['ciudades'] = $this->administracion_model->_get_ciudades();
        $data['bancos'] = $this->administracion_model->_get_bancos();
        $data['matrices'] = $this->procesos_model->_get_matrices();
        $data['title']='GTK Admin';
        $data['main_content']='inicio/form_nuevo_distribuidor_externo_view';
        $this->load->view('includes/template_publico', $data);
    }

    function logout(){
        $this->session->set_userdata('is_logged_in', false);
        $this->session->unset_userdata('nombre');
        $this->session->unset_userdata('password');
        $this->session->sess_destroy();
        $this->index();
    }

    function ciudades_select(){
        $provincia = $this->input->post('id_provincia');
        $datos['ciudades'] = $this->administracion_model->_obtenCiudad($provincia);
        $this->load->view('ciudades_select',$datos);
    }

    function paquetes_select(){
        $idmatrices = $this->input->post('idmatrices');
        $datos['paquetes'] = $this->administracion_model->_obten_paquetes($idmatrices);
        $this->load->view('paquetes_select',$datos);
    }

    function mi_red_select(){
        //Trae la red del usuario para llenar combo y ubicar nuevo miembro
        $patrocinador = $this->input->post('patrocinador');
        $datos['socios'] = $this->administracion_model->_obten_red($patrocinador);
        $this->load->view('socios_select',$datos);
    }

    function paquetes_codigo_select(){
        $idcod_socio = $this->input->post('idcod_socio');
        $idmatriz = 2;
        $datos['paquetes'] = $this->administracion_model->_obten_paquetes($idmatriz);
        $this->load->view('paquetes_codigo_select',$datos);
    }


    function formulario_inscripcion(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');

        if (true) {
            
            $data['provincias'] = $this->administracion_model->_get_provincias();
            $data['ciudades'] = $this->administracion_model->_get_ciudades();
            $data['bancos'] = $this->administracion_model->_get_bancos();
            $data['matrices'] = $this->procesos_model->_get_matrices();

            $data['title'] ='GTK Admin';
            $data['main_content'] ='inicio/form_inscripcion_view';
            $this->load->view('includes/template_publico', $data);
        }
        else{
            $this->session->sess_destroy();
            echo $this->index();
        }
    }

    function formulario_inscripcion_miembro(){

        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        $data['result'] = 0;
        if (isset($is_logged) || $is_logged == true || isset($is_logged) == 1 || $is_logged != false || $is_logged != 0) {
            $data['idcodigo_binario'] = $this->administracion_model->_get_codigo_binario_by_cedula($this->session->userdata('user'));
			$data['idcodigo_uninivel'] = $this->administracion_model->_get_codigo_uninivel_by_cedula($this->session->userdata('user'));
            //$red =  $this->administracion_model->_arma_red_binaria($data['idcodigo_socio_binario']);
			// var_dump($data['idcodigo_uninivel']);
            $data['provincias'] = $this->administracion_model->_get_provincias();
            $data['ciudades'] = $this->administracion_model->_get_ciudades();
            $data['bancos'] = $this->administracion_model->_get_bancos();
            $data['matrices'] = $this->procesos_model->_get_matrices();
            $data['title'] ='GTK Admin';
            $data['main_content'] ='inicio/form_inscrip_miembro2_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->session->sess_destroy();
            echo $this->index();
        }
    }

    function get_ciudades_ajax(){
        $data['id_provincia'] = $this->input->post('id_provincia');
        $data['ciudades'] = $this->administracion_model->get_ciudades($data['id_provincia']);
        echo json_encode($data['ciudades']);
    }

    function suggestions_patrocinador(){
        $term = $this->input->post('term',TRUE);

        if (strlen($term) < 1){
            exit;
        }else{

            $rows = $this->procesos_model->GetAutocomplete_patrocinadores(array('keyword' => $term));

            $json_array = array();
            foreach ($rows as $row)
                    array_push($json_array, $row->cedula);

            echo json_encode($json_array);
        }
    }

    function get_socio_by_cedula_ajax(){
         $cedula = $this->input->post('ced');
         $socio = $this->administracion_model->_get_array_socio_by_cedula($cedula);
         $cuenta = $this->administracion_model->_get_primera_cuenta_socio($socio['id']);
         if ($socio!='0') {
             return json_encode($socio).'<sep>'.json_encode($cuenta);
         }else{
            return 0;
         }

    }

    function get_socio_by_criterio_ajax(){

         $criterio = $this->input->post('criterio');
         $socio = $this->administracion_model->_get_array_socio_by_criterio($criterio);
         if ($socio!='0') {
             echo json_encode($socio);
         }else{
            echo '0';
         }
    }

    /**
      * Registro de usuarios normal
      *
      * @return void
      * @author Pablo Orejuela
      * @revisión: 15-12-2021
      **/
    function recibe_datos_frm_registro(){

        //$this->form_validation->set_rules('cedula', 'Cédula', 'is_unique[socios.cedula]');
        $this->form_validation->set_rules('ubicacion', 'Ubicación', 'required');
        $this->form_validation->set_message('is_unique', '<span style="color:red;font-weight:bold;font-size:1.2em;">ERROR: Ya existe un distribuidor registrado con este número de cédula</span>');
        $this->form_validation->set_message('required', '<span style="color:red;font-weight:bold;font-size:1.2em;">ERROR: Este campo es obligatorio</span>');
        if ($this->form_validation->run() == FALSE){
			$this->formulario_inscripcion_miembro();
        }else{

			//Creo el código uninivel del patrocinador si es que no lo tiene
            $data['idmatrices'] = $this->input->post('idmatrices');
			//Establesco el rango dependiendo de la matriz
            $data['idrango'] = 1;

			if ($data['idmatrices'] == 3) {
				//Patrocinador UNINIVEL
				$data['patrocinador_uninivel'] =  $this->input->post('patrocinador_uninivel');
				if (!isset($data['patrocinador_uninivel']) || $data['patrocinador_uninivel'] == NULL || $data['patrocinador_uninivel'] == '') {
					//El Patrocinador no tiene código binario asi que le creamos uno
					$data['socio'] = $this->administracion_model->_get_array_socio_by_cedula($this->session->userdata('user'));
					$data['nombres'] = $data['socio']['nombres'];
					$data['apellidos'] = $data['socio']['apellidos'];
					$data['patrocinador'] = 1;
					$data['idsocio'] = $data['socio']['id'];
					$data['cod_provincia'] = $this->administracion_model->_get_cod_provincia($data['socio']['idprovincia']);
					$data['ubicacion'] = $this->administracion_model->_get_last_id('codigo_socio') + 1;
					$data['cod_socio'] = $this->administracion_model->_calcula_codigo($data);
					$data['patrocinador_uninivel'] = $this->administracion_model->_inserta_codigo($data);
				}

			}

            $data['nombres'] = strtoupper($this->input->post('nombres'));
            $data['apellidos'] = strtoupper($this->input->post('apellidos'));
            $data['cedula'] = $this->input->post('cedula');
            $data['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
            $originalDate = $data['fecha_nacimiento'];
            $data['fecha_nacimiento'] = date("Y-m-d", strtotime($originalDate));

            $data['direccion'] = strtoupper($this->input->post('direccion'));
            $data['idciudad'] = $this->input->post('ciudad');
            $data['idprovincia'] = $this->input->post('id_provincia');
            $data['idoperadora'] = $this->input->post('operadora');
            if ($data['idoperadora'] == NULL) {
                $data['idoperadora'] = 0;
            }
            $data['telf_casa'] = $this->input->post('telf_casa');
            $data['celular'] = $this->input->post('celular');
            $data['email'] = $this->input->post('email');
            $data['idrol'] = 2; //Rol de socio normal

            //info banco
            //PABLO: 15-12-2021 hacer un if en caso de que llegue vacío
			//PABLO: 15-12-2021 hacer verifique si ya existe el usuario y borrar todo el javascript que está de mas

            $data['num_cta'] = '000000000'; //$this->input->post('num_cta');
            $data['idtipo_cuenta'] = 1; //$this->input->post('tipo_cuenta');
            $data['idbanco'] = 163;  //$this->input->post('banco');

            //Patrocinador Binario
            $data['patrocinador'] =  $this->input->post('patrocinador');
            

            $data['idpaquete'] = $this->input->post('paquetes');
            $data['formulario_id'] = $this->input->post('formulario_id');

            //Ubicación red binaria
            $data['ubicacion'] = $this->input->post('ubicacion');


            //verifica si ya existe el socio
            $data['socio'] = $this->administracion_model->_get_array_socio_by_cedula($data['cedula']);
            $data['cod_provincia'] = $this->administracion_model->_get_cod_provincia($data['idprovincia']);
            $data['cod_socio'] = $this->administracion_model->_calcula_codigo($data);

            $data['filas'] = 0;

            if ($data['socio']['id'] == null || $data['socio']['id']==0){
                $data['filas'] = $this->administracion_model->_registrar_socio($data);
            }

            
            //creo el codigo del socio
            $data['idsocio'] = $this->administracion_model->_get_idsocio_by_cedula($data['cedula']);
            $data['cuenta'] = $this->administracion_model->_get_cuenta_socio_by_id($data['idsocio']);
            
            if ($data['cuenta'] == 0) {
                $this->administracion_model->_registrar_cta_socio($data);
            }

            $data['fecha_inscripcion'] = date('Y-m-d');


            if ($data['idmatrices'] == 2) {
                //$data['id_codigo'] = $this->administracion_model->_inserta_codigo_binario($data);
                $this->administracion_model->_update_codigo_binario_ubicacion($data);
                $data['id_codigo'] = $data['ubicacion'];
                $this->compras_model->_graba_primera_compra_binaria($data);
                $this->exito_registro($data);
            }else if($data['idmatrices'] == 3){
				$data['ubicacion'] = $this->administracion_model->_get_last_id('codigo_socio') + 1;
				$data['cod_socio'] = $this->administracion_model->_calcula_codigo($data);
				
				$data['patrocinador'] = $data['patrocinador_uninivel'];
                $data['id_codigo'] = $this->administracion_model->_inserta_codigo($data);
                $this->compras_model->_graba_compra_primera($data);
                $this->exito_registro($data);
            }
        }
    }


    /**
      * Recibe los datos del formulario de inscripción externo
      *
      * @return void
      * @author Pablo Orejuela
      * Fecha: 16-11-2020
      **/
      function  recibe_datos_form_registro_externo(){

        $this->form_validation->set_rules('cedula', 'Cedula', 'is_unique[socios.cedula]');
        $this->form_validation->set_message('is_unique', 'Ya existe un distribuidor registrado con este número de cédula');
        if ($this->form_validation->run() == FALSE){
			$this->form_nuevo_distribuidor_externo();
        }else{
			
            $data['nombres_socio'] = strtoupper($this->input->post('nombres'));
            $data['apellidos_socio'] = strtoupper($this->input->post('apellidos'));
            $data['cedula_socio'] = $this->input->post('cedula');

            $data['direccion'] = strtoupper($this->input->post('direccion'));
            $data['idciudad'] = $this->input->post('ciudad');
            $data['idprovincia'] = $this->input->post('id_provincia');
            $data['celular_socio'] = $this->input->post('celular');
            $data['email_socio'] = $this->input->post('email');

            //info banco
            $data['num_cta'] = $this->input->post('num_cta');
            $data['idtipo_cuenta'] = $this->input->post('tipo_cuenta');
            $data['idbanco'] = $this->input->post('banco');

            //Patrocinador
            $data['cedula_patrocinador'] =  $this->input->post('cedula_patrocinador');
            $data['nombre_patrocinador'] =  $this->input->post('nombre_patrocinador');
            $data['apellido_patrocinador'] =  $this->input->post('apellido_patrocinador');
            $data['telefono_patrocinador'] =  $this->input->post('telefono_patrocinador');
            $data['email_patrocinador'] =  $this->input->post('email_patrocinador');

            //datos primera compra
            $data['idmatrices'] = $this->input->post('idmatrices'); 
            $data['idpaquete'] =  $this->input->post('paquetes');


            //verificar que no exista el patrocinador
            $data['patrocinador'] = $this->administracion_model->_get_idsocio_by_cedula($data['cedula_patrocinador']);
            $data['cod_provincia'] = $this->administracion_model->_get_cod_provincia($data['idprovincia']);
            $data['rama'] = 2;
            $data['padre'] = 1;

            //Si el patrocinador no está registrado lo registro como consumidor
            if ($data['patrocinador'] == null || $data['patrocinador'] == 0){
                $data['filas'] = 0;

                //El patrocinador sería Carlos
                $data['patrocinador'] = 1;
                $data['cedula'] = $data['cedula_patrocinador'];
                $data['nombres'] = $data['nombre_patrocinador'];
                $data['apellidos'] = $data['apellido_patrocinador'];
                $data['celular'] = $data['telefono_patrocinador'];
                $data['email'] = $data['email_patrocinador'];


                //Registro el socio con el rol de consumidor
                $this->administracion_model->_registrar_socio($data);
                $data['idsocio'] = $this->administracion_model->_get_idsocio_by_cedula($data['cedula_patrocinador']);

                if ($data['idpaquete'] != 0) {
                    //Si es que ha elegido un paquete grabo la compra del consumidor para su bono
                    $this->compras_model->_graba_compra_consumidor($data);
                }

                //NUEVO SOCIO DISTRIBUIDOR
                //Grabo el nuevo socio bajo el patrocinador
                $data['nombres'] = $data['nombres_socio'];
                $data['apellidos'] = $data['apellidos_socio'];
                $data['cedula'] = $data['cedula_socio'];
                $data['email'] = $data['email_socio'];
                $data['idciudad'] = $data['idciudad'];
                $data['celular'] = $data['celular_socio'];
                
                //Encuentro un código libre bajo Carlos
                $data['ubicacion'] = $this->administracion_model->_get_codigo_binario_libre($data);
                $data['cod_socio'] = $this->administracion_model->_calcula_codigo_ubicacion($data);
                
                $this->_insert_socio_externo($data);
                
                //Grabo la primera compra dependiendo de la matriz
                if ($data['idmatrices'] == 2) {
                    //Binaria
                    $data['idcompras_binario'] = $this->compras_model->_graba_primera_compra_binaria($data);
                }else if($data['idmatrices'] == 3){
                    //Uninivel

                }else if($data['idmatrices']){
                    //Economico
                }


                //Grabo el bono generado a favor del registrante
                $this->compras_model->_graba_bono_constante($data);

                $this->index();

            }else{
                //Si es que el patrocinador si estaba registrado obtengo el código del patrocinador y grabo la compra como consumidor

                $data['idsocio'] = $this->administracion_model->_get_idsocio_by_cedula($data['cedula_patrocinador']);
                
                if ($data['idpaquete'] != 0) {
                    //Si es que ha elegido un paquete grabo la compra del consumidor para su bono
                    $this->compras_model->_graba_compra_consumidor($data);
                }
   
                //NUEVO SOCIO DISTRIBUIDOR
                //Grabo el nuevo socio bajo el patrocinador
                $data['nombres'] = $data['nombres_socio'];
                $data['apellidos'] = $data['apellidos_socio'];
                $data['cedula'] = $data['cedula_socio'];
                $data['email'] = $data['email_socio'];
                $data['idciudad'] = $data['idciudad'];
                $data['celular'] = $data['celular_socio'];
                
                //Encuentro un código libre bajo Carlos
                $data['ubicacion'] = $this->administracion_model->_get_codigo_binario_libre($data);
                $data['cod_socio'] = $this->administracion_model->_calcula_codigo_ubicacion($data);
                
                $this->_insert_socio_externo($data);
                
                 //Grabo la primera compra dependiendo de la matriz
                 if ($data['idmatrices'] == 2) {
                    //Binaria
                    $data['idcompras_binario'] = $this->compras_model->_graba_primera_compra_binaria($data); 
                }else if($data['idmatrices'] == 3){
                    //Uninivel

                }else if($data['idmatrices']){
                    //Economico
                }
                
                //Grabo el bono generado a favor del registrante
                $this->compras_model->_graba_bono_constante($data);

                $this->index();
                
            }
        }
    }

    /**
     * Recibe los datos del nuevo socio externo y los graba
     *
     *
     * @param Type array[]
     * @return type void
     * @throws conditon
     **/
    public function _insert_socio_externo($data){
        
        $this->administracion_model->_registrar_socio($data);
        $data['idsocio'] = $this->administracion_model->_get_idsocio_by_cedula($data['cedula']);
        $this->administracion_model->_registrar_cta_socio($data); 
        $this->administracion_model->_update_codigo_binario_ubicacion($data);
    }
}

