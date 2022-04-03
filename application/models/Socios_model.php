<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Socios_model extends CI_Model {

    function _get_socios(){
		$this->db->select('*');
		$this->db->order_by('apellidos', 'ASC');
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $s) {
                $socios[] = $s;
            }
            return $socios;
        }else{
        	return 0;
        }
	}

    /**
     * Función que devuelve el codigo del socio
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     * @fecha 20-01-2021
     **/
    function _get_codigo($data){
        $this->db->select('idcod_socio');
        $this->db->where('idsocio', $data['idsocio']);
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $c){
                $cod = $c->idcod_socio;
            }
            return $cod;
        }else{
            return 0;
        }
    }


    /**
     * Elimina las cuentas de banco registradas
     *
     * @param Type $idsocio
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_cuentas_banco($idsocio){
        
        $this->db->trans_start();
        $this->db->where('idsocio', $idsocio);
        $this->db->delete('cta_banco');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar las cuentas de banco';
        }

    }


    /**
     * Elimina el socio
     *
     * @param Type $idsocio
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_socio($idsocio){
        
        $this->db->trans_start();
        $this->db->where('idsocio', $idsocio);
        $this->db->delete('socios');
        $this->db->query("ALTER TABLE socios AUTO_INCREMENT = $idsocio");
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar el socio';
        }

    }


	function _get_socios($estado = "A"){
		$this->db->select('*');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->order_by('apellidos', 'ASC');
        $q = $this->db->get('socios');
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $r[] = $row;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	function _get_socio_by_id($id){
		$this->db->select('*');
		$this->db->where('idsocio', $id);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$q = $this->db->get('socios');
		//echo $this->db->last_query().'<br>';
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio = $r;
            }
            return $socio;
        }else{
        	return 0;
        }
	}


	function _get_socios_by_idciudad($idciudad){
		$r=null;
		$this->db->select('*');
		$this->db->where('ciudad.idciudad', $idciudad);
		$this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('rangos', 'rangos.idrango = codigo_socio.idrango');
		$this->db->order_by('apellidos', 'ASC');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $r[] = $row;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Trae la información de los socios inactivos
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_info_inactivos(){
		$this->db->select('*');
		//$this->db->select('codigo_socio_binario.idcodigo_socio_binario,codigo_socio_binario,fecha_inscripcion,nombres,apellidos,cedula');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->where('codigo_socio_binario !=', 'UNDEFINED');
		$this->db->where('codigo_socio_binario.idsocio !=', '8');
		//$this->db->where('idcodigo_socio_binario', 1);
		$this->db->order_by('apellidos', 'asc');
		//$this->db->order_by('idcodigo_socio_binario', 'asc');
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if($q->num_rows() > 0){
			foreach ($q->result() as $row) {
				$r[] = $row;
			}
			return $r;
		}
		else{
				return 0;
		}
	}

	/**
	 * undocumented function
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_socios_provincia($idprovincia){
		
		$this->db->select('idcodigo_socio_binario,codigo_socio_binario,nombres,apellidos,cedula,celular,fecha_inscripcion');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$this->db->where('provincias.idprovincia', $idprovincia);
		$this->db->where('codigo_socio_binario !=', 'UNDEFINED');
		$this->db->order_by('apellidos', 'asc');
		$q = $this->db->get('codigo_socio_binario');
		if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r[] = $row;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	function _get_socio_por_cedula($cedula){
		$this->db->select('*');
		$this->db->where('cedula', $cedula);
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio['id'] = $r->idsocio;
                $socio['nombres'] = $r->nombres;
                $socio['cedula'] = $r->cedula;
                $socio['codigo_socio'] = $r->codigo_socio;
                $socio['patrocinador'] = $r->patrocinador;
                $socio['direccion'] = $r->direccion;
                $socio['apellidos'] = $r->apellidos;
                $socio['celular'] = $r->celular;
            }
            return $socio;
        }else{
        	return 0;
        }

	}
}

/* End of file ModelName.php */
