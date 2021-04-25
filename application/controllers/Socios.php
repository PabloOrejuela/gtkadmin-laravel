<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Socios extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('acl_model');
        $this->load->model('socios_model');
        
    }
        

    /**
     *
     * Devuelve un formulario para elegir el socio que será eliminado del sistema
     *
     * @param Type 
     * @return void
     * @author Pablo Orejuela
     * @fecha 20-01-2021
     **/
    public function form_elimina_socio(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['socios'] = $this->socios_model->_obten_socios();
            

            $data['title']='GTK Admin';
            $data['main_content']='socios/form_elimina_socio_view';
            $this->load->view('includes/template', $data);
        }
        else{
            redirect('Inicio');
        }
    }
    
    /**
     * Elimina un socio y libera los datos de las tablas
     *
     * Usada solo en caso extremo, en producción solo se los va a dejar inactivos
     *
     * @param Type $var $idsocio
     * @return type boolean
     * @author Pablo Orejuela
     * @Fecha: 20-01-2021
     **/

    public function elimina_socio(){
        //recibo el idsocio
        $data['idsocio'] = $this->input->post('idsocio');
        
        //Obtengo código binario
        $data['idcodigo_socio_binario'] = $this->socios_model->_get_codigo_binario($data);
    
        //Obtengo el código uninivel
        $data['idcod_socio'] = $this->socios_model->_get_codigo_uninivel($data);

        //Elimino las compras asignadas a su código binario y compras uninivel
        if($data['idcod_socio'] != 0){
            $this->socios_model->_elimina_compras($data['idcod_socio']);
        }

        if($data['idcodigo_socio_binario'] != 0){
            $this->socios_model->_elimina_compras_binarias($data['idcodigo_socio_binario']);
        }


        //Elimino las compras consumidores en caso de tener relacionadas
        $this->socios_model->_elimina_compras_consumidores($data['idsocio']);

        //Elimino las cuentas de banco registradas
        $this->socios_model->_elimina_cuentas_banco($data['idsocio']);

        //Elimino los puntos binarios 
        $this->socios_model->_elimina_puntos_binarios($data['idcodigo_socio_binario']);

        //Restauro el codigo socio y lo libero
        $this->socios_model->_restauro_codigo_binario($data['idcodigo_socio_binario']);

        //Elimino el socio
        $this->socios_model->_elimina_socio($data['idsocio']);

        $this->form_elimina_socio();
    }
}

/* End of file Controllername.php */
