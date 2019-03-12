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
				   
				   
		 /*if($muestra==2)$wheree="AND idestado>=1 AND idmodelo<>-3 ";
	elseif($muestra==3)	$wheree="AND idestado=2 AND idmodelo=-3 ";
	elseif($muestra==4)	$wheree="AND idestado=0 ";
	else $wheree="AND idestado=1 ";*/
/*		
	if($moneda==2) $total="dolares";
elseif($moneda==4)$total="ufvs";else $total="bolivianos";
		
		if($cuenta<>0)	$wherec="AND idcuenta=$cuenta";	else $wherec="";
		if($nivel<>5){
			if($cuenta<>0){
				$padre=devolver_datos_tabla("conta_cuentas",array("s?nivel0","s?nivel1","s?nivel2","s?nivel3","s?nivel4","s?nivel5","s?nivel6"),"WHERE idcuenta=$cuenta");
				switch($nivel){
					case(0):$wherec="AND nivel0='{$padre[0]["nivel0"]}'";break;
					case(1):$wherec="AND nivel0='{$padre[0]["nivel0"]}' AND nivel1='{$padre[0]["nivel1"]}'";break;
					case(2):$wherec="AND nivel0='{$padre[0]["nivel0"]}' AND nivel1='{$padre[0]["nivel1"]}' AND nivel2='{$padre[0]["nivel2"]}'";break;
					case(3):$wherec="AND nivel0='{$padre[0]["nivel0"]}' AND nivel1='{$padre[0]["nivel1"]}' AND nivel2='{$padre[0]["nivel2"]}' AND nivel3='{$padre[0]["nivel3"]}'";break;
					case(4):$wherec="AND nivel0='{$padre[0]["nivel0"]}' AND nivel1='{$padre[0]["nivel1"]}' AND nivel2='{$padre[0]["nivel2"]}' AND nivel3='{$padre[0]["nivel3"]}' AND nivel4='{$padre[0]["nivel4"]}'";break;
				}
			}else
				$wherec="";		
		}
		

*/

ob_end_clean(); 

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
$pdf->AddPage();
//$pdf->Write(0, 'Example of HTML tables'.$query, '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
// NON-BREAKING ROWS (nobr="true")
$del=substr($desde,0,10);
$al=substr($hasta,0,10);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="3" width="636px">
<tr nobr="true"><th colspan="4" align="center" height="50px" valign="midle" ><h3>LIBRO DIARIO</h3><br>DEL $del AL $al<br><br>(expresado en $descripcionmoneda)<br><br></th></tr></table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
/////////////////////////////////////////////////////

$con=conectar_oracle();
$query="
SELECT 
	DISTINCT idasiento,
	fecha,
	count(idasiento) as nro_reg,
	convert(varchar(10),fecha,103) AS FECHA2,
	numero,
  	cambio,
  	concepto 
FROM 
	conta_asientos_det 
WHERE 
	idfondo=".$fondo." AND 
	fecha >='".$desde."' AND fecha<='".$hasta."' 
	$wheree
	$wherec
	
GROUP BY 
	idasiento, 
	fecha, 
  	numero,
  	cambio,
  	concepto
ORDER BY 
	fecha DESC";
	
$resultado=sqlsrv_query($con, $query);
$sw=1;
$contador=0;
$std=0;
while($row=sqlsrv_fetch_array($resultado))
			{$x='';	
				if($sw==1)
						{
						$contador=$contador+$row['nro_reg']+5;
						if($contador<=47)	{'imprime asiento';
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
concat(conta_asientos_det.nivel0,conta_asientos_det.nivel1,conta_asientos_det.nivel2,conta_asientos_det.nivel3,conta_asientos_det.nivel4,conta_asientos_det.nivel5) as cuentas,
conta_asientos_det.cuentad,
conta_asientos_det.original,
".$monto."
conta_asientos_det.tipo,
conta_asientos_det.moneda,
cnf_moneda.siglarept_mone
FROM 
  conta_asientos_det, cnf_moneda 
WHERE
  conta_asientos_det.idasiento=".$row['idasiento']." AND
  conta_asientos_det.moneda=cnf_moneda.id_mone
order by 
	conta_asientos_det.tipo";	
$resultadoint=sqlsrv_query($con, $queryint);
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
			
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint['valor'], 2, '.', ',');$h='';$dt=$dt+$rowint['valor'];}
	else if($rowint['tipo']=='HABER'){$h=number_format($rowint['valor'], 2, '.', ',');$d='';$ht=$ht+$rowint['valor'];}

	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentas'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentad'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$otramoneda.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FAFAFA">'.$h.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="80px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Fecha</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="70px" align="left" style="font-size: 8px; " bgcolor="#FFF">$row[FECHA2]</td>
    <td width="350px" align="left" style="font-size: 8px;" bgcolor="#FFF"></td>
    <td width="30px" align="left" style="font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro.</td>
    <td width="90px" align="left" style="font-size: 8px;" bgcolor="#FFF">$row[numero]</td>
  </tr>
  <tr>
    <td align="left" style="font-size: 8px;font-weight: bold;" >Tipo de cambio</td>
    <td style="font-size: 8px;font-weight: bold;" >:</td>
    <td style="font-size: 8px;" colspan="5" align="left">1Us es 6.86 BOB</td>
  </tr>
    <tr>
    <td colspan="6">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="60px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro</td>
        <td width="324px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cuenta</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Otra moneda</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="3" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
      </tr>
    </table>
	</td>
  </tr>

    <tr>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">Concepto</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">:</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;" colspan="4">$row[concepto]</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
											}
										else{
											$contador=0;
											$sw=0;
											$contador=$contador+$row['nro_reg']+5;
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
concat(conta_asientos_det.nivel0,'.',conta_asientos_det.nivel1,'.',conta_asientos_det.nivel2,'.',conta_asientos_det.nivel3,'.',conta_asientos_det.nivel4,'.',conta_asientos_det.nivel5) as cuentas,
conta_asientos_det.cuentad,
conta_asientos_det.original,
".$monto."
conta_asientos_det.tipo,
conta_asientos_det.moneda,
cnf_moneda.siglarept_mone
FROM 
  conta_asientos_det, cnf_moneda 
WHERE
  conta_asientos_det.idasiento=".$row['idasiento']." AND
  conta_asientos_det.moneda=cnf_moneda.id_mone
order by 
	conta_asientos_det.tipo";	
$resultadoint=sqlsrv_query($con, $queryint);
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
			
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint['valor'], 2, '.', ',');$h='';$dt=$dt+$rowint['valor'];}
	else if($rowint['tipo']=='HABER'){$h=number_format($rowint['valor'], 2, '.', ',');$d='';$ht=$ht+$rowint['valor'];}

	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentas'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentad'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$otramoneda.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FAFAFA">'.$h.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="80px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Fecha</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="70px" align="left" style="font-size: 8px; " bgcolor="#FFF">$row[FECHA2]</td>
    <td width="350px" align="left" style="font-size: 8px;" bgcolor="#FFF"></td>
    <td width="30px" align="left" style="font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro.</td>
    <td width="90px" align="left" style="font-size: 8px;" bgcolor="#FFF">$row[numero]</td>
  </tr>
  <tr>
    <td align="left" style="font-size: 8px;font-weight: bold;" >Tipo de cambio</td>
    <td style="font-size: 8px;font-weight: bold;" >:</td>
    <td style="font-size: 8px;" colspan="5" align="left">1Us es 6.86 BOB</td>
  </tr>
    <tr>
    <td colspan="6">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="60px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro</td>
        <td width="324px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cuenta</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Otra moneda</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="3" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
      </tr>
    </table>
	</td>
  </tr>

    <tr>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">Concepto</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">:</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;" colspan="4">$row[concepto]</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

											} 
							}
				if($sw==0 and $std==0){
						$contador=$contador+$row['nro_reg']+5;
						if($contador<=56)	{'imprime asiento';

/**/
/////////////////////////////////////////////////////////////////
			$dtx=0;
			$htx=0;
			$dt=0;
			$ht=0;
$queryint="
SELECT 
concat(conta_asientos_det.nivel0,'.',conta_asientos_det.nivel1,'.',conta_asientos_det.nivel2,'.',conta_asientos_det.nivel3,'.',conta_asientos_det.nivel4,'.',conta_asientos_det.nivel5) as cuentas,
conta_asientos_det.cuentad,
conta_asientos_det.original,
".$monto."
conta_asientos_det.tipo,
conta_asientos_det.moneda,
cnf_moneda.siglarept_mone
FROM 
  conta_asientos_det, cnf_moneda 
WHERE
  conta_asientos_det.idasiento=".$row['idasiento']." AND
  conta_asientos_det.moneda=cnf_moneda.id_mone
order by 
	conta_asientos_det.tipo";	
$resultadoint=sqlsrv_query($con, $queryint);
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
			
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint['valor'], 2, '.', ',');$h='';$dt=$dt+$rowint['valor'];}
	else if($rowint['tipo']=='HABER'){$h=number_format($rowint['valor'], 2, '.', ',');$d='';$ht=$ht+$rowint['valor'];}

	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentas'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentad'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$otramoneda.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FAFAFA">'.$h.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="80px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Fecha</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="70px" align="left" style="font-size: 8px; " bgcolor="#FFF">$row[FECHA2]</td>
    <td width="350px" align="left" style="font-size: 8px;" bgcolor="#FFF"></td>
    <td width="30px" align="left" style="font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro.</td>
    <td width="90px" align="left" style="font-size: 8px;" bgcolor="#FFF">$row[numero]</td>
  </tr>
  <tr>
    <td align="left" style="font-size: 8px;font-weight: bold;" >Tipo de cambio</td>
    <td style="font-size: 8px;font-weight: bold;" >:</td>
    <td style="font-size: 8px;" colspan="5" align="left">1Us es 6.86 BOB</td>
  </tr>
    <tr>
    <td colspan="6">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="60px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro</td>
        <td width="324px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cuenta</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Otra moneda</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="3" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
      </tr>
    </table>
	</td>
  </tr>

    <tr>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">Concepto</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">:</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;" colspan="4">$row[concepto]</td>
  </tr>
</table>
<br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

											
											}
										else{
											$contador=0;
											$contador=$contador+$row['nro_reg']+5;
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
concat(conta_asientos_det.nivel0,'.',conta_asientos_det.nivel1,'.',conta_asientos_det.nivel2,'.',conta_asientos_det.nivel3,'.',conta_asientos_det.nivel4,'.',conta_asientos_det.nivel5) as cuentas,
conta_asientos_det.cuentad,
conta_asientos_det.original,
".$monto."
conta_asientos_det.tipo,
conta_asientos_det.moneda,
cnf_moneda.siglarept_mone
FROM 
  conta_asientos_det, cnf_moneda 
WHERE
  conta_asientos_det.idasiento=".$row['idasiento']." AND
  conta_asientos_det.moneda=cnf_moneda.id_mone
order by 
	conta_asientos_det.tipo";	
$resultadoint=sqlsrv_query($con, $queryint);
while($rowint=sqlsrv_fetch_array($resultadoint))
			{
			
	if($rowint['tipo']=='DEBE'){$d=number_format($rowint['valor'], 2, '.', ',');$h='';$dt=$dt+$rowint['valor'];}
	else if($rowint['tipo']=='HABER'){$h=number_format($rowint['valor'], 2, '.', ',');$d='';$ht=$ht+$rowint['valor'];}

	if($rowint['moneda']<>$moneda){$otramoneda=number_format($rowint['original'], 2, '.', ',').' '.$rowint['siglarept_mone'];}else{$otramoneda='';}

			$x=$x.'<tr nobr="true">
<td align="center" style="font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentas'].'</td>
<td style="text-align:justify;font-size: 8px;" bgcolor="#FFF">'.$rowint['cuentad'].'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FCFCFC">'.$otramoneda.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" style="font-size: 8px;" bgcolor="#FAFAFA">'.$h.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
			$dtx=number_format($dt, 2, '.', ',');
			$htx=number_format($ht, 2, '.', ',');
/////////////////////////////////////////////////////////////////						
						$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="630px" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="80px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Fecha</td>
    <td width="10px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">:</td>
    <td width="70px" align="left" style="font-size: 8px; " bgcolor="#FFF">$row[FECHA2]</td>
    <td width="350px" align="left" style="font-size: 8px;" bgcolor="#FFF"></td>
    <td width="30px" align="left" style="font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro.</td>
    <td width="90px" align="left" style="font-size: 8px;" bgcolor="#FFF">$row[numero]</td>
  </tr>
  <tr>
    <td align="left" style="font-size: 8px;font-weight: bold;" >Tipo de cambio</td>
    <td style="font-size: 8px;font-weight: bold;" >:</td>
    <td style="font-size: 8px;" colspan="5" align="left">1Us es 6.86 BOB</td>
  </tr>
    <tr>
    <td colspan="6">
	<table border="0" cellpadding="2" cellspacing="1" align="center" width="630px">
	<thead>
      <tr>
        <td width="60px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro</td>
        <td width="324px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Cuenta</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Otra moneda</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Debe</td>
        <td width="80px" align="center" style="border-bottom: 0.2px solid #aaa;border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#FFF">Haber</td>
      </tr>
	</thead>
      $x
	  <tr>
        <td colspan="3" align="center" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#EFEFEF">Total (expresado en $descripcionmoneda)</td>
        <td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
		<td align="right" style="border-top: 0.2px solid #aaa;font-size: 8px;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
      </tr>
    </table>
	</td>
  </tr>

    <tr>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">Concepto</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;font-weight: bold;">:</td>
    <td align="left" bgcolor="#FFF" style="border-top: 0.2px solid #aaa;border-bottom: 0.2px solid #aaa;font-size: 8px;" colspan="4">$row[concepto]</td>
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