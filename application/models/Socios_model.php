<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Socios_model extends CI_Model {

    function _obten_socios(){
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
     * Función que devuelve el codigo binario
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     * @fecha 20-01-2021
     **/
    function _get_codigo_binario($data){
        $this->db->select('idcodigo_socio_binario');
        $this->db->where('idsocio', $data['idsocio']);
        $q = $this->db->get('codigo_socio_binario');
        //echo $this->db->last_query();
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $c){
                $cod = $c->idcodigo_socio_binario;
            }
            return $cod;
        }else{
            return 0;
        }
    }

    /**
     * Función que devuelve el codigo uninivel
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     * @fecha 20-01-2021
     **/
    function _get_codigo_uninivel($data){
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
     * Elimina las compras de la tabla compras
     *
     * @param Type $idcod_socio
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_compras($idcod_socio){
        
        $this->db->trans_start();
        $this->db->where('idcod_socio', $idcod_socio);
        $this->db->delete('compras');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar el usuario';
        }

    }

    /**
     * Elimina las compras de la tabla compras binarias
     *
     * @param Type $idcodigo_socio_binario
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_compras_binarias($idcodigo_socio_binario){
        
        $this->db->trans_start();
        $this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
        $this->db->delete('compras_binario');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar las compras binarias';
        }

    }


    /**
     * Elimina las compras de la tabla compras_consumidores
     *
     * @param Type $idsocio
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_compras_consumidores($idsocio){
        
        $this->db->trans_start();
        $this->db->where('idsocio', $idsocio);
        $this->db->delete('compras_consumidores');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar las compras de consumidor';
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
     * Elimina los puntos binarios
     *
     * @param Type $idcodigo_socio_binario
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _elimina_puntos_binarios($idcodigo_socio_binario){
        
        $this->db->trans_start();
        $this->db->where('idcod_socio', $idcodigo_socio_binario);
        $this->db->delete('p_binaria');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar los puntos binarios';
        }

    }

    /**
     * Restauro el registro del codigo binario para eliminar el socio
     *
     * @param Type $idcodigo_socio_binario
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _restauro_codigo_binario($idcodigo_socio_binario){
        
        $this->db->trans_start();
        $this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
        $this->db->set('codigo_socio_binario', 'UNDEFINED');
        $this->db->set('patrocinador', 0);
        $this->db->set('fecha_inscripcion', '2018-06-06');
        $this->db->set('idsocio', 8);
        $this->db->set('idrango', 1);
        $this->db->update('codigo_socio_binario');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo actualizar la tabla';
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
}

/* End of file ModelName.php */
