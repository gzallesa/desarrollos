<?php

class PersonalEquipo extends CI_Controller {
	
	private $menuId = '10034';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('personalequipo_model');
        $this->load->model('personal_model');
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
		
        $data['data_combo'] = $this->personalequipo_model->Combo($id);
		$data['data_grilla'] = json_encode($this->personalequipo_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'PE_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Consultar
		$opcion = 'PE_Q';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_consultar'] = $opcion;
		} else {
			$data['acc_consultar'] = "0";
		}
		//Eliminar
		$opcion = 'PE_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
			//Formulario
		$opcion = 'PE_R';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_reporte'] = $opcion;
		} else {
			$data['acc_reporte'] = "0";
		}		


		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("personalequipo/listar_vista", $data);
    }

    public function asignar_form($codPersonal) {
        $data['titulo'] = "Asingar / Desasignar Equipos";
        $data['cod_personal'] = $codPersonal;
        $data['tipo_equipo'] = $this->input->post("tipo_equipo");
        $data['marca'] = $this->input->post("marca");
        $data['tipo_equipo_lst'] = json_encode(getListaDominio('TIPO EQUIPO'));
        $data['marca_lst'] = json_encode(getListaDominio('MARCA'));
        $data['datosAAsignar'] = $this->personalequipo_model->getAAsignar($data['tipo_equipo'], $data['marca']);
        $data['datosAsignados'] = $this->personalequipo_model->getAsignado($codPersonal);
        
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/personalequipo');
			return;
		}
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;

        //Registrar
		$opcion = 'PE_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Eliminar
		$opcion = 'PE_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}		
		
        $this->vista->SetView("personalequipo/asignar_vista", $data);
    }

    public function query_form($id) {
        $data['titulo'] = "Consultar Personal-Equipo";
        $data['datos'] = $this->personalequipo_model->getIndividual($id);
        //$data['cod_personal'] = $data['datos']['COD_PERSONAL'];
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'query');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("personalequipo/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codPersonalEquipo = $this->input->post('cod_personal_equipo');
    	$codPersonal = $this->input->post('cod_personal');
    	$codEquipo = $this->input->post('cod_equipo');
    	$nombreEquipo = $this->input->post('nombre_equipo');
    	$descripcion = $this->input->post('descripcion');
    	$observacion = $this->input->post('observacion');
        
        $usuario = $this->session->usuario;
        $proc = $this->personalequipo_model->abm($operacion, $codPersonalEquipo, $codEquipo, $codPersonal, $nombreEquipo, $descripcion, $observacion, $usuario);

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
		//$this->Index();
		
        $data['cod_personal'] = $codPersonal;
        $data['tipo_equipo'] = $this->input->post("tipo_equipo");
        $data['marca'] = $this->input->post("marca");
        //log_message('debug','tipo:' . $data['tipo_equipo'] . ' marca: ' . $data['marca']);
		//$this->vista->SetView("personalequipo/asignar_vista/" . $codPersonal, $data);
		$result['resultado'] = $proc["@estado"];
		echo json_encode($result);
		//$this->asignar_form($codPersonal);
    }
    
    public function mostrarRecibo(){
		
		
	}

}
