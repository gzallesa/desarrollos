<?php

class Personal extends CI_Controller {
	
	private $menuId = '10025';
	private $LATITUD_INI = '-17.78329116182854';
	private $LONGITUD_INI = '-63.182136792659776';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->library('googlemaps');
		$this->load->model("Personal_model");

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
		$crud = new Grocery_CRUD();
		$crud->set_table('mte_personal');
		$crud->set_subject('Personal');
		//Columnas a mostrar en dataTable
		$crud->columns('COD_PERSONAL', 'NOMBRE_COMPLETO', 'foto', 'CARGO', 'DIRECCION', 'DESCRIPCION', 'SUCURSAL', 'TELEFONO_OFICINA', 'INTERNO', 'estado');
		//$crud->columns('COD_PERSONAL', 'NOMBRE_COMPLETO', 'foto', 'CARGO', 'DIRECCION', 'descripcion', 'estado');
		//Columnas a mostrar en formulario(add, edit)
		$crud->fields('COD_PERSONAL', 'NOMBRE_COMPLETO', 'foto', 'CARGO', 'DIRECCION', 'DESCRIPCION', 'SUCURSAL', 'TELEFONO_OFICINA', 'INTERNO', 'LINEA_WIN', 'estado', 'USUARIO_CREACION', 'USUARIO_MODIFICACION','FECHA_CREACION','FECHA_MODIFICACION');
		//$crud->fields('COD_PERSONAL', 'NOMBRE_COMPLETO', 'foto', 'CARGO', 'DIRECCION', 'descripcion', 'LINEA_WIN', 'estado', 'USUARIO_CREACION', 'USUARIO_MODIFICACION','FECHA_CREACION','FECHA_MODIFICACION');
		
		// set alias
		$crud->display_as('foto','FOTO');
		$crud->display_as('estado','ESTADO');
		
		//Combo Cargo
		$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'CARGO'");
		$marcas = array();
		foreach($query->result_array() as $item) {
			$marcas[$item['codigo']] = $item['descripcion'];
		}
		$crud->field_type('CARGO', 'dropdown', $marcas);

		//Combo Estado
		if($crud->getState() == 'list' || $crud->getState() == 'ajax_list') {
			$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'ESTADO'");
			$marcas = array();
			foreach($query->result_array() as $item) {
				$marcas[$item['codigo']] = $item['descripcion'];
			}
			$crud->field_type('estado', 'dropdown', $marcas);
		} else {
			$crud->change_field_type('estado','invisible');
		}
		
		//obtener las sucursales
		$query = $this->db->query("call getAlmacenes()");
		//$query = $this->db->query("select alm.cod_sucursal,alm.nombre_sucursal from mte_almacen alm where alm.fecha_eliminacion IS NULL order by alm.cod_sucursal");
		//$query = $this->db->query("SELECT d.codigo, d.descripcion FROM mon_dominio d WHERE d.DOMINIO = 'ESTADO'");
		$marcas = array();
		foreach($query->result_array() as $item) {
			//error_log('item: ' . print_r($item,true));
			$marcas[$item['cod_sucursal']] = $item['nombre_sucursal'];
			//$marcas[$item['codigo'] . '-JAJA'] = $item['descripcion'] . '-HOLA';
			//error_log('marcas: ' . print_r($marcas,true));
		}
		$crud->field_type('SUCURSAL', 'dropdown', $marcas);
		
		//Configuracion de campos especiales
		$crud->change_field_type('USUARIO_CREACION','invisible');
		$crud->change_field_type('USUARIO_MODIFICACION','invisible');
		$crud->change_field_type('FECHA_CREACION','invisible');
		$crud->change_field_type('FECHA_MODIFICACION','invisible');		
		//Campos requeridos
		$crud->required_fields('COD_PERSONAL', 'NOMBRE_COMPLETO', 'CARGO', 'DIRECCION');
		
		//Obtener Usuarios de acciones
		$crud->callback_before_insert(array($this,'insert_callback'));
		$crud->callback_before_update(array($this,'update_callback'));
		$crud->callback_delete(array($this,'delete_callback'));
		
		//Type upload
		$crud->set_field_upload('foto','assets/uploads/files');
		
		//----Opciones de acceso
		//Registrar (Si NO existe se quita)
		$opcion = 'P_I';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_add();
		}
		//Ver (Si NO existe se quita)
		$opcion = 'P_R';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_read();
		}
		//Modificar (Si NO existe se quita)
		$opcion = 'P_U';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_edit();
		}
		//Eliminar (Si NO existe se quita)
		/*$opcion = 'P_D';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_delete();
		}*/
		$crud->unset_delete()
;
		$opcion = 'P_D';
		if(verificar_acceso($this->menuId, $opcion)) {
			$crud->add_action('Inactivar Personal', base_url().'assets/css/images/close.png', 'personal/eliminar','ui-icon-image',array($this, '_callback_eliminar'));
		}
		//Georeferenciar (Si existe se crea)
		$opcion = 'P_G';
		if(verificar_acceso($this->menuId, $opcion)) {
			//Acciones personalizadas
			$crud->add_action('Georefenciar', base_url().'assets/themes/icons/led/map.png', 'personal/georeferenciar');
		}
		//Activar (Si existe se crea)
		$opcion = 'P_A';
		if(verificar_acceso($this->menuId, $opcion)) {
			$crud->add_action('Activar Personal', base_url().'assets/css/images/success.png', 'personal/activar','ui-icon-image',array($this, '_callback_activar'));
		}
		try {
			$salida = $crud->render();
			//Cargar MigaPan
			$breadCrumb = cargarBreadCrumb($this->menuId, $crud->getState());
			//Asignando a la vista
			$extra = array("breadCrumb" => $breadCrumb);
			$salida = array_merge( (array)$salida, $extra);
			$this->vista->SetView('personal/abm_vista', (array) $salida);
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
		$post_array['FECHA_CREACION'] = date('Y-m-d H:i:s');
		$post_array['estado'] = 'A';
		return $post_array;
	}
	
	function update_callback($post_array) {
		$post_array['USUARIO_MODIFICACION'] = $this->session->usuario;
		$post_array['FECHA_MODIFICACION'] = date('Y-m-d H:i:s');
		return $post_array;
	}
	
	function delete_callback($primary_key) {
		try{
			$query= $this->db->query("call abm_personal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', '', '', '', '', '', '', '', $this->session->usuario, '', '', ''));
		} catch (Exception $e) {
			show_error($e->getMessage());
            return false;
		}
	}
	function _callback_eliminar($primary_key) {
		return "javascript:window.location.href = '" . base_url() . "personal/inactivar/{$primary_key}'";
	}
	
	function _callback_activar($primary_key, $row) {
		return "javascript:confirmActivar('personal/activar', '$primary_key');";
	}
	
	function activar($primary_key) {
		$post_array = array('COD_PERSONAL' => $primary_key );
		try{
			$query= $this->db->query("call abm_personal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('A', $primary_key, '', '', '', '', '', '', '', '', '', '', '', '', $this->session->usuario));
		} catch (Exception $e) {
			show_error($e->getMessage());
            return false;
		}
		redirect(base_url().'personal');
	}
	
	function inactivar($codPersonal){
        $data['titulo'] = "Inactivar Personal";
        $data['cod_personal'] = $codPersonal;        
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'delete');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("personal/inactivar", $data);
	}
	
	function eliminar(){
		
		$fechaSalida = $this->input->post('fecha_salida');
		$codPersonal = $this->input->post('cod_personal');
		$usuario = $this->session->usuario;
		$proc = $this->Personal_model->guardarPersonalDatos('S', null, $codPersonal, null, null, null, $fechaSalida, null, null, null, null, null, null, null, null, null, null, null, null, null, $usuario);
		$result['resultado'] = $proc["@estado"];
		$result['error'] = $proc["@error"];

		if ($proc["@estado"] == '0') {
			$query= $this->db->query("call abm_personal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $codPersonal, '', '', '', '', '', '', '', '', '', $this->session->usuario, '', '', ''));	
		}

		//echo json_encode($result);
		redirect(base_url() . 'personal');
		
	}
	
	public function georeferenciar($codPersonal) {
		if($this->input->post()) {
			$lat = $this->input->post('latitud');
			$lon = $this->input->post('longitud');
			$usuMod = $this->session->usuario;
			$this->Personal_model->actualizarUbicacion($lat, $lon, $usuMod, $codPersonal);
//			$this->guardarAlmacen($codPersonal);
			redirect(base_url() . 'personal');
		}
		$result = $this->Personal_model->getPersonal($codPersonal);
		$config['apiKey'] = 'AIzaSyDvN3nPR1QWKcvgMVztIfqEx2WNmHoIAOo';
		$config['zoom'] = '13';
		//die();
		if($result['LATITUD'] == '' and $result['LONGITUD'] == '') {
			$data['latitud'] = $this->LATITUD_INI;
			$data['longitud'] = $this->LONGITUD_INI;
		} else {
			$data['latitud'] = $result['LATITUD'];
			$data['longitud'] = $result['LONGITUD'];
		}
		$position = $data['latitud'] . "," . $data['longitud'];
		$config['center'] = $position;
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['infowindow_content'] = $codPersonal;
		$marker['position'] = $position;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'setGeoreferencia(event.latLng.lat(), event.latLng.lng())';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		$data['COD_PERSONAL'] = $codPersonal;
		
		$breadCrumb = cargarBreadCrumb($this->menuId, 'georeferencia', $result['NOMBRE_COMPLETO']);
		$data['breadCrumb'] = $breadCrumb;
		$this->vista->SetView('personal/georeferenciar', $data);
	}
	
	public function personal_almacen() {
    	//Verificar acceso
    	$this->menuId = '10028';
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
            $proc = $this->Personal_model->GuardarEncargadoAlmacen($operacion, $this->input->post('idAlmacen'), $this->input->post('elemento'));
        }
        $id = $this->input->post('idAlmacen');
        $data['datosAlmacenTotal'] = $this->Personal_model->ComboAlmacenTotal($id);

        $data['datosAlmacenEncargadoAAsignar'] = $id != null ? $this->Personal_model->GetEncargadoAlmacenAAsignar($id) : "";
        $data['datosAlmacenEncargadoAsignados'] = $id != null ? $this->Personal_model->GetEncargadoAlmacenAsignados($id) : "";
        $error = $this->db->error();
        $data['error'] = $error;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("personal/encargado_almacen_vista", $data);
    }
}
?>