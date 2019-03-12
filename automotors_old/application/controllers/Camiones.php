<?php

class Camiones extends CI_Controller {
	
	private $menuId = '10023';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
//		$this->load->database();
		$this->load->library('grocery_CRUD');
		$this->load->library('session');	
		$this->load->library('vista');
		$this->load->model("Camion_model");

		//si no hay sesion
		if(!($this->session->userdata('logged_in')))
		{  
			redirect(base_url());
		}
		//Verificar acceso
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
	}
	
	public function index() {	
		$crud = new grocery_CRUD();
		$crud->set_table('mte_camion');
		$crud->set_subject('Camion');
		$crud->set_primary_key('COD_CAMION','getCamionTotal');
		$crud->columns('COD_CAMION','COLOR','MARCA','foto','TIPO_HIDROCARBURO','CAPACIDAD_KG', 'DESCRIPCION', 'ESTADO');
		$crud->fields('COD_CAMION', 'MARCA', 'COLOR', 'foto', 'NRO_CAMION', 'TIPO_HIDROCARBURO', 'CAPACIDAD_KG', 'DESCRIPCION', 'ESTADO', 'USUARIO_CREACION', 'USUARIO_MODIFICACION');
		$crud->change_field_type('USUARIO_CREACION','invisible');
		$crud->change_field_type('USUARIO_MODIFICACION','invisible');
		if($crud->getState() == 'list' || $crud->getState() == 'ajax_list') {
			//Combo Estado
			$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'ESTADO'");
			$marcas = array();
			foreach($query->result_array() as $item) {
				$marcas[$item['codigo']] = $item['descripcion'];
			}
			$crud->field_type('ESTADO', 'dropdown', $marcas);
		} else {
			$crud->change_field_type('ESTADO','invisible');
		}
		//Combo Marca
		$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'MARCA'");
		$marcas = array();
		foreach($query->result_array() as $item) {
			$marcas[$item['codigo']] = $item['descripcion'];
		}
		$crud->field_type('MARCA', 'dropdown', $marcas);
		//Combo Color
		$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'COLOR'");
		$colores = array();
		foreach($query->result_array() as $item) {
			$colores[$item['codigo']] = $item['descripcion'];
		}
		$crud->field_type('COLOR', 'dropdown', $colores);
		//Combo Tipo Hidrocarburo
		$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'TIPO_HIDROCARBURO'");
		$th = array();
		foreach($query->result_array() as $item) {
			$th[$item['codigo']] = $item['descripcion'];
		}
		$crud->field_type('TIPO_HIDROCARBURO', 'dropdown', $th);
		//Campos requeridos
		$crud->required_fields('COD_CAMION','MARCA', 'COLOR', 'TIPO_HIDROCARBURO', 'NRO_CAMION');
		$crud->callback_before_insert(array($this,'insert_callback'));
		$crud->callback_before_update(array($this,'update_callback'));
		$crud->callback_delete(array($this,'delete_callback'));
		
		//Type upload
		$crud->set_field_upload('foto','assets/uploads/files');
		//----Opciones de acceso
		//Registrar (Si NO existe se quita)
		$opcion = 'C_I';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_add();
		}
		//Ver (Si NO existe se quita)
		$opcion = 'C_R';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_read();
		}
		//Modificar (Si NO existe se quita)
		$opcion = 'C_U';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_edit();
		}
		//Eliminar (Si NO existe se quita)
		$opcion = 'C_D';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_delete();
		}
		//Activar (Si existe se crea)
		$opcion = 'C_A';
		if(verificar_acceso($this->menuId, $opcion)) {
			$crud->add_action('Activar Camion', base_url().'assets/css/images/success.png', 'camion/activar','ui-icon-image',array($this, '_callback_activar'));
		}
		try {
			$salida = $crud->render();
			$breadCrumb = cargarBreadCrumb($this->menuId, $crud->getState());
			$extra = array("breadCrumb" => $breadCrumb);
			$salida = array_merge( (array)$salida, $extra);
			$this->vista->SetView('camiones/abm_vista',(array)$salida);
		} catch (Exception $e) {
			if ($e->getCode() == 14) {  //The 14 is the code of the error on grocery CRUD (don't have permission).
				$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
				$this->session->set_flashdata('acceso','Acceso retringido...');
//				show_error('LMTF');
				redirect(base_url());
            } else {
                show_error($e->getMessage());
                return false;
            }
		}
	}
	
	function insert_callback($post_array) {
		$post_array['USUARIO_CREACION'] = $this->session->usuario;
		$post_array['ESTADO'] = 'A';
		return $post_array;
	}
	
	function update_callback($post_array) {
		$post_array['USUARIO_MODIFICACION'] = $this->session->usuario;
		return $post_array;
	}
	
	function delete_callback($primary_key) {
		try{
			$query= $this->db->query("call abm_mte_camion(?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', '', '', '', '', $this->session->usuario));
		} catch (Exception $e) {
			show_error($e->getMessage());
            return false;
		}
	}
	
	function _callback_activar($primary_key, $row) {
		return "javascript:confirmActivar('camiones/activar', '$primary_key');";
	}
	
	function activar($primary_key) {
		$post_array = array('COD_CAMION' => $primary_key );
		try{
			$query= $this->db->query("call abm_mte_camion(?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('A', $primary_key, '', '', '', '', '', '', $this->session->usuario));
		} catch (Exception $e) {
			show_error($e->getMessage());
            return false;
		}
		redirect(base_url().'camiones');
	}
	
	public function camion_chofer() {
    	//Verificar acceso
    	$this->menuId = '10027';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else {
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
        $operacion = $this->input->post('operacion');
        if ($operacion != null) {
            $proc = $this->Camion_model->GuardarCamionChofer($operacion, $this->input->post('idCamion'), $this->input->post('elemento'));
        }
        $id = $this->input->post('idCamion');
        $data['datosCamionTotal'] = $this->Camion_model->ComboCamionesTotal($id);

        $data['datosCamionChoferAAsignar'] = $id != null ? $this->Camion_model->GetCamionChoferAAsignar($id) : "";
        $data['datosCamionChoferAsignados'] = $id != null ? $this->Camion_model->GetCamionChoferAsignados($id) : "";
        $error = $this->db->error();
        $data['error'] = $error;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("camiones/camion_chofer_vista", $data);
    }
}
?>