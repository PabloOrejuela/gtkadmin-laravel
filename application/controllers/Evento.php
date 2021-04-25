<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acl_model');
        $this->load->model('procesos_model');
        $this->load->model('evento_model');
	}

	public function nuevo_evento(){
		$rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        $data['result'] = 0;
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='form_nuevoevento_view';
            $this->load->view('includes/template', $data);
        }
        else{
            echo "NOP";
        }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function graba_nuevo_evento(){
		//capturo datos
		$evento['fecha'] = $this->input->post('fecha_evento');
		$evento['lugar'] = $this->input->post('lugar_evento');
		$evento['descripcion'] = $this->input->post('descripcion_evento');

		//inserto datos
		$e = $this->evento_model->_graba_nuevo_evento($evento);
		if ($e) {
			$rol =$this->session->userdata('rol');
	        $data['per'] = $this->acl_model->_extraePermisos($rol);
	        $is_logged = $this->session->userdata('is_logged_in');
	        $data['result'] = 1;
	        if (isset($is_logged) == true || isset($is_logged) == 1) {
	            $data['version'] = $this->config->item('system_version');
	            $data['title']='GTK Admin';
	            $data['main_content']='form_nuevoevento_view';
	            $this->load->view('includes/template', $data);
	        }
	        else{
	            echo "NOP";
	        }
		}else{
			$this->nuevo_evento();
		}
	}
}

/* End of file Evento.php */
/* Location: ./application/controllers/Evento.php */