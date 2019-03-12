<?php

class Zonas extends CI_Controller {
	
	private $menuId = '10022';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
//		$this->load->database();
		$this->load->library('grocery_CRUD');
		$this->load->library('session');	
		$this->load->library('vista');	

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
		$crud->set_table('mte_zonas');
		$crud->set_subject('Zona');
		$crud->set_primary_key('cod_zona','getZonasTotal');
		$crud->unset_columns('FECHA_CREACION','FECHA_MODIFICACION','FECHA_ELIMINACION','USUARIO_CREACION','USUARIO_MODIFICACION','USUARIO_ELIMINACION');
		$crud->fields('COD_ZONA', 'NOMBRE_ZONA', 'descripcion', 'USUARIO_CREACION', 'USUARIO_MODIFICACION');
		$crud->callback_before_insert(array($this,'insert_callback'));
		$crud->callback_before_update(array($this,'update_callback'));
		$crud->callback_delete(array($this,'delete_callback'));
		$crud->change_field_type('USUARIO_CREACION','invisible');
		$crud->change_field_type('USUARIO_MODIFICACION','invisible');
		$crud->required_fields('COD_ZONA','NOMBRE_ZONA');
		
		//----Opciones de acceso
		//Registrar (Si NO existe se quita)
		$opcion = 'Z_I';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_add();
		}
		//Ver (Si NO existe se quita)
		$opcion = 'Z_R';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_read();
		}
		//Modificar (Si NO existe se quita)
		$opcion = 'Z_U';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_edit();
		}
		//Eliminar (Si NO existe se quita)
		$opcion = 'Z_D';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_delete();
		}
		
		try {
			$salida = $crud->render();
			//Cargar MigaPan
			$breadCrumb = cargarBreadCrumb($this->menuId, $crud->getState());
			//Asignando a la vista
			$extra = array("breadCrumb" => $breadCrumb);
			$salida = array_merge( (array)$salida, $extra);
			$this->vista->SetView('zonas/abm_vista',(array)$salida);
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
		return $post_array;
	}
	
	function update_callback($post_array) {
		$post_array['USUARIO_MODIFICACION'] = $this->session->usuario;
		return $post_array;
	}
	
	function delete_callback($primary_key) {
		$query= $this->db->query("call abm_mte_zona(?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', $this->session->usuario));
	}
	
	/*private function _generarAbm($salida = null) {
		$this->vista->SetView('zonas/abm_vista',(array)$salida);
	}*/
}
?>