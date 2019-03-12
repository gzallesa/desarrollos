<?php
//require_once __DIR__ . '/vendor/autoload.php';	
require_once 'mpdf/mpdf-6.1/mpdf.php';
require 'conBd.php';

$sql = "CALL get_car_carta_cartera(null)";
$result = $mysqli->QUERY($sql);

$mpdf = new mPDF('c','A4');

   while($row_receptor = $result->fetch_assoc()){
   	  $nombrerec = $row_receptor['detalle_carta'];
   	  $nombrerec= mb_convert_encoding($nombrerec, 'UTF-8', 'ISO-8859-1');
   	  $mpdf->writeHTML($nombrerec);
   	  $mpdf->AddPage();
   	  //echo $nombrerec; 

   }
   $mpdf->Output('reporte cartas.pdf','D'); 
   //$mpdf->stream('FicheroEjemplo.pdf');
?>	