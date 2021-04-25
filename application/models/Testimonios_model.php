<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonios_model extends CI_Model {

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _graba_nuevo_testimonio($testimonio){

		$h = $this->_verifica($testimonio);
		if ($h == 0) {
			$this->db->trans_start();
			$this->db->set('fecha', $testimonio['fecha']);
			$this->db->set('titulo', $testimonio['titulo']);
			$this->db->set('url', $testimonio['url']);
			$this->db->set('img', $testimonio['url']);
			$this->db->set('descripcion', $testimonio['descripcion']);
			$this->db->insert('testimonios');
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
	function _verifica($testimonio){
		$this->db->select('idtestimonios');
		$this->db->where('url', $testimonio['url']);
		$q = $this->db->get('testimonios');
		if ($q->num_rows() > 0) {
			return 1;
		}else{
			return 0;
		}
	}
}

/* End of file Evento_model.php */
/* Location: ./application/models/Evento_model.php */