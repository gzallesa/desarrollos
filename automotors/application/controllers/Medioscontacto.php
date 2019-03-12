<?php

class MediosContacto extends CI_Controller {
	
	private $menuId = '10029';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('mediocontacto_model');
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
        $data['data_combo'] = $this->mediocontacto_model->Combo($id);
		$data['data_grilla'] = json_encode($this->mediocontacto_model->Listar($id));
		//$data['mensaje']=$mensaje;
        
        //Registrar
		$opcion = 'MC_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = "MC_I";
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'MC_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = "MC_U";
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'MC_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = "MC_D";
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'MC_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = "MC_A";
		} else {
			$data['acc_activar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("mediocontacto/listar_vista", $data);
    }

    public function Insertar_form($codPersonal) {
        $data['titulo'] = "Nuevo Medio Contacto";
        $data['operacion'] = 'I';
        $data['cod_personal'] = $codPersonal;
		$data['id_medio_contacto'] = '-1';
        $data['json'] = json_encode($this->mediocontacto_model->getListaMedios());
        if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/medioscontacto');
			return;
		}
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("mediocontacto/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Medio Contacto";
        $data['operacion'] = 'U';
        $data['id_medio_contacto'] = $id;
        //$data['cod_personal'] = $this->input->post("cod_personal");
		$data['json'] = json_encode($this->mediocontacto_model->getListaMedios());
        $data['datos'] = $this->mediocontacto_model->getIndividual($id);
        $data['cod_personal'] = $data['datos']['cod_personal'];
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("mediocontacto/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$idMedioContacto = $this->input->post('id_medio_contacto');
    	$codPersonal = $this->input->post('cod_personal');
        $medioContacto = $this->input->post('medio_contacto');
        $valor = $this->input->post('valor');
        $usuario = $this->session->usuario;
        $proc = $this->mediocontacto_model->abm($operacion, $idMedioContacto, $codPersonal, $medioContacto, $valor, $usuario);

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
        $proc = $this->mediocontacto_model->abm('D', $id, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
/*    public function activar($id) {
        $proc = $this->mediocontacto_model->Guardar('A', $id, null, null);
        redirect(base_url().'rol');
//        $this->Index();
    }*/

}
