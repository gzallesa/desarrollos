<?php
	require 'Classes/PHPExcel/IOFactory.php';
	require 'conBd.php';
	require 'Classes/PHPMailer/third_party/phpmailer/PHPMailerAutoload.php';
	
	// $nombreArchivo1 = 'Z:\Entregados.xls';
	// $nombreArchivo2 = 'Z:\Prospectos.xls';
	// $nombreArchivo3 = 'Z:\Seguimiento.xls';
	// $nombreArchivo4 = 'Z:\Ventas.xls';
	
	$nombreArchivo1 = 'Entregados.xls';
	$nombreArchivo2 = 'Prospectos.xls';
	$nombreArchivo3 = 'Seguimiento.xls';
	$nombreArchivo4 = 'Ventas.xls';	
	
	$sql = "delete from vta_ventas_general";
	$result = $mysqli->query($sql);
	$sql = "delete from vta_vehiculos_entregados";
	$result = $mysqli->query($sql);
	$sql = "delete from vta_informe_prospectos";
	$result = $mysqli->query($sql);
	$sql = "delete from vta_seguimiento_seguimiento";
	$result = $mysqli->query($sql);
		
	
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo1);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	for($i = 2; $i <= $numRows; $i++){
		$refer = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$IDV = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$matricula = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$bastidor = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$modelo = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$estado = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$color = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$consecionario = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$vendedor = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$ubicacion = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();		
		$cliente = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();		
		$fecha = $objPHPExcel->getActiveSheet()->getCell('L'.$i);//->getCalculatedValue();
		$InvDate = $fecha->getValue();
		$timestamp = PHPExcel_Shared_Date::ExceltoPHP($InvDate);
		$fecha_entrega = date("Y-m-d",$timestamp);
		$fecha2 = $objPHPExcel->getActiveSheet()->getCell('M'.$i);//->getCalculatedValue();
		$InvDate2 = $fecha2->getValue();
		$timestamp2 = PHPExcel_Shared_Date::ExceltoPHP($InvDate2);
		$hora =  date("H:i",$timestamp2);		
		$fecha1 = $objPHPExcel->getActiveSheet()->getCell('N'.$i);//->getCalculatedValue();
		$InvDate1 = $fecha1->getValue();
		$timestamp1 = PHPExcel_Shared_Date::ExceltoPHP($InvDate1);
		$fecha_cierre =  date("Y-m-d",$timestamp1);
        
		$sql = "INSERT INTO vta_vehiculos_entregados (refer,IDV,matricula,bastidor,modelo,estado,color,consecionario,vendedor,ubicacion,cliente,fecha_entrega,hora,fecha_cierre) VALUE('$refer','$IDV','$matricula','$bastidor','$modelo','$estado','$color','$consecionario','$vendedor','$ubicacion','$cliente','$fecha_entrega','$hora','$fecha_cierre')";
		$result = $mysqli->query($sql);
	}
	echo 'Proceso Terminado 1';
	
	
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo2);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	for($i = 2; $i <= $numRows; $i++){
		$refer = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$nombre = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$telefono = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$movil = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$email = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$marca = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$cod_modelo = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$desc_modelo = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$cod_vendedor = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$desc_vendedor = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();		
		$fecha = $objPHPExcel->getActiveSheet()->getCell('K'.$i);//->getCalculatedValue();
		$InvDate = $fecha->getValue();
		$timestamp = PHPExcel_Shared_Date::ExceltoPHP($InvDate);
		$fecha_pedido = date("Y-m-d",$timestamp);
		$fecha1 = $objPHPExcel->getActiveSheet()->getCell('L'.$i);//->getCalculatedValue();
		$InvDate1 = $fecha1->getValue();
		$timestamp1 = PHPExcel_Shared_Date::ExceltoPHP($InvDate1);
		$fecha_cierre =  date("Y-m-d",$timestamp1);
		$tipo = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
		$estado = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();		
        $desc_estado = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
		$fecha2 = $objPHPExcel->getActiveSheet()->getCell('P'.$i);//->getCalculatedValue();
		$InvDate2 = $fecha2->getValue();
		$timestamp2 = PHPExcel_Shared_Date::ExceltoPHP($InvDate2);
		$fecha_estado =  date("Y-m-d",$timestamp2);
		$total_oferta = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
		IF ($total_oferta==''){
			$total_oferta='0';
		}
		$origen = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
		$desc_origen = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
		$concesionario = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
		$nombre_concesionario = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();	
		IF ($nombre_concesionario==''){
			$nombre_concesionario='1';
		}		
		$importe = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
		IF ($importe==''){
			$importe='0';
		}
		$sql = "INSERT INTO vta_informe_prospectos (refer,nombre,telefono,movil,email,marca,cod_modelo,desc_modelo,cod_vendedor,desc_vendedor,fecha_pedido,fecha_cierre,tipo,estado,desc_estado,fecha_estado,total_oferta,origen,desc_origen,concesionario,nombre_concesionario,importe) VALUE('$refer','$nombre','$telefono','$movil','$email','$marca','$cod_modelo','$desc_modelo','$cod_vendedor','$desc_vendedor','$fecha_pedido','$fecha_cierre','$tipo','$estado','$desc_estado','$fecha_estado','$total_oferta','$origen','$desc_origen','$concesionario','$nombre_concesionario','$importe')";
		
		//echo $sql;
		
		$result = $mysqli->query($sql);
	}	
		echo 'Proceso Terminado 2';
		
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo3);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	for($i = 2; $i <= $numRows; $i++){
		$Nro = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$fecha1 = $objPHPExcel->getActiveSheet()->getCell('B'.$i);//->getCalculatedValue();
		$InvDate1 = $fecha1->getValue();
		$timestamp1 = PHPExcel_Shared_Date::ExceltoPHP($InvDate1);
		$fecha = date("Y-m-d",$timestamp1);
		$fecha2 = $objPHPExcel->getActiveSheet()->getCell('C'.$i);//->getCalculatedValue();
		$InvDate2 = $fecha2->getValue();
		$timestamp2 = PHPExcel_Shared_Date::ExceltoPHP($InvDate2);
		$hora =  date("H:i",$timestamp2);
		$Cliente = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$Nombre = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$Telefono = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$Vehiculo = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$Modelo = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$Tipo = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$Tipo1 = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$Est = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
		$dept = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$apl = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
		$vend = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();		
		$For = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();		
		$fecha2 = $objPHPExcel->getActiveSheet()->getCell('P'.$i);//->getCalculatedValue();
		$InvDate2 = $fecha2->getValue();
		$timestamp2 = PHPExcel_Shared_Date::ExceltoPHP($InvDate2);
		$Fprox = date("Y-m-d",$timestamp2);
		$hora1 = $objPHPExcel->getActiveSheet()->getCell('Q'.$i);//->getCalculatedValue();
		$InvDate3 = $hora1->getValue();
		$timestamp3 = PHPExcel_Shared_Date::ExceltoPHP($InvDate3);
		$Hora1 =  date("H:i",$timestamp3);
		$ven_pr = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
		$form = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();		
        		
		$sql = "INSERT INTO vta_seguimiento_seguimiento (Nro,fecha,hora,Cliente,Nombre,Telefono,Vehiculo,Modelo,Tipo,Est,dept,apl,vend,For1,Fprox,Hora1,ven_pr,refer) VALUE('$Nro','$fecha','$hora','$Cliente','$Nombre','$Telefono','$Vehiculo','$Modelo','$Tipo','$Est','$dept','$apl','$vend','$For','$Fprox','$Hora1','$ven_pr','$form')";
		$result = $mysqli->query($sql);
	}	
		echo 'Proceso Terminado 3';	
		
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo4);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	for($i = 2; $i <= $numRows; $i++){
		$Conce = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$refer = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$matricula = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$IDV = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$fecha1 = $objPHPExcel->getActiveSheet()->getCell('E'.$i);//->getCalculatedValue();
		$InvDate1 = $fecha1->getValue();
		$timestamp1 = PHPExcel_Shared_Date::ExceltoPHP($InvDate1);
		$fec_facturacion = date("Y-m-d",$timestamp1);
		$bastidor = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$cuenta = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$nombre_cliente = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$cod_vendedor = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		IF (is_null($cod_vendedor)){
			$cod_vendedor = '1';
		}		
		IF ($cod_vendedor==''){
			$cod_vendedor='1';
		}
		$vendedor = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$UD = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
		$Modelo_VN = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$Color = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
		$venta_bruto = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
		IF ($venta_bruto==''){
			$venta_bruto='0';
		}
		$costo_total = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
		IF ($costo_total==''){
			$costo_total='0';
		}		
		$beneficio = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
		IF ($beneficio==''){
			$beneficio='0';
		}		
		$serie_fra = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
		$numero = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
		$fecha2 = $objPHPExcel->getActiveSheet()->getCell('S'.$i);//->getCalculatedValue();
		$InvDate2 = $fecha2->getValue();
		$timestamp2 = PHPExcel_Shared_Date::ExceltoPHP($InvDate2);
		$Fecha_entrega = date("Y-m-d",$timestamp2);
		$celular = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
		$telefono_fijo = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
		$direccion = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
		$email = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
		$codigo_pago = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
		$desc_pago = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
		$cod_marca = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
		$abrev_marca = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
		$modelo = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
		$marca = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
		IF (is_null($marca)){
			$marca = '1';
		}
        		
		$sql = "INSERT INTO vta_ventas_general (Conce,refer,matricula,IDV,fec_facturacion,bastidor,cuenta,nombre_cliente,cod_vendedor,vendedor,UD,Modelo_VN,Color,venta_bruto,costo_total,beneficio,serie_fra,numero,Fecha_entrega,celular,telefono_fijo,direccion,email,codigo_pago,desc_pago,cod_marca,abrev_marca,modelo,marca,tipo_venta) VALUE('$Conce','$refer','$matricula','$IDV','$fec_facturacion','$bastidor','$cuenta','$nombre_cliente','$cod_vendedor','$vendedor','$UD','$Modelo_VN','$Color','$venta_bruto','$costo_total','$beneficio','$serie_fra','$numero','$Fecha_entrega','$celular','$telefono_fijo','$direccion','$email','$codigo_pago','$desc_pago','$cod_marca','$abrev_marca','$modelo','$marca',$cod_vendedor)";
		//echo $sql;
		$result = $mysqli->query($sql);
	}	
		echo 'Proceso Terminado 4';	
		
   $sql = "CALL abm_vta_reporte_vendedores(@respuesta)";
   $result = $mysqli->QUERY($sql);	
   $sql = "select @respuesta";	
   $result = $mysqli->query($sql);
   $resp = mysqli_fetch_assoc($result);
   $procOutput_resp     = $resp['@respuesta'];
   echo $procOutput_resp;
				
	$mail = new PHPMailer();
	
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '587';
	$mail->Username = 'sistema.ba@avis.com.bo';
	$mail->Password = 'china2009';	

	$mail->setFrom('sistema.ba@avis.com.bo','INGRESO PROSPECTOS-VENTAS-ENTREGAS');	
	$mail->addAddress('gustavo.zalles@ba.com.bo','Ingreso de Prospectos');  
	$mail->Subject = 'Ingreso de Prospectos';
	
	if ($procOutput_resp=='PROCESO TERMINADO'){
	   $mail->Body = '<b>Ingreso con Exito</b><br>Eso Carajo';			
       }
    else{
	   $mail->Body = '<b>Ingreso Con Errores</b><br>Que mierda paso';			
       }   
    $mail->IsHTML(true);
	
	if($mail->send()){
		echo 'Enviado';
    } else {
        echo 'Error';
    }   			
?>