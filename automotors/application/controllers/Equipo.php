<?php

class Equipo extends CI_Controller {
	
	private $menuId = '10033';

	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->helper('utilitario');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('equipo_model');
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
        
        $data['data_grilla'] = json_encode($this->equipo_model->Listar());
        
        //Registrar
		$opcion = 'EQ_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = $opcion;
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'EQ_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = $opcion;
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'EQ_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = $opcion;
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'EQ_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = $opcion;
		} else {
			$data['acc_activar'] = "0";
		}
		
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("equipo/listar_vista", $data);
    }

    public function Insertar_form() {
        $data['titulo'] = "Nuevo Equipo";
        $data['operacion'] = 'I';
        /*$data['cod_personal'] = $codPersonal;
		$data['id_medio_contacto'] = '-1';*/
        $data['tipo_equipo'] = json_encode(getListaDominio('TIPO EQUIPO'));
        $data['marca'] = json_encode(getListaDominio('MARCA'));
        $data['tipo'] = json_encode(getListaDominio('TIPO'));
        $data['moneda'] = json_encode(getListaDominio('MONEDA'));
        $data['proveedor'] = json_encode($this->equipo_model->getProveedor());
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("equipo/formulario_vista", $data);
    }

    public function Actualizar_form($codEquipo) {
        $data['titulo'] = "Editar Equipo";
        $data['operacion'] = 'U';
        $data['cod_equipo'] = $codEquipo;
        $data['tipo_equipo'] = json_encode(getListaDominio('TIPO EQUIPO'));
        $data['marca'] = json_encode(getListaDominio('MARCA'));
        $data['tipo'] = json_encode(getListaDominio('TIPO'));
        $data['moneda'] = json_encode(getListaDominio('MONEDA'));
        $data['proveedor'] = json_encode($this->equipo_model->getProveedor());
        $data['datos'] = $this->equipo_model->getIndividual($codEquipo);
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("equipo/formulario_vista", $data);
    }

    public function Guardar() {
    	$operacion = $this->input->post('operacion');
    	$codEquipo = $this->input->post('cod_equipo');
    	$tipoEquipo = $this->input->post('tipo_equipo');
        $marca = $this->input->post('marca');
        $descripcion = $this->input->post('descripcion');
        $observacion = $this->input->post('observacion');
        $serie = $this->input->post('serie');
        $tipo = $this->input->post('tipo');
        $proveedor = $this->input->post('proveedor');
        $moneda = $this->input->post('moneda');
        $valor = $this->input->post('valor');
        $fechaRegistro = $this->input->post('fecha_registro');
        $usuario = $this->session->usuario;
        $proc = $this->equipo_model->abm($operacion, $codEquipo, $tipoEquipo, $marca, $descripcion, $observacion, $serie, $tipo, $proveedor, $moneda, $valor, $fechaRegistro, $usuario);

        $tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

    public function Eliminar($codEquipo) {
    	$usuario = $this->session->usuario;
    	$observacion = $this->input->post('observacion');
        $proc = $this->equipo_model->abm('D', $codEquipo, null, null, null, $observacion, null, null, null, null, null, null, $usuario);
		
		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }
    
    public function activar($codEquipo) {
    	$usuario = $this->session->usuario;
    	$observacion = $this->input->post('observacion');
        $proc = $this->equipo_model->abm('A', $codEquipo, null, null, null, $observacion, null, null, null, null, null, null, $usuario);

		$tipoResp = 'success';
		if($proc["@estado"] == "1") {
			$tipoResp = 'danger';
		}
		$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
		$this->session->set_flashdata('mensaje', $mensaje);
		$this->Index();
    }

}
