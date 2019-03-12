<?php

class Acceso extends CI_Controller {
	
	private $menuId = '10032';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('acceso_model');
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
		
        $data['data_combo'] = $this->acceso_model->Combo($id);
		$data['data_grilla'] = json_encode($this->acceso_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'AC_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'AC_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'AC_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}


		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("acceso/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nuevo Acceso";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['cod_acceso'] = '-1';
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/acceso');
			return;
		}
		$data['tipo_acceso'] = json_encode(getListaDominio('ACCESO'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("acceso/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Acceso";
        $data['operacion'] = 'U';
        $data['cod_acceso'] = $id;
        //$data['cod_personal'] = $this->input->post("cod_personal");
        $data['datos'] = $this->acceso_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['COD_PERSONAL'];
        $data['tipo_acceso'] = json_encode(getListaDominio('ACCESO'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("acceso/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codAcceso = $this->input->post('cod_acceso');
    	$codPersonal = $this->input->post('cod_personal');
        $acceso = $this->input->post('acceso');
        $valor = $this->input->post('valor');
        $usuario = $this->session->usuario;
        $proc = $this->acceso_model->abm($operacion, $codAcceso, $codPersonal, $acceso, $valor, $usuario);

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
        $proc = $this->acceso_model->abm('D', $id, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
/*    public function activar($id) {
        $proc = $this->acceso_model->Guardar('A', $id, null, null);
        redirect(base_url().'rol');
//        $this->Index();
    }*/

}
