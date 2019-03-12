<?php

class Presupuestos extends CI_Controller {
	
	private $menuId = '10062';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->model("Presupuesto_model");

		//si no hay sesion
		if(!($this->session->userdata('logged_in'))) {  
			redirect(base_url());
		}
		//Verificar acceso
		/*$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else{
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}*/
	}
	
	public function vendedor($periodo = FALSE) {
		$data = array();
		$rItem = $this->Presupuesto_model->cargarItem($periodo);
//		echo count($rItem);
//		print_r($rItem);
		if(!empty($rItem)) {
			$data['item'] = $rItem;
		}
//		die();
		if($this->input->post()) {
			/*echo '<pre>';
			print_r($this->input->post());
			echo '</pre>';die;*/
			$gestion = $this->input->post('gestion');
			$data['gestion'] = $gestion;
			$codItem = $this->input->post('cod_item');
			$data['cod_item'] = $codItem;
			//GESTION
			$resultado = $this->Presupuesto_model->getPresupuestadoTotalNivel1($this->session->usuario, $gestion, $codItem);
//			$resultado = $this->Presupuesto_model->getPresupuestadoTotalNivel1('JLAVAYEN', $gestion, $codItem);
			$data['resultado'] = $resultado;
			/*echo '<pre>';
			print_r($resultado);
			echo '</pre>';die;*/
		}
		$this->vista->SetView('presupuestos/vendedor', $data);
	}
	
	public function ajaxReq($periodo) {
		$data = array();
		$rItem = $this->Presupuesto_model->cargarItem($periodo);
		echo json_encode($rItem);
	}
}
?>