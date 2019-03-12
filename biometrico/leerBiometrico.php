<?php

	require 'Classes/PHPExcel/IOFactory.php';
	require 'conBd.php';
	require 'Classes/PHPMailer/third_party/phpmailer/PHPMailerAutoload.php';
	require 'fpdf/fpdf.php';
	
	$nombreArchivo = 'RESPALDODEPYVTASSEP.xlsx';
	
	$objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
	
	$objPHPExcel->setActiveSheetIndex(0);
	
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	echo '<table border=1><tr><td>NRO</td><td>FECHA</td><td>NOMBRE</td><td>MONTOBS</td><td>MONTOSUS</td></tr>';
	
	
	for($i = 2; $i <= $numRows; $i++){
		$nro = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$fecha = $objPHPExcel->getActiveSheet()->getCell('B'.$i);//->getCalculatedValue();
		$InvDate = $fecha->getValue();
		$timestamp = PHPExcel_Shared_Date::ExceltoPHP($InvDate);
		$fecha_php = date("Y-m-d H:i:s",$timestamp);
		//if(PHPExcel_Shared_Date::isDateTime($fecha)){
			
			//$InvDate = date($format, PHPExcel_Shared::ExcelToPHP($InvDate));
			//$InvDate = date($format = "Y-m-d", PHPExcel_Shared::ExcelToPHP($InvDate));
		//}
		$nombre = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$montoBs = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$montoSus = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		
		echo '<tr>';
		echo '<td>'.$nro.'</td>';
		echo '<td>'.$fecha_php.'</td>';
		echo '<td>'.$nombre.'</td>';
		echo '<td>'.$montoBs.'</td>';
		echo '<td>'.$montoSus.'</td>';
		echo '</tr>';

	//	$sql = "INSERT INTO prbexcel (NRO,FECHA,NOMBRE,MONTOBS,MONTOSUS) VALUE('$nro','$fecha_php','$nombre','$montoBs','$montoSus')";
	//	$result = $mysqli->query($sql);
	}
	echo '</table>';

  // $sql = "CALL getprbexcel()";
//   $result = $mysqli->QUERY($sql);
 //  while($row_receptor = $result->fetch_assoc()){
  // 	  $nombrerec = $row_receptor['nombre'];
   //	  echo $nombrerec;  
  // }	
   
   
	$mail = new PHPMailer();
	
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '587';
	$mail->Username = 'sistema.ba@avis.com.bo';
	$mail->Password = 'china2009';
	
	$mail->setFrom('sistema.ba@avis.com.bo','Codigo Prueba');
	
	$mail->addAddress('gustavo@avis.com.bo','Prueba');
	
	$mail->addAttachment('changelog.txt','changelog.txt');
	
	$mail->Subject = 'Hola';
	//$mail->Body = 'Hola como estas';
	$mail->Body = '<b>Hola como estas</b><br>bienvenido';
	$mail->Body = 'Cliente ha emitido una calificación de insatisfacción 4, favor prestar  atención con urgencia para brindar solución al caso<br><br><b> Número de OR:</b>477111<br><br><b>Datos del Cliente:</b><br>Nombre: JIMMY JOHN TOLEDO CONTRER<br>Teléfono:60039136<br>Placa:3175<br>Vehiculo:TATA<br>Taller:0301<br>Descripcion del trabajo realizado:Mantenimiento<br><br><br><b>Comentario:</b><br><b><FONT COLOR="red">Xzcx</FONT></b><br><br><br><b>Adjunto Encuesta</b><br><br>Cualquier consulta remitirse con Gestión de Clientes.<br><br>No responda este correo, es automático.';
	$mail->IsHTML(true);
	
	if($mail->send()){
		echo 'Enviado';
    } else {
        echo 'Error';
    }
	
//	$pdf = new FPDF();
//	$pdf->AddPage();
	//$pdf->Output();
	
?>	