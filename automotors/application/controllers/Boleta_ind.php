<?php

class Boleta_ind extends CI_Controller {
	
	private $menuId = '10083';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('boleta_ind_model');
        $this->load->helper('utilitario');
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
		
		$ano=$this->input->post("anio");
		$mes=$this->input->post("mes");
		$codPersonal = $this->input->post("cod_personal");
		
		if ($codPersonal == 'null'){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione Personal...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/boleta_ind');
			return;
		}
		
        $data['anio'] = $this->boleta_ind_model->getComboDominio($ano, "ANIO");
        $data['mes'] = $this->boleta_ind_model->getComboDominio($mes, "MESES");
		$data['data_combo'] = $this->boleta_ind_model->Combo($codPersonal);		
		
		$data['data_grilla'] = json_encode($this->boleta_ind_model->Listar($codPersonal));
		//$data['mensaje']=$mensaje;
        
        //Generar Boleta
		$opcion = 'BI_R';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_reporte'] = $opcion;
		} else {
			$data['acc_reporte'] = "0";
		}
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("boleta_ind/listar_vista", $data);
    } 
    

}