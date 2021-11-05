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
	function _get_lista_codigos_binarios(){

		$this->db->select('idcodigo_socio_binario,codigo_socio_binario,fecha_inscripcion,nombres,apellidos,cedula,celular,id_provincia,idprovincia');
		$this->db->join('socios', 'socios.idsocio = codigo_socio_binario.idsocio');
		$this->db->join('ciudad', 'ciudad.idciudad = socios.idciudad');
		$this->db->join('provincias', 'provincias.idprovincia = ciudad.id_provincia');
		$this->db->where('codigo_socio_binario.idsocio !=', '8');
		$this->db->where('codigo_socio_binario !=', 'UNDEFINED');
		$this->db->order_by('apellidos', 'asc');
		$this->db->order_by('idcodigo_socio_binario', 'asc');
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

	/**
	 * Devuelve el cálculo de las piernas de los frontales (BINARIA)
	 *
	 * @param INT, array
	 * @return array
	 * @author Pablo Orejuela
	 * @revisión: 16-11-2020
	 **/
	function _get_hijos_binario_nivel($idcod_socio, $leg){
		$aux_izq = array();
		$aux_der = array();
		$frontales = $this->_get_misfrontales_id($idcod_socio);

		if (!isset($frontales) || $frontales == 0) {
			$leg[] = 0;
		}else{
			foreach ($frontales as $key => $value) {
				if ($key == 0) {
					$aux_izq = $this->_arma_red_binaria($value->idcodigo_socio_binario);
				}elseif ($key == 1) {
					$aux_der = $this->_arma_red_binaria($value->idcodigo_socio_binario);
				}
			}
	
			foreach ($aux_izq as $key => $i) {
				$leg['izq'] += $this->_get_puntos($i);
			}
	
			foreach ($aux_der as $key => $d) {
				$leg['der'] += $this->_get_puntos($d);
			}
		}
		
		return $leg;
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


	function _get_hijos_binario($idcod_socio, $leg){
		//Verifico si tiene frontales
		/* PABLO: Implementar esto mejor, crear un array por nivel con los hijos sabiendo que 
			el hijo izq es el id*2 y el derecho es (id*2)+1 y a cada codigo obtenido aplicar el _get_puntos()
		*/
		$frontales = $this->_get_misfrontales($idcod_socio);

		if (isset($frontales) && $frontales != 0 && $frontales != NULL) {
			//Socio
			foreach ($frontales as $key => $value) {
				if ($key == 0) {
					$leg['izq'] += $this->_get_puntos($value->idcodigo_socio_binario);
				}else if($key == 1){
					$leg['der'] += $this->_get_puntos($value->idcodigo_socio_binario);
				}
				$frontales_1 = $this->_get_misfrontales($value->idcodigo_socio_binario);
				if (isset($frontales_1) && $frontales_1 != 0 && $frontales_1 != NULL) {
					//Primer Nivel
					foreach ($frontales_1 as $value1) {
						if ($key == 0) {
							$leg['izq'] += $this->_get_puntos($value1->idcodigo_socio_binario);
						}else if($key == 1){
							$leg['der'] += $this->_get_puntos($value1->idcodigo_socio_binario);
						}
						$frontales_2 = $this->_get_misfrontales($value1->idcodigo_socio_binario);
						if (isset($frontales_2) && $frontales_2 != 0 && $frontales_2 != NULL) {
							//Segundo Nivel
							foreach ($frontales_2 as $value2) {
								if ($key == 0) {
									$leg['izq'] += $this->_get_puntos($value2->idcodigo_socio_binario);
								}else if($key == 1){
									$leg['der'] += $this->_get_puntos($value2->idcodigo_socio_binario);
								}
								$frontales_3 = $this->_get_misfrontales($value2->idcodigo_socio_binario);
								if (isset($frontales_3) && $frontales_3 != 0 && $frontales_3 != NULL) {
									//Tercer Nivel
									foreach ($frontales_3 as $value3) {
										if ($key == 0) {
											$leg['izq'] += $this->_get_puntos($value3->idcodigo_socio_binario);
										}else if($key == 1){
											$leg['der'] += $this->_get_puntos($value3->idcodigo_socio_binario);
										}
										$frontales_4 = $this->_get_misfrontales($value3->idcodigo_socio_binario);
										if (isset($frontales_4) && $frontales_4 != 0 && $frontales_4 != NULL) {
											//Cuarto Nivel
											foreach ($frontales_4 as $value4) {
												if ($key == 0) {
													$leg['izq'] += $this->_get_puntos($value4->idcodigo_socio_binario);
												}else if($key == 1){
													$leg['der'] += $this->_get_puntos($value4->idcodigo_socio_binario);
												}
												$frontales_5 = $this->_get_misfrontales($value4->idcodigo_socio_binario);
												if (isset($frontales_5) && $frontales_5 != 0 && $frontales_5 != NULL) {
													//Quinto Nivel
													foreach ($frontales_5 as $value5) {
														if ($key == 0) {
															$leg['izq'] += $this->_get_puntos($value5->idcodigo_socio_binario);
														}else if($key == 1){
															$leg['der'] += $this->_get_puntos($value5->idcodigo_socio_binario);
														}
														$frontales_6 = $this->_get_misfrontales($value5->idcodigo_socio_binario);
														if (isset($frontales_6) && $frontales_6 != 0 && $frontales_6 != NULL) {
															//sexto Nivel
															foreach ($frontales_6 as $value6) {
																if ($key == 0) {
																	$leg['izq'] += $this->_get_puntos($value6->idcodigo_socio_binario);
																}else if($key == 1){
																	$leg['der'] += $this->_get_puntos($value6->idcodigo_socio_binario);
																}
																$frontales_7 = $this->_get_misfrontales($value6->idcodigo_socio_binario);
																if (isset($frontales_7) && $frontales_7 != 0 && $frontales_7 != NULL) {
																	//Septimo Nivel
																	foreach ($frontales_7 as $value7) {
																		if ($key == 0) {
																			$leg['izq'] += $this->_get_puntos($value7->idcodigo_socio_binario);
																		}else if($key == 1){
																			$leg['der'] += $this->_get_puntos($value7->idcodigo_socio_binario);
																		}
																		$frontales_8 = $this->_get_misfrontales($value7->idcodigo_socio_binario);
																		if (isset($frontales_8) && $frontales_8 != 0 && $frontales_8 != NULL) {
																			//Octavo Nivel
																			foreach ($frontales_8 as $value8) {
																				if ($key == 0) {
																					$leg['izq'] += $this->_get_puntos($value8->idcodigo_socio_binario);
																				}else if($key == 1){
																					$leg['der'] += $this->_get_puntos($value8->idcodigo_socio_binario);
																				}
																				$frontales_9 = $this->_get_misfrontales($value8->idcodigo_socio_binario);
																				if (isset($frontales_9) && $frontales_9 != 0 && $frontales_9 != NULL) {
																					//Noveno Nivel
																					foreach ($frontales_9 as $value9) {
																						if ($key == 0) {
																							$leg['izq'] += $this->_get_puntos($value9->idcodigo_socio_binario);
																						}else if($key == 1){
																							$leg['der'] += $this->_get_puntos($value9->idcodigo_socio_binario);
																						}
																						$frontales_10 = $this->_get_misfrontales($value9->idcodigo_socio_binario);
																						if (isset($frontales_10) && $frontales_10 != 0 && $frontales_10 != NULL) {
																							//Decimo Nivel
																							foreach ($frontales_10 as $value10) {
																								if ($key == 0) {
																									$leg['izq'] += $this->_get_puntos($value10->idcodigo_socio_binario);
																								}else if($key == 1){
																									$leg['der'] += $this->_get_puntos($value10->idcodigo_socio_binario);
																								}
																								$frontales_11 = $this->_get_misfrontales($value10->idcodigo_socio_binario);
																								if (isset($frontales_11) && $frontales_11 != 0 && $frontales_11 != NULL) {
																									//Undecimo Nivel
																									foreach ($frontales_11 as $value11) {
																										if ($key == 0) {
																											$leg['izq'] += $this->_get_puntos($value11->idcodigo_socio_binario);
																										}else if($key == 1){
																											$leg['der'] += $this->_get_puntos($value11->idcodigo_socio_binario);
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		//echo $leg['izq'].'<br>'.$leg['der'];
		return $leg;
	}



	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _eshijo($idcodigo_socio_binario, $padre){
		$this->db->select('patrocinador');
		$this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
		$q = $this->db->get('codigo_socio_binario');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $key => $value) {
				if ($value->patrocinador == $padre) {
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			return 0;
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

	function _get_bir_binario($idcod_socio, $nivel){
		$mes = date('m');
		if ($idcod_socio!=null) {
			$this->db->select('bono_persona');
			$this->db->where('idcodigo_socio_binario', $idcod_socio);
			$this->db->where('MONTH(fecha)', $mes);
			$this->db->where('nivel', $nivel);
			$this->db->where('pago', 1);
			$this->db->join('bono_nivel_binario', 'bono_nivel_binario.idpaquete = compras_binario.idpaquete');
			$q = $this->db->get('compras_binario');
			//echo $this->db->last_query();
	        if ($q->num_rows() > 0) {
	        	foreach ($q->result() as $row) {
	            	$bir = $row->bono_persona;
	            }
	            return $bir;
	        }
	    }else{
	    	return 0;
	    }
	}


	/**
	 * Esta funcion es la mas importante, ubica el indice del elemento en
	 * Una pierna izq o derecha
	 * Retorna 1 si es Izq o 2 si es derecha
	 * @return INT
	 * @author Pablo Orejuela
	 **/
	function _piernas_by_index($index){
            if ($index == 1) {
                    return 1;
            }else if($index == 2){
                    return 2;
            }else if($index >= 3 && $index <= 4){
                    return 1;
            }else if($index >= 5 && $index <= 6){
                    return 2;
            }else if($index >= 7 && $index <= 10){
                    return 1;
            }else if($index >= 11 && $index <= 14){
                    return 2;
            }else if($index >= 15 && $index <= 22){
                    return 1;
            }else if($index >= 23 && $index <= 30){
                    return 2;
            }else if($index >= 31 && $index <= 46){
                    return 1;
            }else if($index >= 47 && $index <= 62){
                    return 2;
            }else if($index >= 63 && $index <= 94){
                    return 1;
            }else if($index >= 97 && $index <= 126){
                    return 2;
            }else if($index >= 127 && $index <= 190){
                    return 1;
            }else if($index >= 191 && $index <= 254){
                    return 2;
            }
	}

	function tester_pablo($socio,$puntos){
		foreach ($socio as $key => $value) {
			$puntos += $value['puntos'];
			echo " - ".$value['idcod_socio'];
		}

		return $puntos;
	}

	function _get_hijos_recursivo($codigo,$suma=0){

		if ($codigo!=null) {
			echo ' - '.$codigo;
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

	                $suma +=$this->_get_hijos_recursivo($datos[$i]['idcod_socio'],$ptos );
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

	function _get_frontales($idcodigo){
		if ($idcodigo!=null) {
			//$this->db->where('codigo_socio.idcod_socio',$idcodigo);
			$this->db->or_where('patrocinador', $idcodigo);
			$this->db->join('rangos', 'rangos.idrango=codigo_socio.idrango');
			$this->db->join('socios', 'socios.idsocio=codigo_socio.idsocio');
			$this->db->order_by('fecha_inscripcion','asc');
			$q = $this->db->get('codigo_socio');
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

	function _get_matriz_binaria_by_codigo($codigo){

		$codigoDt = new CodigoDTO($codigo);
		//echo "<br>Puntos Izq: ".$codigoDt->get_puntos('I');
		//echo "<br>Puntos Der: ".$codigoDt->get_puntos('D');
		$data['puntos_izq'] = $codigoDt->get_puntos('I');
		$data['puntos_der'] = $codigoDt->get_puntos('D');
		$data['patrocinados_i'] = $codigoDt->get_cant_patrocinados('I');
		$data['patrocinados_d'] = $codigoDt->get_cant_patrocinados('D');
		return $data;
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
	 * Verifica si hay registrada regalía del mes
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
	 * @author Pablo Orejuela
	 **/
	function _actualiza_puntos_binario($idcod_socio, $piernas, $mis_puntos, $mes_actual){
		$fecha_actual = date('Y-m-d');
		$base = $this->_get_volumen_idcodigo_binario($idcod_socio);

		//verifica si tiene registro del mes
		$registro = $this->_bono_mes_binario($idcod_socio, $mes_actual);

		//SUMO A CADA PIERNA LA MITAD DE LOS PUNTOS QUE GENERA EL SOCIO POR SU COMPRA MÁXIMA DEL MES
		$piernas['izq'] += ($mis_puntos/2);
		$piernas['der'] += ($mis_puntos/2);

		if ($registro != 0) {
			//Si tiene registro lo actualiza
			//Traigo saldos anteriores
			if ($mes_actual == '01') {
				$mes_anterior = 12;
			}else{
				$mes_anterior = $mes_actual - 1;
			}

			$saldos = $this->_saldos_mes_binario($idcod_socio, $mes_anterior);

			if ($saldos != 0) {
				$sum_izq = $piernas['izq'] + $saldos['saldo_izq'];
				$sum_der = $piernas['der'] + $saldos['saldo_der'];
			
			

			//Verifico si supera la base
			if ($sum_izq >= $base && $sum_der >= $base) {
				$saldo_izq = $sum_izq - $base;
				$saldo_der = $sum_der - $base;

				// if ($saldo_izq >= 0) {
				// 	$s_izq = $saldo_izq;
				// }else{
				// 	$s_izq = 0;
				// }

				// if ($saldo_der >= 0) {
				// 	$s_der = $saldo_der;
				// }else{
				// 	$s_der = 0;
				// }
				$bono = $base/10;

			}else{
				$saldo_izq = $sum_izq;
				$saldo_der = $sum_der;
				$bono = 0;
			}

			$this->db->where('idcod_socio', $idcod_socio);
			$this->db->where('MONTH(fecha_pago)', $mes_actual);
			$this->db->set('puntos_izq', $piernas['izq']);
			$this->db->set('puntos_der', $piernas['der']);
			$this->db->set('sum_izq', $piernas['izq']);
			$this->db->set('sum_der', $piernas['der']);
			$this->db->set('base', $base);
			$this->db->set('saldo_izq', $saldo_izq);
			$this->db->set('saldo_der', $saldo_der);
			$this->db->set('bono', $bono);
			$this->db->update('p_binaria');
		}


		}else{
			//No tiene registro, inserta nuevo registro
			$saldo_anterior_izq = 0;
			$saldo_anterior_der = 0;
			$sum_izq = $piernas['izq'] + $saldo_anterior_izq;
			$sum_der = $piernas['der'] + $saldo_anterior_der;

			//Verifico si supera la base
			if ($sum_izq >= $base && $sum_der >= $base) {
				$saldo_izq = $sum_izq - $base;
				$saldo_der = $sum_der - $base;
				$bono = $base/10;

			}else{
				$saldo_izq = $sum_izq;
				$saldo_der = $sum_der;
				$bono = 0;
			}

			$this->db->set('idcod_socio', $idcod_socio);
			$this->db->set('fecha_pago', $fecha_actual);
			$this->db->set('puntos_izq', $piernas['izq']);
			$this->db->set('puntos_der', $piernas['der']);
			$this->db->set('sum_izq', $piernas['izq']);
			$this->db->set('sum_der', $piernas['der']);
			$this->db->set('base', $base);
			$this->db->set('saldo_izq', $saldo_izq);
			$this->db->set('saldo_der', $saldo_der);
			$this->db->set('bono', $bono);
			$this->db->insert('p_binaria');
		}
		return 1;
	}

	/**
	 * Verifica si hay registrada regalía del mes
	 *
	 * @return array
	 * @author Pablo Orejuela
	 **/
	function _saldos_mes_binario($idcod_socio, $mes){

		$this->db->select('saldo_izq, saldo_der');
		$this->db->where('idcod_socio', $idcod_socio);
		$this->db->where('MONTH(fecha_pago)', $mes);
		$q = $this->db->get('p_binaria');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
                $saldos['saldo_izq'] = $row->saldo_izq;
                $saldos['saldo_der'] = $row->saldo_der;
			}
			return $saldos;
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
	 * summary
	 *
	 * @return void
	 * @author
	 */
	function _registra_regalia_mes($izq, $der, $regalias, $idcod_socio){
	    $fecha_pago = date('Y-m-d');
	    $pagado = 0;
	    if ($izq > $der) {
			$puntos_pago = $der;
			$saldo = $izq - $der;
			$rama_saldo = 2;
		}else if ($der > $izq) {
			$puntos_pago = $izq;
			$saldo = $der - $izq;
			$rama_saldo = 1;
		}else{
			$puntos_pago = $izq;
			$saldo = 0;
			$rama_saldo = 3;
		}
		$this->db->set('fecha_pago', $fecha_pago);
		$this->db->set('puntos_izq', $izq);
		$this->db->set('puntos_der', $der);
		$this->db->set('puntos_pago', $puntos_pago);
		$this->db->set('saldo', $saldo);
		$this->db->set('rama_saldo', $rama_saldo);
		$this->db->set('regalias_mes', $regalias);
		$this->db->set('pagado', $pagado);
		$this->db->set('idcod_socio', $idcod_socio);
		$this->db->insert('p_binaria');
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
		$fecha_actual = date('Y-m-d');
		$dia = date('w');
		$primer_dia_semana = date('Y-m-d', strtotime('-'.($dia+6).' day'));
		$ultimo_dia_semana = date('Y-m-d', ($primer_dia_semana + strtotime('0 day')));

		$compras = 0;
		$litros = 0;
		$this->db->select('*');
		$this->db->where('idcod_socio', $idcod);
		$this->db->where('fecha >=', $primer_dia_semana);
		$this->db->where('fecha <=', $ultimo_dia_semana);
		$this->db->where('pago', 1);
		// $this->db->join('codigo_socio', 'codigo_socio.idcod_socio = compras.idcod_socio');
		$q = $this->db->get('compras');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $compras += 25;
            }
            //$litros = $this->_get_litros_paquete(4);
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
	 * devuelve la cantidad de semanas seguidas que cumple el volumen de ventas
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_semana_cumple($idcod_socio){
            $this->db->select('semana_1,semana_2,semana_3,semana_4');
            $this->db->where('idcod_socio', $idcod_socio);
            $q = $this->db->get('codigo_socio');
            if ($q->num_rows() > 0) {
                foreach ($q->result() as $value) {
                    if ($value->semana_1 != 0) {
                    	return 1;
                    }else if($value->semana_1 != 0 && $value->semana_2 != 0 && $value->semana_3 == 0){
                    	return 2;
                    }else if($value->semana_1 != 0 && $value->semana_2 != 0 && $value->semana_3 != 0 && $value->semana_3 == 0){
                    	return 3;
                    }else if($value->semana_1 != 0 && $value->semana_2 != 0 && $value->semana_3 != 0 && $value->semana_3 != 0){
                    	return 4;
                    }else{
                    	return 0;
                    }
                }
            }else{
            	return 0;
            }
            // PABLO: 'Terminar esta funcion';
	}

    function _get_cuentas_socio_binario_idcod($idcod){

        $mes_actual = date('m');
        $compras = 0;
        $this->db->select('*');
        $this->db->where('MONTH(fecha)', $mes_actual);
        $this->db->where('idcodigo_socio_binario', $idcod);
        $q = $this->db->get('compras_binario');
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $row) {
            $compras += $row->idpaquete;
        }
            return $compras;
        }else{
            return 0;
        }
    }

	/**
     * verifica si recibe bono por triangulacion
     *
     * @return void
     * @author Pablo Orejuela
     **/
    function _recibe_triangulacion($idcod_socio){
        $cobrado = $this->_verifica_triangulacion_cobrado($idcod_socio);
        $mipaquete = $this->_get_paquete_codigo_binario($idcod_socio);
        $frontales_coinciden = 0;

        if ($cobrado == 0) {
        	/*Extraigo mis frontales*/
        	$mis_frontales = $this->_get_misfrontales($idcod_socio);
        	/*Reviso que haya triangulacion*/
        	if ($mis_frontales != 0) {
        		foreach ($mis_frontales as $m) {
	        		$paquetefrontal = $this->_get_paquete_codigo_binario($m->idcodigo_socio_binario);

	        		if ($paquetefrontal == $mipaquete) {
	        			$frontales_coinciden += 1;
	        		}else{
	        			$frontales_coinciden += 0;
	        		}

	        	}
        		return $frontales_coinciden;
        	}else{
        		return 0;
        	}

        }else{
        	return $frontales_coinciden;
        }
    }

    /**
     * Trae los dos frontales de un codigo binario
     *
     * @return INT
     * @author Pablo Orejuela
     **/
    function _mis_frontales($idcod_socio){
    	$this->db->select('idcod_socio');
    	$this->db->where('patrocinador', $idcod_socio);
    	$this->db->order_by('idcod_socio', 'asc');
    	$q = $this->db->get('codigo_socio', 2);
    	if ($q->num_rows() > 0) {
    		foreach ($q->result() as $c) {
    			$cod[] = $c->idcod_socio;
    		}
    		return $cod;
    	}else{
    		return 0;
    	}
    }

    /**
     * Trae los dos frontales de un codigo binario
     *
     * @return INT
     * @author Pablo Orejuela
     **/
    function _es_mi_patrocinado($mi_codigo_binario, $codigo_socio_binario){
    	$this->db->select('idcodigo_socio_binario');
    	$this->db->where('idcodigo_socio_binario', $codigo_socio_binario);
    	$this->db->where('patrocinador', $mi_codigo_binario);
    	$q = $this->db->get('codigo_socio_binario');
    	if ($q->num_rows() > 0) {
    		return 1;
    	}else{
    		return 0;
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

	function _get_cuentas_frontales_binario_idcod($idcod){
		/*Extrae las compras de los frontales*/
		$frontales = $this->_get_misfrontales($idcod);
		if ($frontales != NULL && $frontales != 0) {
			foreach ($frontales as $value) {
				$compras = 0;
				$this->db->select('*');
				$this->db->where('codigo_socio_binario.idcodigo_socio_binario', $value->idcodigo_socio_binario);
				$this->db->where('pago', 1);
				$this->db->join('compras_binario', 'compras_binario.idcodigo_socio_binario = codigo_socio_binario.idcodigo_socio_binario');
				$q = $this->db->get('codigo_socio_binario');
				//echo $this->db->last_query();
				if ($q->num_rows() > 0) {
		            foreach ($q->result() as $row) {
		                $compras += $row->idpaquete;
		            }
		            return $compras;
		        }else{
		        	return 0;
		        }
			}
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

	function _get_litros_movidos_red($id_codigo){
		$litros_movidos = 0;
		$idpaquete = 0;
		$patrocinados = $this->_es_patrocinador_uninivel($id_codigo);
		if ($patrocinados != 0 && $patrocinados != NULL) {
			foreach ($patrocinados as $v) {
				$litros_movidos += $this->_get_cuentas_socio_by_idcod($v);
			}
			return $litros_movidos;
		}else{
			return 0;
		}
	}

	/**
	 * devuelve el total de compras de toda una red de un codigo
	 *
	 * @return int
	 * @author
	 **/
	function _get_compras_mi_red($patrocinados){
		$p = 0;
		$this->db->select('compras.idpaquete, litros');
		$this->db->where('idcod_socio', $patrocinados);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras.idpaquete');
		$q = $this->db->get('compras');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$litros = $value->litros;
			}
			return $litros;
		}else{
			return 0;
		}
	}

	function _verifica_si_bono_bir($idcod){
		//revisa si el codigo es nuevo o si hay nuevos codigos que patrocian en la semana
		//Es codigo nuevo?
		$fecha_actual = date('Y-m-d');
		$dia = date('w');
		$primer_dia_semana = date('Y-m-d', strtotime('-'.($dia-1).' day'));
		$ultimo_dia_semana = date('Y-m-d', ($primer_dia_semana + strtotime('4 day')));
		$fecha_inscripcion = $this->_get_fecha_inscripcion($idcod);
		if ($fecha_inscripcion >= $primer_dia_semana && $fecha_inscripcion <= $primer_dia_semana) {
			return 1;
		}else{
			return 0;
		}
	}

	function _verifica_inscripcion_mes($idcod){
		//revisa si el codigo es nuevo o si hay nuevos codigos que patrocian en la semana
		//Es codigo nuevo?
		$fecha_actual = date('Y-m-d');
		$mes = date('m');
		$fecha_inscripcion = $this->_get_fecha_inscripcion($idcod);
		$fecha_inscripcion_mes = date('m', strtotime($fecha_inscripcion));
		if ($fecha_inscripcion_mes == $mes) {
			return 1;
		}else{
			return 0;
		}
	}

	function _calcula_BIR($idcod_socio){
		//obtengo los patrocinados
		$patrocinados = $this->_es_patrocinador($idcod_socio);
		$BIR = 0;
		if ($patrocinados != 0 && $patrocinados != NULL) {
			foreach ($patrocinados as $key => $value) {
				$r = $this->_verifica_si_bono_bir($value);
				if ($r == 1) {
					$BIR += 50;
				}
			}
			return $BIR;
		}else{
			return 0;
		}

	}


	/**
	 * Hace el cálculo del Bono Constante hasta el 5to nivel
	 *
	 * @return void
	 * @author Pablo Orejuela
	 * @fecha 5-11-2021
	 **/
	function _calcula_bonoconstante_binario($patrocinados){
		
		$bir = 0;
		
		foreach ($patrocinados as $key => $value) {
			$paquete = $this->_get_paquete_codigo_binario($value->idcodigo_socio_binario);
			if ($paquete == 200) {
				$bir += 40;
			}else if ($paquete == 500) {
				$bir += 100;
			}else if($paquete == 1000){
				$bir += 200;
			}else if($paquete == 300){
				$bir += 50;
			}else if($paquete == 85){
				$bir += 10;
			}else if($paquete == 112){
				$bir += 20;
			}
		}
		return $bir;
	}

	/**
	 * Recibe un nivel y devuelve los siguientes de cada valor
	 *
	 * @return void
	 * @author Pablo orejuela
	 **/
	function _calcula_BIR_binario_nivel_inf($primer_nivel){
		$segundo_nivel = array();

		foreach ($primer_nivel as $key => $value) {

			$array = $this->_get_mis_directos($value);
			foreach ($array as $key => $value1) {
				$segundo_nivel[] = $value1;
			}
		}
		return $segundo_nivel;
	}


	/**
	 * Extrae los patrocinados directos
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_mis_directos($idcod_socio){
		$patro = array();
		//$idrango = $this->_get_rango_idcodigo($idcod_socio);
		$this->db->select('idcodigo_socio_binario');
		$this->db->where('patrocinador', $idcod_socio);
        $q = $this->db->get('codigo_socio_binario');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
            	//echo $idcod_socio.' - '.$p->idcodigo_socio_binario.'<br>';
                $patro[] = $p->idcodigo_socio_binario;
            }
        }
        return $patro;
	}


	/**
	 * Calcula el bono constante
	 *
	 * Recibe el código binario y calcula el BONO CONSTANTE DEL MES
	 *
	 * @param Type $array
	 * @return double
	 * @throws conditon
	 **/
	public function _bono_constante($idcodigo_socio_binario){

		

		$bono_constante = 0;

		//Obtener el mes actual
		$mes = date('m');

		//Obtener todos los patrocinados por el socio
		$patrocinados = $this->_es_patrocinador($idcodigo_socio_binario);

		//Por cada patrocinado extraer la compra mas alta del mes anterior y el bono
		if ($patrocinados && $patrocinados != 0) {
			foreach ($patrocinados as $key => $value) {
			
				$bono_constante += $this->_get_recompras_mes_anterior_patrocinados($mes, $value->idcodigo_socio_binario);
			}
		}
		

		//Devuelvo el total del bono
		
		return $bono_constante;
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

	/**
	 * Devuelve los datos de la compra actual PLAN BINARIO
	 *
	 * @return array
	 * @author Pablo Orejuela
	 * @revision 28-11-2020
	 **/
	function _get_paquete_codigo_binario($idcod_socio){
		$compras = 0;
		$mes_actual = date('m');
		
		$this->db->where('idcodigo_socio_binario', $idcod_socio);
		$this->db->where('pago', 1);
		$this->db->where('MONTH(fecha)', $mes_actual);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->order_by('idcompras_binario','desc');
		$q = $this->db->get('compras_binario', 1);
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$compras= $value->paquete;
			}
		}
		return $compras;
	}

	/**
	 * Devuelve los datos de la última compra PLAN BINARIO
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _get_ultimo_paquete_codigo_binario($idcod_socio){
		$mes_actual = date('m');
		$this->db->where('idcodigo_socio_binario', $idcod_socio);
		$this->db->where('pago', 1);
		$this->db->join('paquetes', 'paquetes.idpaquete = compras_binario.idpaquete');
		$this->db->order_by('idcompras_binario','desc');
		$q = $this->db->get('compras_binario', 1);
		//echo $this->db->last_query();
		if ($q->num_rows() == 1) {
			foreach ($q->result() as $value) {
				$paquete = $value->idpaquete;
			}
			return $paquete;
		}else{
			return 0;
		}
	}


	function _get_rango_codigo_uninivel($idcod_socio){
		$this->db->select('rango,rangos.idrango,bono_rango,codigo_socio,regalia');
		$this->db->where('idcod_socio', $idcod_socio);
		$this->db->join('rangos', 'rangos.idrango = codigo_socio.idrango');
		$q = $this->db->get('codigo_socio');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $rango['rango'] = $r->rango;
                $rango['idrango'] = $r->idrango;
                $rango['bono_rango'] = $r->bono_rango;
                $rango['regalia'] = $r->regalia;
                $rango['codigo_socio'] = $r->codigo_socio;
                // PABLO: Verificar si el bono rango no han sido pagados
            }
            return $rango;
        }else{
        	return 0;
        }
	}

	function _get_rango_codigo_binario($idcod_socio){
		$this->db->select('rango,rangos_binarios.idrango,codigo_socio_binario');
		$this->db->where('idcodigo_socio_binario', $idcod_socio);
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango = codigo_socio_binario.idrango');
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $rango['rango'] = $r->rango;
                $rango['idrango'] = $r->idrango;
                $rango['codigo_socio'] = $r->codigo_socio_binario;
                // PABLO: Verificar si el bono rango no han sido pagados
            }
            return $rango;
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

	function _get_rango_idcodigo_binario($idcodigo){
		$this->db->select('idrango');
		$this->db->where('idcodigo_socio_binario', $idcodigo);
		$q = $this->db->get('codigo_socio_binario');
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

	function _get_volumen_idcodigo_binario($idcodigo){
		$this->db->select('volumen');
		$this->db->where('idcodigo_socio_binario', $idcodigo);
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango = codigo_socio_binario.idrango');
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $base = $r->volumen;
            }
            return $base;
        }else{
        	return 0;
        }
	}

	function _get_bono_rango($idrango){
		$this->db->select('bono_rango');
		$this->db->where('idrango', $idrango+1);
		$q = $this->db->get('rangos');
		//echo $this->db->last_query();
		if ($q->num_rows() >0) {
            foreach ($q->result() as $r) {
                $bono = $r->bono_rango;
            }
            return $bono;
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
	function _nuevos_socios_semana($idcod_socio){
		$fecha_actual = date('Y-m-d');
		$dia = date('w');
		$socios = 0;
		$primer_dia_semana = date('Y-m-d', strtotime('-'.($dia+6).' day'));
		$ultimo_dia_semana = date('Y-m-d', ($primer_dia_semana + strtotime('0 day')));

		$this->db->select('idcod_socio');
		$this->db->where('patrocinador', $idcod_socio);
		$this->db->where('fecha_inscripcion >=', $primer_dia_semana);
		$this->db->where('fecha_inscripcion <=', $ultimo_dia_semana );
        $q = $this->db->get('codigo_socio');
        //echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $p) {
                //$patrocinados_nuevos[] = $p->idcod_socio;
                $socios += count($p->idcod_socio);
            }
            return $socios;
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
        	return 0;
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
	 * retorna el idsocio dado el idcodigo_socio_binario
	 *
	 * @return void
	 * @author
	 **/
	function _get_idsocio_codigo_binario($idcodigo_socio_binario){
		
		$r = null;
		$this->db->select('idsocio');
		$this->db->where('idcodigo_socio_binario', $idcodigo_socio_binario);
        $q = $this->db->get('codigo_socio_binario');
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
	function _get_posicion($cedula, $matriz){
		$r = null;
		$this->db->select('posicion');
		$this->db->where('cedula', $cedula);
		$this->db->where('idmatrices', $matriz);
        $q = $this->db->get('socios');
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $r = $row->posicion;
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
	function _get_codigo_socio($cedula, $matriz){
		$c = null;
		$this->db->select('codigo_socio');
		$this->db->where('cedula', $cedula);
		$this->db->where('idmatrices', $matriz);
        $q = $this->db->get('socios');
        if($q->num_rows() > 0){
            foreach ($q->result() as $r) {
                $c = $r->codigo_socio;
            }
            return $c;
        }
        else{
        	return 0;
        }
	}

	/**
	 * Devuelve el codigo de UNINIVEL
	 *
	 * @return void
	 * @author
	 **/
	function _get_datos_uninivel($idsocio){
		$c = null;
		$this->db->select('*');
		$this->db->where('idsocio', $idsocio);
		$q = $this->db->get('codigo_socio');
		//echo $this->db->last_query();
        if($q->num_rows() > 0){
            foreach ($q->result() as $r) {
                $c[] = $r;
            }
            return $c;
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
	function _get_nombre_id_socio_binario($id){
		$r = null;
		$this->db->select('nombres,apellidos');
		$this->db->where('idcodigo_socio_binario', $id);
		$this->db->join('codigo_socio_binario', 'codigo_socio_binario.idsocio = socios.idsocio');
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
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _regalias_nivel($matriz, $superior, $inferior, $nivel, $regalias){
			//verificar filas llenas abajo del usuario

			$fila_llena = $this->_socios_fila($matriz, $inferior, $superior);

			if ($fila_llena == $superior) {
				//echo 'El nivel '.$fila. ' está lleno <br>';
				$regalias = $this->niveles[$nivel];
			}else{
				//echo 'El nivel '.$fila. ' NO está lleno <br>';
				$regalias = 0;
			}


		return $regalias;
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

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function _get_recompras($id_codigo){

		$anio_mes_actual = date('Y-m');
		$mes_actual = date('m');
		$anio_actual = date('Y');
		$dia_actual = date('d');

		$fecha_inscripcion = $this->_get_fecha_inscripcion($id_codigo);
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

		$fecha_min =  $fecha_recompra_obj->format('Y-m-d');
		$fecha_max = $fecha_max_recompra->format('Y-m-d');

		$this->db->select('*');
		$this->db->where('fecha >=', $fecha_min);
		$this->db->where('fecha <=', $fecha_max);
		$this->db->where('idcod_socio', $id_codigo);
		$this->db->where('recompra', 1);
		$this->db->where('pago', 1);
		$q = $this->db->get('compras');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Esta función almacena y devuelve los valores de las regalias por nivel
	 *
	 * @return void
	 * @author
	 **/
	function _get_regalia_nivel($nivel_completo){
		return $this->niveles[$nivel_completo];
	}

	/**
	 * Consulta todos los socios registrados por id_patrocinador
	 *
	 * @return Array de socios
	 * @author 	Santiago Viteri
	 **/
	function _get_codigos_socio_by_patrocinador($id){
		$socios = null;
		$this->db->or_where('codigo_socio',$id);
		$this->db->or_where('patrocinador',$id);
		$this->db->join('matrices', 'matrices.idmatrices=codigo_socio.idmatrices');
		$this->db->join('socios', 'socios.idsocio=codigo_socio.codigo_socio');
		$this->db->order_by('posicion','desc');
		$q = $this->db->get('codigo_socio');

		if ($q->num_rows() >0) {
			foreach ($q->result() as $value) {
				$socios[] = $value;
			}
		}
		return $socios;
	}

	/**
	 * Consulta una lista de codigos socio  por el tipo de matriz dado el codigo_socio del patrocinador
	 *
	 * @return Array de socios
	 * @author Pablo Orejuela
	 **/
	function get_piramide_by_matriz($id_codigo){
		$socios = null;
		$this->db->or_where('codigo_socio_binario.idsocio', $id_codigo);
		$this->db->or_where('padre', $id_codigo);
		$this->db->join('socios', 'socios.idsocio=codigo_socio_binario.idsocio');
		$this->db->join('rangos_binarios', 'rangos_binarios.idrango=codigo_socio_binario.idrango');
		$this->db->order_by('idcodigo_socio_binario','asc');
		$q = $this->db->get('codigo_socio_binario');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $value) {
				$socios[] = $value;
			}
		}
		return $socios;
	}

	/**
	 * Consulta una lista de codigos socio  por el tipo de matriz dado el codigo_socio del patrocinador
	 *
	 * @return Array de socios
	 * @author Pablo Orejuela
	 **/
	function get_datos_matriz($red){

		foreach ($red as $key => $value) {
			$this->db->select('nombres,apellidos,cedula,idcodigo_socio_binario,codigo_socio_binario,rango,rama,patrocinador,direccion');
			$this->db->where('idcodigo_socio_binario', $value);
			$this->db->join('socios', 'socios.idsocio=codigo_socio_binario.idsocio');
			$this->db->join('rangos_binarios', 'rangos_binarios.idrango=codigo_socio_binario.idrango');
			//$this->db->join('compras_binario', 'compras_binario.idcodigo_socio_binario=codigo_socio_binario.idcodigo_socio_binario');
			$q = $this->db->get('codigo_socio_binario');
			if ($q->num_rows() >= 0) {
				foreach ($q->result() as $value) {
					$socios[] = $value;
					$_SESSION['patrocinador'] = $value->patrocinador;
				}
			}else{
				$socios[] = 0;
			}
		}
		return $socios;
	}

	function _obten_red($padre){

		$this->db->select('idcodigo_socio_binario,rama');
		//$this->db->where('patrocinador', $patrocinador);
		$this->db->where('padre', $padre);
		$this->db->order_by('rama', 'asc');
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $s) {
				$socios[] = $s['idcodigo_socio_binario'];
            }
            return $socios;
        }else{
        	return 0;
        }
	}

	function _get_hijo_izq($padre){

		$this->db->select('idcodigo_socio_binario,rama');
		//$this->db->where('patrocinador', $patrocinador);
		$this->db->where('padre', $padre);
		$this->db->where('rama', 1);
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $s) {
				$socios = $s['idcodigo_socio_binario'];
            }
            return $socios;
        }else{
        	return 0;
        }
	}

	function _get_hijo_der($padre){

		$this->db->select('idcodigo_socio_binario,rama');
		//$this->db->where('patrocinador', $patrocinador);
		$this->db->where('padre', $padre);
		$this->db->where('rama', 2);
		$q = $this->db->get('codigo_socio_binario');
		//echo $this->db->last_query();
		if ($q->num_rows() > 0) {
            foreach ($q->result_array() as $s) {
				$socios = $s['idcodigo_socio_binario'];
            }
            return $socios;
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
	function _arma_red_binaria($id_codigo){
		//Fila 1
		$socios[1] = $id_codigo;

		//hijos
		$fila_1 = $this->_obten_red($id_codigo);
		foreach ($fila_1 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 2
		foreach ($fila_1 as $key => $value) {
			$fila_2[] = $this->_get_hijo_izq($value);
			$fila_2[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_2 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 3
		foreach ($fila_2 as $key => $value) {
			$fila_3[] = $this->_get_hijo_izq($value);
			$fila_3[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_3 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 4
		foreach ($fila_3 as $key => $value) {
			$fila_4[] = $this->_get_hijo_izq($value);
			$fila_4[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_4 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 5
		foreach ($fila_4 as $key => $value) {
			$fila_5[] = $this->_get_hijo_izq($value);
			$fila_5[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_5 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 6
		foreach ($fila_5 as $key => $value) {
			$fila_6[] = $this->_get_hijo_izq($value);
			$fila_6[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_6 as $key => $value) {
			$socios[] = $value;
		}

		//Fila 7
		foreach ($fila_6 as $key => $value) {
			$fila_7[] = $this->_get_hijo_izq($value);
			$fila_7[] = $this->_get_hijo_der($value);
		}

		foreach ($fila_7 as $key => $value) {
			$socios[] = $value;
		}

		return $socios;
	}


	/**
	 * Verifica si el padre tiene frontal de la rama
	 *
	 * @return INT
	 * @author Pablo Orejuela
	 **/
	function _tiene_frontal($padre, $rama){
		$this->db->select('idcodigo_socio_binario');
		$this->db->where('padre', $padre);
		$this->db->where('rama', $rama);
		$q = $this->db->get('codigo_socio_binario');
		if ($q->num_rows() == 1) {
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Crea un frontal en caso de no haber
	 *
	 * @return void
	 * @author Pablo Orejuela
	 **/
	function _inserta_frontal($padre, $rama, $id_codigo){
		$fecha = date('Y-m-d');
		$this->db->set('codigo_socio_binario', 'UNDEFINED');
		$this->db->set('patrocinador', $id_codigo);
		$this->db->set('fecha_inscripcion', $fecha);
		$this->db->set('idsocio',8);
		$this->db->set('idrango',1);
		$this->db->set('padre', $padre);
		$this->db->set('rama', $rama);
		$this->db->insert('codigo_socio_binario');

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
