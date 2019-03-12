<?php

class BonoDeduccion extends CI_Controller {
	
	private $menuId = '10068';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('bonodeduccion_model');
        $this->load->helper('utilitario');
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
		
		$id=$this->input->post("cod_personal");
		
        $data['data_combo'] = $this->bonodeduccion_model->Combo($id);
		$data['data_grilla'] = json_encode($this->bonodeduccion_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'BD_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'BD_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'BD_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Consultar
		$opcion = 'BD_Q';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_consultar'] = $opcion;
		} else {
			$data['acc_consultar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("bonodeduccion/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nuevo Bono - Deduccion";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['codBonoDeduccion'] = '-1';

        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/bonodeduccion');
			return;
		}
		$data['tipo_planilla'] = json_encode($this->bonodeduccion_model->getTipoPlanilla($codPersonal));
		$data['tipo'] = json_encode(getListaDominio('TIPO DEDUCCIO'));
		$data['nivel'] = json_encode(array(''));

        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("bonodeduccion/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Bono - Deduccion";
        $data['operacion'] = 'U';
        $data['codBonoDeduccion'] = $id;

        $data['datos'] = $this->bonodeduccion_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['cod_personal'];
            
		$data['tipo_planilla'] = json_encode($this->bonodeduccion_model->getTipoPlanilla($data['datos']['cod_personal']));
		$data['tipo'] = json_encode(getListaDominio('TIPO DEDUCCIO'));
		$data['nivel'] = json_encode($this->bonodeduccion_model->getValorDeduccion($data['datos']['tipo']));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("bonodeduccion/formulario_vista", $data);
    }

    public function consultar_form($id) {
        $data['titulo'] = "Consultar Bono - Deduccion";
        $data['operacion'] = 'C';
        $data['codBonoDeduccion'] = $id;

        $data['datos'] = $this->bonodeduccion_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['cod_personal'];
            
		$data['tipo_planilla'] = json_encode($this->bonodeduccion_model->getTipoPlanilla($data['datos']['cod_personal']));
		$data['tipo'] = json_encode(getListaDominio('TIPO DEDUCCIO'));
		$data['nivel'] = json_encode($this->bonodeduccion_model->getValorDeduccion($data['datos']['tipo']));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'query');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("bonodeduccion/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
		$cod_bono_deduccion = $this->input->post('codBonoDeduccion');
		$cod_personal = $this->input->post('cod_personal');
		$tipo_planilla = $this->input->post('tipo_planilla');
		$tipo = $this->input->post('tipo');
		$nivel = $this->input->post('nivel');
		$descripcion = $this->input->post('descripcion');
		$periodo_inicio = $this->input->post('periodo_inicio');
		$periodo_final = ($this->input->post('periodo_final') !== null)?$this->input->post('periodo_final'):null;
		$monto = $this->input->post('monto');
        $usuario = $this->session->usuario;
        
        $proc = $this->bonodeduccion_model->abm($operacion,
												$cod_bono_deduccion,
												$cod_personal,
												$tipo_planilla,
												$tipo,
												$nivel,
												$descripcion,
												$periodo_inicio,
												$periodo_final,
												$monto,
												$usuario);

        $tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

    public function Eliminar($id) {
    	$usuario = $this->session->usuario;
        $proc = $this->bonodeduccion_model->abm('D',
												$id,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												$usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
	function getComboDinamico($tipo){
		echo json_encode($this->bonodeduccion_model->getValorDeduccion($tipo));
	}

}
