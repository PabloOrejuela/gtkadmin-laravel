<?php

class Login_model extends CI_Model{
    
    function _validate_user($data){
        $this->db->where('user', $data['nombre']);
        $this->db->where('password', md5($data['password']));
        $q = $this->db->get('usuarios');
        if($q->num_rows() == 1){
            foreach ($q->result() as $v) {
                $id = $v->idusuario;
            }
            return $id;
        }
        else{
            return 0;
        }
    }

    function _validate_email($data){
        $this->db->where('email', $data['nombre']);
        $this->db->where('password', md5($data['password']));
        $q = $this->db->get('usuarios');
        if($q->num_rows() == 1){
            foreach ($q->result() as $v) {
                $id = $v->idusuario;
            }
            return $id;
        }
        else{
            return 0;
        }
    }

    function _validate_credentials($data){
        $socio=null;
        $this->db->where('cedula', $data['user']);
        $this->db->where('clave_socio', md5($data['password']));
        $q = $this->db->get('socios');
        if($q->num_rows() == 1){
            foreach ($q->result_array() as $v) {
                $socio = $v;
            }
            return $socio;
        }
        else{
            return 0;
        }
    }
        
    function is_logged_in(){
        $is_logged_in = $this->session->userdata('is_logged_in');
        
        if(!isset($is_logged_in) || $is_logged_in != true){	
            redirect('ingreso');
        }		
    }

    /**
     * Almacena el pin y la expiración en la tabla socios
     *
     * @param Type array
     * @return type void
     * @author Pablo Orejuela
     * @editado 31-03-2021
     **/
    public function _set_pin($data){
    
        $this->db->where('idsocio', $data['id']);
        $this->db->set('pin', $data['pin']);
        $this->db->set('expira', $data['expira']);
        $this->db->update('socios');  
    }

    /**
     * Verifica si el pin es válido
     *
     * @param Type int
     * @return type boolean
     * @throws conditon
     * @author Pablo Orejuela
     * @date 19-07-2021
     **/
    function _verifica_pin($pin, $idsocio){
        $actual = strtotime(date('Y-m-d H:i:s'));
        
        $this->db->select('expira, pin')->where('idsocio', $idsocio);
        $q = $this->db->get('socios');
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $key => $value) {
                $expira = $value->expira;
                
                if ($expira && ($expira-$actual >= 0 && $pin === $value->pin)) {
                    $estado = 1;
                }else{
                    $estado = 0;
                }
            }
        }
        return $estado;

    }

    function _get_rol($data){
        $this->db->where('user', $data['nombre']);
        $this->db->where('password', md5($data['password']));
        $this->db->join('rol', 'rol.idrol = usuarios.idrol');
        $q = $this->db->get('usuarios');
        if($q->num_rows() == 1){
            foreach ($q->result as $rol) {
                $idrol = $rol->idrol;
            }
            return $idrol;
        }
        else{
            return 0;
        }
    }

    

    function _get_permiso($data, $seccion){
        $this->db->where('user', $data['nombre']);
        $this->db->where('password', md5($data['password']));
        $this->db->join('rol', 'rol.idrol = usuarios.idrol');
        $q = $this->db->get('usuarios');
        if($q->num_rows() == 1){
            foreach ($q->result as $rol) {
                $idrol = $rol->seccion;
            }
            return $idrol;
        }
        else{
            return 0;
        }
    }
}