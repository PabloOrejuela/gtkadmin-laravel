<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acl extends CI_Controller{
    
    function index(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['superadmin'] = $this->acl_model->_extrae_roles('SUPERADMIN');
            $data['socio'] = $this->acl_model->_extrae_roles('SOCIO');

            $data['version'] = $this->config->item('system_version');
            $data['title']='Niveles de acceso';
            $data['main_content']='acceso_admin_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }
    
    function __construct() {
        parent::__construct();
        $this->load->model('acl_model');
    }
    
    function cambiar_permisos(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            for ($i = 1; $i <= 4; $i++) {
                $superadmin[] = $this->input->post('superadmin'.$i);
                $socio[] = $this->input->post('socio'.$i);
            }
            $this->acl_model->_graba($superadmin, 1);
            $q = $this->acl_model->_graba($socio, 2);
            if ($q) {
                $data['title']='Niveles de acceso';
                $data['main_content']='exito';
                $this->load->view('includes/template', $data);
            }
        }
    }
}

        