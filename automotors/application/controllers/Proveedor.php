<?php

class Proveedor extends CI_Controller {
	
	private $menuId = '10030';
	private $LATITUD_INI = '-17.78329116182854';
	private $LONGITUD_INI = '-63.182136792659776';

	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->helper('utilitario');
        $this->load->library('session');
        $this->load->library('vista');
		$this->load->library('googlemaps');
        $this->load->model('proveedor_model');
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
        
        $data['data_grilla'] = json_encode($this->proveedor_model->Listar());
        
        //Registrar
		$opcion = 'PR_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'PR_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'PR_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'PR_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = $opcion;
		} else {
			$data['acc_activar'] = "0";
		}
		//Georefencia
		$opcion = 'PR_G';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_georeferenciar'] = $opcion;
		} else {
			$data['acc_georeferenciar'] = "0";
		}		
		
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("proveedor/listar_vista", $data);
    }

    public function Insertar_form() {
        $data['titulo'] = "Nuevo Proveedor";
        $data['operacion'] = 'I';
        /*$data['cod_personal'] = $codPersonal;
		$data['id_medio_contacto'] = '-1';*/
        $data['especialidad'] = json_encode(getListaDominio('ESPECIALIDAD PROVEEDOR'));
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("proveedor/formulario_vista", $data);
    }

    public function Actualizar_form($codProveedor) {
        $data['titulo'] = "Editar Proveedor";
        $data['operacion'] = 'U';
        $data['cod_proveedor'] = $codProveedor;
		$data['especialidad'] = json_encode(getListaDominio('ESPECIALIDAD PROVEEDOR'));
        $data['datos'] = $this->proveedor_model->getIndividual($codProveedor);
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("proveedor/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codProveedor = $this->input->post('cod_proveedor');
    	$razonSocial = $this->input->post('razon_social');
        $contacto = $this->input->post('contacto');
        $especialidad = $this->input->post('especialidad');
        $descripcion = $this->input->post('descripcion');
        $observacion = $this->input->post('observacion');
        $nit = $this->input->post('nit');
        $direccion = $this->input->post('direccion');
        $latitud = '';
        $longitud = '';
        $telefonoFijo = $this->input->post('telefono_fijo');
        $telefonoCelular = $this->input->post('telefono_celular');
        $valor = $this->input->post('valor');
        $usuario = $this->session->usuario;        
        $proc = $this->proveedor_model->abm($operacion, $codProveedor, $razonSocial, $contacto, $especialidad, $descripcion, $observacion, $nit, $direccion, $latitud, $longitud, $telefonoFijo, $telefonoCelular, $usuario);

        $tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

    public function Eliminar($codProveedor) {
    	$usuario = $this->session->usuario;
    	$observacion = $this->input->post('observacion');
        $proc = $this->proveedor_model->abm('D', $codProveedor, null, null, null, null, $observacion, null, null, null, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
    public function activar($codProveedor) {
    	$usuario = $this->session->usuario;
    	$observacion = $this->input->post('observacion');
        $proc = $this->proveedor_model->abm('A', $codProveedor, null, null, null, null, $observacion, null, null, null, null, null, null, $usuario);

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
