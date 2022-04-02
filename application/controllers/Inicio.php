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

    function exito_registro($id){
		$rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
		if (isset($is_logged) == true || isset($is_logged) == 1) {
			$data['id'] = $id;
			$data['title']='Registro de Socios';
			$data['main_content']='publico/exito_registro_socio';
			$this->load->view('includes/template', $data);
		}else {
			$this->index();
		}
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

    function formulario_inscripcion_miembro($mensaje = ''){
		$data['mensaje'] = $mensaje;
        $rol = $this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        $data['result'] = 0;
        if (isset($is_logged) || $is_logged == true || isset($is_logged) == 1 || $is_logged != false || $is_logged != 0) {
            
			//$data['socio'] = $this->administracion_model->_get_data_socio_by_id($this->session->userdata('id'));

            $data['provincias'] = $this->administracion_model->_get_provincias();
            $data['ciudades'] = $this->administracion_model->_get_ciudades();
            $data['bancos'] = $this->administracion_model->_get_bancos();
            $data['title'] ='GTK Admin';
            $data['main_content'] ='inicio/form_inscrip_miembro_view';
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

        $this->form_validation->set_rules('cedula', 'Cédula', 'is_unique[socios.cedula]');
        $this->form_validation->set_message('is_unique', '<span style="color:red;font-weight:bold;font-size:1em;">ERROR: Ya existe un socio registrado con este número de cédula</span>');
        $this->form_validation->set_message('required', '<span style="color:red;font-weight:bold;font-size:1em;">ERROR: Este campo es obligatorio</span>');
        if ($this->form_validation->run() == FALSE){
			$this->formulario_inscripcion_miembro();
        }else{

			//Establesco el rango dependiendo de la matriz
            $data['idrango'] = 1;			}
			$data['cedula'] = $this->input->post('cedula');
            $data['nombres'] = strtoupper($this->input->post('nombres'));
            $data['apellidos'] = strtoupper($this->input->post('apellidos'));
            $data['direccion'] = strtoupper($this->input->post('direccion'));
			$data['idprovincia'] = $this->input->post('id_provincia');
            $data['idciudad'] = $this->input->post('ciudad');
            $data['celular'] = $this->input->post('celular');
            $data['email'] = $this->input->post('email');
			$data['cedula_patrocinador'] = $this->input->post('cedula_patrocinador');

			//Rol de socio
            $data['idrol'] = 3;

            //info banco
			$data['num_cta'] = $this->input->post('num_cta');

			if (!isset($data['num_cta']) || $data['num_cta'] == ''  || $data['num_cta'] == NULL) {
				$data['num_cta'] = '000000000'; //$this->input->post('num_cta');
				$data['idtipo_cuenta'] = 1; //$this->input->post('tipo_cuenta');
				$data['idbanco'] = 163;  //$this->input->post('banco');
			}else{
				$data['num_cta'] = $this->input->post('num_cta');
				$data['idtipo_cuenta'] = $this->input->post('tipo_cuenta');
				$data['idbanco'] = $this->input->post('banco');
			}

			if (isset($data['cedula_patrocinador']) && $data['cedula_patrocinador'] != NULL && $data['cedula_patrocinador'] != '') {
				$patrocinador = $this->administracion_model->_get_socio_by_cedula($data['cedula_patrocinador']);
				$data['patrocinador'] = $patrocinador->idsocio;
			}else{
				//Patrocinador
				$data['patrocinador'] = $this->session->userdata('id');
			}

			$data['fecha_inscripcion'] = date('Y-m-d');
            $data['cod_provincia'] = $this->administracion_model->_get_cod_provincia($data['idprovincia']);
            $data['cod_socio'] = $this->administracion_model->_calcula_codigo($data);

			$data['result'] = $this->administracion_model->_registrar_socio($data);
			$this->exito_registro($data['result']);
        }
    
}

