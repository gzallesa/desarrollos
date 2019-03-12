<?php
include("../../../../../assets/bin/conectar.php");
include("../../../../../assets/bin/lib_general.php");
require_once('tcpdf_include.php');
$con=conectar_oracle();
//var_dump($_REQUEST);

$cuenta=$_REQUEST['cuenta'];
$fondo=$_REQUEST['fondo'];
$desde=$_REQUEST['desde'];
$hasta=$_REQUEST['hasta'];
$formato=$_REQUEST['formato'];
$moneda=$_REQUEST['moneda'];
$cambio=$_REQUEST['cambio'];
$muestra=$_REQUEST['muestra'];

$desde=$_REQUEST['desde'].' 00:00:00';
$hasta=$_REQUEST['hasta'].' 23:59:59';

	    if($muestra==2)	$wheree="AND idestado IN (1,2) AND idmodelo NOT IN (-3) AND borraconf=1";
	elseif($muestra==3)	$wheree="AND idestado IN (1,2) AND idmodelo=-3 OR idmodelo=-2";
	elseif($muestra==4)	$wheree="AND idestado=0 AND idestado_asiento=0";
	elseif($muestra==5) $wheree="AND idestado IN (1,2) AND borraconf = 2";
	               else $wheree="AND idestado=1 AND idmodelo NOT IN (-3,-2) AND borraconf=1";
		if($formato)	$whereformato=" AND idmodelo=".$formato.' '; 			   
	
    $wherefecha="fecha BETWEEN convert(DATETIME,'$desde 00:00:00',103) AND CONVERT(DATETIME,'$hasta 23:59:59',103)";
	if($modelo)$whereauto="AND idmodelo=$modelo"; 
	if($cuenta<>"")	$wherecuenta="AND idcuenta='{$_REQUEST["cuenta"]}'"; else $wherecuenta="";
	
		
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 6);
// -----------------------------------------------------------------------------

if($formato<>''){$sigla=buscar_dato_especifico_tabla("CONCEPTO_TIAS","CON_MODELO_ASIENTOS","ID_TIAS",$formato);$sigla=strtoupper(' de '.$sigla);}
$del=substr($desde,0,10);
$al=substr($hasta,0,10);

$fecha=fecha_en_sp($fila['FECHA2']);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="3" width="636px">
<tr nobr="true"><th colspan="4" align="center" height="50px" valign="midle" ><h3>ASIENTOS CONTABLES$sigla</h3><br>DEL $del AL $al<br><br>(expresado en bolivianos)<br><br></th></tr></table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');



$query=" 		
SELECT 
	DISTINCT IDASIENTO AS idasiento , 
	FECHA AS fechaorden , 
	CONVERT(VARCHAR(10),FECHA,103) AS fecha2 , 
	numero , usuario , concepto , total , totald , totalu , generacion , idmodelo 
FROM 
	CONTA_ASIENTOS_DET 
WHERE 
	IDFONDO=$fondo AND 
	FECHA >= '$desde' AND FECHA<='$hasta'
	$whereauto
	$wheree 
	$whereformato
ORDER BY 
	FECHA DESC";


$resultado=sqlsrv_query($con, $query);
while($row=sqlsrv_fetch_array($resultado))
			{
$x=$x.'<tr nobr="true">
<td width="60px" align="left"   style="border-bottom: 0.2px solid #aaa;" bgcolor="#FFF">'.$row['numero'].'</td>
<td width="45px" align="center" style="border-bottom: 0.2px solid #aaa;" bgcolor="#FFF">'.$row['fecha2'].'</td>
<td width="60px"  align="center"   style="border-bottom: 0.2px solid #aaa;" bgcolor="#FFF">'.$row['usuario'].'</td>
<td width="60px"  align="center"   style="border-bottom: 0.2px solid #aaa;" bgcolor="#FFF">'.$row['usuario'].'</td>
<td width="340px" style="border-bottom: 0.2px solid #aaa;text-align:justify;" bgcolor="#FFF">'.$row['concepto'].'</td>
<td width="71px" align="rigth"  style="border-bottom: 0.2px solid #aaa;" bgcolor="#FFF7FF">'.number_format($row['total'], 2, ',', '.').'</td>
</tr>';	
$preparado=$row['usuario'];
				}
				

$tbl = <<<EOD
<table border="0" cellpadding="3" cellspacing="2" width="636px">
<thead>
 <tr nobr="true" align="center">
  <td width="60px" align="center" style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Comprobante</td>
  <td width="45px" align="center" style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Fecha</td>
  <td width="60px" align="center"style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Generado</td>
  <td width="60px" align="center"style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Confirmado</td>
  <td width="340px" align="center" style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Concepto</td>
  <td width="71px" align="center" style="font-size: 8px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Monto BOB</td>
 </tr>
 </thead>
 $x
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('asientos.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
