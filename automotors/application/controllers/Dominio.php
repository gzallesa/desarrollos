<?php

class Dominio extends CI_Controller {
	
	private $menuId = '10054';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->helper('utilitario');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('dominio_model');
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
		$dominio = $this->input->post("dominio");
        $data['data_combo'] = $this->dominio_model->comboDominios($dominio);
        $data['data_grilla'] = json_encode($this->dominio_model->listaDetalleDominio($dominio));

        //Registrar Cabecera
		$opcion = 'DO_IC';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrarC'] = $opcion;
		} else {
			$data['acc_registrarC'] = "0";
		}
        //Registrar Detalle
		$opcion = 'DO_ID';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrarD'] = $opcion;
		} else {
			$data['acc_registrarD'] = "0";
		}
		//Editar
		$opcion = 'DO_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'DO_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'DO_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = $opcion;
		} else {
			$data['acc_activar'] = "0";
		}
		
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("dominio/listar_vista", $data);
    }

    /*public function insertar_form_dominio() {
        $data['titulo'] = "Nuevo Dominio";
        $data['operacion'] = 'I';

        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'addM');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("dominio/formulario_vista_dominio", $data);
    }*/

    public function insertar_form($tipo, $dominio=null) {
        $data['titulo'] = "Nuevo Dominio";
        $data['operacion'] = 'I';
        if (($tipo == 'D') && ($dominio == '')){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Dominio...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . 'dominio');
			return;
		}
        if ($tipo == 'D'){
			$data['dominio'] = urldecode($dominio); //str_replace(' ', '%20', $dominio);
		}		
        
		/*$data['codigo'] = $codigo;
		$data['descripcion'] = $descripcion;*/
        //Cargar MigaPan
        if ($dominio == null){
			$breadCrumb = cargarBreadCrumb($this->menuId, 'addC');
		} else {
			$breadCrumb = cargarBreadCrumb($this->menuId, 'addD');
		}

		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("dominio/formulario_vista", $data);
    }

    public function Actualizar_form($dominio, $codigo) {
        $data['titulo'] = "Editar Dominio";
        $data['operacion'] = 'U';
        /*$dominio = $this->input->post('dominio');
        $codigo = $this->input->post('codigo');*/
        $data['dominio'] = urldecode($dominio); //str_replace(' ', '%20', $dominio);
        $data['datos'] = $this->dominio_model->getIndividual(urldecode($dominio), urldecode($codigo));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("dominio/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$dominio = $this->input->post('dominio');
    	log_message('debug','Dominio: ' . $dominio);
    	$codigo = $this->input->post('codigo');
    	$descripcion = $this->input->post('descripcion');
    	
    	if ($codigo == null) {
			$codigo = '';
		}

    	if ($descripcion == null) {
			$descripcion = '';
		}
    	
        $usuario = $this->session->usuario;        
        $proc = $this->dominio_model->abm($operacion, $dominio, $codigo, $descripcion, $usuario);

        $tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

    public function Eliminar() {

    	$operacion = 'D';
    	$dominio = $this->input->post('dominio');
    	$codigo = $this->input->post('codigo');
    	$usuario = $this->session->usuario;
        $proc = $this->dominio_model->abm($operacion, $dominio, $codigo, null, $usuario);
		$data['dominio'] = $dominio;
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
    public function Activar() {

    	$operacion = 'A';
    	$dominio = $this->input->post('dominio');
    	$codigo = $this->input->post('codigo');
    	$usuario = $this->session->usuario;
        $proc = $this->dominio_model->abm($operacion, $dominio, $codigo, null, $usuario);
		$data['dominio'] = $dominio;
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

	public function georeferenciar($codProveedor) {
		if($this->input->post()) {
			$lat = $this->input->post('latitud');
			$lon = $this->input->post('longitud');
			$usuMod = $this->session->usuario;
			$proc = $this->proveedor_model->abm('A', $codProveedor, null, null, null, null, null, null, null, $lat, $lon, null, null, $usuMod);
//			$this->guardarAlmacen($codPersonal);
			redirect(base_url() . 'proveedor');
		}
		$result = $this->proveedor_model->getIndividual($codProveedor);
		$config['apiKey'] = 'AIzaSyDvN3nPR1QWKcvgMVztIfqEx2WNmHoIAOo';
		$config['zoom'] = '13';
		//die();
		if($result['LATITUD'] == '' and $result['LOGITUD'] == '') {
			$data['latitud'] = $this->LATITUD_INI;
			$data['longitud'] = $this->LONGITUD_INI;
		} else {
			$data['latitud'] = $result['LATITUD'];
			$data['longitud'] = $result['LOGITUD'];
		}
		log_message('debug',' Latitud ' . $data['latitud'] . ' Longitud ' . $data['longitud']);
		
		$position = $data['latitud'] . "," . $data['longitud'];
		$config['center'] = $position;
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['infowindow_content'] = $codProveedor;
		$marker['position'] = $position;
		$marker['draggable'] = true;
		$marker['ondragend'] = 'setGeoreferencia(event.latLng.lat(), event.latLng.lng())';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		$data['COD_PROVEEDOR'] = $codProveedor;
		
		$breadCrumb = cargarBreadCrumb($this->menuId, 'georeferencia', $result['RAZON_SOCIAL']);
		$data['breadCrumb'] = $breadCrumb;
		$this->vista->SetView('proveedor/georeferenciar', $data);
	}

}
