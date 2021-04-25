<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodigoDTO extends CI_Model {

	var $codigo;
	var $patrocinado_1;
	var $patrocinado_2;
	var $conteo_socios;

	var $suma_izq;
	var	$suma_der;

	var $cant_patrocinados_i=0;
	var $cant_patrocinados_d=0;

	/*function __construct($codigo)
	{
		$this->codigo = $codigo;
		$hijos = $this->_get_hijos($codigo);
		
		if (count($hijos)>0){
			$this->patrocinado_1 = new CodigoDTO($hijos[0]['idcod_socio']);
			$this->conteo_socios++;
		}

		if (count($hijos)>1){
			$this->patrocinado_2 = new CodigoDTO($hijos[1]['idcod_socio']);
			$this->conteo_socios ++;
		}
	}*/

	public function __construct($codigo)
	{
		/*INICIALIZACION DE PUNTAJES*/
		$puntos_ini=$this->_get_puntaje_by_codigo($codigo);
		$this->suma_izq =$puntos_ini;
		$this->suma_der =$puntos_ini;
		$socio = $this->_get_hijos($codigo);
		/* CALCULO DE CADA RAMA*/
		$this->_get_hijos_recursivo($socio[0]['idcod_socio'],'I');
		$this->_get_hijos_recursivo($socio[1]['idcod_socio'],'D');
	}

	public function get_puntos($rama)
	{
		if($rama=='I'){
			return $this->suma_izq;
		}else{
			return $this->suma_der;
		}		
	}

	public function get_cant_patrocinados($rama)
	{
		if($rama=='I'){
			return $this->cant_patrocinados_i;
		}else{
			return $this->cant_patrocinados_d;
		}		
	}

	function _get_hijos_recursivo($codigo,$suma='I')
	{
		
		if ($codigo!=null) {
			//echo ' - '.$codigo;
			$this->db->select('*');
			$this->db->where('codigo_socio.patrocinador', $codigo);
			$this->db->join('socios', 'socios.idsocio = codigo_socio.idsocio');
	        $q = $this->db->get('codigo_socio');

	        if($q->result() > 0){
	        	$i =0;
	        	$puntos=0;
	            foreach ($q->result() as $row) {
	                $datos[$i]['idcod_socio'] = $row->idcod_socio;
	                $datos[$i]['codigo_socio'] = $row->codigo_socio;
	                $datos[$i]['idmatrices'] = $row->idmatrices;
	                $datos[$i]['patrocinador'] = $row->patrocinador;
	                $datos[$i]['fecha_inscripcion'] = $row->fecha_inscripcion;
	                $datos[$i]['nombres'] = $row->nombres;
	                $datos[$i]['apellidos'] = $row->apellidos;
	                $datos[$i]['cedula'] = $row->cedula;
	                $ptos = $this->_get_puntaje_by_codigo($datos[$i]['idcod_socio']);
	                if ($suma=='I') {
	                	$this->suma_izq +=$ptos;
	                	$this->cant_patrocinados_i++;
	                }else{
	                	$this->suma_der +=$ptos;
	                	$this->cant_patrocinados_d++;
	                }
	               
	                $this->_get_hijos_recursivo($datos[$i]['idcod_socio'],$ptos );
	                $i++;
	            }
	            
	             return $suma;
	        }
	        else{
	        	return 0;
	        }
    	}else{
    		return 0;
    	}
	}

	function _get_hijos($codigo)
	{
		$datos = null;
		$this->db->select('*');
		$this->db->where('codigo_socio.patrocinador', $codigo);
		$this->db->join('socios', 'socios.idsocio = codigo_socio.idcod_socio');
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
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
                $i++;
            }
            return $datos;
        }
        else{
        	return 0;
        }
	}

	function _get_puntaje_by_codigo($codigo)
	{
		$puntos=0;
		$sql ="SELECT 
			IFNULL((SELECT SUM(puntos_paq) FROM compras c 
			JOIN paquetes p ON c.idpaquete=p.idpaquete 
			WHERE c.idcod_socio=cs.idcod_socio),0) AS puntos
			 FROM codigo_socio cs JOIN socios s ON s.idsocio = cs.idsocio 
			 WHERE cs.idcod_socio=".$codigo.";";
	        $q = $this->db->query($sql);
	        if($q->result() > 0){
	            foreach ($q->result() as $row) {
	            	$puntos=$row->puntos;
	            }
	        }
	    //echo "<br>Codigo: ".$codigo." - Puntos: ".$puntos;
	    return $puntos;
	}

}

/* End of file CodigoDTO.php */
/* Location: ./application/models/entidades/CodigoDTO.php */