<?php

class MenuMobOpcion extends CI_Controller
{
	private $menuId = '10009';
	
    public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
//		$this->load->database();
		//$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->model("menumobopcion_model");
		$this->load->library('vista');

		//si no hay sesion
		if(!($this->session->userdata('logged_in'))){  
			redirect(base_url()); 
		}
		if(!$this->session->has_userdata('usuario')){
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
        $data['data_combo'] = $this->menumobopcion_model->Combo($id);	
		$data['data_grilla'] = json_encode($this->menumobopcion_model->Lista($id));
		$data['mensaje']=$mensaje;
		
		//Registrar
		$opcion = 'MMO_I';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_registrar'] = "MMO_I";
		} else {
			$data['acc_registrar'] = "0";
		}
		//Editar
		$opcion = 'MMO_U';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_editar'] = "MMO_U";
		} else {
			$data['acc_editar'] = "0";
		}
		//Eliminar
		$opcion = 'MMO_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_eliminar'] = "MMO_D";
		} else {
			$data['acc_eliminar'] = "0";
		}
		//Activar
		$opcion = 'MMO_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_activar'] = "MMO_A";
		} else {
			$data['acc_activar'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menumobopcion/listar_vista",$data);
    }
    
    public function Insertar_form($menu) {
		$data['titulo'] = "Nuevo Opcion Menu Mobile";
		$data['operacion'] = 'I';
		$data['id'] = null;
        $data['idMenu'] = $menu;
        //Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'add');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menumobopcion/formulario_vista",$data);
	}
	
	public function Actualizar_form($menu,$id) {
		$data['titulo']="Editar Opcion Menu Mobile";
		$data['operacion']='U';
		$data['id']=$id;
        $data['idMenu']=$menu;
		$data['datos']=$this->menumobopcion_model->GetOpcionMenuMobile($menu,$id);
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId, 'edit');
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
		$this->vista->SetView("menumobopcion/formulario_vista",$data);
	}
	
	public function Guardar() {
		$id=$this->input->post('id');
		$menu=$this->input->post('menu')!=null? $this->input->post('menu'): $this->input->post('idMenu');
		$operacion=$this->input->post('operacion');
		$menu_mob_opcion=$this->input->post('menu_mob_opcion');
		$nombre_opcion=$this->input->post('nombre_opcion');	
		$descripcion=$this->input->post('descripcion');  
		print_r($this->input->post);
		echo 'ID: '.$id; 	
		echo ';MENU: '.$menu; 	
		echo ';OPERACION: '.$operacion; 	
		echo ';MMO: '.$menu_mob_opcion; 	
		echo ';DES: '.$descripcion; 	
		$proc=$this->menumobopcion_model->Guardar($operacion ,$menu_mob_opcion,$menu,$nombre_opcion,$descripcion);
		if($operacion == "I"){
			$this->Insertar_form($menu);
		}
		else if($operacion == "U"){
			$this->Actualizar_form($menu,$id);
		}
	}
	
	public function Eliminar($id) {
		$proc=$this->menumobopcion_model->Guardar('D',$id,null,null,null);
		$this->Listar();
	}
	
	public function rmm_opcion(){
		//Verificar acceso
    	$this->menuId = '10011';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
        $id = $this->input->post('idRolMenuMob');
        $operacion = $this->input->post('operacion');
        if ($operacion != null) {
        	list($id1, $menu) = explode("_", $id);
            $proc = $this->menumobopcion_model->GuardarRolMenuMobOpcion($operacion, $id1, $this->input->post('elemento'));
        }
        $data['valueSelected'] = $id == null ? '' : $id;
        
        if($id == NULL) {
        	$id1 = 0;
        	$menu = 0;
        } else {
			list($id1, $menu) = explode("_", $id);
		}
		echo $id;
		$data['datosOpcionesAAsignar'] = $id != null ? $this->menumobopcion_model->GetMenuMobOpcionAAsignar($id1, $menu) : "";
        $data['datosOpcionesAsignados'] = $id != null ? $this->menumobopcion_model->GetMenuMobOpcionAsignados($id1, $menu) : "";
        $error = $this->db->error();
        $data['error'] = $error;
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
		//Asignando vista
        $this->vista->SetView("menumobopcion/rmm_opcion_vista", $data);
	}
	
	public function cargarCombo(){
		$id=$this->input->post("idSeleccionCombo");
        $data = $this->menumobopcion_model->lista_rmm();
		echo json_encode($data);
	}
}