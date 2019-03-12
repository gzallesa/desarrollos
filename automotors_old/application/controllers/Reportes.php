<?php

class Reportes extends CI_Controller {
	
	private $menuId = '10042';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->model("Reporte_model");

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
	
	public function vrs() {
		//Verificar acceso
    	/*$this->menuId = '10032';
		$res = verificar_acceso($this->menuId);
		if($res){
			$this->session->set_userdata(array('menu_id' => 'Existe acceso'));
		} else {
			$this->session->set_userdata(array('menu_id' => 'No existe acceso'));
			$this->session->set_flashdata('acceso','Acceso retringido...');
			redirect(base_url());
		}*/
		$breadCrumb = cargarBreadCrumb($this->menuId);
		$data['breadCrumb'] = $breadCrumb;
//		$data['meses'] = "[{label: 'enero',value: 'Enero'},{label: 'febrero',value: 'Febrero'},{label: 'marzo',value: 'Marzo'},{label: 'abril',value: 'Abril'}]";
		$resultM = $this->Reporte_model->cargarMeses();
		$resultU = $this->Reporte_model->cargarUnidadVenta();
		$resultE = $this->Reporte_model->cargarEje();
		if($this->input->post()) {
			//MES
			$this->Reporte_model->limpiarTemporal('MES');
			$selecM = $this->input->post('meses');
			if(count($selecM) == 0 || count($resultM) == count($selecM)) {
				$this->Reporte_model->runCargarAuxiliarConsolidado('MES', '', 'ALL');
				$TM = 'ALL';
			} else {
				$TM = 'FULL';
				if($selecM && count($selecM)) {
					foreach($selecM as $mes) {
						$this->Reporte_model->runCargarAuxiliarConsolidado('MES', $mes, 'ADD');
					}
				}
			}
			//UV
			$this->Reporte_model->limpiarTemporal('UNINEG');
			$selecU = $this->input->post('uv');
			if(count($selecU) == 0 || count($resultU) == count($selecU)) {
				$this->Reporte_model->runCargarAuxiliarConsolidado('UNINEG', '', 'ALL');
				$TU = 'ALL';
			} else {
				$TU = 'FULL';
				if($selecU && count($selecU)) {
					foreach($selecU as $uv) {
						$this->Reporte_model->runCargarAuxiliarConsolidado('UNINEG', $uv, 'ADD');
					}
				}
			}
			//VENDEDOR
			$this->Reporte_model->limpiarTemporal('VENDEDOR');
			$selecE = $this->input->post('eje');
			if(count($selecE) == 0 || count($resultE) == count($selecE)) {
				$this->Reporte_model->runCargarAuxiliarConsolidado('VENDEDOR', '', 'ALL');
				$TE = 'ALL';
			} else {
				$TE = 'FULL';
				if($selecE && count($selecE)) {
					foreach($selecE as $eje) {
						$this->Reporte_model->runCargarAuxiliarConsolidado('VENDEDOR', $eje, 'ADD');
					}
				}
			}
			//Reporte Consolidado Presupuestado
			$gestion = $this->input->post('gestion');
			$CP1 = $this->Reporte_model->runConsolidadoPresupuestado1($gestion, $TM, $TU, $TE);
			$data['cp1'] = $CP1;
			/*echo '<pre>';
			print_r($CP1);
			echo '</pre>';*/
			$CP2 = $this->Reporte_model->runConsolidadoPresupuestado2($gestion, $TM, $TU, $TE);
			$data['cp2'] = $CP2;
			/*echo '<pre>';
			print_r($CP2);
			echo '</pre>';*/
			//die();
		}
		//print_r($result);
		$data['meses'] = json_encode($resultM);
		$data['uv'] = json_encode($resultU);
		$data['eje'] = json_encode($resultE);
		$this->vista->SetView('reportes/vrs', $data);
	}
	
	public function excel() {
		require(APPPATH . 'third_party\PHPExcel-1.8\Classes\PHPExcel.php');
		require(APPPATH . 'third_party\PHPExcel-1.8\Classes\PHPExcel\Writer\Excel2007.php');
		
		/*echo "GD: ", extension_loaded('gd') ? 'OK' : 'MISSING', '<br>';
		echo "XML: ", extension_loaded('xml') ? 'OK' : 'MISSING', '<br>';
		echo "zip: ", extension_loaded('zip') ? 'OK' : 'MISSING', '<br>';
		die;
		*/
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("");
		$objPHPExcel->getProperties()->setLastModifiedBy("");
		$objPHPExcel->getProperties()->setTitle("");
		$objPHPExcel->getProperties()->setSubject("");
		$objPHPExcel->getProperties()->setDescription("");
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objPHPExcel->getActiveSheet()->setCellValue('A1','ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');
		$objPHPExcel->getActiveSheet()->setCellValue('C1','Direccion');
		
		$row = 2;
		
		for($i = 0; $i < 5; $i++){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $i);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'luis'.$i);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, 'B/18 Noviembre'.$i);
		}
		
		for ($col = ord('a'); $col <= ord('h'); $col++) {
		    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		}
		
		$filename = 'ArchivoExcel'.date("Y-m-d-H-i-s").'.xlsx';
		$objPHPExcel->getActiveSheet()->setTitle("Task-Over");
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=01simple.xlsx');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		ob_end_clean();
		$writer->save('php://output');
		//exit;
		
		/*
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Hello')
		            ->setCellValue('B2', 'world!')
		            ->setCellValue('C1', 'Hello')
		            ->setCellValue('D2', 'world!');

		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'LMTF');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
//		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
//		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
		*/
	}
}
?>