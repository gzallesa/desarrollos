<?php

class MenuWebOpcion extends CI_Controller
{
	private $menuId = '10008';
	
    public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
//		$this->load->database();
		//$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->model("menuwebopcion_model");
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
	
	public function index($mensaje=null) {	
        $id=$this->input->post("idSeleccionCombo");
        $data['data_combo'] = $this->menuwebopcion_model->Combo($id);
		$data['data_grilla'] = json_encode($this->menuwebopcion_model->Lista($id));
		$data['mensaje']=$mensaje;
		//Registrar
		$opcion = 'MWO_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = "MWO_I";
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'MWO_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = "MWO_U";
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'MWO_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = "MWO_D";
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'MWO_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = "MWO_A";
		} else {
			$data['acc_activar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menuwebopcion/listar_vista",$data);
    }

   /* public function Listar($mensaje=null)
	{	
        $id=$this->input->post("idSeleccionCombo");
        $data['data_combo'] = $this->menuwebopcion_model->Combo($id);	
		$data['data_grilla'] = json_encode($this->menuwebopcion_model->Lista($id));
		$data['mensaje']=$mensaje;

		$this->vista->SetView("menuwebopcion/listar_vista",$data);
    }*/
    public function Insertar_form($menu) {
		$data['titulo'] = "Nuevo Opcion Menu Web";
		$data['operacion'] = 'I';
		$data['id'] = null;
        $data['idMenu'] = $menu;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menuwebopcion/formulario_vista",$data);
	}
	
	public function Actualizar_form($menu,$id) {
		$data['titulo']="Editar Opcion Menu Web";
		$data['operacion']='U';
		$data['id']=$id;
        $data['idMenu']=$menu;
		$data['datos']=$this->menuwebopcion_model->GetOpcionMenuWeb($menu,$id);
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menuwebopcion/formulario_vista",$data);
	}
    
    public function Guardar() {
		$id=$this->input->post('id');
		$menu=$this->input->post('menu')!=null? $this->input->post('menu'): $this->input->post('idMenu');
		$operacion=$this->input->post('operacion');
        $menu_web_opcion=$this->input->post('menu_web_opcion');
		$nombre_opcion=$this->input->post('nombre_opcion');	
        $descripcion=$this->input->post('descripcion'); 
        echo 'ID: '.$id; 	
		echo ';MENU: '.$menu; 	
		echo ';OPERACION: '.$operacion; 	
		echo ';MMO: '.$menu_web_opcion; 	
		echo ';DES: '.$descripcion; 	  	
		//$proc=$this->menuwebopcion_model->Guardar($operacion ,$menu_web_opcion,$id!=null ? $id:$menu,$nombre_opcion,$descripcion);
		$proc=$this->menuwebopcion_model->Guardar($operacion ,$menu_web_opcion,$menu,$nombre_opcion,$descripcion);
//		print_r($proc);
		
		if($operacion=="I")
		{
			$this->Insertar_form($menu);
		}
		else if($operacion=="U")
		{
			$this->Actualizar_form($menu,$id);
		}
	}
	
	public function Eliminar($id) {
		$proc=$this->menuwebopcion_model->Guardar('D',$id,null,null,null);
		$this->Index();
	}
	
	public function activar($id) {
		$proc=$this->menuwebopcion_model->Guardar('A',$id,null,null,null);
		$this->Index();
	}
	
	public function rmw_opcion(){
		//Verificar acceso
    	$this->menuId = '10010';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
        $id = $this->input->post('idRolMenuWeb');
        $operacion = $this->input->post('operacion');
        if ($operacion != null) {
        	list($id1, $menu) = explode("_", $id);
            $proc = $this->menuwebopcion_model->GuardarRolMenuWebOpcion($operacion, $id1, $this->input->post('elemento'));
        }
        $data['valueSelected'] = $id == null ? '' : $id;
        
        if($id == NULL) {
        	$id1 = 0;
        	$menu = 0;
        } else {
			list($id1, $menu) = explode("_", $id);
		}        	
		$data['datosOpcionesAAsignar'] = $id != null ? $this->menuwebopcion_model->GetMenuWebOpcionAAsignar($id1, $menu) : "";
        $data['datosOpcionesAsignados'] = $id != null ? $this->menuwebopcion_model->GetMenuWebOpcionAsignados($id1, $menu) : "";
        $error = $this->db->error();
        $data['error'] = $error;
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("menuwebopcion/rmw_opcion_vista", $data);
	}
	
	public function cargarCombo(){
		$id=$this->input->post("idSeleccionCombo");
        $data = $this->menuwebopcion_model->lista_rmw();
		echo json_encode($data);
	}
}