<?php

class Acl_model extends CI_Model{

    function _graba($data, $rol){
        $this->db->where('idrol', $rol);
        $this->db->set('administracion', $data[0]);
        $this->db->set('inicio', $data[1]);
        $this->db->set('reportes', $data[2]);
        $this->db->set('socios', $data[3]);
        $this->db->update('rol');
        return TRUE;
    }

    function _verificaRol($socio,$section){
        $this->db->select('*');
        $this->db->where('idrol', $socio['idrol']);
        $q = $this->db->get('rol');
        if($q->result() > 0){
            foreach ($q->result() as $value) {
                $r = $value->$section;
            }
            return $r;
        }
    }

    /**
     * E$xtrae el nombre del usuario
     *
     * @return void
     * @author Pablo Orejuela
     **/
    function _get_name($cedula){
        $r = "";
        $this->db->select('nombres, apellidos');
        $this->db->where('cedula', $cedula);
        $q = $this->db->get('socios');
        if($q->result() > 0){
            foreach ($q->result() as $value) {
                $r = $value->nombres.' '.$value->apellidos;
            }
            return $r;
        }else{
            return $r;
        }
    }

    function _extrae_roles($rol){
        /*
         * Creado por: Pablo Orejuela
         *
         * Esta funcion es pensada para ser usada con todos los roles
         */
        $this->db->select('*');
        $this->db->where('rol', $rol);
        $q = $this->db->get('rol');

        if($q->result() > 0){
            foreach ($q->result() as $key => $value) {
                $admin[0] = $value->rol;
                $admin[1] = $value->administracion;
                $admin[2] = $value->inicio;
                $admin[3] = $value->reportes;
                $admin[4] = $value->socios;
            }
            return $admin;
        }
    }

    function _extrae_rol($iduser){
        $r = 0;
        $this->db->select('idrol');
        $this->db->where('idusuario',$iduser);
        $q = $this->db->get('usuarios');
        if($q->result() > 0){
            foreach ($q->result() as $value) {
                $r = $value->idrol;
            }
            return $r;
        }
        else{
            return 0;
        }
    }

    function _extrae_id_user($usuario){
        $sql = "SELECT `idsocio` FROM `socios` WHERE `cedula` = '$cedula' OR `email` = '$email'";

        $q = $this->db->query($sql);
        if($q->num_rows() == 1){
            foreach ($q->result() as $value) {
                $id = $value->iduser;
            }
            return $id;
        }
        else{
            return 0;
        }
    }

    function extraeDir($usuario){
        $this->db->select('dirigente');
        $this->db->where('nombre',$usuario);
        $q = $this->db->get('socios');
        if($q->result() > 0){
            foreach ($q->result() as $value) {
                $dir = $value->dirigente;
            }
            return $dir;
        }
    }

    function permisosDir($dir, $section){
        if($dir == 1){
            $this->db->select('*');
            $this->db->where('idrol', 4);
            $q = $this->db->get('rol');
            if($q->result() > 0){
                foreach ($q->result() as $value) {
                    $r = $value->$section;
                }
                return $r;
            }
        }
        else{
            return FALSE;
        }
    }

    function _get_usuarios(){
        /*
         * Extrae los usuarios registrados en la base de datos
         * Es llamada por el controlador archivos en edita_profe
         */
        $this->db->order_by('nombre_usuario');
        $usuarios = $this->db->get('USUARIO');
        return $usuarios;
    }

    function _get_profes(){
        /*
         * Extrae los usuarios registrados en la base de datos
         * Es llamada por el controlador archivos en edita_profe
         */
        $this->db->order_by('nombre_usuario');
        $this->db->where('idrol !=', 6);
        $this->db->where('idrol !=', 0);
        $usuarios = $this->db->get('USUARIO');
        return $usuarios;
    }

    function _get_roles(){
        /*
         * Extrae los Roles de la base de datos
         * Es llamada por el controlador archivos en edita_profe
         */
        $roles = $this->db->get('rol');
        return $roles;
    }

    function _extraePermisos($rol){
        $this->db->where('idrol', $rol);
        $q = $this->db->get('rol');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $p) {
                $per['administracion'] = $p->administracion;
                $per['inicio'] = $p->inicio;
                $per['reportes'] = $p->reportes;
                $per['socios'] = $p->socios;
            }
            return $per;
        }
        else{
            return 0;
        }
    }

    function _is_logged_rol() {
        $this->db->select('idrol');
        $this->db->where('logged_socio', 1);
        $q = $this->db->get('socios');
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $value) {
                $user = $value->idrol;
            }
            return $user;
        }
        else{
            return 0;
        }
    }

    function _set_logged_socio() {
        $this->db->select('idrol');
        $this->db->where('logged_socio', 1);
        $q = $this->db->get('socios');
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $value) {
                $user = $value->idrol;
            }
            return $user;
        }
        else{
            return 0;
        }
    }
}
