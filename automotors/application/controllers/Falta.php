<?php

class Falta extends CI_Controller {
	
	private $menuId = '10064';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('falta_model');
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
		
        $data['data_combo'] = $this->falta_model->Combo($id);
		$data['data_grilla'] = json_encode($this->falta_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'FA_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'FA_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'FA_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}


		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("falta/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nuevo Falta";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['cod_dia_falta'] = '-1';
		$data['tipo_planilla'] = json_encode($this->falta_model->getTipoPlanilla($codPersonal));
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/falta');
			return;
		}
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("falta/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Falta";
        $data['operacion'] = 'U';
        $data['cod_dia_falta'] = $id;
        $data['datos'] = $this->falta_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['cod_personal'];
        $data['tipo_planilla'] = json_encode($this->falta_model->getTipoPlanilla($data['cod_personal']));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("falta/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codDiaFalta = $this->input->post('cod_dia_falta');
    	$codPersonal = $this->input->post('cod_personal');
        $tipoPlanilla = $this->input->post('tipo_planilla');
        $descripcion = $this->input->post('descripcion');
        $periodo = $this->input->post('periodo');
        $valor = $this->input->post('valor');
        $usuario = $this->session->usuario;
        $proc = $this->falta_model->abm($operacion, $codDiaFalta, $codPersonal, $tipoPlanilla, $descripcion, $periodo, $valor, $usuario);

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
        $proc = $this->falta_model->abm('D', $id, null, null, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

}
