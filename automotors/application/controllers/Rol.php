<?php

class Rol extends CI_Controller {
	
	private $menuId = '10003';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('rol_model');
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
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
        $data['datos_lista'] = json_encode($this->rol_model->Listar());
        //Registrar
		$opcion = 'R_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = "R_I";
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'R_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = "R_U";
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'R_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = "R_D";
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'R_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = "R_A";
		} else {
			$data['acc_activar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("rol/listado_vista", $data);
    }

    public function Insertar_form() {
        $data['titulo'] = "Nuevo Rol";
        $data['operacion'] = 'I';
        $data['id'] = null;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("rol/formulario_vista", $data);
    }

    public function Actualizar_form($id) {
        $data['titulo'] = "Editar Rol";
        $data['operacion'] = 'U';
        $data['id'] = $id;
        $data['datos'] = $this->rol_model->GetRol($id);
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("rol/formulario_vista", $data);
    }

    public function Detalle_form($id) {
        $data['titulo'] = "Detalles del Rol";
        $data['id'] = $id;
        $data['datos'] = $this->rol_model->GetRol($id);

        $this->vista->SetView("rol/detalle_vista", $data);
    }

    public function Guardar() {
        $id = $this->input->post('id');
        $rol = $this->input->post('rol');
        $operacion = $this->input->post('operacion');
        $nombre = $this->input->post('nombre_rol');
        $proc = $this->rol_model->Guardar($operacion, $id != null ? $id : $rol, $nombre);

        if ($operacion == "I") {
            $this->Insertar_form();
        } else if ($operacion == "U") {
            $this->Actualizar_form($id);
        }
    }

    public function Eliminar($id) {
        $proc = $this->rol_model->Guardar('D', $id, null, null);
        $this->Index();
    }
    
    public function activar($id) {
        $proc = $this->rol_model->Guardar('A', $id, null, null);
        redirect(base_url().'rol');
//        $this->Index();
    }

    public function Rol_menu_web() {
    	//Verificar acceso
    	$this->menuId = '10006';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
//        log_message('error', 'Some variable did not contain a value.');
//        log_message('info', 'The purpose of some variable is to provide some value.');
        $operacion = $this->input->post('operacion');
        if ($operacion != null) {
            $proc = $this->rol_model->GuardarRolMenuWeb($operacion, $this->input->post('idRol'), $this->input->post('elemento'));
            //TODO Quitar esto para la carga de menu
            $this->load->model('menuweb_model');
            $this->session->menu = $this->menuweb_model->GetMenuUsuario($this->session->usuario);
            //TODO Quitar esto para la carga de menu
        }

        $id = $this->input->post('idRol');
        $data['datosRolesTotal'] = $this->rol_model->ComboRolesTotal($id);

        $data['datosMenuWebAAsignar'] = $id != null ? $this->rol_model->GetMenuWebAAsignar($id) : "";
        $data['datosMenuWebAsignados'] = $id != null ? $this->rol_model->GetMenuWebAsignados($id) : "";
        $error = $this->db->error();
        $data['error'] = $error;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("rol/rol_menu_web_vista", $data);
    }

    public function Rol_menu_mobile() {
    	//Verificar acceso
    	$this->menuId = '10007';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
		
        $operacion = $this->input->post('operacion');
        if ($operacion != null) {
            $proc = $this->rol_model->GuardarRolMenuMobile($operacion, $this->input->post('idRol'), $this->input->post('elemento'));
        }

        $id = $this->input->post('idRol');
        $data['datosRolesTotal'] = $this->rol_model->ComboRolesTotal($id);

        $data['datosMenuMobileAAsignar'] = $id != null ? $this->rol_model->GetMenuMobileAAsignar($id) : "";
        $data['datosMenuMobileAsignados'] = $id != null ? $this->rol_model->GetMenuMobileAsignados($id) : "";
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("rol/rol_menu_mobile_vista", $data);
    }

}
