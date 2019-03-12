<?php

class Almacenes extends CI_Controller {
	
	private $menuId = '10024';
	private $LATITUD_INI = '-17.78329116182854';
	private $LONGITUD_INI = '-63.182136792659776';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->library('googlemaps');
		$this->load->model("Almacen_model");

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
		$crud->set_table('mte_almacen');
		$crud->where('fecha_eliminacion IS NULL');
		$crud->set_subject('Sucursal');
		$crud->columns('COD_SUCURSAL', 'NOMBRE_SUCURSAL', 'DIRECCION', 'DESCRIPCION');
		$crud->fields('COD_SUCURSAL', 'NOMBRE_SUCURSAL', 'DIRECCION', 'DESCRIPCION', 'USUARIO_CREACION', 'USUARIO_MODIFICACION', 'FECHA_CREACION', 'FECHA_MODIFICACION');
		$crud->change_field_type('USUARIO_CREACION','invisible');
		$crud->change_field_type('USUARIO_MODIFICACION','invisible');
		$crud->change_field_type('FECHA_CREACION','invisible');
		$crud->change_field_type('FECHA_MODIFICACION','invisible');
		//Campos requeridos
		$crud->required_fields('COD_SUCURSAL','NOMBRE_SUCURSAL', 'DIRECCION');
		
		//Obtener Usuarios de acciones
		$crud->callback_before_insert(array($this,'insert_callback'));
		$crud->callback_before_update(array($this,'update_callback'));
		$crud->callback_delete(array($this,'delete_callback'));
		
		//----Opciones de acceso
		//Registrar (Si NO existe se quita)
		$opcion = 'A_I';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_add();
		}
		//Ver (Si NO existe se quita)
		$opcion = 'A_R';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_read();
		}
		//Modificar (Si NO existe se quita)
		$opcion = 'A_U';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_edit();
		}
		//Eliminar (Si NO existe se quita)
		$opcion = 'A_D';
		if(!verificar_acceso($this->menuId, $opcion)) {
			$crud->unset_delete();
		}
		//Georeferenciar (Si existe se crea)
		$opcion = 'A_G';
		if(verificar_acceso($this->menuId, $opcion)) {
			//Acciones personalizadas
			$crud->add_action('Georefenciar', base_url().'assets/themes/icons/led/map.png', 'almacenes/georeferenciar');
		}
		try {
			$salida = $crud->render();
			$breadCrumb = cargarBreadCrumb($this->menuId, $crud->getState());
			$extra = array("breadCrumb" => $breadCrumb);
			$salida = array_merge( (array)$salida, $extra);
			$this->vista->SetView('almacenes/abm_vista', (array) $salida);
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
		return $post_array;
	}
	
	function update_callback($post_array) {
		$post_array['USUARIO_MODIFICACION'] = $this->session->usuario;
		$post_array['FECHA_MODIFICACION'] = date('Y-m-d H:i:s');
		return $post_array;
	}
	
	function delete_callback($primary_key) {
		try{
			$query= $this->db->query("call abm_mte_almacen(?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', '', '', '', $this->session->usuario));
			log_message('debug', 'Query baja ' . $this->db->last_query());
		} catch (Exception $e) {
			show_error($e->getMessage());
            return false;
		}
	}
	
	public function georeferenciar($codAlmacen) {
		if($this->input->post()) {
			$lat = $this->input->post('latitud');
			$lon = $this->input->post('longitud');
			$usuMod = $this->session->usuario;
			$this->Almacen_model->actualizarUbicacion($lat, $lon, $usuMod, $codAlmacen);
			//$this->guardarAlmacen($codAlmacen);
			redirect(base_url() . 'almacenes');
		}
		$result = $this->Almacen_model->getAlmacen($codAlmacen);
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
		$marker['infowindow_content'] = $codAlmacen;
		$marker['position'] = $position;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'setGeoreferencia(event.latLng.lat(), event.latLng.lng())';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		$data['COD_SUCURSAL'] = $codAlmacen;

		$breadCrumb = cargarBreadCrumb($this->menuId, 'georeferencia', $result['COD_SUCURSAL']);
		$data['breadCrumb'] = $breadCrumb;
		$this->vista->SetView('almacenes/georeferenciar', $data);
	}
	
	public function guardarAlmacen($codAlmacen=null) {
		$datos = array();
		$datos = array(
			'U',
			$codAlmacen,
			null,
			null,
			null,
			$this->input->post('latitud'),
			$this->input->post('longitud'),
			$this->session->usuario
		);
		$resultado = $this->Almacen_model->Abm($datos);
	}
	
	public function almacen_camion() {
    	//Verificar acceso
    	$this->menuId = '10026';
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
            $proc = $this->Almacen_model->GuardarAlmacenCamion($operacion, $this->input->post('idAlmacen'), $this->input->post('elemento'));
        }
        $id = $this->input->post('idAlmacen');
        $data['datosAlmacenesTotal'] = $this->Almacen_model->ComboAlmacenesTotal($id);

        $data['datosAlmacenCamionAAsignar'] = $id != null ? $this->Almacen_model->GetAlmacenCamionAAsignar($id) : "";
        $data['datosAlmacenCamionAsignados'] = $id != null ? $this->Almacen_model->GetAlmacenCamionAsignados($id) : "";
        $error = $this->db->error();
        $data['error'] = $error;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("almacenes/almacen_camion_vista", $data);
    }
	
	public function test() {
		$config['apiKey'] = 'AIzaSyDvN3nPR1QWKcvgMVztIfqEx2WNmHoIAOo';
//		$config['center'] = '37.4419, -122.1419';
// 		$config['zoom'] = 'auto';
//		$this->googlemaps->initialize($config);
//		
//		$marker = array();
// 		$marker['position'] = '37.429, -122.1419';
// 		$this->googlemaps->add_marker($marker);
//		$data['map'] = $this->googlemaps->create_map();

//		$config['center'] = 'Adelaide, Australia';
//		$config['zoom'] = '13';
//		$config['drawing'] = true;
//		$config['drawingDefaultMode'] = 'circle';
//		$config['drawingModes'] = array('circle','rectangle','polygon');
//		$this->googlemaps->initialize($config);
//		$data['map'] = $this->googlemaps->create_map();

//		$config['center'] = '37.4419, -122.1419';
//		$config['zoom'] = 'auto';
//		$config['onclick'] = 'createMarker_map({ map: map, position:event.latLng });';
//		$this->googlemaps->initialize($config);
//		$data['map'] = $this->googlemaps->create_map();

		$config['zoom'] = '13';
		$config['center'] = '-17.783, -63.182';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['infowindow_content'] = 'LMTF2017';
		$marker['position'] = '-17.783, -63.182';
		$marker['draggable'] = true;
		$marker['ondragend'] = 'alert(\'You just dropped me at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		
		$this->vista->SetView('almacenes/test', $data);
	}
}
?>