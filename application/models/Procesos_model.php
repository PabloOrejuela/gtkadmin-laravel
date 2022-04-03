<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procesos_model extends CI_Model {

	private $niveles = array(1 => 5, 2 => 10, 3 => 20, 4 => 40, 5 => 80, 6 => 160, 7 => 320, 8 => 640, 9 => 1250, 10 => 2500, 11 => 5000);
	private $pago_bono_contante  = array(1 => 40, 2 => 100, 3 => 200, 4 => 25, 5 => 10, 6 => 20);

	public function __construct(){
		parent::__construct();
		require_once("entidades/CodigoDTO.php");
	}

	/**
	 * undocumented function
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_matrices(){
		$this->db->select('*');
		$this->db->where('idmatrices !=', 1);
        $q = $this->db->get('matrices');
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
	 * undocumented function
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_provincias(){
		$this->db->select('*');
        $q = $this->db->get('provincias');
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
	function _get_paquete_comprado($idcodigo_socio_binario, $fecha){

		$this->db->select('paquete');
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->where('idcodigo_socio_binario =', $idcodigo_socio_binario);
		$this->db->where('fecha =', $fecha);
		$q = $this->db->get('compras_binario');
		//echo $this->db->last_query();
		if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->paquete;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/**
	 * devuelve el paquete compŕado por el socio nuevo inscrito
	 * en el mes
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_paquete_comprado_mes($idcodigo_socio_binario, $mes){

		$this->db->select('MAX(paquete) as compra,bono');
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->where('idcodigo_socio_binario =', $idcodigo_socio_binario);
		$this->db->where('MONTH(fecha) =', $mes);
		$q = $this->db->get('compras_binario');
		//echo $this->db->last_query();
		if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
				$r['compra'] = $row->compra;
				$r['bono'] = $row->bono;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	

	function _get_last_valid_id(){
		$sql = "SELECT MAX(`idcodigo_socio_binario`) FROM `codigo_socio_binario` WHERE `codigo_socio_binario` NOT LIKE '%UNDEFINED%'";
		
		$this->db->select_max('idcodigo_socio_binario');
		$this->db->not_like('codigo_socio_binario', 'UNDEFINED');
		$q = $this->db->get('codigo_socio_binario');
		if($q->result() > 0){
            foreach ($q->result() as $row) {
            	$id = $row->idcodigo_socio_binario;
            }
            return $id;
        }else{
        	return 1;
        }
	}

	/**
	 * Recibe el idciudad y devuelve el nombre de la ciudad
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_ciudad_nombre($idciudad){
		$ciudad = NULL;
		$this->db->select('ciudad');
		$this->db->where('idciudad', $idciudad);
        $q = $this->db->get('ciudad');
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $ciudad = $row->ciudad;
            }
            return $ciudad;
        }
        else{
        	return 'Error en el nombre';
        }
	}

	function _get_puntos($idcod_socio){
		$mes = date('m');
		if ($idcod_socio!=null) {
			$this->db->select('puntos_paq');
			$this->db->where('idcodigo_socio_binario', $idcod_socio);
			$this->db->where('MONTH(fecha)', $mes);
			$this->db->where('pago', 1);
			$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
			$q = $this->db->get('compras_binario');
			//echo $this->db->last_query();
	        if ($q->num_rows() > 0) {
	        	foreach ($q->result() as $row) {
	            	$puntos = $row->puntos_paq;
	            }
	            return $puntos;
	        }
	    }else{
	    	return 0;
	    }
	}


	function tester_pablo($socio,$puntos){
		foreach ($socio as $key => $value) {
			$puntos += $value['puntos'];
			echo " - ".$value['idcod_socio'];
		}

		return $puntos;
	}


	function GetAutocomplete_ciudades($options = array()) {
        $this->db->select('ciudad');
        $this->db->like('ciudad', $options['keyword'], 'after');
        $query = $this->db->get('ciudad');
        return $query->result();
    }

    function GetAutocomplete_patrocinadores($options = array()) {
        $this->db->select('cedula');
        $this->db->like('cedula', $options['keyword'], 'after');
        $query = $this->db->get('socios');
        return $query->result();
    }

	/**
	 * Verifica si es el primer mes
	 *
	 * @return void
	 * @author
	 **/
	function _es_primer_mes($codigo){
		$fecha_inscripcion = $this->_get_fecha_inscripcion($codigo);
		$fecha_actual = date('Y-m-d');

		$fecha_actual_obj = new DateTime($fecha_actual);
		$fecha_inscripcion_obj = new DateTime($fecha_inscripcion);
		if ($fecha_actual_obj <= $fecha_inscripcion_obj->add(new DateInterval('P0Y0M30D'))) {
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _litros_por_cobrar($id_codigo){
		$r = 0;
		$this->db->select('litros_ganados');
		$this->db->where('litros_ganados.idcod_socio', $id_codigo);
		$this->db->join('socios', 'socios.idsocio = litros_ganados.idcod_socio');
        $q = $this->db->get('litros_ganados');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->litros_ganados;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/**
	 * devuelve la cantidad de litros que debe mover para subir de rango
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_litros_rango($idrango){
		$this->db->select('volumen');
		if($idrango == 11){
			$this->db->where('idrango', $idrango);
		}else{
			$this->db->where('idrango', $idrango+1);
		}

		$q = $this->db->get('rangos');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
			foreach ($q->result() as $value) {
				$litros = $value->volumen;
			}
			return $litros;
		}else{
			return 0;
		}
	}

	/**
	 * Retorna el premio del rago en caso de haber subido de rango, se lo recibe una sola vez
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _gana_bono_rango($idrango, $idcod_socio){
		$this->db->select('volumen');
		$this->db->where('idrango', $idrango['idrango']);
		$q = $this->db->get('rangos');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
			foreach ($q->result() as $value) {
				$litros = $value->volumen;
			}
			return $litros;
		}else{
			return 0;
		}
	}

	/**
	 * devuelve la cantidad de litros que recibe un paquete
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_litros_paquete($idpaquete){
		$this->db->select('litros');
		$this->db->where('idpaquete', $idpaquete);
		$q = $this->db->get('paquetes');
		if ($q->num_rows() >0) {
			foreach ($q->result() as $value) {
				$litros = $value->litros;
			}
			return $litros;
		}else{
			return 0;
		}
	}
	
	/**
	 * Devuelve los datos de la compra actual PLAN UNINIVEL
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_paquete_codigo($idcod_socio){
		$mes_actual = date('m');
		$this->db->where('idcod_socio', $idcod_socio);
		$this->db->where('pago', 1);
		$this->db->where('MONTH(fecha)', $mes_actual);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras.idpaquete');
		$q = $this->db->get('compras');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$compras = $value->idpaquete;

			}
			return $compras;
		}else{
			return 0;
		}
	}


	function _get_rango_idcodigo($idcodigo){
		$this->db->select('idrango');
		$this->db->where('idcod_socio', $idcodigo);
		$q = $this->db->get('codigo_socio');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $rango= $r->idrango;
            }
            return $rango;
        }else{
        	return 0;
        }
	}

	/**
	 * Devuelve último día de la semana
	 *
	 *
	 * @param Type $date
	 * @return type $date
	 * @fecha 21-12-2021
	 **/
	public function _get_lastday_of_week($primer_dia_semana){
		return date('Y-m-d', strtotime($primer_dia_semana. '+ 6 day'));
	}

	/**
	 * devuelve datos del patrocinador desde la tabla codigo_socio_binario
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _es_patrocinador($idsocio){
		$patro = null;
		//$idrango = $this->_get_rango_idcodigo($idcod_socio);
		$this->db->select('idcodigo_socio_binario,codigo_socio_binario');
		$this->db->where('patrocinador', $idsocio);
        $q = $this->db->get('codigo_socio_binario');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
				$patro[] = $p;
            }
            return $patro;
        }
        else{
        	return 0;
        }
	}

	/**
	 * devuelve datos del patrocinador desde la tabla codigo_socio_binario
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_patrocinados($idsocio){
		$patro = null;
		$this->db->select('idcodigo_socio_binario');
		$this->db->where('patrocinador', $idsocio);
        $q = $this->db->get('codigo_socio_binario');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
				$patro[] = $p;
            }
            return $patro;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Extrae los patrocinados directos
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _es_patrocinador_directo($idcod_socio){
		//$idrango = $this->_get_rango_idcodigo($idcod_socio);
		$this->db->select('*');
		$this->db->where('patrocinador', $idcod_socio);
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango = codigo_socio_binario.idrango');
        $q = $this->db->get('codigo_socio_binario');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
                $patro[] = $p;
            }
            return $patro;
        }
        else{
        	return 0;
        }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _get_posicion_max_matriz($matriz){
		$this->db->select_max('idsocio');
		$this->db->where('idmatrices', $matriz);
		$q = $this->db->get('codigo_socio');
		if ($q->num_rows() == 1) {
			foreach ($q->result() as $value) {
				$max = $value->idsocio;
			}
			return $max;
		}else{
			return 0;
		}
	}

	/**
	 * undocumented function
	 *
	 * @return cantidad a pagar
	 * @author Pablo Orejuela
	 **/
	function _calcula_regalias($id_codigo, $matriz){

		$regalias = 0;
		$max = $this->_get_posicion_max_matriz($matriz);
		//Ubicar posicion
		$posicion = $this->_get_posicion_matriz($matriz, $id_codigo);
		$fila = $this->_ubica_fila($posicion, $max);

		$inferior = pow(2, $fila-1);
		$superior = pow(2, $fila) - 1;

		//Verifico si esta llena su fila
		$fila_llena = $this->_socios_fila($matriz, $inferior, $superior);
		if ($fila_llena != $superior) {
			// echo 'La fia del socio No esta llena';
			return 0;
		}else{
		$inferior = $superior + 1;
		$superior = ($inferior * 2) - 1;
		$nivel = 1;
			while ($superior <= $max) {
				$fila += 1;
				$regalias = $this->_regalias_nivel($matriz, $superior, $inferior, $nivel, $regalias);
				$inferior = $superior + 1;
				$superior = ($inferior * 2) - 1;
				$nivel++;
			}
		}
		return $regalias;
	}
}

/* End of file Procesos_model.php */
/* Location: ./application/models/Procesos_model.php */
