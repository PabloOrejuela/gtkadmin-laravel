<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion_model extends CI_Model {

	function _get_ciudades($id=null){
		$ciudades=null;
		if ($id!=null) {
			$this->db->where('id_provincia', $id);
		}
		$this->db->select('*');
		$this->db->order_by('ciudad', 'ASC');
		$q = $this->db->get('ciudad');
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $ciudades[] = $r;
            }

        }
        return $ciudades;
	}

    /**
     * Esta función verifica las compras de los codigos principales de CARLOS
     *
     * @return bool
     * @author Pablo Orejuela
     **/
    function _get_compras_principales($idcodigo_socio_binario){
        $mes = date('m');

        $this->db->select('idcompras_binario');
        $this->db->where('MONTH(fecha)', $mes);
        $this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
        $q = $this->db->get('compras_binario');
        if ($q->num_rows() > 0) {
            return 1;
        }else{
            return 0;
        }
    }
    
    /**
     * Esta función verifica las compras de los codigos principales de CARLOS
     *
     * @return bool
     * @author Pablo Orejuela
     **/
    function _get_fecha_inscripcion($idcodigo_socio_binario){

        $this->db->select('fecha_inscripcion');
        $this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
        $q = $this->db->get('codigo_socio_binario');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $fecha = $r->fecha_inscripcion;
            }
            return $fecha;
        }else{
            return 0;
        }
    }

    function _obtenCiudad($provincia){
        $this->db->select('*');
        $this->db->where('id_provincia', $provincia);
        $this->db->order_by('ciudad', 'ASC');
        $q = $this->db->get('ciudad');
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $r) {
                $ciudades[] = $r;
            }
            return $ciudades;
        }else{
                return 0;
        }
    }

    function _obten_paquetes($matriz){
        $this->db->select('*');
        $this->db->where('idmatrices', $matriz);
        $this->db->order_by('paquete', 'ASC');
        $q = $this->db->get('paquetes');
        if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $r) {
                $paquetes[] = $r;
            }
            return $paquetes;
        }else{
                return 0;
        }
    }

    function _get_paquetes(){
        $paquetes = null;
        $this->db->select('*');
        $this->db->order_by('paquete', 'ASC');
        $q = $this->db->get('paquetes');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $paquetes[] = $r;
            }
        }
        return $paquetes;
    }

	function _obten_red($patrocinador){

        /*Función que arma la red del usuario*/
		$this->db->select('*');
		//$this->db->where('patrocinador >=', $patrocinador);
		$this->db->or_where('idcodigo_socio_binario >=', $patrocinador);
        $this->db->where('codigo_socio_binario ==', 'UNDEFINED');
        $this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
                foreach ($q->result_array() as $s) {
                    $socios[] = $s;
                }
                return $socios;
            }else{
                    return 0;
            }
    }
    
    /**
     * Va formando un array con 6 filas desde el codigo del patrocinador sin consultas a la
     * base de datos
     *
     * @param INT
     * @return array
     * @autor: Pablo Orejuela
     * @revisión 27-11-2020
     **/
    public function _arma_red_binaria($patrocinador){
        //pablo Ver como hacer para que esto se haga con un bucle y no así fila por fila
        $red[] = null;
        $izquierda = $patrocinador*2;
        $derecha = $izquierda+1;
        $fila = [$izquierda, $derecha];
        $red = $fila;

        $izquierda = $izquierda*2;
        $derecha = ($izquierda)+3;
        $fila = null;
        for($i=$izquierda; $i <=$derecha; $i++) { 
            $fila[] += $i;
        }
        $red = array_merge($red, $fila);

        $izquierda = $izquierda*2;
        $derecha = ($izquierda)+6;
        $fila = null;
        for($i=$izquierda; $i <=$derecha; $i++) { 
            $fila[] += $i;
        }
        $red = array_merge($red, $fila);

        $izquierda = $izquierda*2;
        $derecha = ($izquierda)+12;
        $fila = null;
        for($i=$izquierda; $i <=$derecha; $i++) { 
            $fila[] += $i;
        }
        $red = array_merge($red, $fila);

        $izquierda = $izquierda*2;
        $derecha = ($izquierda)+24;
        $fila = null;
        for($i=$izquierda; $i <=$derecha; $i++) { 
            $fila[] += $i;
        }
        $red = array_merge($red, $fila);
        return $red;
    }

	function _obten_socios($data){
		$this->db->select('*');
		$this->db->where('idciudad', $data['id_ciudad']);
		$this->db->where('idmatrices', $data['matriz']);
		$this->db->order_by('apellidos', 'ASC');
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $s) {
                $socios[] = $s;
            }
            return $socios;
        }else{
        	return 0;
        }
	}

	function _obten_patrocinador($patrocinador){
		$this->db->select('*');
		$this->db->where('idsocio', $patrocinador);
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $s) {
                $socios[] = $s;
            }
            return $socios;
        }else{
        	return 0;
        }
	}

	function _get_provincias(){
		$provincia=null;
		$this->db->select('*');
		$this->db->order_by('provincia', 'asc');
		$q = $this->db->get('provincias');
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $provincia[] = $r;
            }

        }
        return $provincia;
	}

	function _get_matrices(){
		$matriz=null;
		$this->db->select('*');
		$this->db->where('idmatrices >', 3);
		$q = $this->db->get('matrices');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $matriz[] = $r;
            }
            return $matriz;
        }else{
        	return 0;
        }
	}

	function _get_bancos(){
		$bancos=null;
        $this->db->select('*');
        $this->db->order_by('banco', 'asc');
        
		$q = $this->db->get('banco');
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $bancos[] = $r;
            }

        }
        return $bancos;
	}

	function _get_socio_by_cedula($cedula){
		$this->db->select('*');
		$this->db->where('cedula', $cedula);
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio[] = $r;
            }
            return $socio;
        }else{
        	return 0;
        }
    }
    
    /**
     * devuelve el idsocio dada la cédula
     *
     * @param string
     * @return int
     * @author Pablo Orejuela1
     * @revision 16-11-2020
     **/
    function _get_idsocio_by_cedula($cedula){
		$this->db->select('idsocio');
		$this->db->where('cedula', $cedula);
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio = $r->idsocio;
            }
            return $socio;
        }else{
        	return 0;
        }
    }

	function _get_array_socio_by_cedula($cedula){
        $socio['id'] = 0;
		$this->db->select('*');
		$this->db->where('cedula', $cedula);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$q = $this->db->get('socios');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio['id'] = $r->idsocio;
                $socio['nombres'] = $r->nombres;
                $socio['cedula'] = $r->cedula;
                $socio['idciudad'] = $r->idciudad;
                $socio['idprovincia'] = $r->idprovincia;
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
        	return $socio;
        }
	}

	function _get_array_socio_by_id($id){
		$this->db->select(
            'socios.idsocio,nombres,cedula,socios.idciudad,
            idprovincia,direccion,apellidos,celular,email,idrol,
            clave_socio,logged_socio,rango,codigo_socio_binario'
        );
		$this->db->where('socios.idsocio', $id);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango = codigo_socio_binario.idrango');
		$q = $this->db->get('socios');
		//echo $this->db->last_query().'<br>';
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio['id'] = $r->idsocio;
                $socio['nombres'] = $r->nombres;
                $socio['cedula'] = $r->cedula;
                $socio['idciudad'] = $r->idciudad;
                $socio['idprovincia'] = $r->idprovincia;
                $socio['direccion'] = $r->direccion;
                $socio['apellidos'] = $r->apellidos;
                $socio['celular'] = $r->celular;
                $socio['email'] = $r->email;
                $socio['idrol'] = $r->idrol;
                $socio['clave_socio'] = $r->clave_socio;
				$socio['logged_socio'] = $r->logged_socio;
                $socio['rango'] = $r->rango;
                $socio['codigo_socio_binario'] = $r->codigo_socio_binario; 
            }
            return $socio;
        }else{
        	return 0;
        }
	}

	function _get_array_socio_by_criterio($criterio){
		$this->db->select('*');
		$this->db->or_like('cedula', $criterio);
		// $this->db->or_like('socios.nombres', $criterio);
		// $this->db->or_like('socios.apellidos', $criterio);
		// $this->db->or_like('codigo_socio.codigo_socio', $criterio);
  //       $this->db->or_like('codigo_socio_binario.idcodigo_socio_binario', $criterio);
		// $this->db->or_like('socios.idciudad', $criterio);
		//$this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
        $this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
        // $this->db->join('codigo_socio', 'codigo_socio.idsocio = socios.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$q = $this->db->get('socios');
        //$this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio[] = $r;
            }
            return $socio;
        }else{
        	return 0;
        }
	}

	function _get_array_socio_by_filtros($data){
		$this->db->select('*');
		$this->db->like('socios.cedula', $data['criterio_socio']);
		$this->db->like('socios.nombres', $data['criterio_socio']);
		$this->db->like('socios.apellidos', $data['criterio_socio']);
		$this->db->like('codigo_socio.codigo_socio', $data['codigo_socio']);
		if($data['id_ciudad']!=null && $data['id_ciudad']!=''){
			$this->db->where('socios.idciudad', $data['id_ciudad']);
		}
		$this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$q = $this->db->get('codigo_socio');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio[] = $r;
            }
            return $socio;
        }else{
        	return 0;
        }
	}

	function _get_primera_cuenta_socio($id){
		$cuenta=null;
		$this->db->select('*');
		$this->db->where('idsocio', $id);
		$q = $this->db->get('cta_banco');
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $cuenta['num_cta'] = $r->num_cta;
                $cuenta['idbanco'] = $r->idbanco;
                $cuenta['idtipo_cuenta'] = $r->idtipo_cuenta;
            }
            return $cuenta;
        }else{
        	return 0;
        }
    }
    
    /**
     * Cambia el password cuando se lo recupera
     *
     * @param Type string
     * @return type void
     * @throws conditon
     **/
    public function _set_password($password, $data){
        $this->db->set('clave_socio', md5($password));
        $this->db->where('cedula', $data['cedula']);
        $this->db->update('socios'); 
    }


    /**
     * Recibe el email y devuelve los datos asociados al dueño de ese email
    */
    function _get_data_usuario($data){
        $socio[] = null; 
        $this->db->select('*');
        $this->db->where('email', $data['email']);
        //$this->db->or_where('cedula', $data['cedula']); 
        $this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
        $q = $this->db->get('socios');
        //echo $this->db->last_query();
        
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio = $r;
            }
        }
        return $socio;
	}

    /**
     * Recibe el CI y devuelve los datos asociados al dueño de ese CI
    */
    function _get_data_usuario_ci($data){
        $socio[] = null; 
        $this->db->select('*');
        $this->db->where('cedula', $data['user']);
        $q = $this->db->get('socios');
        //echo $this->db->last_query();
        
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $socio = $r;
            }
        }
        return $socio;
	}

	function _get_cuenta_socio_by_id($idsocio){
		$this->db->select('idcta_banco');
		$this->db->where('idsocio', $idsocio);
		$q = $this->db->get('cta_banco');
		if ($q->num_rows() > 0) {
            return 1;
        }else{
        	return 0;
        }
	}

    function _get_patrocinador_by_id_socio($id){
        $this->db->select('patrocinador');
        $this->db->where('idsocio', $id);
        $q = $this->db->get('socios');
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $r) {
            $socio = $r->patrocinador;
        }
        
            return $socio;
        }else{
        	return 0;
        }
    }

    function _get_codigos_by_socio($id_socio){
        /*Devuelve los codigos UNINIVEL del usuario*/
        $codigos=null;
        $this->db->select('*');
        $this->db->where('codigo_socio.idsocio', $id_socio);
        $this->db->join('socios', 'socios.idsocio=codigo_socio.idsocio');
        $this->db->join('rangos', 'rangos.idrango=codigo_socio.idrango');
        $this->db->order_by('idcod_socio', 'asc');
        $q = $this->db->get('codigo_socio');
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $r) {
            $codigos[] = $r;
        }
            return $codigos;
        }else{
            return $codigos;
        }
    }

    function _get_codigos_binarios_by_socio($id_socio){
        $codigos=null;
        $this->db->select('*');
        $this->db->where('codigo_socio_binario.idsocio', $id_socio);
        $this->db->join('socios', 'socios.idsocio=codigo_socio_binario.idsocio');
        $this->db->join('rangos', 'rangos.idrango=codigo_socio_binario.idrango');
        $this->db->order_by('idcodigo_socio_binario', 'asc');
        $q = $this->db->get('codigo_socio_binario');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $codigos[] = $r;
            }
            return $codigos;
        }else{
            return $codigos;
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

    function _get_codigo_binario_by_cedula($cedula){
        $codigo=null;
        $this->db->select('MIN(idcodigo_socio_binario) as id');
        $this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
        $this->db->where('cedula', $cedula);
        $q = $this->db->get('codigo_socio_binario');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $codigo = $r->id;
            }
            return $codigo;
        }else{
            return $codigo;
        }
    }

    function _get_min_cod_binario_by_idsocio($id_socio){
        $this->db->select_min('idcodigo_socio_binario', 'min_codigo_binario');
        $this->db->where('idsocio', $id_socio);
        $this->db->order_by('idcodigo_socio_binario', 'asc');
        $q = $this->db->get('codigo_socio_binario');
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $r) {
                $codigo = $r->min_codigo_binario;
            }
            return $codigo;
        }else{
            return 0;
        }
    }

    function _get_codigo_socio_by_id($id_socio){
        $codigos=null;
        $this->db->select('*');
        $this->db->where('codigo_socio.idcod_socio', $id_socio);
        $this->db->join('matrices', 'matrices.idmatrices=codigo_socio.idmatrices');
        $this->db->join('socios', 'socios.idsocio=codigo_socio.patrocinador');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $r) {
            $codigos['id_codigo'] = $r->idcod_socio;
            $codigos['codigo'] = $r->codigo_socio;
            $codigos['id_matriz'] = $r->idmatrices;
            $codigos['matriz'] = $r->matriz;
            $codigos['id_patrocinador'] = $r->patrocinador;
            $codigos['fecha_inscripcion'] = $r->fecha_inscripcion;
            $codigos['id_socio'] = $r->idsocio;
        }
            return $codigos;
        }else{
            return null;
        }
    }

    function _get_codigo_by_id_codigo($idcodigo){
        $codigos=null;
        $this->db->select('*');
        $this->db->where('codigo_socio.idcod_socio', $idcodigo);
        $this->db->join('matrices', 'matrices.idmatrices=codigo_socio.idmatrices');
        $this->db->join('socios', 'socios.idsocio=codigo_socio.idsocio');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $r) {
                $codigos['id_codigo'] = $r->idcod_socio;
                $codigos['codigo'] = $r->codigo_socio;
                $codigos['id_matriz'] = $r->idmatrices;
                $codigos['matriz'] = $r->matriz;
                $codigos['id_patrocinador'] = $r->patrocinador;
                $codigos['fecha_inscripcion'] = $r->fecha_inscripcion;
                $codigos['id_socio'] = $r->idsocio;
            }
            return $codigos;
        }else{
            return null;
        }
    }

    /*
    * Esta función hora registra a todo tipo de socios
    * 
    * Param: array
    * Return: array
    */
    function _registrar_socio($socio){

        $this->db->trans_start();
        $this->db->set('nombres',strtoupper($socio['nombres']));
        $this->db->set('apellidos',strtoupper($socio['apellidos']));
        $this->db->set('cedula',$socio['cedula']);
        $this->db->set('idciudad',$socio['idciudad']);
        $this->db->set('direccion',strtoupper($socio['direccion']));
        $this->db->set('celular',$socio['celular']);
        $this->db->set('email',$socio['email']);
        $this->db->set('idrol', 3);
        $this->db->set('clave_socio',md5($socio['cedula']));
        $this->db->set('logged_socio',0);
        $this->db->insert('socios');
        $filas = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        } else {
            return $filas;
            ;
        }
    }

	function _registrar_cta_socio($socio){
		$this->db->trans_start();
    	$this->db->set('idtipo_cuenta',$socio['idtipo_cuenta']);
		$this->db->set('idbanco',$socio['idbanco']);
		$this->db->set('num_cta',$socio['num_cta']);
		$this->db->set('idsocio',$socio['idsocio']);
		$this->db->insert('cta_banco');
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            return 0;
        }else {
            return 1;
        }
	}

	/**
	 * Devuelve el código binario dada la ubicación en la matriz
	 *
	 * @return void
	 * @author Pablo Orejuela
     * @revision: 28-11-2020
	 **/
	function _calcula_codigo($data){

		/*
			Código provincia
			primera letra nombre
			primera letra apellido segundo apellido
            concatenado con "/"
			primera letra de la matriz
			numero de la posición dentro de la matriz
		*/
		$prim_nombre = $data['nombres'];
		$prim_apellido = $data['apellidos'];

		if ($data['idmatrices'] == 2) {
			$pri_matriz = 'B';
		}else{
			$pri_matriz = 'U';
        }
        
        $cod_socio =  $data['cod_provincia'].strtoupper($prim_nombre[0]).strtoupper($prim_apellido[0]).'/'.$pri_matriz.$data['ubicacion'];

        // if ($data['rama'] == 1) {
        //     $cod_socio =  $data['cod_provincia'].strtoupper($prim_nombre[0]).strtoupper($prim_apellido[0]).'/'.$pri_matriz.(($data['padre']*2));
        // }else if($data['rama'] == 2){
        //     $cod_socio =  $data['cod_provincia'].strtoupper($prim_nombre[0]).strtoupper($prim_apellido[0]).'/'.$pri_matriz.(($data['padre']*2)+1);
        // }
		return $cod_socio;
    }
    
    /**
	 * Calcula el código binario del socio conociendo la ubicación
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _calcula_codigo_ubicacion($data){

		/*
			Código provincia
			primera letra nombre
			primera letra apellido segundo apellido
            concatenado con "/"
			primera letra de la matriz
			numero de la posición dentro de la matriz
		*/
		$prim_nombre = $data['nombres'];
		$prim_apellido = $data['apellidos'];

		if ($data['idmatrices'] == 2) {
			$pri_matriz = 'B';
		}else{
			$pri_matriz = 'U';
		}
        if ($data['rama'] == 1) {
            $cod_socio =  $data['cod_provincia'].strtoupper($prim_nombre[0]).strtoupper($prim_apellido[0]).'/'.$pri_matriz.$data['ubicacion'];
        }else if($data['rama'] == 2){
            $cod_socio =  $data['cod_provincia'].strtoupper($prim_nombre[0]).strtoupper($prim_apellido[0]).'/'.$pri_matriz.$data['ubicacion'];
        }
		return $cod_socio;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _get_idprovincia($idsocio){
		$this->db->select('id_provincia');
		$this->db->where('idsocio', $idsocio);
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$q = $this->db->get('socios');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$cod = $value->id_provincia;
			}
			return $cod;
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
	function _get_cod_provincia($idprovincia){
		$this->db->select('cod_provincia');
		$this->db->where('idprovincia', $idprovincia);
		$q = $this->db->get('provincias');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$cod = $value->cod_provincia;
			}
			return $cod;
		}else{
			return 0;
		}
	}

	/**
	 * undocumented function
	 * @arg Array Codigo
	 * @return int
	 * @author Pablo Orejuela
	 **/
	function _inserta_codigo($data){
		$this->db->trans_start();
		$this->db->set('codigo_socio', $data['cod_socio']);
		$this->db->set('idrango', $data['idrango']);
		$this->db->set('patrocinador', $data['patrocinador']);
		$this->db->set('fecha_inscripcion', date('Y-m-d'));
		$this->db->set('idsocio', $data['idsocio']);
		$this->db->insert('codigo_socio');
		$filas = $this->db->affected_rows();
		$this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
        	$this->db->trans_rollback();
            return 0;
        }else {
        	if ($filas>0) {
        		$q = $this->db->query('select last_insert_id() as last;');
	            foreach ($q->result() as $row) {
	                $lastid = $row->last;
	                return $lastid;
	            }
        	}
            return 1;
        }
    }

    /**
     * Funcion que inserta un codigo binario en caso de no existir, ya no se la va a usar por que
     * se va a hacer update en la posicion de la piramide
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     **/
    function _inserta_codigo_binario($data){
        $this->db->trans_start();
        $this->db->set('codigo_socio_binario', $data['cod_socio']);
        $this->db->set('patrocinador', $data['patrocinador']);
        $this->db->set('fecha_inscripcion', date('Y-m-d'));
        $this->db->set('idsocio', $data['idsocio']);
        $this->db->set('idrango', $data['idrango']);
        $this->db->set('padre', $data['padre']);
        $this->db->set('rama', $data['rama']);
        $this->db->insert('codigo_socio_binario');
        $filas = $this->db->affected_rows();
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else {
            if ($filas>0) {
                    $q = $this->db->query('select last_insert_id() as last;');
                foreach ($q->result() as $row) {
                    $lastid = $row->last;
                    return $lastid;
                }
            }
            return 1;
        }
    }

    /**
     * Funcion que hace updated de un codigo binario en la ubicacion
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     **/
    function _update_codigo_binario($data){
        $this->db->trans_start();

        //Traer el codigo binario del PATROCINADOR
        $patrocinador = $this->_get_min_cod_binario_by_idsocio($data['patrocinador']);

        $this->db->set('codigo_socio_binario', $data['cod_socio']);
        $this->db->set('patrocinador', $patrocinador);
        $this->db->set('fecha_inscripcion', date('Y-m-d'));
        $this->db->set('idsocio', $data['idsocio']);
        $this->db->set('idrango', $data['idrango']);
        $this->db->where('padre', $data['padre']);
        $this->db->where('rama', $data['rama']);
        $this->db->update('codigo_socio_binario');
        $this->db->trans_complete();
        //echo $this->db->last_query();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else {
            return 1;
        }
    }

    /**
     * Funcion que hace update de un codigo binario en la ubicacion dada
     * @arg Array 
     * @return int
     * @author Pablo Orejuela
     **/
    function _update_codigo_binario_ubicacion($data){
        //echo '<pre>'.var_export($data, true).'</pre>';
        $this->db->trans_start();
        $this->db->set('codigo_socio_binario', $data['cod_socio']);
        $this->db->set('patrocinador', $data['patrocinador']);
        $this->db->set('fecha_inscripcion', date('Y-m-d'));
        $this->db->set('idsocio', $data['idsocio']);
        $this->db->set('idrango', 1);
        $this->db->where('idcodigo_socio_binario', $data['ubicacion']);
        $this->db->update('codigo_socio_binario');
        $this->db->trans_complete();
        //echo $this->db->last_query();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else {
            return 1;
        }
    }

    /**
     * Función que devuelve el codigo binario
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     **/
    function _get_codigo_binario($data){
        $this->db->select('idcodigo_socio_binario');
        $this->db->where('padre', $data['padre']);
        $this->db->where('rama', $data['rama']);
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
     * Función que devuelve el primer codigo binario libre bajo la red de carlos
     * @arg Array Codigo
     * @return int
     * @author Pablo Orejuela
     * @revision: 28-11-2020
     **/
    function _get_codigo_binario_libre($data){
        
        $cod = null;
        $this->db->select('idcodigo_socio_binario');
        $this->db->where('codigo_socio_binario', 'UNDEFINED');
        $this->db->where('patrocinador', 1);
        $this->db->or_where('patrocinador', 0);
        $this->db->where('rama', $data['rama']);
        $q = $this->db->get('codigo_socio_binario', 1);
        //echo $this->db->last_query();
        if ($q->num_rows() == 1) {
            foreach ($q->result() as $c){
                $cod = $c->idcodigo_socio_binario;
            }
        }
        return $cod;
    }

}

/* End of file administracion_model.php */
/* Location: ./application/models/administracion_model.php */