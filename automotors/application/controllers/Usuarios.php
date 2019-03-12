<?php

class Usuarios extends CI_Controller {

	private $menuId = '10002';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->helper('utilitario');
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

	public function index($modif = false, $us = false) {
		$crud = new grocery_CRUD();
		$crud->set_table('mon_usuario');
//                $crud->set_theme('bootstrap');
		//$crud->set_relation_n_n('ROL','mon_usuario_rol','mon_rol','USUARIO','ROL','NOMBRE_ROL');
		//$crud->columns('USUARIO','NOMBRE_COMPLETO','ESTADO','FECHA_CREACION');
		$crud->set_relation_n_n('ROL','vw_getUsuarioRolActivo','vw_getRolesActivos','USUARIO','ROL','NOMBRE_ROL');
		
		/*$crud->unset_add();
		$crud->unset_edit();
		$crud->set_theme('datatables');
		$crud->add_action('More', '', 'demo/action_more','ui-icon-plus');*/
		$crud->set_subject('Usuario');
		$crud->set_primary_key('USUARIO_ROL','vw_getUsuarioRolActivo');
		$crud->set_primary_key('ROL','vw_getRolesActivos');
		$crud->unset_columns('CONTRASEÑA','FECHA_CREACION','FECHA_MODIFICACION','FECHA_ELIMINACION','USUARIO_CREACION','USUARIO_MODIFICACION','USUARIO_ELIMINACION');
		$crud->unset_edit_fields('FECHA_CREACION','FECHA_MODIFICACION','FECHA_ELIMINACION','USUARIO_CREACION','USUARIO_MODIFICACION','USUARIO_ELIMINACION','ESTADO', 'CONTRASEÑA');
		$crud->unset_add_fields('FECHA_CREACION','FECHA_MODIFICACION','FECHA_ELIMINACION','USUARIO_CREACION','USUARIO_MODIFICACION','USUARIO_ELIMINACION','ESTADO');
		$crud->required_fields('USUARIO','NOMBRE_COMPLETO','CONTRASEÑA','WEB','MOBILE','FECHA_DESDE');
		$crud->change_field_type('CONTRASEÑA', 'password');
//		$crud->callback_edit_field('CONTRASEÑA', function () {
//			return '<input type="password" class="form-control" maxlength="50" value="" name="CONTRASEÑA">';
//		});
		
		//----Opciones de acceso
		//Registrar (Si NO existe se quita)
		$opcion = 'U_I';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_add();
		}
		//Ver (Si NO existe se quita)
		$opcion = 'U_R';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_read();
		}
		//Modificar (Si NO existe se quita)
		$opcion = 'U_U';
		$state = $crud->getState();
		if($state == 'edit'){
			if($us != $this->session->usuario && !verificar_acceso($this->menuId, $opcion)) {
				$crud->unset_edit();
			}
		} else {
			if(!verificar_acceso($this->menuId, $opcion)) {
				$crud->unset_edit();
			}
		}
		//Eliminar (Si NO existe se quita)
		$opcion = 'U_D';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_delete();
		}
		//Activar (Si existe se crea)
		$opcion = 'U_A';
		if(verificar_acceso($this->menuId, $opcion)) {
			$crud->add_action('Activar Usuario', base_url().'assets/css/images/success.png', 'usuarios/activar','ui-icon-image',array($this, '_callback_activar'));
		}
		//Validacion campos
		$crud->set_rules('FECHA_HASTA', 'FECHA HASTA', 'callback_fechaHasta_check');

		$crud->callback_insert(array($this,'_callback_insertar'));
		$crud->callback_update(array($this,'_callback_actualizar'));
		$crud->callback_delete(array($this,'_callback_eliminar'));
		//Combo Estado
		if($crud->getState() == 'list' || $crud->getState() == 'ajax_list') {
			$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'ESTADO'");
			$marcas = array();
			foreach($query->result_array() as $item) {
				$marcas[$item['codigo']] = $item['descripcion'];
			}
			$crud->field_type('ESTADO', 'dropdown', $marcas);
		} else {
			$crud->change_field_type('ESTADO','invisible');
		}
		//
		//Combo
		$arr = array('S' => 'SI', 'N' => 'NO');
		$crud->field_type('WEB', 'dropdown', $arr);
		$crud->field_type('MOBILE', 'dropdown', $arr);
		try {
			$salida = $crud->render();
			//Cargar MigaPan
			$breadCrumb = cargarBreadCrumb($this->menuId, $crud->getState());
			//Asignando a la vista
			$extra = array("breadCrumb" => $breadCrumb);
			$salida = array_merge( (array)$salida, $extra);
			$this->_generarAbm($salida);
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
	
	function fechaHasta_check($fechaHasta) {
//		$this->session->set_userdata('FH', $fechaHasta);
		$fechaDesde = $this->input->post('FECHA_DESDE');
//		$this->session->set_userdata('FD', $fechaDesde);
		if($fechaHasta == "") {
			return TRUE;
		}
		if(fechaMenorIgualQue($fechaDesde, $fechaHasta)) {
			$this->form_validation->set_message('fechaHasta_check', 'Todo bien');
			return TRUE;
		}
		$this->form_validation->set_message('fechaHasta_check', 'FECHA_HASTA es menor que FECHA_DESDE');
		return FALSE;
//		return TRUE;
	}

	function _callback_insertar($post_array,$primary_key) {
		$resultado = $this->_guardar_usuario('i',$post_array);

		$this->_guardarElementos($post_array['USUARIO'],$post_array['ROL']);
	}
	
	function _callback_actualizar($post_array,$primary_key) {
		$resultado = $this->_guardar_usuario('u',$post_array);
		$this->_guardarElementos($primary_key,$post_array['ROL']);
	}
	
	function _callback_eliminar($primary_key) {
		$post_array=array('USUARIO' => $primary_key );
		$resultado = $this->_guardar_usuario('d',$post_array);
	}
	
	function _callback_activar($primary_key, $row) {
		return "javascript:confirmActivar('usuarios/activar', '$primary_key');";
	}
	
	function activar($primary_key) {
		$post_array=array('USUARIO' => $primary_key );
		$resultado = $this->_guardar_usuario('A',$post_array);
		redirect(base_url().'usuarios');
	}
	
	public function cambiarPass() {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$usuario = $this->session->usuario;
		if($this->input->post()) {
			switch($this->input->post('boton')) {
				case "Cancelar": {
					redirect(base_url());
				}
				break;
				case "Modificar": {
					$oldPass = $this->input->post("old_pass");
					$newPass = $this->input->post("new_pass");
					$sql="call set_cambio_password(?, ?, ?, ?, @estado, @error)";
					$query = $this->db->query($sql, array($usuario, $oldPass, $newPass, $usuario));
					$query = $this->db->query('select @estado, @error');
					$resultado = $query->row_array();
					if($resultado['@estado'] == 1) {
						$datos['error'] = $resultado['@error'];
						$datos['usuario'] = $usuario;
						$this->vista->SetView('usuarios/cambiarPass', $datos);
					} else {
						$this->session->set_flashdata('success', $resultado['@error']);
//						$this->session->set_flashdata('acceso', $resultado['@error']);
						redirect(base_url());						
					}
				}
				break;
			}
		} else {
			$this->form_validation->set_rules('old_pass', 'old_pass Name', 'required');
			if ($this->form_validation->run() == FALSE) {
                $datos['usuario'] = $usuario;
				$this->vista->SetView('usuarios/cambiarPass', $datos);
            }
            else {
                    $this->load->view('formsuccess');
            }
			
		}
	}
	
	private function _guardar_usuario($operacion, $post_array) {
		$sql='call abm_usuario(?,?,?,?,?,?,?,?,?,@estado,@error)';
		$args=array(
			$operacion,
			$post_array['USUARIO'],
			array_key_exists('NOMBRE_COMPLETO',$post_array)?$post_array['NOMBRE_COMPLETO']:"",
			array_key_exists('CONTRASEÑA',$post_array) ? sha1($post_array['CONTRASEÑA']) : NULL,
			array_key_exists('WEB',$post_array)?$post_array['WEB']:"",
			array_key_exists('MOBILE',$post_array)?$post_array['MOBILE']:"",
			$this->session->usuario,
			array_key_exists('FECHA_DESDE',$post_array)?date_create_from_format('d/m/Y', $post_array['FECHA_DESDE'])->format('Y-m-d'):"",
//			array_key_exists('FECHA_HASTA',$post_array)?date_create_from_format('d/m/Y', $post_array['FECHA_HASTA'])->format('Y-m-d'):""
			array_key_exists('FECHA_HASTA',$post_array) && $post_array['FECHA_HASTA'] != null ? date_create_from_format('d/m/Y', $post_array['FECHA_HASTA'])->format('Y-m-d') : ""
		);
		$query=$this->db->query($sql, $args);
		
		log_message('query _guardar_usuario: ' . print_r($query->db->last_query(),true));
		$query = $this->db->query('select @estado,@error');
		$resultado = $query->row();
		log_message('resultado _guardar_usuario: ' . print_r($query->row(),true));
		return $resultado->error;//mensaje de resultado
	}
	
	private function _guardarElementos($pkey,$elementos) {
		$elem = $elementos!=null? implode(",", $elementos):"";
		$sql='call abm_usuario_rol_asignar(?,?,?)';
		$this->db->query($sql, array($pkey, $elem, $this->session->usuario));
		
		$this->load->model('menuweb_model');
		$this->session->menu = $this->menuweb_model->GetMenuUsuario($this->session->usuario)  ;
	}
	
	private function _generarAbm($salida = null) {
		$this->vista->SetView('usuarios/abm_vista',(array)$salida);
	}
}