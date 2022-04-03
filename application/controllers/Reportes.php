<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('acl_model');
        $this->load->model('procesos_model');
        $this->load->model('administracion_model');
        $this->load->model('compras_model');
        $this->load->library('pdf');
    }

    public function index(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            redirect('Inicio','refresh');
        }
        else{
            $this->inicio();
        }
    }

    /*
    * descripcion: Viene del form donde se elige el mes para el reporte
    * input: int
    * returns: void
    * Autor: Pablo Orejuela
    */
    function frm_recompras_mes(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['mes'] = $this->input->post('mes_recompras');
            $data['recompras'] = $this->procesos_model->_get_recompras_mes($this->input->post('mes_recompras'));
            $data['recompras_anterior'] = $this->procesos_model->_get_recompras_mes_anterior($this->input->post('mes_recompras'));

            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/frm_reporte_recompra_binaria';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    function reporte_recompras(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['opcion'] = $this->input->post('opcion');
            $data['recompras'] = $this->procesos_model->_get_recompras_mes();
            $data['recompras_anterior'] = $this->procesos_model->_get_recompras_mes_anterior();

            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/frm_reporte_recompra_binaria';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    function buscar_resumen_socios_individual(){
       $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['criterio'] = $this->input->post('txt_criterio');
            $data['socios'] = $this->procesos_model->_get_socios_by_criterio($data['criterio']);
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/form_resumen_socio_individual';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->inicio();
        }
    }

    public function reportes(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes_view';
            $this->load->view('includes/template', $data);
        }
        else{
            redirect('Inicio','refresh');
        }
    }

    public function reportes_ciudad(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['matrices'] = $this->procesos_model->_get_matrices();

            $data['provincias'] = $this->administracion_model->_get_provincias();
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes_ciudad_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }


    public function lista_codigos(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/frm_getLista_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    public function reporte_inactivos(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            $data['codigos_inactivos'] = $this->procesos_model->_get_info_inactivos();

            $this->reporte_inactivos_pdf($data['codigos_inactivos']);
        }
        else{
            $this->index();
        }
    }

    /**
     * summary
     *
     * @return void
     * @author Pablo Orejuela
     */
    function reporte_inactivos_pdf($codigos_inactivos){
        
        $this->pdf = new TCPDF("L", "mm", "A4", true, 'UTF-8', false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        //Información referente al PDF
        $this->pdf->SetCreator('PDF_CREATOR');
        $this->pdf->SetAuthor('Pablo Orejuela');
        $this->pdf->SetTitle('Reporte Inactivos');
        $this->pdf->SetSubject('Reportes GTK Admin');
        $this->pdf->SetKeywords('TCPDF, PDF, reportes, Gtk-ecuador');

        $this->pdf->SetFont('Helvetica', 'C', 10);
        $this->pdf->SetMargins(12, 12, 12, true);
        $this->pdf->SetFillColor(140,215,229);
        $this->pdf->SetLineWidth(0.01);
        $this->pdf->setCellPaddings(1, 1, 1, 1);
        $this->pdf->SetLineStyle(array('width' => 0.01, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(10, 0, 0)));

        // Saltos de página automáticos.
        //$this->pdf->SetAutoPageBreak(TRUE, 'PDF_MARGIN_BOTTOM');


        // Establecer el ratio para las imagenes que se puedan utilizar
        //$this->pdf->setImageScale('PDF_IMAGE_SCALE_RATIO');

        // Establecer la fuente
        $this->pdf->SetFont('Helvetica', 'P', 11);
        $this->pdf->SetMargins(12, 12);

        $fecha = date('Y-m-d');

        // Añadir página
        $this->pdf->AddPage();

        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(185, 0, 'REPORTE DE SOCIOS INACTIVOS GTK ECUADOR', 'tbrl', 0, 'C', false);
        

        $this->pdf->ln(12);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(18, 0, 'FECHA: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(50, 0, $fecha, '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(10, 0, 'RED: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(50, 0, 'PLAN RED BINARIO', '', 0, 'L', false);

        $this->pdf->ln(10);
        $this->pdf->SetX(12);
        $this->pdf->SetFont('helvetica', 'B', 8);
        $this->pdf->Cell(27, 0, 'COD', 'LTB', 0, 'C', true);
        $this->pdf->Cell(20, 0, 'CEDULA', 'LTB', 0, 'L', true);
        $this->pdf->Cell(80, 0, 'NOMBRE', 'LBT', 0, 'L', true);
        $this->pdf->Cell(30, 0, 'CELULAR', 'LBT', 0, 'L', true);
        $this->pdf->Cell(20, 0, 'F INGRESO', 'LBT', 0, 'L', true);
        $this->pdf->Cell(18, 0, 'U COMPRA', 'LBT', 0, 'L', true);
        $this->pdf->Cell(20, 0, 'PAQUETE', 'LBT', 0, 'L', true);
        $this->pdf->Cell(17, 0, 'ESTADO', 'LBTR', 0, 'L', true);
        $this->pdf->SetFont('helvetica', 'P', 7);

        if (!isset($codigos_inactivos) || $codigos_inactivos == NULL) {
            $this->pdf->ln();
            $this->pdf->Cell(185, 0, 'NO HAY DATOS PARA EL REPORTE', 'LBTR', 0, 'L', FALSE);
        }else{
            $linea = 0;
            foreach ($codigos_inactivos as $c) {
                $ultima_compra = $this->procesos_model->_get_ultima_compra($c->idcodigo_socio_binario);
                $ultimo_paquete = $this->procesos_model->_get_paquete_comprado($c->idcodigo_socio_binario, $ultima_compra);
                $estado = $this->procesos_model->_calcula_estado($c->fecha_inscripcion, $ultima_compra);
                
                $this->pdf->ln();
                $this->pdf->SetFont('helvetica', 'P', 8);
                $this->pdf->Cell(27, 0, $c->codigo_socio_binario, 'LTB', 0, 'L', false);
                $this->pdf->Cell(20, 0, $c->cedula, 'LTB', 0, 'L', false);
                $this->pdf->Cell(80, 0, $c->apellidos.' '.$c->nombres, 'LBT', 0, 'L', false);
                $this->pdf->Cell(30, 0, $c->celular, 'LBT', 0, 'C', false);
                $this->pdf->Cell(20, 0, $c->fecha_inscripcion, 'LBT', 0, 'C', false);
                $this->pdf->Cell(18, 0, $ultima_compra, 'LBT', 0, 'C', false);
                $this->pdf->Cell(20, 0, $ultimo_paquete, 'LBT', 0, 'R', false);
                //$this->pdf->Cell(15, 0, '', 'LBTR', 0, 'R', false);
                if ($estado == 1) {
                    $this->pdf->Cell(17, 0, 'ACTIVO', 'LBTR', 0, 'C', false);
                }else{
                    $this->pdf->Cell(17, 0, 'INACTIVO', 'LBTR', 0, 'C', false);
                }
                
                $linea++;
                // if ($linea >= 48) {
                //     $this->pdf->AddPage();
                //     $linea = 0;
                // }
            }
        } 
        //Cerramos y damos salida al fichero PDF
        $this->pdf->Output('reporte_pagos.pdf', 'I');
    }
    

    public function genera_lista_codigos(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {

            //$data['idcodigo_socio_binario'] = $this->input->post('idcodigo_socio_binario');
            $data['ordenar'] = $this->input->post('ordenar');

            $data['provincias'] = $this->procesos_model->_get_provincias();
            $data['lista_codigos'] = $this->procesos_model->_get_lista_codigos_binarios();

            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/frm_lista_codigos_view';
            $this->load->view('includes/template', $data);

        }
        else{
            $this->index();
        }
    }


    function resumen_pagos_ciudad(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            // PABLO: El valor de la idciudad está en la sessión;
            $idmatrices = $this->input->post('idmatrices');
            if ($idmatrices == 'NULL') {
                $data['matrices'] = $this->procesos_model->_get_matrices();
                $data['provincias'] = $this->administracion_model->_get_provincias();
                $data['version'] = $this->config->item('system_version');
                $data['title']='GTK Admin';
                $data['main_content']='reportes_ciudad_view';
                $this->load->view('includes/template', $data);
            }else{
                $id_ciudad = $this->input->post('id_ciudad');
                $idmatrices = $this->input->post('idmatrices');
				$_SESSION['id_ciudad'] = $id_ciudad;

                if ($idmatrices == 2) {
                    $ciudad = $this->procesos_model->_get_ciudad_nombre($id_ciudad);
                    $fecha = date('Y-m-d');
                    $socios = $this->procesos_model->_get_socios_binarios_by_idciudad($id_ciudad);
                    
                    $this->reporte_pagos_binarios_ciudad($socios, $ciudad, $fecha, $idmatrices);
                }else if($idmatrices == 3){
                    $ciudad = $this->procesos_model->_get_ciudad_nombre($id_ciudad);
                    $fecha = date('Y-m-d');
                    $socios = $this->procesos_model->_get_socios_by_idciudad($id_ciudad);

                    $this->reporte_pagos_ciudad($socios, $ciudad, $fecha, $idmatrices);
                }

            }

        }
        else{
            $this->index();
        }
    }

    /**
     * summary
     *
     * @return void
     * @author
     */
    function reporte_pagos_ciudad($socios, $ciudad, $fecha, $idmatrices){
        $this->pdf = new TCPDF("L", "mm", "A4", true, 'UTF-8', false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        //Información referente al PDF
        $this->pdf->SetCreator('PDF_CREATOR');
        $this->pdf->SetAuthor('Pablo Orejuela');
        $this->pdf->SetTitle('Reporte Pagos Ciudad');
        $this->pdf->SetSubject('Reportes GTK Admin');
        $this->pdf->SetKeywords('TCPDF, PDF, reportes, Gtk-ecuador');

        $this->pdf->SetFont('Helvetica', 'C', 10);
        $this->pdf->SetMargins(15, 15, 15, true);
        $this->pdf->SetFillColor(140,215,229);
        $this->pdf->SetLineWidth(0.01);
        $this->pdf->setCellPaddings(1, 1, 1, 1);
        $this->pdf->SetLineStyle(array('width' => 0.01, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(10, 0, 0)));

        // Saltos de página automáticos.
        $this->pdf->SetAutoPageBreak(TRUE, 'PDF_MARGIN_BOTTOM');

        // Establecer el ratio para las imagenes que se puedan utilizar
        //$this->pdf->setImageScale('PDF_IMAGE_SCALE_RATIO');

        // Establecer la fuente
        $this->pdf->SetFont('Helvetica', 'P', 11);
        $this->pdf->SetMargins(15, 15);

        // Añadir página
        $this->pdf->AddPage();

        $this->pdf->SetFont('helvetica', 'B', 14);
        $this->pdf->Cell(270, 0, 'REPORTE DE BONOS Y REGALIAS GTK ECUADOR', '', 0, 'C', false);
        $this->pdf->ln(15);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(20, 0, 'CIUDAD: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(150, 0, $ciudad, '', 0, 'L', false);

        $this->pdf->ln();
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(20, 0, 'FECHA: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(50, 0, $fecha, '', 0, 'L', false);

        $this->pdf->ln();
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(20, 0, 'RED: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(50, 0, 'PLAN RED UNINIVEL', '', 0, 'L', false);

        $this->pdf->ln(10);
        $this->pdf->SetX(12);
        $this->pdf->SetFont('helvetica', 'B', 9);
        $this->pdf->Cell(17, 0, 'CEDULA', 'LTB', 0, 'C', true);
        $this->pdf->Cell(65, 0, 'NOMBRE', 'LTB', 0, 'L', true);
        $this->pdf->Cell(20, 0, 'COD', 'LBT', 0, 'L', true);
        $this->pdf->Cell(45, 0, 'RANGO', 'LBT', 0, 'L', true);
        $this->pdf->Cell(15, 0, 'SOCIOS', 'LBT', 0, 'C', true);
        $this->pdf->Cell(15, 0, 'BSN', 'LBT', 0, 'C', true);
        $this->pdf->Cell(17, 0, 'B EXT', 'LBT', 0, 'C', true);
        $this->pdf->Cell(15, 0, 'LTS SO', 'LBT', 0, 'C', true);
        $this->pdf->Cell(15, 0, 'LTS RED', 'LBT', 0, 'C', true);
        $this->pdf->Cell(20, 0, 'SEM', 'LBT', 0, 'C', true);
        $this->pdf->Cell(20, 0, 'B SEM', 'LBTR', 0, 'C', true);
        $this->pdf->SetFont('helvetica', 'P', 7);

        if (!isset($socios) || $socios == NULL) {
            $this->pdf->ln();
            $this->pdf->SetX(12);
            $this->pdf->SetFont('helvetica', 'B', 9);
            $this->pdf->Cell(264, 0, 'NO HAY DATOS', 'LTBR', 0, 'C', false);
            $this->pdf->SetFont('helvetica', 'P', 7);
            
        }else{
            foreach ($socios as $value) {
                $compras_socio = $this->procesos_model->_get_cuentas_socio_by_idcod($value->idcod_socio);
                $nuevos_socios_semana = $this->procesos_model->_nuevos_socios_semana($value->idcod_socio);
                $rango = $this->procesos_model->_get_rango_codigo_uninivel($value->idcod_socio);
                $bono_rango = $this->procesos_model->_get_bono_rango($rango['idrango']);
                // $data['patrocinados'] = $this->procesos_model->_es_patrocinador($data['idcod_socio']);

                $litros_movidos = $this->procesos_model->_get_litros_movidos_red($value->idcod_socio);
                $litros_rango = $this->procesos_model->_get_litros_rango($rango);
                $litros_movidos_totales = $litros_movidos + $compras_socio;
                //$semana_seguida = $this->procesos_model->_get_semana_cumple($value->idcod_socio, 1);

                if ($litros_movidos_totales >= $litros_rango) {
                    $semana_seguida = 1;
                }else{
                    $semana_seguida = 0;
                }

                $this->pdf->ln();
                $this->pdf->SetX(12);
                $this->pdf->SetFont('helvetica', 'P', 7);
                $this->pdf->Cell(17, 0, $value->cedula, 'LTB', 0, 'C', false);
                $this->pdf->Cell(65, 0, $value->nombres.' '. $value->apellidos, 'LTB', 0, 'L', false);
                $this->pdf->Cell(20, 0, $value->codigo_socio, 'LBT', 0, 'L', false);
                $this->pdf->Cell(45, 0, $value->rango, 'LBT', 0, 'L', false);
                $this->pdf->Cell(15, 0, $nuevos_socios_semana, 'LBT', 0, 'C', false);
                $this->pdf->Cell(15, 0, '$'.($nuevos_socios_semana * 50), 'LBT', 0, 'R', false);
                if (count($nuevos_socios_semana) >= 3 && count($nuevos_socios_semana) < 5) {
                    $this->pdf->Cell(17, 0, '$ 130', 'LBT', 0, 'R', false);
                }else if(count($nuevos_socios_semana) >= 5){
                    $this->pdf->Cell(17, 0, '$ 320', 'LBT', 0, 'R', false);
                }else{
                    $this->pdf->Cell(17, 0, '$ 0', 'LBT', 0, 'R', false);
                }

                $this->pdf->Cell(15, 0, $compras_socio, 'LBT', 0, 'C', false);
                $this->pdf->Cell(15, 0, $litros_movidos, 'LBT', 0, 'C', false);
                $this->pdf->Cell(20, 0, $semana_seguida, 'LBT', 0, 'C', false);
                if ($semana_seguida > 0) {
                    $this->pdf->Cell(20, 0, '$'.$bono_rango, 'LBTR', 0, 'C', false);
                }else{
                    $this->pdf->Cell(20, 0, '$ 0', 'LBTR', 0, 'C', false);
                }
                $this->pdf->SetFont('helvetica', 'P', 7);
            }
        }
        //Cerramos y damos salida al fichero PDF
        $this->pdf->Output('reporte_pagos.pdf', 'I');
    }

    function suggestions_ciudades(){
        $term = $this->input->post('term',TRUE);

        if (strlen($term) < 1) exit;

        $rows = $this->procesos_model->GetAutocomplete_ciudades(array('keyword' => $term));

        $json_array = array();
        foreach ($rows as $row)
                array_push($json_array, $row->idciudad.'-'.$row->ciudad);

        echo json_encode($json_array);
    }


    function red_mis_codigos($value=''){
        $rol =$this->session->userdata('rol');
        $id_socio =$this->session->userdata('id');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $data['socio']=$this->administracion_model->_get_array_socio_by_id($id_socio);
            
            $data['codigo']=$this->administracion_model->_get_codigos_by_socio($id_socio);

            if ($data['codigos_binarios'] || $data['codigos_uninivel']) {
                $data['title']='GTK Admin';
                $data['main_content']='reportes/form_red_mis_codigos';
                $this->load->view('includes/template', $data);
            }else{
                $data['title']='GTK Admin';
                $data['main_content']='reportes/error';
                $this->load->view('includes/template', $data);
            }   
        }
        else{
            $this->inicio();
        }
    }

    function elige_resumen_financiero(){
        $idmatrices = $this->input->post('idmatrices');
        $id_codigo = $this->input->post('id_codigo');
        if ($idmatrices == 2) {
            $this->resumen_financiero_binario($id_codigo);
        }else if($idmatrices == 3){
            $this->resumen_financiero($id_codigo);
        }
    }

    function resumen_financiero($id_codigo){
        
        // PABLO: hacer una funcion que revise las compras y que actualice el rango antes de sacar el resumen
        $rol =$this->session->userdata('rol');
        $id_socio =$this->session->userdata('id');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $semana = date('W');
            $data['idcod_socio'] = $id_codigo;
            //UNINIVEL
            $data['idmatrices'] = 3;
            $data['socio'] = $this->administracion_model->_get_array_socio_by_id($id_socio);
            $data['rango'] = $this->procesos_model->_get_rango_codigo_uninivel($data['idcod_socio']);
            $data['patrocinados'] = $this->procesos_model->_es_patrocinador_uninivel($data['idcod_socio']);
            $data['nuevos_socios_semana'] = $this->procesos_model->_nuevos_socios_semana($data['idcod_socio']);
            $data['compras_socio'] = $this->procesos_model->_get_cuentas_socio_by_idcod($data['idcod_socio']);
            $data['bono_rango'] = $this->procesos_model->_get_bono_rango($data['rango']['idrango']);

            $data['litros_movidos'] = $this->procesos_model->_get_litros_movidos_red($data['idcod_socio']);

            $data['litros_rango'] = $this->procesos_model->_get_litros_rango($data['rango']['idrango']);
            $data['litros_movidos_totales'] = $data['litros_movidos'] + $data['compras_socio'];

            //Actualizo la semana
            $this->procesos_model->_actualiza_semana($data['idcod_socio'],$data['litros_movidos_totales'], $data['litros_rango'], $semana);
            $data['semana_seguida'] = $this->procesos_model->_get_semana_cumple($data['idcod_socio']);

            $data['title']='GTK Admin';
            $data['main_content']='reportes/frm_resumen_financiero';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    function print_historico($idcodigo_socio){


        $nombre = $this->procesos_model->_get_nombre_id_socio_binario($idcod_socio);
        $codigo = $this->procesos_model->_get_codigo_binario_by_idcodigo($idcod_socio);
        $registros = $this->procesos_model->_bono_histórico_binario($idcod_socio);

        //var_dump($registros);

        $this->pdf = new TCPDF("L", "mm", "A4", true, 'UTF-8', false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        //Información referente al PDF
        $this->pdf->SetCreator('PDF_CREATOR');
        $this->pdf->SetAuthor('Pablo Orejuela');
        $this->pdf->SetTitle('Reporte Histórico');
        $this->pdf->SetSubject('Reportes GTK Admin');
        $this->pdf->SetKeywords('TCPDF, PDF, reportes, Gtk-ecuador');

        $this->pdf->SetFont('Helvetica', 'C', 10);
        $this->pdf->SetMargins(15, 15, 15, true);
        $this->pdf->SetFillColor(190,255,229);
        $this->pdf->SetLineWidth(0.01);
        $this->pdf->setCellPaddings(1, 1, 1, 1);
        $this->pdf->SetLineStyle(array('width' => 0.01, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(3, 0, 3)));

        // Saltos de página automáticos.
        $this->pdf->SetAutoPageBreak(TRUE, 10);

        // Establecer el ratio para las imagenes que se puedan utilizar
        //$this->pdf->setImageScale('PDF_IMAGE_SCALE_RATIO');

        // Establecer la fuente
        $this->pdf->SetFont('Helvetica', 'B', 12);
        $this->pdf->SetMargins(20, 20);
		
        // Añadir página
        $this->pdf->AddPage();

        $this->pdf->Cell(270, 0, 'REPORTE HISTÓRICO DE BONOS BINARIOS', '', 0, 'C', false);
        $this->pdf->ln(15);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(15, 0, 'SOCIO: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(100, 0, $nombre, '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(17, 0, 'CODIGO: ', '', 0, 'L', false);
        $this->pdf->SetFont('helvetica', 'P', 10);
        $this->pdf->Cell(100, 0, $codigo, '', 0, 'L', false);


        $this->pdf->ln(10);
        $this->pdf->SetX(15);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell(25, 0, 'FECHA', 'LTB', 0, 'L', true);
        $this->pdf->Cell(30, 0, 'BINARIO IZQ', 'LTB', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'BINARIO DER', 'LBT', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'TOTAL IZQ', 'LBT', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'TOTAL DER', 'LBT', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'BASE NIVEL', 'LBT', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'SALDO IZQ', 'LBT', 0, 'R', true);
        $this->pdf->Cell(30, 0, 'SALDO DER', 'LBT', 0, 'R', true);
        $this->pdf->Cell(25, 0, 'BONO', 'LBTR', 0, 'R', true);
        $this->pdf->ln();

        foreach ($registros as $key => $value) {
            $this->pdf->SetX(15);
            $this->pdf->SetFont('helvetica', 'p', 9);
            $this->pdf->Cell(25, 0, $value['fecha_pago'], 'LTB', 0, 'L', false);
            $this->pdf->Cell(30, 0, $value['puntos_izq'].' pts.', 'LTB', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['puntos_der'].' pts.', 'LBT', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['sum_izq'].' pts.', 'LBT', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['sum_der'].' pts.', 'LBT', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['base'], 'LBT', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['saldo_izq'], 'LBT', 0, 'R', false);
            $this->pdf->Cell(30, 0, $value['saldo_der'], 'LBT', 0, 'R', false);
            $this->pdf->Cell(25, 0, $value['bono'], 'LBTR', 0, 'R', false);
            $this->pdf->ln();
        }

        //Cerramos y damos salida al fichero PDF
        $this->pdf->Output('historico_bonos_binario.pdf', 'I');
    }

    public function mi_red(){
        $rol =$this->session->userdata('rol');
        $id_socio =$this->session->userdata('id');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            $idcodigo = $this->input->post('id_codigo');
            $data['socio']=$this->administracion_model->_get_array_socio_by_id($id_socio);
            $data['patrocinados'] = $this->procesos_model->_es_patrocinador_uninivel_directo($idcodigo);
            $data['version'] = $this->config->item('system_version');
            $data['title']='GTK Admin';
            $data['main_content']='reportes/directos_uninivel_view';
            $this->load->view('includes/template', $data);
        }
        else{
            $this->index();
        }
    }

    /**
     * urecibe un entero y devuelve su ubicación en la piramide
     *
     * @return int
     * @author Pablo Orejuela
     **/
    function _get_ultima_fila($posicion){
        if ($posicion > 1 && $posicion <= 3) {
            return 2;
        }else if($posicion > 3 && $posicion <= 3){
            return 3;
        }else if($posicion > 4 && $posicion <= 7){
            return 4;
        }else if($posicion > 8 && $posicion <= 15){
            return 5;
        }else if($posicion > 16 && $posicion <= 31){
            return 6;
        }else if($posicion > 32 && $posicion <= 63){
            return 7;
        }else if($posicion > 64 && $posicion <= 127){
            return 8;
        }else if($posicion > 128 && $posicion <= 255){
            return 9;
        }else if($posicion > 256 && $posicion <= 511){
            return 10;
        }else if($posicion > 512 && $posicion <= 1023){
            return 11;
        }else if($posicion > 1024 && $posicion <= 2049){
            return 12;
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
    function ver_resumen_mensual_ciudad(){
        $rol =$this->session->userdata('rol');
        $data['per'] = $this->acl_model->_extraePermisos($rol);
        $is_logged = $this->session->userdata('is_logged_in');
        if (isset($is_logged) == true || isset($is_logged) == 1) {
            //capturo la cedula
            $data['ciudad'] = $this->input->post('ciudad');
            $matriz = 1;
            if ($data['ciudad'] == NULL || $data['ciudad'] == '') {
                echo 'hacer algo en caso de cedula vacia';
            }else{

                $data['cedulas'] = $this->procesos_model->_get_cedulas_socios_ciudad($data['ciudad'], $matriz);

                $data['title']='GTK Admin';
                $data['main_content']='resumen_socios_ciudad_view';
                $this->load->view('includes/template', $data);
            }
        }else{
            $this->index();
        }
    }
}

/* End of file reportes.php */
/* Location: ./application/controllers/reportes.php */
