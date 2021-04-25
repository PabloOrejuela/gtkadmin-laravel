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
	function _get_compras_confirmar_uninivel($data){

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
	 * Devuelve las compras sin confirmar uninivel
	 *
	 * @return void
	 * @author
	 **/
	function _get_compras_confirmar_binaria($data){

        //COMPRAS BINARIO
		$this->db->select('*');
		$this->db->where('pago', 0);
		if ($data['idciudad'] != NULL) {
                    $this->db->where('socios.idciudad', $data['idciudad']);
		}
		if ($data['cedula'] != NULL) {
                    $this->db->like('socios.cedula', $data['cedula']);
		}
		$this->db->join('codigo_socio_binario', 'compras_binario.idcodigo_socio_binario=codigo_socio_binario.idcodigo_socio_binario');
		$this->db->join('paquetes', 'paquetes.idpaquete=compras_binario.idpaquete');
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango=codigo_socio_binario.idrango');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->join('ciudad', 'socios.idciudad=ciudad.idciudad');
		$this->db->join('provincias', 'ciudad.id_provincia=provincias.idprovincia');
		$q = $this->db->get('compras_binario');
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
	function _confirmar_compra_binaria($idcompras){
		$this->db->trans_start();
		$this->db->set('pago', 1);
		$this->db->where('idcompras_binario', $idcompras);
		$this->db->update('compras_binario');
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
	function _confirmar_compra_binaria_principal($idcodigo_socio_binario){
		$mes = date('m');
		$this->db->trans_start();
		$this->db->set('pago', 1);
		$this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
		$this->db->where('MONTH(fecha)', $mes);
		$this->db->update('compras_binario');
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
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _eliminar_compra_binaria($idcompras){
		$this->db->trans_start();
		$this->db->where('idcompras_binario', $idcompras);
		$this->db->delete('compras_binario');
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
	function _get_datos_usuario_binario($cedula){
		$r = null;
		$this->db->select('nombres,apellidos');
		$this->db->where('cedula', $cedula);
		//$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
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
	function _get_idsocio($user){
		$this->db->select('idsocio');
		$this->db->where('cedula', $user);
        $q = $this->db->get('socios');
        if($q->num_rows() == 1){
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
	function _get_fecha_inscripcion($id){
		$r = 0;
		$this->db->select('fecha_inscripcion');
		$this->db->where('idcod_socio', $id);
        $q = $this->db->get('codigo_socio');
        if($q->num_rows() == 1){
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

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _get_ultima_compra_binaria($id_codigo, $fecha, $paquete){
		
        $q = $this->db->query("SELECT idcompras_binario FROM compras_binario
							join (
								SELECT MAX(fecha) as max_fecha from compras_binario) m ON m.max_fecha = compras_binario.fecha
			   				WHERE idcodigo_socio_binario = '..'");
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
	 * Esta funcio se usa para grabar la recompra binaria
	 *
	 * @return void
	 * @author
	 **/
    function _graba_compra_binaria($data){
        /*
        *	Se usa en las nuevas matrices
        */

        $this->db->trans_start();
        $this->db->set('idcodigo_socio_binario', $data['idcodigo_socio_binario']);
        $this->db->set('fecha', $data['fecha_recompra']);
        $this->db->set('idpaquete', $data['idpaquete']);
        $this->db->insert('compras_binario');
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return 0;
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
	function _graba_compra_binaria_admin($data){
		/*
		*	Se usa en las nuevas matrices
		*/

		$fecha_compra = date('Y-m-d');

		$this->db->trans_start();
		$this->db->set('idcodigo_socio_binario', $data['idcodigo_socio_binario']);
		if ($data['fecha'] == "0") {
			$this->db->set('fecha', $fecha_compra);
		}else{
			$fecha_recompra = date("Y-m-d", strtotime($data['fecha']));
			$this->db->set('fecha', $fecha_recompra);
		}

		$this->db->set('idpaquete', $data['idpaquete']);
		$this->db->set('pago', 1);
		$this->db->insert('compras_binario');
		$this->db->trans_complete();
		if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
        	return 1;
        }
	}

	function _graba_compra_old($data){
		/*
		 *	Cuando graba una compra debe verificar que tipo de compra es y sobre eso adjudicar la cantidad
		 *	de litros extra ganados por el patrocinador
		 *	Se utilizaba cuando habia matriz general y era cada mes
		*/

		// PABLO:  buscar la manera de que se pueda evitar que al refrescar la pag se vuelva a procesar la compra

		$anio_mes_actual = date('Y-m');
		$fecha_compra = date('Y-m-d');
		$mes_actual = date('m');
		$anio_actual = date('Y');
		$dia_actual = date('d');

		$fecha_inscripcion = $this->_get_fecha_inscripcion($data['id_codigo']);
		$fecha_inscripcion_obj = new DateTime($fecha_inscripcion);
		$dia_recompra = $fecha_inscripcion_obj->format('d');

		//Verifico si es febrero
		if ($mes_actual == '02') {
			if ($dia_recompra >= 28 && $dia_recompra <= 31) {
				$dia_recompra = 28;
			}
		}
		//Armo la fecha de recompra
		$fecha_repra = $anio_mes_actual.'-'.$dia_recompra;

		//Transformo en objeto
		$fecha_recompra_obj = new DateTime($fecha_repra);
		$feccha_re_temp = new DateTime($fecha_repra);

		//Al objeto le aumento los 3 dias de gracia
		$fecha_max_recompra = $feccha_re_temp->add(new DateInterval('P0Y0M03D'));

		$mes_maximo = $fecha_max_recompra->format('m').'<br>';
		if ($mes_maximo < $mes_actual) {
			$fecha_max_recompra = $feccha_re_temp->add(new DateInterval('P0Y0M30D'));
		}

		$fecha_compra = new DateTime($fecha_compra);

		$idmatriz = $this->_get_matriz_codigo($data['id_codigo']);

		// Verifica si es recompra o compra obtativa
		if ($fecha_compra >= $fecha_recompra_obj && $fecha_compra <= $fecha_max_recompra) {
			//RECOMPRA
			$fecha = $fecha_compra->format('Y-m-d');
			$ultima_compra = $this->_get_ultima_compra($data['id_codigo'], $fecha, $data['idpaquete']);


			$this->db->trans_start();
			$this->db->set('idcod_socio', $data['id_codigo']);
			$this->db->set('fecha', $fecha);
			$this->db->set('idpaquete', $data['idpaquete']);
			$this->db->set('recompra', 1);
			$this->db->insert('compras');
			$this->db->trans_complete();
			if ($this->db->trans_status() == FALSE) {
	        	$this->db->trans_rollback();
	            return 0;
	        } else {
	        	$patrocinador = $this->_get_patrocinador($data['id_codigo']);
	        	$idcompras = $this->_get_ultima_compra($data['id_codigo'], $fecha, $data['idpaquete']);
	        	if ($idmatriz != 4) {
	        		$t = $this->_insert_litros_ganados($patrocinador, $idcompras, $data['idpaquete'], 0);
	        	}else{
	        		$t = 1;
	        	}

	            if ($t == 1) {
	            	return 1;
	            }else{
	            	return 0;
	            }
	        }
		}else{
			//COMPRA OPTATIVA
			$fecha = $fecha_compra->format('Y-m-d');
			$this->db->trans_start();
			$this->db->set('idcod_socio', $data['id_codigo']);
			$this->db->set('fecha', $fecha);
			$this->db->set('idpaquete', $data['idpaquete']);
			$this->db->insert('compras');
			$this->db->trans_complete();
			if ($this->db->trans_status() == FALSE) {
	        	$this->db->trans_rollback();
	            return 0;
	        } else {
	        	$patrocinador = $this->_get_patrocinador($data['id_codigo']);
	        	$idcompras = $this->_get_ultima_compra($data['id_codigo'], $fecha, $data['idpaquete']);
	        	if ($idmatriz != 4) {
	        		$t = $this->_insert_litros_ganados($patrocinador, $idcompras, $data['idpaquete'], 1);
	        	}else{
	        		$t = 1;
	        	}

	            if ($t == 1) {
	            	return 1;
	            }else{
	            	return 0;
	            }
	        }
		}
	}

	/**
	 * Devuelve la matriz a la que pertenece el socio, luego hay que hacer que sea con el codigo
	 *
	 * @return void
	 * @author
	 **/
	function _get_matriz_codigo($id_codigo){
		$this->db->select('matrices.idmatrices,matriz');
		$this->db->where('codigo_socio.idcod_socio', $id_codigo);
		$this->db->join('rangos', 'rangos.idrango = codigo_socio.idrango');
		$this->db->join('matrices', 'matrices.idmatrices = rangos.idmatrices');
        $q = $this->db->get('codigo_socio');
        //$this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->idmatrices;
            }
            return $r;
        }
        else{
        	return 0;
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
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _graba_compra_primera($data){

		$this->db->trans_start();
		$fecha_compra = date('Y-m-d');
		$this->db->set('idcod_socio', $data['id_codigo']);
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
	 * Recibe datos del consumidor y registra la compra
	 *	
	 * @param array
	 * @return void
	 * @author Pablo Orejuela
	 * @fecha 16-11-2020 
	 **/
	function _graba_compra_consumidor($data){


		$this->db->trans_start();
		$fecha_compra = date('Y-m-d');
		$this->db->set('fecha', $fecha_compra);
		$this->db->set('confirmado', 0);
		$this->db->set('idpaquete', $data['idpaquete']);
		$this->db->set('idsocio', $data['idsocio']);
		$this->db->insert('compras_consumidores');
		$this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
            return 1;
        }
	}

	/**
	 * Graba la primera compra socio binario
	 *
	 * @return int
	 * @author Pablo Orejuela
	 * Fecha: 16-11-2020
	 **/
	function _graba_primera_compra_binaria($data){

			$fecha_compra = date('Y-m-d');
            $this->db->set('idcodigo_socio_binario', $data['ubicacion']);
            $this->db->set('fecha', $fecha_compra);
            $this->db->set('idpaquete', $data['idpaquete']);
			$this->db->insert('compras_binario');
			return $this->db->insert_id(); 
			//echo $this->db->last_query();
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
	
	/**
	 * Recibe datos y registra el bono constante de la primera compra al registrar el socio
	 *
	 * @param Type $var
	 * @return int 
	 * @throws conditon
	 **/
	public function _graba_bono_constante($data){
		$fecha = date('Y-m-d');
		$this->db->set('idcompras_binario', $data['idcompras_binario']);
		$this->db->set('fecha', $fecha);
		$this->db->set('idcod_socio', $data['cod_socio']);
		$this->db->insert('bono_constante_binario');
		return $this->db->insert_id();
	}

}

/* End of file Evento_model.php */
/* Location: ./application/models/Evento_model.php */