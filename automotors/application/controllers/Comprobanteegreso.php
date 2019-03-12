<?php

class ComprobanteEgreso extends CI_Controller {
	
	private $menuId = '10091';

	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->helper('utilitario');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('comprobanteegreso_model');
        //si no hay sesion
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url());
        }
    }

    public function Index() {
    	//Verificar acceso
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Acceso retringido...');
			//$this->session->set_flashdata('acceso','Acceso retringido...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url());
		}
        
        $data['data_grilla'] = json_encode($this->comprobanteegreso_model->Listar());
        
        //Registrar
		$opcion = 'CE_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'CE_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'CE_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Excel
		$opcion = 'CE_E';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_excel'] = $opcion;
		} else {
			$data['acc_excel'] = "0";
		}
		//Imprimir reporte
		$opcion = 'CE_R';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_imprimir'] = $opcion;
		} else {
			$data['acc_imprimir'] = "0";
		}
		//Consultar
		$opcion = 'CE_Q';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_consultar'] = $opcion;
		} else {
			$data['acc_consultar'] = "0";
		}		
		
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comprobanteegreso/listar_vista", $data);
    }

    public function Insertar_form() {
        $data['titulo'] = "Nuevo Comprobante Egreso";
        $data['operacion'] = 'I';
        $data['banco'] = json_encode(getListaDominio('BANCO'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comprobanteegreso/formulario_vista", $data);
    }

    public function Actualizar_form($nroComprobante) {
        $data['titulo'] = "Editar Comprobante Egreso";
        $data['operacion'] = 'U';
        $data['numero_comprobante'] = $nroComprobante;
		$data['banco'] = json_encode(getListaDominio('BANCO'));
        $data['datos'] = $this->comprobanteegreso_model->getIndividual($nroComprobante);
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comprobanteegreso/formulario_vista", $data);
    }

    public function Consultar_form($nroComprobante) {
        $data['titulo'] = "Consultar Comprobante Egreso";
        $data['operacion'] = 'C';
        $data['numero_comprobante'] = $nroComprobante;
		$data['banco'] = json_encode(getListaDominio('BANCO'));
        $data['datos'] = $this->comprobanteegreso_model->getIndividual($nroComprobante);
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'query');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comprobanteegreso/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$nroComprobante = $this->input->post('numero_comprobante');
    	$ordenDe = $this->input->post('orden_de');
        $nitCi = $this->input->post('nit_ci');
        $concepto = $this->input->post('concepto');
        $banco = $this->input->post('banco');
        $montoPagar = $this->input->post('monto_pagar');
        $fechaRegistro = $this->input->post('fecha_registro');
        $usuario = $this->session->usuario;        
        $proc = $this->comprobanteegreso_model->abm($operacion, $nroComprobante, $ordenDe, $nitCi, $concepto, $banco, $montoPagar, $fechaRegistro, $usuario);

        $tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

    public function Eliminar($nroComprobante) {
    	$usuario = $this->session->usuario;
        $proc = $this->comprobanteegreso_model->abm('D', $nroComprobante, null, null, null, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

}
