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

	


	/**
	 * Trae la información de los socios inactivos
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_info_inactivos(){
            $this->db->select('celular,codigo_socio_binario.idcodigo_socio_binario,codigo_socio_binario,fecha_inscripcion,nombres,apellidos,cedula');
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
	 * recibe la fecha de inscripcion y la de ultima compra y calcula el estado
	 *
	 * @return int
	 * @author Pablo Orejuela
	 */
	function _calcula_estado($fecha_inscripcion, $ultima_compra){
		$fecha_actual = date('Y-m-d');
		$fecha_actual_dia = date('d');
		$fecha_actual_mes = date('m');
		$fecha_actual_anio = date('Y');

		$fecha_inscripcion_dia = date('d', strtotime($fecha_inscripcion));
		$fecha_inscripcion_mes = date('m', strtotime($fecha_inscripcion));

		//Armo la fecha que le tocaba pagar
		
		if ($fecha_inscripcion_dia > $fecha_actual_dia ) {
			if ($fecha_actual_mes == 01) {
				$fecha = $fecha_actual_anio.'-12-'.$fecha_inscripcion_dia;
			}else{
				$fecha = $fecha_actual_anio.'-'.($fecha_actual_mes-1).'-'.$fecha_inscripcion_dia;
			}
		}else{
			$fecha = $fecha_actual_anio.'-'.$fecha_actual_mes.'-'.$fecha_inscripcion_dia;
		}

		$fecha_gracia = date("Y-m-d",strtotime($fecha."+ 3 days"));

		//echo $fecha_inscripcion.' - '.$fecha_gracia.'- '.$ultima_compra.'<br>';
		
		//CALCULO EL ESTADO
		if (strtotime($ultima_compra) >= strtotime($fecha) && strtotime($ultima_compra) <= strtotime($fecha_gracia)) {
			return 1;
		}else {
			return 0;
		}
	    

	}

	/**
	 * Trae la información de los socios inactivos
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_ultima_compra($idcodigo_socio_binario){

		$this->db->select('MAX(fecha) as fecha');
		$this->db->where('idcodigo_socio_binario =', $idcodigo_socio_binario);
		$this->db->order_by('idcodigo_socio_binario', 'asc');
		$q = $this->db->get('compras_binario');
		//echo $this->db->last_query();
		if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->fecha;
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
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _inserta_frontales($patrocinador, $idsocio, $padre, $rama){

		$fecha = date('Y-m-d');
		$this->db->set('codigo_socio_binario', 'UNDEFINED');
		$this->db->set('patrocinador', $patrocinador);
		$this->db->set('fecha_inscripcion', $fecha);
		$this->db->set('idsocio', $idsocio);
		$this->db->set('idrango', 1);
		$this->db->set('padre', $padre);
		$this->db->set('rama', $rama);
		$this->db->insert('codigo_socio_binario');
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

	function _get_hijos($codigo){
		$datos = null;
		$this->db->select('*');
		$this->db->where('codigo_socio.patrocinador', $codigo);
		$this->db->join('socios', 'socios.idsocio = codigo_socio.idcod_socio');
        $q = $this->db->get('codigo_socio');

        if($q->result() > 0){
        	$i =0;
            foreach ($q->result() as $row) {
                $datos[$i]['idcod_socio'] = $row->idcod_socio;
                $datos[$i]['codigo_socio'] = $row->codigo_socio;
                $datos[$i]['idmatrices'] = $row->idmatrices;
                $datos[$i]['patrocinador'] = $row->patrocinador;
                $datos[$i]['fecha_inscripcion'] = $row->fecha_inscripcion;
                $datos[$i]['nombres'] = $row->nombres;
                $datos[$i]['apellidos'] = $row->apellidos;
                $datos[$i]['cedula'] = $row->cedula;
                $datos[$i]['puntos'] = 100;
                $i++;
            }
            return $datos;
        }
        else{
        	return 0;
        }
	}

	function _get_misfrontales($idcod_socio){
		//pablo: Eliminar esta función pues hay una forma mas simple de calcular los frontales
		if ($idcod_socio!=null) {
			$this->db->where('padre', $idcod_socio);
			$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
			$this->db->order_by('idcodigo_socio_binario', 'asc');
			$q = $this->db->get('codigo_socio_binario');
	        if ($q->num_rows() > 0) {
	        	foreach ($q->result() as $row) {
	            	$frontales[] = $row;
	            }
	            return $frontales;
	        }
	    }else{
	    	return 0;
	    }
	}

	function _get_misfrontales_id($idcod_socio){
		if ($idcod_socio!=null) {
			$this->db->select('idcodigo_socio_binario');
			$this->db->where('padre', $idcod_socio);
			$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
			$this->db->order_by('idcodigo_socio_binario', 'asc');
			$q = $this->db->get('codigo_socio_binario');
	        if ($q->num_rows() > 0) {
	        	foreach ($q->result() as $row) {
	            	$frontales[] = $row;
	            }
	            return $frontales;
	        }
	    }else{
	    	return 0;
	    }
	}

	function _get_codigo_binario_by_idcodigo($idcod_socio){
        $codigo=null;
        $this->db->select('codigo_socio_binario');
        $this->db->where('idcodigo_socio_binario', $idcod_socio);
        $q = $this->db->get('codigo_socio_binario');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $codigo = $r->codigo_socio_binario;
            }
            return $codigo;
        }else{
            return $codigo;
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


	function _get_puntaje_by_codigo($codigo){
		$puntos=0;
		$this->db->select_max('puntos_paq');
		$this->db->where('compras_binario.idcodigo_socio_binario', $codigo);
		$this->db->where('pago', 1);
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idcodigo_socio_binario = compras_binario.idcodigo_socio_binario');
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$q = $this->db->get('compras_binario');
        //echo $this->db->last_query();
        if($q->result() > 0){
            foreach ($q->result() as $row) {
            	$puntos=$row->puntos_paq;
            }
            return $puntos;
        }else{
        	return $puntos;
        }
	    //echo "<br>Codigo: ".$codigo." - Puntos: ".$puntos;

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

	function _get_fecha_recompra($usuario){
		foreach ($usuario as $u) {
			//list($anio, $mes, $dia) =  explode('-', $u->fecha_inscripcion);
			//$fecha_inscripcion = strtotime($u->fecha_inscripcion);
			$fecha_recompra =  date('M');
			$fecha_inscripcion = new DateTime($u->fecha_inscripcion);
			$fecha_recompra = $fecha_inscripcion->add(new DateInterval('P0Y0M30D'));
			return $fecha_recompra;
		}
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
	 * Verifica si hay registrada regalía del mes y devuelve los valores
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _bono_mes_binario($idcod_socio, $mes_actual){

		$this->db->select('*');
		$this->db->where('idcod_socio', $idcod_socio);
		$this->db->where('MONTH(fecha_pago)', $mes_actual);
		$q = $this->db->get('p_binaria');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$bono['fecha_pago'] = $row->fecha_pago;
                $bono['puntos_izq'] = $row->puntos_izq;
                $bono['puntos_der'] = $row->puntos_der;
                $bono['sum_izq'] = $row->sum_izq;
                $bono['sum_der'] = $row->sum_der;
                $bono['base'] = $row->base;
                $bono['saldo_izq'] = $row->saldo_izq;
                $bono['saldo_der'] = $row->saldo_der;
                $bono['bono'] = $row->bono;
                $bono['pagado'] = $row->pagado;
			}
			return $bono;
		}else{
			return 0;
		}
	}

	/**
	 * Devuelve los todos registros de los bonos binarios
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _bono_histórico_binario($idcod_socio){

		$this->db->select('*');
		$this->db->where('idcod_socio', $idcod_socio);
		$q = $this->db->get('p_binaria');
		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$bono_historico[] = $row;
			}
			return $bono_historico;
		}else{
			return 0;
		}
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Orejuela
	 **/
	function _get_recompras_mes($mes){
		$anio = date('Y');
		$r = NULL;
		$this->db->select(
			'codigo_socio_binario.idcodigo_socio_binario,paquetes.idpaquete,
			codigo_socio_binario,paquete,fecha,nombres,apellidos,litros'
		);
		$this->db->where('MONTH(fecha)', $mes);
		$this->db->where('YEAR(fecha)', $anio);
		$this->db->where('pago', 1);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idcodigo_socio_binario = compras_binario.idcodigo_socio_binario');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$q = $this->db->get('compras_binario');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
                $r[] = $row;
			}
			return $r;
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
	function _get_recompras_mes_anterior($mes_actual){
		$anio = date('Y');
		$mes = ($mes_actual-1);

		$r = NULL;
		$this->db->select(
			'codigo_socio_binario.idcodigo_socio_binario,paquetes.idpaquete,
			codigo_socio_binario,paquete,fecha,nombres,apellidos,litros'
		);
		if ($mes == 0) {
			$this->db->where('MONTH(fecha)', 12);
			$anio = $anio-1;
		}else{
			$this->db->where('MONTH(fecha)', $mes);
		}
		
		$this->db->where('YEAR(fecha)', $anio);
		$this->db->where('pago', 1);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idcodigo_socio_binario = compras_binario.idcodigo_socio_binario');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$q = $this->db->get('compras_binario');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
                $r[] = $row;
			}
			return $r;
		}else{
			return 0;
		}
	}

	/**
	 * Función que extrae las recompras de los patrocinados
	 *
	 * @return 
	 * @author Pablo Orejuela
	 **/
	function _get_recompras_mes_anterior_patrocinados($mes_actual, $idcodigo_socio_binario){
		$anio = date('Y');
		$mes = ($mes_actual-1);

		$r = 0;
		$this->db->select(
			'MAX(paquete),bono'
		);
		if ($mes == 0) {
			$this->db->where('MONTH(fecha)', 12);
			$anio = $anio-1;
		}else{
			$this->db->where('MONTH(fecha)', $mes);
		}
		$this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
		$this->db->where('MONTH(fecha)', $mes);
		$this->db->where('pago', 1);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$q = $this->db->get('compras_binario');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$r += $row->bono;
			}
			return $r;
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
	function _get_fecha_inscripcion($codigo){
		$r = '';
		$this->db->select('fecha_inscripcion');
		$this->db->where('idcod_socio', $codigo);
        $q = $this->db->get('codigo_socio');
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $r = $row->fecha_inscripcion;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Devuelve la matriz a la que pertenece el socio, luego hay que hacer que sea con el codigo
	 *
	 * @return void
	 * @author
	 **/
	function _get_cedulas_socios_ciudad($ciudad, $matriz){
		$this->db->select('cedula');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->where('ciudad', $ciudad);
		$this->db->where('idmatrices', $matriz);
		$this->db->order_by('posicion', 'ASC');
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

	function _get_socios_by_ciudad($ciudad,$estado){
		$r=null;
		$this->db->select('*');
		$this->db->where('ciudad.ciudad', $ciudad);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'ciudad.id_provincia=provincias.idprovincia');
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

	function _get_socios_binarios_by_idciudad($idciudad){
		$r=null;
		$this->db->select('idcodigo_socio_binario,codigo_socio_binario,patrocinador,fecha_inscripcion,nombres,apellidos');
		$this->db->where('ciudad.idciudad', $idciudad);
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango = codigo_socio_binario.idrango');
		$this->db->order_by('apellidos', 'ASC');
        $q = $this->db->get('codigo_socio_binario');
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
	 * Devuelve la matriz a la que pertenece el socio, luego hay que hacer que sea con el codigo
	 *
	 * @return void
	 * @author
	 **/
	function _get_cedulas_socios_matriz_individual($matriz, $patrocinador){
		$r = null;
		$this->db->select('cedula');
		$this->db->where('patrocinador', $patrocinador);
		$this->db->where('idmatrices', $matriz);
        $q = $this->db->get('socios');
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

	function _get_array_socio_by_id($id){
		$this->db->select('*');
		$this->db->where('idsocio', $id);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$q = $this->db->get('socios');
		//echo $this->db->last_query().'<br>';
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio['id'] = $r->idsocio;
                $socio['nombres'] = $r->nombres;
                $socio['cedula'] = $r->cedula;
                $socio['socio_nuevo'] = $r->socio_nuevo;
                $socio['idciudad'] = $r->idciudad;
                $socio['idprovincia'] = $r->idprovincia;
				$socio['provincia'] = $r->provincia;
                $socio['direccion'] = $r->direccion;
                $socio['apellidos'] = $r->apellidos;
                $socio['celular'] = $r->celular;
                $socio['email'] = $r->email;
                $socio['idrol'] = $r->idrol;
                $socio['clave_socio'] = $r->clave_socio;
				$socio['logged_socio'] = $r->logged_socio;
            }
            return $socio;
        }else{
        	return 0;
        }
	}

	function _get_cuentas_socio_by_idcod($idcod){

		$primer_dia_semana = $this->_get_firstday_of_week();
		$ultimo_dia_semana = $this->_get_lastday_of_week($primer_dia_semana);

		$compras = 0;
		$this->db->select('*');
		$this->db->where('idcod_socio', $idcod);
		$this->db->where('fecha >=', $primer_dia_semana);
		$this->db->where('fecha <=', $ultimo_dia_semana);
		$this->db->where('pago', 1);
		$q = $this->db->get('compras');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $compras += 25;
            }
            return ($compras);
        }else{
        	return 0;
        }
	}

	/**
	 * summary
	 *
	 * @return void
	 * @author
	 */
	function _actualiza_semana($idcod_socio, $litros_movidos_totales, $litros_rango, $semana){

		// PABLO: Cooregir esta formula para que actualice la semana dependiendo de la fecha
		$semana_1 = $this->_get_semana_cumple($idcod_socio, 1);
		$semana_2 = $this->_get_semana_cumple($idcod_socio, 2);
		$semana_3 = $this->_get_semana_cumple($idcod_socio, 3);
		$semana_4 = $this->_get_semana_cumple($idcod_socio, 4);

		if ($litros_movidos_totales >= $litros_rango) {

			if ($semana_1 == 0 && $semana_2 == 0 && $semana_3 == 0 && $semana_4 == 0) {
				$this->db->where('idcod_socio', $idcod_socio);
				$this->db->set('semana_1' , $semana);
				//$this->db->update('codigo_socio');
			}else if($semana_1 == 1 && $semana_2 == 0 && $semana_3 == 0 && $semana_4 == 0){
				$this->db->where('idcod_socio', $idcod_socio);
				$this->db->set('semana_2' , $semana);
				//$this->db->update('codigo_socio');
			}else if($semana_1 == 1 && $semana_2 == 1 && $semana_3 == 0 && $semana_4 == 0){
				$this->db->where('idcod_socio', $idcod_socio);
				$this->db->set('semana_3' , $semana);
				//$this->db->update('codigo_socio');
			}else if($semana_1 == 1 && $semana_2 == 1 && $semana_3 == 1 && $semana_4 == 0){
				$this->db->where('idcod_socio', $idcod_socio);
				$this->db->set('semana_4' , $semana);
				//$this->db->update('codigo_socio');
			}

		}else{
			$this->db->where('idcod_socio', $idcod_socio);
			$this->db->set('semana_1' , 0);
			$this->db->set('semana_2' , 0);
			$this->db->set('semana_3' , 0);
			$this->db->set('semana_4' , 0);
			$this->db->update('codigo_socio');
		}
	}

    /**
     * verifica si ya ha cobrado el bono de triangulacion
     *
     * @return void
     * @author Pablo Orejuela
     **/
    function _verifica_triangulacion_cobrado($idcod_socio){
        $this->db->select('idtipobono_binario');
        $this->db->where('idcod_socio', $idcod_socio);
        $this->db->where('idtipobono_binario', 1);
        $q = $this->db->get('bonos_socios_binarios');
        if ($q->num_rows() > 0) {
        	foreach ($q->result as $i) {
        		$id = $i->idtipobono_binario;
        	}
        	return $id;
        }else{
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
	 * Devuelve la cantidad de socios UNINIVEL que registró en la semana
	 *
	 * @return void
	 * @author Pablo Orejuela
	 * @fecha: 21-12-2021
	 **/
	function _nuevos_socios_semana($idcod_socio){

		$socios = 0;
		$primer_dia_semana = $this->_get_firstday_of_week();
		$ultimo_dia_semana = $this->_get_lastday_of_week($primer_dia_semana);

		$this->db->select('idcod_socio');
		$this->db->where('patrocinador', $idcod_socio);
		$this->db->where('fecha_inscripcion >=', $primer_dia_semana);
		$this->db->where('fecha_inscripcion <=', $ultimo_dia_semana );
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            $socios = $q->num_rows();
            return $socios;
        }
        else{
        	return $socios;
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
	 * Devuelve primer día de la semana
	 *
	 * @param Type $date
	 * @return type $date
	 * @fecha 21-12-2021
	 **/
	public function _get_firstday_of_week(){
		$dia = date('w');
		if($dia == 7){
			$primer_dia_semana = date('Y-m-d', strtotime('- 6 day'));
		}elseif ($dia == 6) {
			$primer_dia_semana = date('Y-m-d', strtotime('- 5 day'));
		}elseif ($dia == 5) {
			$primer_dia_semana = date('Y-m-d', strtotime('- 4 day'));
		}elseif ($dia == 4) {
			$primer_dia_semana = date('Y-m-d', strtotime('- 3 day'));
		}elseif ($dia == 3) {
			$primer_dia_semana = date('Y-m-d', strtotime('- 2 day'));
		}elseif ($dia == 2) {
			$primer_dia_semana = date('Y-m-d', strtotime('- 1 day'));
		}elseif ($dia == 1) {
			$primer_dia_semana = date('Y-m-d');
		}

		return $primer_dia_semana;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _es_patrocinador_uninivel($idcod_socio){
		//$idrango = $this->_get_rango_idcodigo($idcod_socio);
		$this->db->select('idcod_socio');
		$this->db->where('patrocinador', $idcod_socio);
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
                $patro[] = $p->idcod_socio;
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
	 * Extrae los patrocinados directos
	 *
	 * @return void
	 * @author
	 **/
	function _es_patrocinador_uninivel_directo($idcod_socio){
		//$idrango = $this->_get_rango_idcodigo($idcod_socio);
		$this->db->select('*');
		$this->db->where('patrocinador', $idcod_socio);
		$this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
		$this->db->join('rangos', 'rangos.idrango = codigo_socio.idrango');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
                $patro[] = $p;
            }
            return $patro;
        }
        else{
        	return NULL;
        }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _es_patrocinador_BIR($idcod_socio){
		$r = null;
		$fecha_actual = date('Y-m-d');
		$dia = date('w');
		$primer_dia_semana = date('Y-m-d', strtotime('-'.($dia-1).' day'));
		$ultimo_dia_semana = date('Y-m-d', ($primer_dia_semana + strtotime('4 day')));
		$patrocinados_nuevos = 0;
		$this->db->select('idcod_socio');
		$this->db->where('codigo_socio.patrocinador', $idcod_socio);
		//$this->db->join('socios', 'socios.idsocio=codigo_socio.idsocio');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
                $fecha_inscripcion = $this->_get_fecha_inscripcion($p->idcod_socio);
                if ($fecha_inscripcion >= $primer_dia_semana && $fecha_inscripcion <= $primer_dia_semana) {
					$patrocinados_nuevos += 1;
				}else{
					$patrocinados_nuevos += 0;
				}
            }
            return $patrocinados_nuevos;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Esta funcion es similar a la del uninivel solo que el calculo se hace por mes
	 *
	 * @return INT
	 * @author Pablo Orejuela
	 **/
	function _es_patrocinador_BIR_binario($idcod_socio){

            $r = null;
            $mes_actual = date('m');
            $patrocinados_nuevos = 0;
            //$idrango = $this->_get_rango_idcodigo_binario($idcod_socio);
            $this->db->select('idcodigo_socio_binario');
            $this->db->where('codigo_socio_binario.patrocinador', $idcod_socio);
            //$this->db->where('codigo_socio_binario.idrango', $idrango);
            $this->db->where('MONTH(fecha_inscripcion)', $mes_actual);
            //$this->db->join('socios', 'socios.idsocio=codigo_socio.idsocio');
            //$this->db->join('rangos', 'rangos.idrango = codigo_socio_binario.idrango');
            $q = $this->db->get('codigo_socio_binario');
            //echo $this->db->last_query();
            if($q->num_rows() > 0){
                foreach ($q->result() as $p) {
                    $patrocinados_nuevos += 1;
                }
                return $patrocinados_nuevos;
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
	function _get_idsocio($cedula){
		$r = null;
		$this->db->select('idsocio');
		$this->db->where('cedula', $cedula);
        $q = $this->db->get('socios');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->idsocio;
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
	 * @return void
	 * @author
	 **/
	function _get_nombre_id_socio($id){
		$r = null;
		$this->db->select('nombres,apellidos');
		$this->db->where('idsocio', $id);
        $q = $this->db->get('socios');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->nombres.' '.$row->apellidos;
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
	 * @return void
	 * @author
	 **/
	function _get_cedula_id_socio_binario($id){
		$r = null;
		$this->db->select('cedula');
		$this->db->where('idcodigo_socio_binario', $id);
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
        $q = $this->db->get('socios');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->cedula;;
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
	 * @return void
	 * @author
	 **/
	function _get_rama_id_socio($id){
		$r = null;
		$this->db->select('rama');
		$this->db->where('idcodigo_socio_binario', $id);
        $q = $this->db->get('codigo_socio_binario');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->rama;;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Devuelve la posicion en la matriz
	 *
	 * @return INT
	 * @author Pablo Orejuela
	 **/
	function _get_posicion_matriz($matriz, $codigo_socio){
		//$codigo_socio = $this->_get_codigo_socio($cedula, $matriz);
		$this->db->select('idcod_socio');
		$this->db->where('idmatrices', $matriz);
		$this->db->where('idcod_socio', $codigo_socio);
		$q = $this->db->get('codigo_socio');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $posicion = $r->idcod_socio;
            }
            return $posicion;
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

	/**
	 * undocumented function
	 *
	 * @return cantidad a pagar
	 * @author Pablo Orejuela
	 **/
	function _calcula_regalias_patrocinador($cedula, $matriz){

		$regalias = 0;
		$max = $this->_get_posicion_max_matriz($matriz);
		//Ubicar posicion
		$posicion = 1;
		$fila = 1;

		$inferior = pow(2, $fila-1);
		$superior = pow(2, $fila) - 1;

		//Verifico si esta llena su fila
		$fila_llena = 1;
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

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _ubica_fila($posicion, $max){
		$inf = 0;
		$sup = 1;
		$fila= 0;
		while ($posicion >= pow(2, $inf) && $posicion <= $max) {
			$inf++;
			$sup++;
			$fila++;
		}
		return $fila;
	}

	/**
	 * Verifica si esta llena la siguiente fila en la matriz
	 *
	 * @return int
	 * @author Pablo Orejuela
	 **/
	function _socios_fila($matriz, $desde, $hasta){
		$socios = 0;
		for($i = $desde; $i <= $hasta; $i++){
			$this->db->select('idsocio,posicion');
			$this->db->where('idmatrices', $matriz);
			$this->db->where('posicion', $i);
			$q = $this->db->get('codigo_socio');
			if ($q->num_rows() == 1) {
				foreach ($q->result() as $value) {
					$socios = $value->posicion;
				}
			}else{
				$socios = 0;
				break;
			}
		}
		return $socios;
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

/* End of file Procesos_model.php */
/* Location: ./application/models/Procesos_model.php */
