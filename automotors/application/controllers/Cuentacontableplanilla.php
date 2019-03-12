<?php

class CuentaContablePlanilla extends CI_Controller{
	
	private $menuId = '10081';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('acceso');
        $this->load->library('session');
        $this->load->library('vista');
        $this->load->model('cuentacontableplanilla_model');
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
		
        $data['anio'] = $this->cuentacontableplanilla_model->getComboDominio($ano, "ANIO");
        $data['mes'] = $this->cuentacontableplanilla_model->getComboDominio($mes, "MESES");
		$data['data_grilla'] = json_encode($this->cuentacontableplanilla_model->Listar($ano.$mes));
		//$data['mensaje']=$mensaje;
        
        //Detalle
		$opcion = 'CC_D';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_detalle'] = $opcion;
		} else {
			$data['acc_detalle'] = "0";
		}

		//EXPORTAR
		$opcion = 'CC_E';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_exportar'] = $opcion;
		} else {
			$data['acc_exportar'] = "0";
		}

		// Exportar TXT
		$opcion = 'CC_T';
		if(verificar_acceso($this->menuId, $opcion)) {
        	$data['acc_exportar_txt'] = $opcion;
		} else {
			$data['acc_exportar_txt'] = "0";
		}	
		
		$gestion = $this->input->post("gestion");
		$planilla = $this->input->post("planilla");
		$data['data_grilla_det'] = json_encode($this->cuentacontableplanilla_model->getIndividual($gestion, $planilla));
		$data['gestion'] = $gestion;
		$data['planilla'] = $planilla;
		
		//Cargar MigaPan
		$breadCrumb = cargarBreadCrumb($this->menuId);
		//Asignando a la vista
		$data['breadCrumb'] = $breadCrumb;
        $this->vista->SetView("cuentacontableplanilla/listar_vista", $data);
	}
	
	public function exportar($gestion, $planilla){

        if (($gestion == null)||($planilla == null)){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'Seleccione una fila de cabecera');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/cuentacontableplanilla');
			//$this->vista->SetView("cuentacontableplanilla/listar_vista", $data);
			return;
		}
		
		$file_name = FCPATH . "archivos/" . $planilla . '_' . $gestion .'.txt';
		//log_message('debug','archivo: ' . $file_name);
		$handle = fopen($file_name, "w");
		$result = $this->cuentacontableplanilla_model->getIndividual($gestion, $planilla);
		$data = '';
		foreach($result as $row){
			$data = $data . $row['VACIO'] . $row['EMPRESA'] . $row['FECHA'] . $row['CUENTA_CONTABLE'] . $row['CUENTA_PERSONAL'] . $row['DIARIO'] . $row['DEBITO'] . $row['CREDITO'] . $row['DESCRIPCION'] . $row['MONEDA'] . PHP_EOL;
			//log_message('debug','datos archivo ind: ' . $data);
			
		}
		fwrite($handle, $data);
	    fclose($handle);

	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($file_name));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_name));
	    ob_clean();
	    flush();
	    readfile($file_name);
	    unlink($file_name);
	}
}

?>