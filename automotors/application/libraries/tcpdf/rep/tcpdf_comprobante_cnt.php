<?php session_start();
include("../../../assets/libs/libs3.php");
include("../../../assets/libs/tcpdf/tcpdf.php");


//clase para crear header y footer personalizado
class PDF extends TCPDF{  
  
	 public function Header() {	
		$mesliteral ='ENERO';/// SelectSQL("select to_char(to_date(to_char('{$GLOBALS['mesplan']}'),'mm'),'Month','NLS_DATE_LANGUAGE = SPANISH') AS MESLIT from dual");

		$this->Image('../../../img/'.$GLOBALS['logo_safi'].'',15 ,10,50,12,'png','','M'); 
		//$this->Image('../../../img/'.$_REQUEST['idfondo'].'.png',3,5,39,22,'PNG','localhost','T'); 

		$datos_safi=devolver_datos_tabla("SIS_SAFI",array("NIT_SAFI","RAZONSOCIAL_SAFI","DIRECCION_SAFI","TELEFONO_SAFI","FAX_SAFI","OFCENTRAL_SAFI","LOGO_SAFI"),"WHERE ID_ESTADO=1");
		
		$this->SetXY(18,24);
		$this->SetAligns(array('C'));
		$this->SetWidths(array( 60));
		//$this->SetFont('helvetica','',10);
		$this->SetXY(15,$this->GetY());
		//$this->Row('helvetica',9, array( $datos_safi[0]["RAZONSOCIAL_SAFI"]),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));  nombre_safi
		//$this->Row('helvetica',9, array( $GLOBALS["nombre_safi"]),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));  
			
		if($GLOBALS['BORRACONFIRMADO_CADF']=="2"){
			$txt_asiento="<b>";
			$nro_asiento="<b>";
		}else{
			$txt_asiento="<b>Nro. : ";
			$nro_asiento="<b>".$GLOBALS['numero'];
		}	
		
		$this->SetAligns(array('R', 'L'));
		$this->SetWidths(array( 30, 30));
		$this->SetXY(140,$this->GetY());
		$this->Row('helvetica',10,array( $txt_asiento, $nro_asiento),5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
		
		//para moastrar el texto de REVERSION
		if($GLOBALS['adjunto']=="REVERSION"){
			$texto_ref="<b>REF. REVERSION";
			$num_comprobante=buscar_dato_especifico_tabla("numero","CONTA_ASIENTOS_DEF","idasiento",$GLOBALS['id_operacion']);
			$texto_reversion=" : ".$num_comprobante;
		}

		//para moastrar el texto de CONFIRMADO
		if($GLOBALS['adjunto']=="CONFIRMADO"){
			$texto_conf="<b>REF. CONFIRMADO";
			$num_comprobanteconf=buscar_dato_especifico_tabla("numero","CONTA_ASIENTOS_DEF","idasiento",$GLOBALS['id_operacion']);
			$texto_confirmado=" : ".$num_comprobanteconf;
		}
		
		//para moastrar el texto de BORRADOR O CONFIRMADO
		if($GLOBALS['BORRACONFIRMADO_CADF']=="2"){
			$texto_borra="<b>ASIENTO BORRADOR";
		}else{
			$texto_borra="<b>ASIENTO CONFIRMADO";
		}	
		
		//para moastrar el texto de REVERTIDO POR ID_CADF
		$IDCADF=explode("_",$GLOBALS['adjunto']);
		if($IDCADF[0]=="REVERTIDO"){
			$texto_conf="<b>REVERTIDO POR";
			$num_comprobanteconf=buscar_dato_especifico_tabla("numero","CONTA_ASIENTOS_DEF","idasiento",$IDCADF[1]);
			$texto_conf.=" : ".$num_comprobanteconf;
		}		
		
		$this->SetAligns(array('R', 'L'));
		$this->SetWidths(array( 30, 30));
		$this->SetXY(140,$this->GetY());
		$this->Row('helvetica',10,array( $texto_ref, $texto_reversion),5,array('L' =>0, 'T' => 0, 'R' => 0, 'B' => 0));
	
		
		$this->SetAligns(array('C', 'L'));
		$this->SetWidths(array( 70, 10));
		$this->SetXY(140,$this->GetY()-0.5);
		//$this->Row('helvetica',10,array( $texto_borra),5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
		$this->Row('helvetica',9,array(  $texto_conf, '' ),5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
		
        $this->SetFont('helvetica', '', 7);
		$fecha = date("d/m/Y");

		$valx=70; 
		$valy=8; 
		$this->setXY(10,25);
		$this->SetFont('helvetica','B',12);
		$this->Cell($valx);
		$this->Cell(50,6, 'COMPROBANTE CONTABLE' ,0,1);  
		$this->setXY(65,$this->GetY());$this->SetFont('helvetica','B',11);
		$this->Cell(50,6, '' ,0,1);  		
		$this->setXY(175,$this->GetY()-6);
		$this->Cell(65,6, '' ,0,1);  
		
		$this->SetAligns(array('L', 'L'));
		$this->SetWidths(array( 30,120));
		$this->SetXY(15,$this->GetY()-6);
		$this->Row('helvetica',8,array( '<b>Fecha ',': '. $GLOBALS['fecha']),4,array('L' => 0, 'T' =>0, 'R' => 0, 'B' => 0) );
			
		$this->SetAligns(array('L', 'L'));
		$this->SetWidths(array( 30,120));
		$this->SetXY(15,$this->GetY());
		$this->Row('helvetica',8,array( '<b>Tipo de Cambio ',': '. $GLOBALS['cambios']),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );

		$this->Ln(2);
		
		$this->SetAligns(array('L', 'L'));
		$this->SetWidths(array( 30,120));
		$this->SetXY(15,$this->GetY());
		//$this->Row('helvetica',8,array( '<b>A la orden de',': '. $GLOBALS['orden']),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );
			
		$this->SetAligns(array('L', 'L'));
		$this->SetWidths(array( 30,120));
		$this->SetXY(15,$this->GetY());
		$this->Row('helvetica',8,array( '<b>Glosa',': '. $GLOBALS['concepto']),4,array('L' =>0, 'T' => 0, 'R' => 0, 'B' => 0) );
				
		$this->Ln(2);
		$this->SetAligns(array('C','C','C','C','C'));
		$this->SetWidths(array(30,80,25,25,25));
		$this->SetXY(15,$this->GetY());
		$this->Row('helvetica',8,array( '<b>Cuenta','<b>Descripcion','<b>Monto por Moneda','<b>Debe  ','<b>Haber '),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 1));
		
		
		$this->SetFont('helvetica','',7);
		$hora=date("H:i:s");
		$this->setXY(172,$valy+2);
        $this->Cell(30, 4, 'Fecha' , 0, 1, 'L');
		$this->setXY(172,$valy+6);
		$this->Cell(30, 4, $fecha, 0, 1, 'L');
		$this->setXY(172,$valy+10);
		$this->Cell(30, 4, $hora, 0, 1, 'L');
		$this->setXY(188,$valy+10);
		$this->Cell(30, 4,$_SESSION['us_usuario'] , 0, 1, 'L');
//$_SESSION["us_id"].' $_SESSION['us_fu_id'] 
		//para el numero de la pagina
	/*	$this->setXY(195,$valy+2);
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(20, 4, 'Pagina ', 0, 1, 'L');
		$this->setXY(195,$valy+6);
		$this->Cell(20, 4, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 1, 'L');
		$this->setXY(195,$valy+10);
		$this->Cell(20, 4, 'Usuario',0, 1, 'L');	
		*/

    }

    // Page footer
	public function Footer() {
		
		if($GLOBALS['idmodelo']==5){
			$this->SetY(-25); //-30
			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'RECIBI CONFORME: ',''),4,array('L' => 0, 'T' =>0, 'R' => 0, 'B' => 0) );
				
			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'Firma (Sello):',' '),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );
			
			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'Nombre:',''),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );

			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'C.I.:',' '),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );


			$this->SetAligns(array('C'));
			$this->SetWidths(array( 50));
			$this->SetXY(80,$this->GetY()-4);
			$this->Row('helvetica',8,array( 'PREPARADO POR'),4,array('L' => 0, 'T' => 1, 'R' => 0, 'B' => 0) );

			$this->SetAligns(array('C'));
			$this->SetWidths(array( 50));
			$this->SetXY(145,$this->GetY()-4);
			$this->Row('helvetica',8,array('APROBADO POR'),4,array('L' => 0, 'T' => 1, 'R' => 0, 'B' => 0) );
		
			$this->Rect(12, $this->GetY()-22, 190, 24); //Cuadro1  -17    18
			
		}else{
			$this->SetY(-10); //-30
			/*$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'RECIBI CONFORME: ',''),4,array('L' => 0, 'T' =>0, 'R' => 0, 'B' => 0) );
				
			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'Firma (Sello):',' '),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );
			
			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'Nombre:',''),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );

			$this->SetAligns(array('L', 'L'));
			$this->SetWidths(array( 30,120));
			$this->SetXY(15,$this->GetY());
			$this->Row('helvetica',8,array( 'C.I.:',' '),4,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0) );
*/

		/*	$this->SetAligns(array('C'));
			$this->SetWidths(array( 50));
			$this->SetXY(80,$this->GetY()-4);
			$this->Row('helvetica',8,array( 'PREPARADO POR'),4,array('L' => 0, 'T' => 1, 'R' => 0, 'B' => 0) );

			$this->SetAligns(array('C'));
			$this->SetWidths(array( 50));
			$this->SetXY(145,$this->GetY()-4);
			$this->Row('helvetica',8,array('APROBADO POR'),4,array('L' => 0, 'T' => 1, 'R' => 0, 'B' => 0) );
		
			$this->Rect(12, $this->GetY()-22, 190, 24); //Cuadro1  -17    18			
			*/
		}
		

		// Position at 15 mm from bottom
		$this->SetY(-10); //-15
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
	}
	

	//////
	
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	function Row($fuente, $tamanio, $data, $altc=5, $style4 = array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0), $padingL=0, $padingT=0, $padingR=0, $padingB=0)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=$altc*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			
			//Draw the border
			$this->Rect($x,$y,$w,$h, '',$style4, array(224, 224, 224));  // al $y-1 para alinear un poco   //DF para color
			$this->setCellPaddings($padingL, $padingT,$padingR,  $padingB);
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)
			
			//Para poner en negrillas algunas columnas   jhocaj 4716
			$existe_b = strpos($data[$i], '<b>');
			if ($existe_b !== false) {
				$resdata = substr($data[$i], 3);
				$this->SetFont($fuente,'B',$tamanio);
				$this->MultiCell($w,$altc,$resdata,0,$a,false,1, '', '', true, 0, false, true, 0, 'M', true);
				$this->SetXY($x+$w,$y);				
			} else {
				$this->SetFont($fuente,'',$tamanio);
				$this->MultiCell($w,$altc,$data[$i],0,$a,false,1, '', '', true, 0, false, true, 0, 'M', true);
				$this->SetXY($x+$w,$y);			
			}
	
			// $this->MultiCell($w,$altc,$data[$i],0,$a,false,1, '', '', true, 0, false, true, 0, 'M', true);
			// $this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	

	function NbLines($w,$txt)
	{		//Calcula el número de líneas de un MultiCell de anchura w tendrá
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}	

	
	
	function Genera_Detalle_Comprobante($asiento,$alaorden=0){
		
		$resultado=devolver_datos_tabla("CONTA_ASIENTOS_DEF",array("idasiento","idfondo","s?fondo","idmodelo","s?modelo","h?fecha","s?concepto","s?numero","n?total","idusuario","estado","s?tipo","s?borraconfirmado_cadf","s?id_usuario_confirmado_cadf","f?fechaconfirmado_cadf","s?usuario_confirmado","s?usuario"),"WHERE idasiento=$asiento AND  IDESTADO=1");

		if ($resultado[0]["idmodelo"] == -3)
			$estado = '1,2';
		else 
		 	$estado = '1';

		$detalle=devolver_datos_tabla("CONTA_ASIENTOS_DET",array("iddetalle","idasiento","tipo","idcuenta","s?cuentan","s?cuentad","idmoneda","n?bolivianos","n?dolares","n?ufvs","s?glosa","n?cambio","n?cambiou","s?alaorden","idpadre","moneda"),"WHERE idasiento=$asiento AND  IDESTADO IN({$estado}) ORDER BY tipo,iddetalle ASC");
		
		if($resultado[0]["idfondo"]==0)
			$orden=($alaorden<>0?$alaorden:$detalle[0]["alaorden"]);
		else		
			$orden="";
		$tdebe=$thaber=0;
		if($detalle[0]["idmoneda"]==4)
			$cambios=" 1 UFV = {$detalle[0]["cambiou"]} BOB";
		else
			$cambios=" 1 USD = {$detalle[0]["cambio"]} BOB";


		//verifica la cantidad de registro y hojas que se utilizaran
		$tot_filas = count($detalle);
		$cant_filas = 19;//13;
		$num_hojas = floor($tot_filas / $cant_filas);
		$num_hojas_resto = $tot_filas % $cant_filas;
		$cuenta_hoja=1;

		
		$this->Ln(50);

		//echo "<pre>";print_r($detalle);echo "</pre>";  //son 22 reg
		for($i=0;$i<=count($detalle)-1;$i++){
			
			if($cuenta_hoja<=$num_hojas){
				
				if($i<($cant_filas*$cuenta_hoja)){
					
					$padre=devolver_datos_tabla("CON_PLAN_CUENTAS_SAFI",array("id_plcs","s?cuenta_plcs","s?descripcion_plcs"),"WHERE id_plcs={$detalle[$i]["idpadre"]}");
					if($detalle[$i]["tipo"]=="DEBE"){
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(30,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),number_format($detalle[$i]["bolivianos"],2),''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));

						
						$tdebe+=$detalle[$i]["bolivianos"];
					}else{
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),'',number_format($detalle[$i]["bolivianos"],2)),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						$thaber+=$detalle[$i]["bolivianos"];
						
					}	
				}else{
								
					$cuenta_hoja++;
					
					$this->setPrintHeader(true);
					$this->setPrintFooter(true);
					$this->SetDisplayMode('fullpage'); 
					$this->SetFont('helvetica','',7);
					$this->SetMargins(5, 5, 5);
					$this->SetHeaderMargin(20);
					$this->SetAutoPageBreak(true,0);
					$this->AddPage();
					$this->Ln(50);
					
					$padre=devolver_datos_tabla("CON_PLAN_CUENTAS_SAFI",array("id_plcs","s?cuenta_plcs","s?descripcion_plcs"),"WHERE id_plcs={$detalle[$i]["idpadre"]}");
					if($detalle[$i]["tipo"]=="DEBE"){
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),number_format($detalle[$i]["bolivianos"],2),''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));

						
						$tdebe+=$detalle[$i]["bolivianos"];
					}else{
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),'',number_format($detalle[$i]["bolivianos"],2)),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						$thaber+=$detalle[$i]["bolivianos"];
						
					}
				}
			}else{
					$padre=devolver_datos_tabla("CON_PLAN_CUENTAS_SAFI",array("id_plcs","s?cuenta_plcs","s?descripcion_plcs"),"WHERE id_plcs={$detalle[$i]["idpadre"]}");
					if($detalle[$i]["tipo"]=="DEBE"){
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),number_format($detalle[$i]["bolivianos"],2),''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));

						
						$tdebe+=$detalle[$i]["bolivianos"];
					}else{
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						//$this->Row('helvetica',8,array("<b>{$padre[0]["cuenta_plcs"]}","<b>{$padre[0]["descripcion_plcs"]}",'','',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("{$detalle[$i]["cuentan"]}","{$detalle[$i]["cuentad"]}",number_format($detalle[$i]["moneda"]==1?$detalle[$i]["bolivianos"]:($detalle[$i]["moneda"]==4?$detalle[$i]["ufvs"]:$detalle[$i]["dolares"]),2),'',number_format($detalle[$i]["bolivianos"],2)),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						
						$this->SetAligns(array('L','L','R','R','R'));
						$this->SetWidths(array(20,90,25,25,25));
						$this->SetXY(15,$this->GetY());
						$this->Row('helvetica',8,array("","{$detalle[$i]["glosa"]}","",'',''),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
						$thaber+=$detalle[$i]["bolivianos"];
						
					}
			}
			
			$literal=NumeroLetra($tdebe);
			
			
			if($i==count($detalle)-1) //si es el último  imprimimos los totales
			{
				$this->SetAligns(array('L','L','R','R','R'));
				$this->SetWidths(array(30,80,25,25,25));
				$this->SetXY(15,$this->GetY());
				$this->Row('helvetica',9,array("<b>Totales: ","","",'<b>'.number_format($tdebe,2,'.',','),'<b>'.number_format($thaber,2,'.',',')),4.5,array('L' => 0, 'T' => 1, 'R' => 0, 'B' => 0));
				
				$this->Ln(1);
				$this->SetAligns(array('L'));
				$this->SetWidths(array(150));
				$this->SetXY(15,$this->GetY());
				$this->Row('helvetica',8,array("Son: ".ucfirst($literal)."/100 Bolivianos. "),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
				
				
				$generadopor=buscar_dato_especifico_tabla("NOMBRE_USUA","SIS_USUARIOS","ID_USUARIO",$resultado[0]["idusuario"]);
				$this->Ln(1);
				$this->SetAligns(array('R','L','R','L'));
				$this->SetWidths(array(45,45,25,45));
				$this->SetXY(15,$this->GetY());
				//$this->Row('helvetica',8,array("<b>Preparado por: ",(($resultado[0]["tipo"]=='ASIENTO MANUAL')?$resultado[0]["usuario"]:"Generacion Automatica "),'<b>Confirmado por: ',$resultado[0]["usuario"] ),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				$this->SetXY(15,$this->GetY()+10);
				//$this->Row('helvetica',8,array(" ",(($resultado[0]["tipo"]=='ASIENTO MANUAL')?$resultado[0]["usuario"]:"Usuario : ".$resultado[0]["usuario"]),' ','' ),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				$this->Row('helvetica',8,array(" ",'---------------------------------------------------',' ','----------------------------------------------------' ),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				$this->SetXY(15,$this->GetY()-1);
				$this->SetAligns(array('R','C','R','C'));
				$this->SetWidths(array(45,45,25,45));
				$this->Row('helvetica',8,array("               ",(($resultado[0]["tipo"]=='ASIENTO MANUAL')?$resultado[0]["usuario"]:"".$resultado[0]["usuario"]),'       ','Vo.Bo.' ),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
				
				$this->SetAligns(array('L','L','R','L'));
				$this->SetWidths(array(45,45,45,45));
				$this->SetXY(15,$this->GetY()-1);
				$this->Row('helvetica',7,array("NRO TRA: ".$GLOBALS["asiento"],'',' ','' ),4.5,array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));
			 }
		 
			
		}
		
		
	}
	
	
}

 
ob_end_clean(); 
 
$dimensiones=array (279,216);  //Carta
$pdf=new PDF('P','mm',$dimensiones,true, 'UTF-8',false); //
$pdf->SetTitle('COMPROBANTE CONTABLE');
/*
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);
$pdf->SetDisplayMode('fullpage'); 
$pdf->SetFont('helvetica','',7);
$pdf->SetMargins(5, 5, 5);
$pdf->SetHeaderMargin(20);
$pdf->SetAutoPageBreak(true,0);
$pdf->AddPage();

*/



$datos_safi=devolver_datos_tabla("SIS_SAFI",array("NIT_SAFI","RAZONSOCIAL_SAFI","DIRECCION_SAFI","TELEFONO_SAFI","FAX_SAFI","OFCENTRAL_SAFI","LOGO_SAFI"),"WHERE ID_ESTADO=1");

$logo_safi=$datos_safi[0]['LOGO_SAFI'];
$array_asiento=$_REQUEST['asiento'];
$id_asiento =explode("_",$array_asiento);


for($i=0;$i<count($id_asiento);$i++){ 

	$asiento=$id_asiento[$i];
	$resultado=devolver_datos_tabla("CONTA_ASIENTOS_DEF",array("idasiento","idfondo","s?fondo","idmodelo","s?modelo","h?fecha","s?concepto","s?numero","n?total","idusuario","estado","s?tipo","s?adjunto","s?id_operacion","s?BORRACONFIRMADO_CADF","s?ID_USUARIO_CONFIRMADO_CADF","f?FECHACONFIRMADO_CADF"),"WHERE idasiento=$asiento AND IDESTADO=1 ");
	
	if ($resultado[0]["idmodelo"] == -3)
		$estado = '1,2';
	else 
	 	$estado = '1';
	  
	  
	$detalle=devolver_datos_tabla("CONTA_ASIENTOS_DET",array("iddetalle","idasiento","tipo","idcuenta","s?cuentan","s?cuentad","idmoneda","n?bolivianos","n?dolares","n?ufvs","s?glosa","n?cambio","n?cambiou","s?alaorden","idpadre","moneda"),"WHERE idasiento=$asiento AND IDESTADO IN({$estado}) ORDER BY tipo,iddetalle ASC");
	$idmodelo=$resultado[0]["idmodelo"];
	
	
	
	if($resultado[0]["idfondo"]==0){
		$orden=($alaorden<>0?$alaorden:$detalle[0]["alaorden"]);
	}
	else		
		$orden="";
	$tdebe=$thaber=0;
	if($detalle[0]["idmoneda"]==4)
		$cambios=" 1 UFV = {$detalle[0]["cambiou"]} BOB";
	else
		$cambios=" 1 USD = {$detalle[0]["cambio"]} BOB";
	
	$fecha  =	$resultado[0]["fecha2"];
	$numero =	$resultado[0]["numero"];
	$cambios=	$cambios;
	$orden	= $orden;
	$concepto=	$resultado[0]["concepto"];	

	$adjunto=$resultado[0]["adjunto"];
	$id_operacion=$resultado[0]["id_operacion"];
	$BORRACONFIRMADO_CADF=$resultado[0]["BORRACONFIRMADO_CADF"];
	
	$idfondo=$resultado[0]["idfondo"];
	
	$sqlf="SELECT * from FND_FONDO  WHERE ID_FOND='{$idfondo}'  and ID_ESTADO=1";
	$resfon = ejecutar_consulta2($sqlf);	
	//echo "<pre> $sql";print_r($resfon);echo "</pre>";

	$logo_safi=$resfon[0]['LOGO_FOND'];
	$nombre_safi=($resfon[0]['NOMBRE_FOND']=='SAFI'?$datos_safi[0]['RAZONSOCIAL_SAFI']:$resfon[0]['NOMBRE_FOND']);

	
	
	$cant_det=count($detalle);
	$num_hoja=($cant_det/13);

	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);
	$pdf->SetDisplayMode('fullpage'); 
	$pdf->SetFont('helvetica','',7);
	$pdf->SetMargins(5, 5, 5);
	$pdf->SetHeaderMargin(20);
	$pdf->SetAutoPageBreak(true,0);
	$pdf->AddPage();	

	$pdf->Genera_Detalle_Comprobante($asiento);
	
}

//ob_clean();
//$pdf->Output('kiuvox.pdf', 'I');
$pdf->Output('Comprobante_Cnt_'.date('d-m-y').'.pdf');


?> 
