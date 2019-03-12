<?php
// Include the main TCPDF library (search for installation path).
include("../../../../../assets/bin/conectar.php");
include("../../../../../assets/bin/lib_general.php");
require_once('tcpdf_include.php');
$cuenta=$_REQUEST['cuenta'];
$fondo=$_REQUEST['fondo'];
$desde=$_REQUEST['desde'].' 00:00:00';
$hasta=$_REQUEST['hasta'].' 23:59:59';
$formato=$_REQUEST['formato'];
$moneda=$_REQUEST['moneda'];
$cambio=$_REQUEST['cambio'];
$muestra=$_REQUEST['muestra'];

$sigla=buscar_dato_especifico_tabla("siglarept_mone","cnf_moneda","id_mone",$moneda);

	if($cuenta<>0)	$wherec="AND idcuenta=$cuenta ";
//descripción de la moneda  as TIPO_CAMBIO
	if($moneda==1) {$descripcionmoneda="bolivianos"; 						$monto='conta_asientos_det.bolivianos AS valor, ';	}
	if($moneda==2) {$descripcionmoneda="dolares"; 							$monto='conta_asientos_det.dolares AS valor, ';		}
	if($moneda==4) {$descripcionmoneda="unidades de fomento a la vivienda"; $monto='conta_asientos_det.ufvs AS valor, ';		}
//tipo de muestra por verificar !!!

	   if($muestra==2)	$wheree="AND idestado IN (1,2) AND idmodelo NOT IN (-3) AND borraconf=1";
	elseif($muestra==3)	$wheree="AND idestado IN (1,2) AND idmodelo=-3 OR idmodelo=-2";
	elseif($muestra==4)	$wheree="AND idestado=0 AND idestado_asiento=0";
	elseif($muestra==5) $wheree="AND idestado IN (1,2) AND borraconf = 2";
	               else $wheree="AND idestado=1 AND idmodelo NOT IN (-3,-2) AND borraconf=1";
				   
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

// set font
$pdf->SetFont('helvetica', 'B', 20);
// add a page
//$pdf->AddPage('L', 'A4');
$pdf->AddPage();
//$pdf->Write(0, 'Example of HTML tables'.$query, '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
// NON-BREAKING ROWS (nobr="true")
$del=substr($desde,0,10);
$al=substr($hasta,0,10);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="3" width="636px">
<tr nobr="true"><th colspan="4" align="center" height="50px" valign="midle" ><h3>LIBRO MAYOR</h3><br>DEL $del AL $al<br><br>(expresado en $descripcionmoneda)<br><br></th></tr></table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
/////////////////////////////////////////////////////
$con=conectar_oracle();
$query="
SELECT 
  DISTINCT idcuenta AS idcuenta , 
  (cuentan+' '+cuentad) AS cuenta , 
  moneda , 
  negativo,
  count(idcuenta) as nro_reg
FROM 
  conta_asientos_det 
WHERE 
  idfondo=".$fondo." AND 
  fecha >='".$desde."' AND fecha<='".$hasta."' AND
  idestado=1 
  GROUP BY
  idcuenta,cuentan,cuentad,moneda,negativo
ORDER BY 
  cuenta ASC
";
	
$resultado=sqlsrv_query($con, $query);
$sw=1;
$contador=0;
$std=0;
while($row=sqlsrv_fetch_array($resultado))
			{$x='';	
				if($sw==1)
						{
						$contador=$contador+$row['nro_reg']+3;
						if($contador<=42)	{'imprime asiento';
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
  CONVERT(VARCHAR(10),fecha,103) AS fecha2 , 
  cambio , cambiob , 
  cambiou , numero , 
  cuentan , cuentad , 
  original , bolivianos , 
  dolares , concepto , 
  glosa , tipo , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE 0 END) AS debe , 
  (CASE tipo WHEN 'HABER' THEN bolivianos ELSE 0 END) AS haber , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE -bolivianos END) AS saldo , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE 0 END) AS debed , 
  (CASE tipo WHEN 'HABER' THEN dolares ELSE 0 END) AS haberd , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE -dolares END) AS saldod , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE 0 END) AS debeu , 
  (CASE tipo WHEN 'HABER' THEN ufvs ELSE 0 END) AS haberu , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE -ufvs END) AS saldou , 
  negativo 
FROM 
    conta_asientos_det 
WHERE 
  idcuenta=".$row['idcuenta']." AND 
  fecha >='".$desde."' AND fecha<='".$hasta."' AND
  idestado=1 
ORDER BY fecha ASC,tipo ASC";	
$resultadoint=sqlsrv_query($con, $queryint);
$saldo=0;
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
	//descripción de la moneda  as TIPO_CAMBIO
	/**/
	if($moneda==1) {$dc="debe";  $hc="haber";   $sc="saldo";}
	if($moneda==2) {$dc="debed"; $hc="'haberd"; $sc="saldod";}
	if($moneda==4) {$dc="debeu"; $hc="'haberu"; $sc="saldou";}
	
	
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint[$dc], 2, '.', ',');$h='';$dt=$dt+$rowint[$dc];}
	if($rowint['tipo']=='HABER'){$h=number_format($rowint[$hc], 2, '.', ',');$d='';$ht=$ht+$rowint[$hc];}
	$saldo=$saldo+$rowint[$sc];
	
	$s=number_format($saldo, 2, '.', ',');
	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['fecha2'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cambio'].'</td>
<td align="left" style="font-size: 8px;" bgcolor="#FCFCFC">'.$rowint['numero'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['concepto'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$h.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF">'.$s.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="30px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Cuenta</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="590px" align="left" style="font-size: 8px; " bgcolor="#FFF" colspan="6" >$row[cuenta]</td>
  </tr>
    <tr>
    <td colspan="3">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="55px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Fecha</td>
        <td width="30px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">TC</td>
        <td width="65px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cpbte</td>
		<td width="235px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Descripción</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
		<td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Saldo</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="4" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">$s</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');


											}
										else{
											$contador=0;
											$sw=0;
											$contador=$contador+$row['nro_reg']+3;
											'nueva pagina';
											$pdf->AddPage();
											'imprime asiento';
											$std=1;
/*	aca */										
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
  CONVERT(VARCHAR(10),fecha,103) AS fecha2 , 
  cambio , cambiob , 
  cambiou , numero , 
  cuentan , cuentad , 
  original , bolivianos , 
  dolares , concepto , 
  glosa , tipo , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE 0 END) AS debe , 
  (CASE tipo WHEN 'HABER' THEN bolivianos ELSE 0 END) AS haber , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE -bolivianos END) AS saldo , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE 0 END) AS debed , 
  (CASE tipo WHEN 'HABER' THEN dolares ELSE 0 END) AS haberd , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE -dolares END) AS saldod , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE 0 END) AS debeu , 
  (CASE tipo WHEN 'HABER' THEN ufvs ELSE 0 END) AS haberu , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE -ufvs END) AS saldou , 
  negativo 
FROM 
    conta_asientos_det 
WHERE 
  idcuenta=".$row['idcuenta']." AND 
  fecha >='".$desde."' AND fecha<='".$hasta."' AND
  idestado=1 
ORDER BY fecha ASC,tipo ASC";	
$resultadoint=sqlsrv_query($con, $queryint);
$saldo=0;
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
	//descripción de la moneda  as TIPO_CAMBIO
	/**/
	if($moneda==1) {$dc="debe";  $hc="haber";   $sc="saldo";}
	if($moneda==2) {$dc="debed"; $hc="'haberd"; $sc="saldod";}
	if($moneda==4) {$dc="debeu"; $hc="'haberu"; $sc="saldou";}
	
	
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint[$dc], 2, '.', ',');$h='';$dt=$dt+$rowint[$dc];}
	if($rowint['tipo']=='HABER'){$h=number_format($rowint[$hc], 2, '.', ',');$d='';$ht=$ht+$rowint[$hc];}
	$saldo=$saldo+$rowint[$sc];
	
	$s=number_format($saldo, 2, '.', ',');
	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['fecha2'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cambio'].'</td>
<td align="left" style="font-size: 8px;" bgcolor="#FCFCFC">'.$rowint['numero'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['concepto'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$h.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF">'.$s.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="30px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Cuenta</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="590px" align="left" style="font-size: 8px; " bgcolor="#FFF" colspan="6" >$row[cuenta]</td>
  </tr>
    <tr>
    <td colspan="3">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="55px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Fecha</td>
        <td width="30px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">TC</td>
        <td width="65px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cpbte</td>
		<td width="235px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Descripción</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
		<td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Saldo</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="4" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">$s</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

											} 
							}
				if($sw==0 and $std==0){
						$contador=$contador+$row['nro_reg']+3;
						if($contador<=46)	{'imprime asiento';

/**/
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
  CONVERT(VARCHAR(10),fecha,103) AS fecha2 , 
  cambio , cambiob , 
  cambiou , numero , 
  cuentan , cuentad , 
  original , bolivianos , 
  dolares , concepto , 
  glosa , tipo , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE 0 END) AS debe , 
  (CASE tipo WHEN 'HABER' THEN bolivianos ELSE 0 END) AS haber , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE -bolivianos END) AS saldo , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE 0 END) AS debed , 
  (CASE tipo WHEN 'HABER' THEN dolares ELSE 0 END) AS haberd , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE -dolares END) AS saldod , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE 0 END) AS debeu , 
  (CASE tipo WHEN 'HABER' THEN ufvs ELSE 0 END) AS haberu , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE -ufvs END) AS saldou , 
  negativo 
FROM 
    conta_asientos_det 
WHERE 
  idcuenta=".$row['idcuenta']." AND 
  fecha >='".$desde."' AND fecha<='".$hasta."' AND
  idestado=1 
ORDER BY fecha ASC,tipo ASC";	
$resultadoint=sqlsrv_query($con, $queryint);
$saldo=0;
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
	//descripción de la moneda  as TIPO_CAMBIO
	/**/
	if($moneda==1) {$dc="debe";  $hc="haber";   $sc="saldo";}
	if($moneda==2) {$dc="debed"; $hc="'haberd"; $sc="saldod";}
	if($moneda==4) {$dc="debeu"; $hc="'haberu"; $sc="saldou";}
	
	
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint[$dc], 2, '.', ',');$h='';$dt=$dt+$rowint[$dc];}
	if($rowint['tipo']=='HABER'){$h=number_format($rowint[$hc], 2, '.', ',');$d='';$ht=$ht+$rowint[$hc];}
	$saldo=$saldo+$rowint[$sc];
	
	$s=number_format($saldo, 2, '.', ',');
	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['fecha2'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cambio'].'</td>
<td align="left" style="font-size: 8px;" bgcolor="#FCFCFC">'.$rowint['numero'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['concepto'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$h.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF">'.$s.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="30px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Cuenta</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="590px" align="left" style="font-size: 8px; " bgcolor="#FFF" colspan="6" >$row[cuenta]</td>
  </tr>
    <tr>
    <td colspan="3">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="55px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Fecha</td>
        <td width="30px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">TC</td>
        <td width="65px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cpbte</td>
		<td width="235px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Descripción</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
		<td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Saldo</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="4" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">$s</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

											
											}
										else{
											$contador=0;
											$contador=$contador+$row['nro_reg']+3;
											'nueva pagina';
											$pdf->AddPage();
											'imprime asiento';
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
  CONVERT(VARCHAR(10),fecha,103) AS fecha2 , 
  cambio , cambiob , 
  cambiou , numero , 
  cuentan , cuentad , 
  original , bolivianos , 
  dolares , concepto , 
  glosa , tipo , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE 0 END) AS debe , 
  (CASE tipo WHEN 'HABER' THEN bolivianos ELSE 0 END) AS haber , 
  (CASE tipo WHEN 'DEBE' THEN bolivianos ELSE -bolivianos END) AS saldo , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE 0 END) AS debed , 
  (CASE tipo WHEN 'HABER' THEN dolares ELSE 0 END) AS haberd , 
  (CASE tipo WHEN 'DEBE' THEN dolares ELSE -dolares END) AS saldod , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE 0 END) AS debeu , 
  (CASE tipo WHEN 'HABER' THEN ufvs ELSE 0 END) AS haberu , 
  (CASE tipo WHEN 'DEBE' THEN ufvs ELSE -ufvs END) AS saldou , 
  negativo 
FROM 
    conta_asientos_det 
WHERE 
  idcuenta=".$row['idcuenta']." AND 
  fecha >='".$desde."' AND fecha<='".$hasta."' AND
  idestado=1 
ORDER BY fecha ASC,tipo ASC";	
$resultadoint=sqlsrv_query($con, $queryint);
$saldo=0;
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
	//descripción de la moneda  as TIPO_CAMBIO
	/**/
	if($moneda==1) {$dc="debe";  $hc="haber";   $sc="saldo";}
	if($moneda==2) {$dc="debed"; $hc="'haberd"; $sc="saldod";}
	if($moneda==4) {$dc="debeu"; $hc="'haberu"; $sc="saldou";}
	
	
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint[$dc], 2, '.', ',');$h='';$dt=$dt+$rowint[$dc];}
	if($rowint['tipo']=='HABER'){$h=number_format($rowint[$hc], 2, '.', ',');$d='';$ht=$ht+$rowint[$hc];}
	$saldo=$saldo+$rowint[$sc];
	
	$s=number_format($saldo, 2, '.', ',');
	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['fecha2'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cambio'].'</td>
<td align="left" style="font-size: 8px;" bgcolor="#FCFCFC">'.$rowint['numero'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['concepto'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$h.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF">'.$s.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="30px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Cuenta</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="590px" align="left" style="font-size: 8px; " bgcolor="#FFF" colspan="6" >$row[cuenta]</td>
  </tr>
    <tr>
    <td colspan="3">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="55px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Fecha</td>
        <td width="30px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">TC</td>
        <td width="65px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cpbte</td>
		<td width="235px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Descripción</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
		<td width="79px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Saldo</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="4" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">$s</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

											}
							}
					$std=0;
				}

// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('libro_diario.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+