<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acl_model');
        $this->load->model('procesos_model');
        $this->load->model('testimonios_model');
	}

	public function nuevo_testimonio(){
		$rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        $data['result'] = 0;
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='form_nuevotestimonio_view';
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
	function graba_nuevo_testimonio(){
		//capturo datos
		$fecha = date('Y-m-d');
		$testimonio['fecha'] = $fecha;
		$testimonio['titulo'] = $this->input->post('titulo');
		$testimonio['url'] = $this->input->post('url');
		$testimonio['descripcion'] = $this->input->post('descripcion');

		//inserto datos
		$e = $this->testimonios_model->_graba_nuevo_testimonio($testimonio);
		if ($e) {
			$rol =$this->session->userdata('rol');
	        $data['per'] = $this->acl_model->_extraePermisos($rol);
	        $is_logged = $this->session->userdata('is_logged_in');
	        $data['result'] = 1;
	        if (isset($is_logged) == true || isset($is_logged) == 1) {
	            $data['version'] = $this->config->item('system_version');
	            $data['title']='GTK Admin';
	            $data['main_content']='form_nuevotestimonio_view';
	            $this->load->view('includes/template', $data);
	        }
	        else{
	            echo "NOP";
	        }
		}else{
			$this->nuevo_testimonio();
		}
	}
}

/* End of file Evento.php */
/* Location: ./application/controllers/Evento.php */