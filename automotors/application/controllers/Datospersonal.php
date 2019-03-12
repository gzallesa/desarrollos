<?php

class DatosPersonal extends CI_Controller {
	
	private $menuId = '10062';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('datospersonal_model');
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
		
        $data['data_combo'] = $this->datospersonal_model->Combo($id);
		$data['data_grilla'] = json_encode($this->datospersonal_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'DP_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'DP_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'DP_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Consultar
		$opcion = 'DP_Q';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_consultar'] = $opcion;
		} else {
			$data['acc_consultar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("datospersonal/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nuevo Datos Personal";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['codDatosPersonal'] = '-1';
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/datospersonal');
			return;
		}
		
		$data['division_negocio'] = json_encode(getListaDominio('DIVISION NEGOCIO'));
		$data['centro_gestion'] = json_encode(array(''));
		$data['tipo_documento'] = json_encode(getListaDominio('TIPO DOCUMENTO'));
		$data['expedido'] = json_encode(getListaDominio('EXPEDIDO'));
		$data['desc_afp'] = json_encode(getListaDominio('AFP'));
		$data['afp'] = json_encode(getListaDominio('DECIDE'));
		$data['tipo_planilla'] = json_encode(getListaDominio('TIPO PLANILLA'));
		$data['tipo_empleado'] = json_encode(getListaDominio('TIPO EMPLEADO'));
		$data['excepcionado'] = json_encode(getListaDominio('DECIDE'));
		$data['pago_aguinaldo'] = json_encode(getListaDominio('DECIDE'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("datospersonal/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Datos Personal";
        $data['operacion'] = 'U';
        $data['codDatosPersonal'] = $id;

        $data['datos'] = $this->datospersonal_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['COD_PERSONAL'];
            
		$data['division_negocio'] = json_encode(getListaDominio('DIVISION NEGOCIO'));
		$data['centro_gestion'] = json_encode($this->datospersonal_model->getCentroGestion($data['datos']['DIVISION_NEGOCIO']));
		$data['tipo_documento'] = json_encode(getListaDominio('TIPO DOCUMENTO'));
		$data['expedido'] = json_encode(getListaDominio('EXPEDIDO'));
		$data['desc_afp'] = json_encode(getListaDominio('AFP'));
		$data['afp'] = json_encode(getListaDominio('DECIDE'));
		$data['tipo_planilla'] = json_encode(getListaDominio('TIPO PLANILLA'));
		$data['tipo_empleado'] = json_encode(getListaDominio('TIPO EMPLEADO'));
		$data['excepcionado'] = json_encode(getListaDominio('DECIDE'));
		$data['pago_aguinaldo'] = json_encode(getListaDominio('DECIDE'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("datospersonal/formulario_vista", $data);
    }

    public function consultar_form($id) {
        $data['titulo'] = "Consultar Datos Personal";
        $data['operacion'] = 'C';
        $data['codDatosPersonal'] = $id;

        $data['datos'] = $this->datospersonal_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['COD_PERSONAL'];
            
		$data['division_negocio'] = json_encode(getListaDominio('DIVISION NEGOCIO'));
		$data['centro_gestion'] = json_encode($this->datospersonal_model->getCentroGestion($data['datos']['DIVISION_NEGOCIO']));
		$data['tipo_documento'] = json_encode(getListaDominio('TIPO DOCUMENTO'));
		$data['expedido'] = json_encode(getListaDominio('EXPEDIDO'));
		$data['desc_afp'] = json_encode(getListaDominio('AFP'));
		$data['afp'] = json_encode(getListaDominio('DECIDE'));
		$data['tipo_planilla'] = json_encode(getListaDominio('TIPO PLANILLA'));
		$data['tipo_empleado'] = json_encode(getListaDominio('TIPO EMPLEADO'));
		$data['excepcionado'] = json_encode(getListaDominio('DECIDE'));
		$data['pago_aguinaldo'] = json_encode(getListaDominio('DECIDE'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'query');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("datospersonal/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
		$cod_personal_planilla = $this->input->post('codDatosPersonal');
		$cod_personal = $this->input->post('cod_personal');
		$division_negocio = $this->input->post('division_negocio');
		$centro_gestion = $this->input->post('centro_gestion');
		$fecha_ingreso = $this->input->post('fecha_ingreso');
		$fecha_salida = $this->input->post('fecha_salida');
		$sueldo_basico = $this->input->post('sueldo_basico');
		$fecha_nacimiento = $this->input->post('fecha_nacimiento');
		$tipo_documento = $this->input->post('tipo_documento');
		$numero_documento = $this->input->post('numero_documento');
		$expedido = $this->input->post('expedido');
		$matricula = $this->input->post('matricula');
		$afp = $this->input->post('afp');
		$desc_afp = $this->input->post('desc_afp');
		$tipo_planilla = $this->input->post('tipo_planilla');
		$tipo_empleado = $this->input->post('tipo_empleado');
		$cuenta = $this->input->post('cuenta');
		$excepcionado = $this->input->post('excepcionado');
		$pago_aguinaldo = $this->input->post('pago_aguinaldo');
        $usuario = $this->session->usuario;
        
        $proc = $this->datospersonal_model->abm($operacion,
												$cod_personal_planilla,
												$cod_personal,
												$division_negocio,
												$centro_gestion,
												$fecha_ingreso,
												$fecha_salida,
												$sueldo_basico,
												$fecha_nacimiento,
												$tipo_documento,
												$numero_documento,
												$expedido,
												$matricula,
												$afp,
												$desc_afp,
												$tipo_planilla,
												$tipo_empleado,
												$cuenta,
												$excepcionado,
												$pago_aguinaldo,
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
        $proc = $this->datospersonal_model->abm('D',
												$id,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
												NULL,
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
    
	function getComboDinamico($divisionNegocio){
		echo json_encode($this->datospersonal_model->getCentroGestion($divisionNegocio));
	}

}
