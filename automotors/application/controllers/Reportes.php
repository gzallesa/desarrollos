<?php

class Reportes extends CI_Controller {
	
	private $menuId = '10042';
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('acceso');
		$this->load->helper('utilitario');
		$this->load->library('session');
		$this->load->library('vista');
		$this->load->library('Pdf');
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
	
	public function comprobanteAsignacion($codPersonal){
		$this->load->model('personalequipo_model');
		$this->load->model('personal_model');
		$cabecera = $this->personalequipo_model->getCabeceraReporteAsignacion($codPersonal);
		$detalle = $this->personalequipo_model->getDetalleReporteAsignacion($codPersonal);
		$filasDetalle = '';
		$datosPersonal = $this->personal_model->getIndividual($codPersonal);
		$entregue = getListaDominio('ENTREGUE');
		$entregue = $entregue[0]['descripcion'];
/*		log_message('debug','Cabecera: ' . print_r($cabecera, true));
		log_message('debug','Detalle: ' . print_r($detalle, true));
		log_message('debug','DatosPersonal: ' . print_r($datosPersonal, true));
		log_message('debug','Entregue: ' . print_r($entregue, true));*/
		$filasDetalle = '';
		foreach ($detalle as $row){
			//log_message('debug','Detalle: ' . print_r($row, true));
			$filasDetalle = $filasDetalle .'<tr style="height: 18px;">
					            <td style="height: 18px;">' . $row['CODIGO'] . '</td>
					            <td style="height: 18px;">' . $row['ARTICULO'] . '</td>
					            <td style="height: 18px;">' . $row['CANTIDAD'] . '</td>
					            <td style="height: 18px;">' . $row['OBSERVACION'] . '</td>
					         </tr>';
		}
		
		$content = '<body>
						   <table cellpadding="3">
						      <tbody>
						         <tr>
						         	<td rowspan="4">
						      	 		<img src="' . base_url() . 'assets/img/logo_avis.png" />
						      	 	</td>
						         	<td bgcolor="#fff"style="border:none; border-right:solid; border-right-width:1px" width="50%"></td>
						            <td style="width: 62px;" border="1"><strong>FORM</strong></td>
						            <td style="width: 133px; text-align: center;" border="1">' . $cabecera[0]["FORM"] . '</td>
						         </tr>
						         <tr>
						         	<td bgcolor="#fff" style="border:none; border-right:solid; border-right-width:1px" width="50%"></td>
						            <td style="width: 62px;" border="1"><strong>Nro</strong></td>
						            <td style="width: 133px; text-align: center;" border="1">' . $cabecera[0]["NRO"] . '</td>
						         </tr>
						         <tr>
						         	<td bgcolor="#fff" style="border:none; border-right:solid; border-right-width:1px" width="50%"></td>
						            <td colspan="2" style="text-align: center;" border="1"><strong>FECHA RECEPCION</strong></td>
						         </tr>
						         <tr>
						         	<td bgcolor="#fff"style="border:none; border-right:solid; border-right-width:1px" width="50%"></td>
						            <td colspan="2" style="text-align: center;" border="1">' . $cabecera[0]["FECHARECEPCION"] . '</td>
						         </tr>
						      </tbody>
						   </table>
					   
					   <p></p>
					   <h2 style="text-align: center;"><strong>NOTA DE ENTREGA</strong></h2>
					   <table style="width: 60%;">
					      <tbody>
					         <tr>
					            <td style="width: 30%; "><strong>AREA:</strong></td>
					            <td style="width: 70%; ">' . $cabecera[0]['AREA'] . '</td>
					         </tr>
					         <tr>
					            <td style="width: 30%; ;"><strong>CARGO:</strong></td>
					            <td style="width: 70%; ">' . $datosPersonal['desc_cargo'] . '</td>
					         </tr>
					         <tr>
					            <td style="width: 30%; "><strong>RESPONSABLE:</strong></td>
					            <td style="width: 70%; ">' . $cabecera[0]['RESPONSABLE'] . '</td>
					         </tr>
					      </tbody>
					   </table>

					   <p></p>
					   <table width="100%" border="1" cellpadding="5">
					      <tbody>
					         <tr style="height: 18px;">
					            <td style="height: 18px;text-align: center;" width="15%"><strong>CODIGO/ITEM</strong></td>
					            <td style="height: 18px;text-align: center;" width="40%"><strong>DESCRIPCION Y/O ARTICULO</strong></td>
					            <td style="height: 18px;text-align: center;" width="10%"><strong>CANTIDAD</strong></td>
					            <td style="height: 18px;text-align: center;" width="35%"><strong>OBSERVACION</strong></td>
					         </tr>' . 
							$filasDetalle .
					         '<tr style="height: 18px;">
					            <td style="height: 18px;" colspan="4"><strong>OBSERVACIONES: EN CASO DE PERDIDA, SE DEBE REPONER LOS EQUIPOS ENTREGADOS</strong></td>
					         </tr>
					      </tbody>
					   </table>
					   <table width="100%" border="1" cellpadding="5">
					      <tbody>
					         <tr style="height: 41px;">
					            <td style="height: 100px;" >FIRMA:</td>
					            <td style="height: 100px;" >FIRMA:</td>
					         </tr>
					         <tr style="height: 18px;">
					            <td style="height: 18px;" >Nombre:' . $datosPersonal['nombre_completo'] . '</td>
					            <td style="height: 18px;" >Nombre:' . $entregue . '</td>
					         </tr>
					         <tr style="height: 18px;">
					            <td style="height: 18px; text-align: center;" ><strong>RECIBI CONFORME</strong></td>
					            <td style="height: 18px; text-align: center;" ><strong>ENTREGUE CONFORME</strong></td>
					         </tr>
					      </tbody>
					   </table>
					</body>';
		//log_message('debug','Reporte: ' . $content);
		$nom_pdf = "Reporte_{$codPersonal}.pdf";
		$titulo = '';//Reporte Asignacion';
		$data['nom_pdf'] = $nom_pdf;
		$data['titulo'] = $titulo;
		$data['content'] = $content;
		$data['orientation'] = 'L';
		$this->load->view('pdfreport', $data);
	}
	
	public function comprobanteBoleta($codPersonal, $gestion){
		$this->load->model('boleta_model');
		//$this->load->model('personal_model');
		$datos = $this->boleta_model->getBoletaPago($codPersonal,$gestion);
		
		if ($datos == null){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'La consulta no generao datos...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/boleta');
			return;
		}
		
		$content = '<body>
					<div align="center">
						<table width="85%" cellpadding="3">
						   <tbody>
							  <tr>
							  	 <td></td>
								 <td ><img src="' . base_url() . 'assets/img/logo.png" /></td>
								 <td colspan="3"></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>BOLETA DE PAGO</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Cod.:</strong></td>
								 <td style="text-align: left">' . $datos['COD_PERSONAL'] . '</td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Gestion:</strong></td>
								 <td style="text-align: left">' . $datos['GESTION'] . '</td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Nombre:</strong></td>
								 <td style="text-align: left">' . $datos['NOMBRE_APELLIDO'] . '</td>
								 <td style="text-align: left"><strong>Division Negocio:</strong></td>
								 <td style="text-align: left">' . $datos['DIVISION_NEGOCIO'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Cargo:</strong></td>
								 <td style="text-align: left">' . $datos['CARGO'] . '</td>
								 <td style="text-align: left"><strong>Centro Gestion:</strong></td>
								 <td style="text-align: left">' . $datos['CENTRO_GESTION'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Fecha Ingreso:</strong></td>
								 <td style="text-align: left">' . $datos['FECHA_INGRESO'] . '</td>
								 <td style="text-align: left"><strong>Dias Trabajados:</strong></td>
								 <td style="text-align: left">' . $datos['DIAS_TRABAJADOS'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>INGRESOS</strong><strong></strong></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Total Ganado</strong></td>
								 <td></td>
								 <td style="text-align: right">' . number_format($datos['TOTAL_GANADO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Otros Bonos Laborales</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['OTROS_BONOS_LABORALES'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Variables</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['MONTO_VARIABLE'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Comisiones</strong></td>
								 <td></td>
								 <td style="text-align: right">' . number_format($datos['MONTO_COMISION'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Bono Antiguedad</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['BONO_ANTIGUEDAD'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Bonos</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['BONOS'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td  colspan="2"></td>
								 <td style="text-align: left" ><strong>Total Ganado</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['MONTO_GANADO'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>DESCUENTOS</strong></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Descuento AFP</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['DESCUENTO_AFP'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Prestamo</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['PRESTAMO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Anticipo</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['ANTICIPO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Fondo Solidario</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['FONDO_SOLIDIARIO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>RCIVA</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['RCIVA'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td style="text-align: left"><strong>Total Descuentos</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['DESCUENTO_TOTAL'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td style="text-align: left"><strong>Liquido Pagable</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['LIQUIDO_PAGABLE'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Aporte AFP Patronal</strong></td>
								 <td></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['APORTE_AFP_PATRONAL'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Aporte Caja</strong></td>
								 <td></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['APORTE_CAJA'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>________________________</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>Firma</strong></td>
							  </tr>
						   </tbody>
						</table>
					</div>
					</body>';
		//log_message('debug','Reporte: ' . $content);
		$nom_pdf = "Reporte_Boleta_{$codPersonal}.pdf";
		$titulo = '';//Reporte Asignacion';
		$data['nom_pdf'] = $nom_pdf;
		$data['titulo'] = $titulo;
		$data['content'] = $content;
		$data['orientation'] = 'P';
		$this->load->view('pdfreport', $data);		
	}

	public function comprobanteBoletaInd($codPersonal, $gestion, $tipoPlanilla){
		$this->load->model('boleta_ind_model');
		//$this->load->model('personal_model');
		$datos = $this->boleta_ind_model->getBoletaPagoIndividual($codPersonal,$gestion,$tipoPlanilla);
		
		if ($datos == null){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'La consulta no generao datos...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/boleta');
			return;
		}
		
		$content = '<body>
					<div align="center">
						<table width="85%" cellpadding="3">
						   <tbody>
							  <tr>
							  	 <td></td>
								 <td ><img src="' . base_url() . 'assets/img/logo.png" /></td>
								 <td colspan="3"></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>BOLETA DE PAGO</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Cod.:</strong></td>
								 <td style="text-align: left">' . $datos['COD_PERSONAL'] . '</td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Gestion:</strong></td>
								 <td style="text-align: left">' . $datos['GESTION'] . '</td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Nombre:</strong></td>
								 <td style="text-align: left">' . $datos['NOMBRE_APELLIDO'] . '</td>
								 <td style="text-align: left"><strong>Division Negocio:</strong></td>
								 <td style="text-align: left">' . $datos['DIVISION_NEGOCIO'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Cargo:</strong></td>
								 <td style="text-align: left">' . $datos['CARGO'] . '</td>
								 <td style="text-align: left"><strong>Centro Gestion:</strong></td>
								 <td style="text-align: left">' . $datos['CENTRO_GESTION'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left"><strong>Fecha Ingreso:</strong></td>
								 <td style="text-align: left">' . $datos['FECHA_INGRESO'] . '</td>
								 <td style="text-align: left"><strong>Dias Trabajados:</strong></td>
								 <td style="text-align: left">' . $datos['DIAS_TRABAJADOS'] . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>INGRESOS</strong><strong></strong></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Total Ganado</strong></td>
								 <td></td>
								 <td style="text-align: right">' . number_format($datos['TOTAL_GANADO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Otros Bonos Laborales</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['OTROS_BONOS_LABORALES'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Variables</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['MONTO_VARIABLE'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Comisiones</strong></td>
								 <td></td>
								 <td style="text-align: right">' . number_format($datos['MONTO_COMISION'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Bono Antiguedad</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['BONO_ANTIGUEDAD'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Bonos</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['BONOS'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td  colspan="2"></td>
								 <td style="text-align: left" ><strong>Total Ganado</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['MONTO_GANADO'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>DESCUENTOS</strong></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Descuento AFP</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['DESCUENTO_AFP'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Prestamo</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['PRESTAMO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Anticipo</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['ANTICIPO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>Fondo Solidario</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['FONDO_SOLIDIARIO'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: left" colspan="2"><strong>RCIVA</strong></td>
								 <td></td>
								 <td style="text-align: right;">' . number_format($datos['RCIVA'],2) . '</td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td style="text-align: left"><strong>Total Descuentos</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['DESCUENTO_TOTAL'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td style="text-align: left"><strong>Liquido Pagable</strong></td>
								 <td style="text-align: right;"><strong>' . number_format($datos['LIQUIDO_PAGABLE'],2) . '</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td colspan="2"></td>
								 <td></td>
								 <td></td>
							  </tr>
							  
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
								 <td></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>________________________</strong></td>
							  </tr>
							  <tr>
							  	 <td></td>
								 <td style="text-align: center;" colspan="4"><strong>Firma</strong></td>
							  </tr>
						   </tbody>
						</table>
					</div>
					</body>';
		log_message('debug','Reporte: ' . $content);
		$nom_pdf = "Reporte_Boleta_Ind_{$codPersonal}.pdf";
		$titulo = '';//Reporte Asignacion';
		$data['nom_pdf'] = $nom_pdf;
		$data['titulo'] = $titulo;
		$data['content'] = $content;
		$data['orientation'] = 'P';
		$this->load->view('pdfreport', $data);		
	}

	public function comprobanteCheque($nroComprobante){
		$this->load->model('comprobanteegreso_model');
		//$this->load->model('personal_model');
		$datos = $this->comprobanteegreso_model->getCheque($nroComprobante);
		
		if ($datos == null){
        	$mensaje = array('tipo'=>'danger','titulo'=>'Error','mensaje'=>'La consulta no generao datos...');
			$this->session->set_flashdata('mensaje', $mensaje);
			redirect(base_url() . '/comprobanteegreso');
			return;
		}
		
		/*$content = '<body>
						<table width="100%">
							<tbody>
								<tr>
									<td width="20%"></td>
									<td width="30%"></td>
									<td width="25%"></td>
									<td width="25%" style="align:center">' . number_format($datos['MONTO_PAGAR'], 2) . '</td>
								</tr>   
								<tr>
									<td></td>
									<td></td>
									<td colspan="2">' . $datos['FECHA_LITERAL'] . '</td>
								</tr>   
								<tr>
									<td></td>
									<td colspan="3">' . $datos['ORDEN_DE'] . '</td>
								</tr>   
								<tr>
									<td></td>
									<td colspan="3">' . $datos['LITERAL'] . '</td>
								</tr>
							</tbody>
						</table>
					</body>';*/

		$espacio1 = '';
		$espacio2 = '';
		$espacio3 = '';
		$espacio4 = '';

		$cant1 = 90;
		$cant2 = 51;
		$cant3 = 10;
		$cant4 = 8;
		
		for($i = 0; $i < $cant1 ; $i++){
			$espacio1 = $espacio1 . '&nbsp;';
		}
		for($i = 0; $i < $cant2 ; $i++){
			$espacio2 = $espacio2 . '&nbsp;';
		}
		for($i = 0; $i < $cant3 ; $i++){
			$espacio3 = $espacio3 . '&nbsp;';
		}
		for($i = 0; $i < $cant4 ; $i++){
			$espacio4 = $espacio4 . '&nbsp;';
		}	
		$content = '<body>
						' . $espacio1 . number_format($datos['MONTO_PAGAR'], 2) . 
						'<br>' . $espacio2 . $datos['FECHA_LITERAL'] . 
						'<br>' . $espacio3 . $datos['ORDEN_DE'] .  
						'<br>' . $espacio4 . $datos['LITERAL'] . 
					'</body>';
		//log_message('debug','Reporte: ' . $content);
		$nom_pdf = "Comprobante_cheque_{$nroComprobante}.pdf";
		$titulo = 'Comprobante_cheque_{$nroComprobante}';//Reporte Asignacion';
		$data['margin1'] = 5;
		$data['margin2'] = 5;
		$data['margin3'] = 5;
		$data['font'] = 'helvetica';
		$data['fontSize'] = '9';
		$data['pageFormat'] = 'A5';
		$data['nom_pdf'] = $nom_pdf;
		$data['titulo'] = $titulo;
		$data['content'] = $content;
		$data['orientation'] = 'P';
		$this->load->view('pdfreport', $data);
	}
	
}
?>