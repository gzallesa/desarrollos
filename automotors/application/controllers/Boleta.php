<?php

class Boleta extends CI_Controller{
	
	private $menuId = '10082';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('boleta_model');
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
		
        $data['anio'] = $this->boleta_model->getComboDominio($ano, "ANIO");
        $data['mes'] = $this->boleta_model->getComboDominio($mes, "MESES");
		$data['data_combo'] = $this->boleta_model->Combo($codPersonal);
        
        //Reporte
		$opcion = 'BO_R';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_reporte'] = $opcion;
		} else {
			$data['acc_reporte'] = "0";
		}
				
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("boleta/listar_vista", $data);
	}

}

?>