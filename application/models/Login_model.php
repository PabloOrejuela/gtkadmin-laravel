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
            foreach ($q->result() as $v) {
                $socio['id'] = $v->idsocio;
                $socio['nombres'] = $v->nombres;
                $socio['apellidos'] = $v->apellidos;
                $socio['cedula'] = $v->cedula;
                $socio['id_rol'] = $v->idrol;
                $socio['email'] = $v->email;
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