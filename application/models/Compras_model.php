<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras_model extends CI_Model {

	private $IVA = 0.12;

	/**
	 * Devuelve las compras sin confirmar uninivel
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_compras_confirmar($data){

            //COMPRAS UNINIVEL
            $this->db->select('*');
            $this->db->where('pago', 0);
            if ($data['idciudad'] != NULL) {
                $this->db->where('socios.idciudad', $data['idciudad']);
            }
            if ($data['cedula'] != NULL) {
                $this->db->like('socios.cedula', $data['cedula']);
            }
            $this->db->join('codigo_socio', 'compras.idcod_socio=codigo_socio.idcod_socio');
            //Paquete de Uninivel es siempre el 4
            $this->db->join('paquetes', 'idpaquete=4');
            $this->db->join('rangos', 'rangos.idrango=codigo_socio.idrango');
            $this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
            $this->db->join('ciudad', 'socios.idciudad=ciudad.idciudad');
            $this->db->join('provincias', 'ciudad.id_provincia=provincias.idprovincia');
            $q = $this->db->get('compras');
            //echo $this->db->last_query();
            if ($q->num_rows() > 0) {
                foreach ($q->result_array() as $r) {
                    $filas[] = $r;
                }
                return $filas;
            }else{
                return NULL;
            }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _confirmar_compra($idcompras){
		$this->db->trans_start();
		$this->db->set('pago', 1);
		$this->db->where('idcompras', $idcompras);
		$this->db->update('compras');
		$this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
            return 1;
        }
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _eliminar_compra($idcompras){
		$this->db->trans_start();
		$this->db->where('idcompras', $idcompras);
		$this->db->delete('compras');
		$this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
            return 1;
        }
	}

	/**
	 * GETTER de la propiedad IVA
	 *
	 * @return DOUBLE
	 * @author
	 **/
	function _get_IVA(){
		return $this->IVA;
	}

	/**
	 * undocumented function
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_datos_user($user, $pass){
		$this->db->select('*');
		$this->db->where('cedula', $user);
		$this->db->where('clave_socio', md5($pass));
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


	/**
	 * undocumented function
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _get_codigos_usuario_binario($cedula){
		$r = null;
		$this->db->select('idcodigo_socio_binario,codigo_socio_binario,fecha_inscripcion');
		$this->db->where('cedula', $cedula);
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
        $q = $this->db->get('codigo_socio_binario');
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
	 * @return void
	 * @author
	 **/
	function _get_patrocinador($id){
		$this->db->select('patrocinador');
		$this->db->where('idcod_socio', $id);
        $q = $this->db->get('codigo_socio');
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $r = $row->patrocinador;
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
	function _get_ultima_compra($id_codigo, $fecha, $paquete){
		$r = 0;
		$this->db->select('idcompras');
		$this->db->where('idcod_socio', $id_codigo);
		$this->db->where('fecha', $fecha);
		$this->db->where('idpaquete', $paquete);
        $q = $this->db->get('compras');
        if($q->result() > 0){
            foreach ($q->result() as $row) {
                $r = $row->idcompras;
            }
            return $r;
        }
        else{
        	return 0;
        }
	}

	/*
	SELECT `idcompras_binario` FROM `compras_binario`
join (SELECT MAX(`fecha`) as max_fecha from `compras_binario`) m ON m.max_fecha = `compras_binario`.`fecha`
       WHERE `idcodigo_socio_binario` = 9
	*/

	function _obten_paquetes($matriz){
		//Cambiar el tema de los paquetes cuando se ponga el nuevo plan de compensacion
		$this->db->select('*');
		$this->db->where('idmatrices', $matriz);
		$this->db->order_by('paquete', 'ASC');
		$q = $this->db->get('paquetes');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $paquetes[] = $r;
            }
            return $paquetes;
        }else{
        	return 0;
        }
	}

	function _obten_fecha_recompra($usuario){
		foreach ($usuario as $u) {
			//list($anio, $mes, $dia) =  explode('-', $u->fecha_inscripcion);
			//$fecha_inscripcion = strtotime($u->fecha_inscripcion);
			$fecha_recompra =  date('M');
			$fecha_inscripcion = new DateTime($u->fecha_inscripcion);
			$fecha_recompra = $fecha_inscripcion->add(new DateInterval('P0Y0M30D'));
			return $fecha_recompra;
		}
	}

	function _obten_fecha_recompra_by_codigo($codigo){

			//list($anio, $mes, $dia) =  explode('-', $u->fecha_inscripcion);
			//$fecha_inscripcion = strtotime($u->fecha_inscripcion);
			$fecha_recompra =  date('M');
			$fecha_inscripcion = new DateTime($codigo['fecha_inscripcion']);
			$fecha_recompra = $fecha_inscripcion->add(new DateInterval('P0Y0M30D'));
			return $fecha_recompra;

	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _graba_compra($data){
            /*
            *	Se usa en las nuevas matrices
            */

            $fecha_compra = date('Y-m-d');

            $this->db->trans_start();
            $this->db->set('idcod_socio', $data['idcod_socio']);
            $this->db->set('fecha', $fecha_compra);
            $this->db->set('recompra', 1);
            $this->db->insert('compras');
            $this->db->trans_complete();
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
        	return 1;
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
     * Elimina las compras de la tabla compras
     *
     * @param Type $idcod_socio
     * @return type void
     * @autor Pablo Orejuela
     **/
    public function _delete_compras($idcod_socio){
        
        $this->db->trans_start();
        $this->db->where('idcod_socio', $idcod_socio);
        $this->db->delete('compras');
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            echo 'Hubo un error y no se pudo borrar el usuario';
        }

    }


	/**
	 * Esta funcion inserta los litros extra que gana el patrocinador con la compra que
	 * realiza su patrocinado
	 *
	 * @return void
	 * @author
	 **/
	function _insert_litros_ganados($id_codigo, $idcompras, $paquete, $litros){

		//Verificar si es recompra o optativa, solo en optativa gana el patrocinbador 1 litro
		$this->db->trans_start();
		$this->db->set('idcod_socio', $id_codigo);
		$this->db->set('litros_ganados', $litros);
		//$this->db->where('idsocio', $idsocio);
		$this->db->set('idcompras', $idcompras);
		$this->db->insert('litros_ganados');
		$this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
            return 1;
        }
	}

    /**
     * Extrae el bono que corresponda al paquete que compró
     *
     * @return double
     * @author Pablo Orejuela
     */
    function _obten_bono_paquete($paquete){
        $this->db->select('bono');
        $this->db->where('paquete', $paquete);
        $q = $this->db->get('paquetes');
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $r) {
                $bono = $r->bono;
            }
            return $bono;
        }else{
            return 0;
        }
	}
	
}

/* End of file Evento_model.php */
/* Location: ./application/models/Evento_model.php */
