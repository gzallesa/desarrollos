<?php

class Comision extends CI_Controller {
	
	private $menuId = '10067';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->helper('utilitario');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('comision_model');
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
		
        $data['data_combo'] = $this->comision_model->Combo($id);
		$data['data_grilla'] = json_encode($this->comision_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'CO_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'CO_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'CO_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}


		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comision/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nueva Comision";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['cod_comision_variable'] = '-1';
		$data['tipo_planilla'] = json_encode(getListaDominio('TIPO PLANILLA'));
		$data['comision_variable'] = json_encode(getListaDominio('COMISION VARIABLE'));
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/comision');
			return;
		}
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comision/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Comision";
        $data['operacion'] = 'U';
        $data['cod_comision_variable'] = $id;
        $data['cod_personal'] = $this->input->post("cod_personal");
        $data['datos'] = $this->comision_model->getIndividual($id);
        $data['tipo_planilla'] = json_encode(getListaDominio('TIPO PLANILLA'));
        $data['comision_variable'] = json_encode(getListaDominio('COMISION VARIABLE'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("comision/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codComision = $this->input->post('cod_comision_variable');
    	$codPersonal = $this->input->post('cod_personal');
    	$gestion = $this->input->post('gestion');
    	$tipo_planilla = $this->input->post('tipo_planilla');
        $comision_variable = $this->input->post('comision_variable');
        $descripcion = $this->input->post('descripcion');
        $monto = $this->input->post('monto');
        $usuario = $this->session->usuario;
        $proc = $this->comision_model->abm($operacion, $codComision, $codPersonal, $gestion, $tipo_planilla, $comision_variable, $descripcion, $monto, $usuario);

       /* if ($operacion == "I") {
            $this->Insertar_form();
        } else if ($operacion == "U") {
            $this->Actualizar_form($id);
        }*/
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
        $proc = $this->comision_model->abm('D', $id, null, null, null, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
/*    public function activar($id) {
        $proc = $this->comision_model->Guardar('A', $id, null, null);
        redirect(base_url().'rol');
//        $this->Index();
    }*/

}
