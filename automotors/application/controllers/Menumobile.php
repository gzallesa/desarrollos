<?php

class MenuMobile extends CI_Controller
{
	private $menuId = '10005';
	
    public function __construct()
	{
		parent::__construct();
		$this->load->helper('acceso');
//		$this->load->database();
		//$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->model("menumobile_model");
		$this->load->library('vista');

		//si no hay sesion
		if(!($this->session->userdata('logged_in')))
		{  
			redirect(base_url()); 
		}
		if(!$this->session->has_userdata('usuario'))
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

    public function Index($mensaje=null)
	{		
		$data['json'] = json_encode($this->menumobile_model->Lista());
		$data['mensaje']=$mensaje;

		//Registrar
		$opcion = 'MM_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = "MM_I";
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'MM_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = "MM_U";
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'MM_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = "MM_D";
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'MM_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = "MM_A";
		} else {
			$data['acc_activar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menumobile/listar_vista",$data);
    }
    
    private function _generarAbm($salida = null) {
		$this->vista->SetView("menumobile/listar_vista",(array)$salida);
	}
	
	public function agregar_menu_mobile($mensaje=null) {	
		$data["operacion"]="i";
		$data["titulo"]="Nuevo menu";
		$data["mensaje"]=$mensaje;
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->_operacion_menu($data);	
	}
	
	public function editar_menu_mobile($id,$mensaje=null) {
		$data['menu'] = $this->menumobile_model->Get_menu($id);
		$data["operacion"] = "u";
		$data["titulo"] = "Editar menu";
		$data["mensaje"] = $mensaje;
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->_operacion_menu($data);
	}
	
	private function _operacion_menu($data) {
		$data["json"]=json_encode($this->menumobile_model->Lista_padre());
		$this->load->helper('form');
		$this->vista->SetView("menumobile/formulario_vista",$data);
	}
	
	public function guardar_menu_mobile($id=null) {
		$datos=array();
		$datos=array(
			$this->input->post('operacion'),
			array_key_exists('MENU',$_POST) ? $this->input->post('MENU'):"",
			array_key_exists('MENU_PADRE',$_POST) ? ($this->input->post('MENU_PADRE')==""?null:$this->input->post('MENU_PADRE')):null,
			array_key_exists('NOMBRE_MENU',$_POST) ? $this->input->post('NOMBRE_MENU'):"",
			array_key_exists('DESCRIPCION',$_POST) ? $this->input->post('DESCRIPCION'):"",
			$this->session->usuario
		);
		$resultado = $this->menumobile_model->Abm($datos);
		
		if($this->input->post('operacion')=="i")
		{
			$this->agregar_menu_mobile($resultado);
		}
		else if($this->input->post('operacion')=="u"){
			$this->editar_menu_mobile($this->input->post('MENU'),$resultado);
		}
	}
	
	public function eliminar_menu_mobile($id=null) {
		if(isset($id)){
		$datos=array(
			"d",
			$id,
			"",
			"",
			"",
			$this->session->usuario
		);
		$resultado = $this->menumobile_model->Abm($datos);
		$this->Index($resultado);
		}else
		{
			$this->Index();
		}
	}
	
	public function activar_menu_mobile($id=null) {
		if(isset($id)){
			$datos=array(
				"a",
				$id,
				"",
				"",
				"",
				$this->session->usuario
			);
			$resultado = $this->menumobile_model->Abm($datos);
			//$this->Index($resultado);
			redirect(base_url().'menumobile');
		}else
		{
			//$this->Index();
			redirect(base_url().'menumobile');
		}
	}
}