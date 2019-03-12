<?php
class PlanillaDeposito extends CI_Controller {
	
	private $menuId = '10069';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->model("planilladeposito_model");

		//si no hay sesion
		if(!($this->session->userdata('logged_in')))
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

		$mes = $this->input->post("mes");
		$anio = $this->input->post("anio");
		$seccion = $this->input->post("seccion");
		$periodo = $anio . $mes;
		$data['data_grilla'] = json_encode('');

        $data['mes'] = $this->planilladeposito_model->getComboDominio($mes,'MESES');
        $data['anio'] = $this->planilladeposito_model->getComboDominio($anio,'ANIO');
        $data['periodo'] = $periodo;
        $data['seccion'] = $seccion;
        $operacion = $this->input->post('operacion');
        if ($operacion == 'G') {
	        if (($mes !== null) && ($anio !== null) && ($seccion !== null)) {
	        	$result = $this->planilladeposito_model->getPlanilla($periodo, $seccion);
				
				if ($seccion == '1'){
					
					$MONTO = 0;

					foreach($result as $row){
						$MONTO += $row["monto"];
					}

					$data['data_grilla'] = json_encode($result); 

				} else {
					$PREAL = 0;
					$PFISCAL = 0;

					foreach($result as $row){
						$PREAL += $row["PREAL"];
						$PFISCAL += $row["PFISCAL"];
					}

					$footer = array("GESTION"=>"",
					                "DIVISION_NEGOCIO"=>"",
					                "CENTRO_GESTION"=>"",
					                "COD_PERSONAL"=>"",
					                "NOMBRE_APELLIDO"=>"",
					                "CARGO"=>"",
					                "CUENTA"=>"TOTAL",
					                "PFISCAL"=>$PFISCAL,
					                "PREAL"=>$PREAL);

					$result[] = $footer;
					$data['data_grilla'] = json_encode($result); 					
				}
			}
		}

        //Generar
		$opcion = 'PD_G';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_generar'] = $opcion;
		} else {
			$data['acc_generar'] = "0";
		}
        //Exportar
		$opcion = 'PD_E';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_exportar'] = $opcion;
		} else {
			$data['acc_exportar'] = "0";
		}

		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("planilladeposito/listar_vista", $data);
    }
	
}
?>