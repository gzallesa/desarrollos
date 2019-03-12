<?php

	require 'Classes/PHPExcel/IOFactory.php';
	require 'conBd.php';
	require 'Classes/PHPMailer/third_party/phpmailer/PHPMailerAutoload.php';

	$mail = new PHPMailer();
	
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '587';
	$mail->Username = 'sistema.ba@avis.com.bo';
	$mail->Password = 'china2009';	

	$mail->setFrom('sistema.ba@avis.com.bo','PROSPECTOS-VENTAS-ENTREGAS');
	
 	
    $sql = "CALL get_demonio_sin_facturar_cab(null)";
    $result = $mysqli->QUERY($sql);
    while($row_receptor = $result->fetch_assoc()){
   	  $subjectrec = $row_receptor['subject'];
   	  $bodytrec = $row_receptor['body'];
   	  $correorec = $row_receptor['correo'];
   	  //echo print_r($row_receptor, true);
   	  //echo print_r($mail, true); 
   	  $mail->addAddress($correorec,$subjectrec);  
   	  $mail->Subject = $subjectrec; 
   	  $mail->Body = $bodytrec;
	  $mail->IsHTML(true);
	  //$mail->send();
	  if($mail->send()){
		echo 'Enviado';
      } else {
        echo 'Error';
        }
        $mail->ClearAddresses();
        $mail->ClearAttachments();
   	  //echo $subjectrec;  
    } 	
?>	