<?php

class ReporteGerencial extends CI_Controller {

	private $menuId = '10032';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('session');
		$this->load->library('vista');

		//si no hay sesion
		if(!($this->session->userdata('logged_in'))) {  
			redirect(base_url());
		}
		//Verificar acceso
		$res = verificar_acceso($this->menuId);
		if(!$res){
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}
	}
	
	public function index() {
		$this->vista->SetView('reporte_gerencial/gastos_ventas');
	}
}
?>