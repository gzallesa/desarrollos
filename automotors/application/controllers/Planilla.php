<?php
class Planilla extends CI_Controller {
	
	private $menuId = '10063';
	
	function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->library('googlemaps');
		$this->load->model("planilla_model");

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
		
		$tipo_planilla = $this->input->post("tipo_planilla");
		$mes = $this->input->post("mes");
		$anio = $this->input->post("anio");
		$periodo = $anio . $mes;
		$data['data_grilla'] = json_encode('');

        $data['tipo_planilla'] = $this->planilla_model->getComboDominio($tipo_planilla,'TIPO PLANILLA');
        $data['mes'] = $this->planilla_model->getComboDominio($mes,'MESES');
        $data['anio'] = $this->planilla_model->getComboDominio($anio,'ANIO');
        $data['periodo'] = $periodo;
        $operacion = $this->input->post('operacion');
        if ($operacion == 'G') {
	        if (($tipo_planilla !== null) && ($mes !== null)&& ($anio !== null)) {
	        	$usuario = $this->session->usuario;
	        	$result = $this->planilla_model->getPlanilla($tipo_planilla, $periodo, $usuario);
				//log_message('debug', 'resultado: ' . print_r($result, true));
	        	if (isset($result['@estado'])){
	        		//log_message('debug','entre if!');
					$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>$result['@error']);
					$this->session->set_flashdata('mensaje', $mensaje);
					redirect(base_url() . '/planilla');
					return;
				}
				
				$SUELDO_BASICO = 0;
				$TOTAL_SUELDO_BASICO = 0;
				$BONO_ANTIGUEDAD = 0;
				$BONOS = 0;
				$TOTAL_GANADO = 0;
				$DESCUENTOS_PRESTAMO = 0;
				$DESCUENTOS_ANTERIORRES = 0;
				$DESCUENTOS_AFP = 0;
				$FONDO_SOLIDIARIO = 0;
				$RCIVA = 0;
				$TOTAL_DESCUENTOS = 0;
				$LIQUIDO_PAGABLE = 0;
				
				foreach($result as $row){
					$SUELDO_BASICO += $row["SUELDO_BASICO"];
					$TOTAL_SUELDO_BASICO += $row["TOTAL_SUELDO_BASICO"];
					$BONO_ANTIGUEDAD += $row["BONO_ANTIGUEDAD"];
					$BONOS += $row["BONOS"];
					$TOTAL_GANADO += $row["TOTAL_GANADO"];
					$DESCUENTOS_PRESTAMO += $row["DESCUENTOS_PRESTAMO"];
					$DESCUENTOS_ANTERIORRES += $row["DESCUENTOS_ANTERIORRES"];
					$DESCUENTOS_AFP += $row["DESCUENTOS_AFP"];
					$FONDO_SOLIDIARIO += $row["FONDO_SOLIDIARIO"];
					$RCIVA += $row["RCIVA"];
					$TOTAL_DESCUENTOS += $row["TOTAL_DESCUENTOS"];
					$LIQUIDO_PAGABLE += $row["LIQUIDO_PAGABLE"];
				}
				
				/*$footer = array();
				$footer[] = array("DIAS_TRABAJADOS"=>"TOTAL",
								  "SUELDO_BASICO"=>$SUELDO_BASICO, 
								  "TOTAL_SUELDO_BASICO"=>$TOTAL_SUELDO_BASICO,
								  "BONO_ANTIGUEDAD"=>$BONO_ANTIGUEDAD,
								  "BONOS"=>$BONOS,
								  "TOTAL_GANADO"=>$TOTAL_GANADO,
								  "DESCUENTOS_PRESTAMO"=>$DESCUENTOS_PRESTAMO,
								  "DESCUENTOS_ANTERIORRES"=>$DESCUENTOS_ANTERIORRES,
								  "DESCUENTOS_AFP"=>$DESCUENTOS_AFP,
								  "FONDO_SOLIDIARIO"=>$FONDO_SOLIDIARIO,
								  "RCIVA"=>$RCIVA,
								  "TOTAL_DESCUENTOS"=>$TOTAL_DESCUENTOS,
								  "LIQUIDO_PAGABLE"=>$LIQUIDO_PAGABLE);*/
				$footer = array("GESTION"=>"",
				                "TIPO_PLANILLA"=>"",
				                "DIVISION_NEGOCIO"=>"",
				                "CENTRO_GESTION"=>"",
								"MATRICULA"=>"", 
								"NUMERO_DOCUMENTO"=>"", 
								"COD_PERSONAL"=>"", 
								"NOMBRE_APELLIDO"=>"",  
								"CARGO"=>"", 
								"FECHA_INGRESO"=>"", 
								"FECHA_SALIDA"=>"", 
								"DIAS_TRABAJADOS"=>"", 
								"SUELDO_BASICO"=>"", 
								"DIAS_TRABAJADOS"=>"TOTAL",
								"SUELDO_BASICO"=>$SUELDO_BASICO, 
								"TOTAL_SUELDO_BASICO"=>$TOTAL_SUELDO_BASICO,
								"BONO_ANTIGUEDAD"=>$BONO_ANTIGUEDAD,
								"BONOS"=>$BONOS,
								"TOTAL_GANADO"=>$TOTAL_GANADO,
								"DESCUENTOS_PRESTAMO"=>$DESCUENTOS_PRESTAMO,
								"DESCUENTOS_ANTERIORRES"=>$DESCUENTOS_ANTERIORRES,
								"DESCUENTOS_AFP"=>$DESCUENTOS_AFP,
								"FONDO_SOLIDIARIO"=>$FONDO_SOLIDIARIO,
								"RCIVA"=>$RCIVA,
								"TOTAL_DESCUENTOS"=>$TOTAL_DESCUENTOS,
								"LIQUIDO_PAGABLE"=>$LIQUIDO_PAGABLE);
				$result[] = $footer;
				//$data['data_grilla'] = json_encode(array("rows"=>$result, "footer"=>$footer)); 
				$data['data_grilla'] = json_encode($result); 
				//$data['data_grilla'] = json_encode($result);
			}
		}
		if ($operacion == 'A') {
			if (($tipo_planilla !== null) && ($mes !== null)&& ($anio !== null)) {
				$usuario = $this->session->usuario;
				$proc = $this->planilla_model->generaCuentaContable($tipo_planilla, $periodo, $usuario);
		        $tipoResp = 'success';
				if($proc["@estado"] == "1") {
					$tipoResp = 'danger';
				}
				$mensaje = array('tipo'=>$tipoResp,'titulo'=>'Resultado','mensaje'=>$proc["@error"]);
				$this->session->set_flashdata('mensaje', $mensaje);
			}
		}

        //Generar
		$opcion = 'PM_G';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_generar'] = $opcion;
		} else {
			$data['acc_generar'] = "0";
		}
        //Exportar
		$opcion = 'PM_E';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_exportar'] = $opcion;
		} else {
			$data['acc_exportar'] = "0";
		}
		//Asiento
		$opcion = 'PM_A';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_asiento'] = $opcion;
		} else {
			$data['acc_asiento'] = "0";
		}

		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("planilla/listar_vista", $data);
    }
	
}
?>