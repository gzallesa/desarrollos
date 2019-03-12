<?php
class PlanillaCMO extends CI_Controller {
	
	private $menuId = '10065';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->library('googlemaps');
		$this->load->model("planillacmo_model");

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
		$periodo = $anio . $mes;
		$data['data_grilla'] = json_encode('');

        $data['mes'] = $this->planillacmo_model->getComboDominio($mes,'MESES');
        $data['anio'] = $this->planillacmo_model->getComboDominio($anio,'ANIO');
        $data['periodo'] = $periodo;
        $operacion = $this->input->post('operacion');
        if ($operacion == 'G') {
	        if (($mes !== null)&& ($anio !== null)) {
	        	$usuario = $this->session->usuario;
	        	$result = $this->planillacmo_model->getPlanilla($periodo, $usuario);
				//log_message('debug', 'resultado: ' . print_r($result, true));
	        	if (isset($result['@estado'])){
	        		//log_message('debug','entre if!');
					$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>$result['@error']);
					$this->session->set_flashdata('mensaje', $mensaje);
					redirect(base_url() . '/planillacmo');
					return;
				}
				
				$PLANILLA_CAJA_AFP = 0;
                $PLANILLA_SOLO_AFP = 0;
                $PLANILLA_SIN_DESCUENTOS = 0;
                $TOTAL_GANADO = 0;
                $OTROS_BONOS_LABORALES = 0;
                $APORTE_AFP_PATRONAL = 0;
                $APORTE_CAJA = 0;
                /*$PREVISION_INDEMINIZACION = 0;
                $PREVISION_AGUINALDO_1 = 0;
                $PREVISION_AGUINALDO_2 = 0;
                $CMO_UN_AGUINALDO = 0;
                $CMO_DOS_AGUINALDOS = 0;*/
                $MONTO_VARIABLE = 0;
				$MONTO_COMISION = 0;
				$PREVISION_INDEMINIZACION_VARIABLE_COMISION = 0;
				$PREVISION_AGUINALDO_VARIABLE_COMISION_1 = 0;
				$PREVISION_AGUINALDO_VARIABLE_COMISION_2 = 0;
				$CMO_VARIABLE_COMISION_UN_AGUINALDO = 0;
				$CMO_VARIABLE_COMISION_DOS_AGUINALDOS = 0;

				foreach($result as $row){

					$PLANILLA_CAJA_AFP += $row["PLANILLA_CAJA_AFP"];
					$PLANILLA_SOLO_AFP += $row["PLANILLA_SOLO_AFP"];
					$PLANILLA_SIN_DESCUENTOS += $row["PLANILLA_SIN_DESCUENTOS"];
					$TOTAL_GANADO += $row["TOTAL_GANADO"];
					$OTROS_BONOS_LABORALES += $row["OTROS_BONOS_LABORALES"];
					$APORTE_AFP_PATRONAL += $row["APORTE_AFP_PATRONAL"];
					$APORTE_CAJA += $row["APORTE_CAJA"];
					/*$PREVISION_INDEMINIZACION += $row["PREVISION_INDEMINIZACION"];
					$PREVISION_AGUINALDO_1 += $row["PREVISION_AGUINALDO_1"];
					$PREVISION_AGUINALDO_2 += $row["PREVISION_AGUINALDO_2"];
					$CMO_UN_AGUINALDO += $row["CMO_UN_AGUINALDO"];
					$CMO_DOS_AGUINALDOS += $row["CMO_DOS_AGUINALDOS"];*/
					$MONTO_VARIABLE += $row["MONTO_VARIABLE"];
					$MONTO_COMISION += $row["MONTO_COMISION"];
					$PREVISION_INDEMINIZACION_VARIABLE_COMISION += $row["PREVISION_INDEMINIZACION_VARIABLE_COMISION"];
					$PREVISION_AGUINALDO_VARIABLE_COMISION_1 += $row["PREVISION_AGUINALDO_VARIABLE_COMISION_1"];
					$PREVISION_AGUINALDO_VARIABLE_COMISION_2 += $row["PREVISION_AGUINALDO_VARIABLE_COMISION_2"];
					$CMO_VARIABLE_COMISION_UN_AGUINALDO += $row["CMO_VARIABLE_COMISION_UN_AGUINALDO"];
					$CMO_VARIABLE_COMISION_DOS_AGUINALDOS += $row["CMO_VARIABLE_COMISION_DOS_AGUINALDOS"];
				}

				$footer = array("GESTION"=>"",
				                "DIVISION_NEGOCIO"=>"",
				                "CENTRO_GESTION"=>"",
				                "COD_PERSONAL"=>"",
				                "NOMBRE_APELLIDO"=>"",
				                "CARGO"=>"TOTAL",
								"PLANILLA_CAJA_AFP"=>$PLANILLA_CAJA_AFP,
								"PLANILLA_SOLO_AFP"=>$PLANILLA_SOLO_AFP,
								"PLANILLA_SIN_DESCUENTOS"=>$PLANILLA_SIN_DESCUENTOS,
								"TOTAL_GANADO"=>$TOTAL_GANADO,
								"OTROS_BONOS_LABORALES"=>$OTROS_BONOS_LABORALES,
								"APORTE_AFP_PATRONAL"=>$APORTE_AFP_PATRONAL,
								"APORTE_CAJA"=>$APORTE_CAJA,
								/*"PREVISION_INDEMINIZACION"=>$PREVISION_INDEMINIZACION,
								"PREVISION_AGUINALDO_1"=>$PREVISION_AGUINALDO_1,
								"PREVISION_AGUINALDO_2"=>$PREVISION_AGUINALDO_2,
								"CMO_UN_AGUINALDO"=>$CMO_UN_AGUINALDO,
								"CMO_DOS_AGUINALDOS"=>$CMO_DOS_AGUINALDOS,*/
								"MONTO_VARIABLE"=>$MONTO_VARIABLE,
								"MONTO_COMISION"=>$MONTO_COMISION,
								"PREVISION_INDEMINIZACION_VARIABLE_COMISION"=>$PREVISION_INDEMINIZACION_VARIABLE_COMISION,
								"PREVISION_AGUINALDO_VARIABLE_COMISION_1"=>$PREVISION_AGUINALDO_VARIABLE_COMISION_1,
								"PREVISION_AGUINALDO_VARIABLE_COMISION_2"=>$PREVISION_AGUINALDO_VARIABLE_COMISION_2,
								"CMO_VARIABLE_COMISION_UN_AGUINALDO"=>$CMO_VARIABLE_COMISION_UN_AGUINALDO,
								"CMO_VARIABLE_COMISION_DOS_AGUINALDOS"=>$CMO_VARIABLE_COMISION_DOS_AGUINALDOS);

				$result[] = $footer;
				//$data['data_grilla'] = json_encode(array("rows"=>$result, "footer"=>$footer)); 
				$data['data_grilla'] = json_encode($result); 
				//$data['data_grilla'] = json_encode($result);
			}
		}

        //Generar
		$opcion = 'PC_G';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_generar'] = $opcion;
		} else {
			$data['acc_generar'] = "0";
		}
        //Exportar
		$opcion = 'PC_E';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_exportar'] = $opcion;
		} else {
			$data['acc_exportar'] = "0";
		}

		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("planillacmo/listar_vista", $data);
    }
	
}
?>