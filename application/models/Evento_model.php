<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento_model extends CI_Model {

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	function _graba_nuevo_evento($evento){

		$h = $this->_verifica($evento);
		if ($h == 0) {
			$this->db->trans_start();
			$this->db->set('fecha', $evento['fecha']);
			$this->db->set('lugar', $evento['lugar']);
			$this->db->set('descripcion', $evento['descripcion']);
			$this->db->insert('agenda');
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){
			    return 0;
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _verifica($evento){
		$this->db->select('idagenda');
		$this->db->where('fecha', $evento['fecha']);
		$this->db->where('lugar', $evento['lugar']);
		$q = $this->db->get('agenda');
		if ($q->num_rows() > 0) {
			return 1;
		}else{
			return 0;
		}
	}
}

/* End of file Evento_model.php */
/* Location: ./application/models/Evento_model.php */