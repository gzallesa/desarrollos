<?php
session_start();
include("../../../../../assets/bin/conectar.php");
include("../../../../../assets/bin/lib_general.php");
require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DATA_FIDELIS');
$pdf->SetTitle('BANECO');
$pdf->SetSubject('Reporte');
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
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 6);
// -----------------------------------------------------------------------------

$id_asiento=$_GET['asiento'];
$con=conectar_oracle();
$query=" 					SELECT 
								IDASIENTO , IDFONDO , FONDO , IDMODELO , MODELO , TIPO , 
								CAST( CONVERT(VARCHAR(10),fecha, 120)  AS VARCHAR(10)) AS FECHA2,
								CAST( CONVERT(VARCHAR(8),fecha, 108)  AS VARCHAR(8)) AS HORA2,
								CONCEPTO , NUMERO , TOTAL , IDUSUARIO , ESTADO , TIPO , ADJUNTO , ID_OPERACION , 
								CONCAT('1 $=',cast(TIPO_CAMBIO as varchar(10)),' Bs.') as TIPO_CAMBIO,
								BORRACONFIRMADO_CADF , ID_USUARIO_CONFIRMADO_CADF ,
								CAST( CONVERT(VARCHAR(10),FECHACONFIRMADO_CADF, 120)  AS VARCHAR(12)) AS FECHACONFIRMADO_CADF2 
							FROM 
								CONTA_ASIENTOS_DEF 
							WHERE 
								IDASIENTO=$id_asiento";
$respta=sqlsrv_query($con, $query);

$fila=sqlsrv_fetch_array($respta);
//print_r($fila);
$fecha=fecha_en_sp($fila['FECHA2']);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="3" width="636px">
<tr nobr="true"><th colspan="4" align="center" height="50px" valign="midle" ><h3>COMPROBANTE CONTABLE</h3><br>(expresado en bolivianos)<br><br><br></th> </tr>

<tr nobr="true">
	<td width="80px" align="left" style="font-size: 10px; font-weight: bold;" >Origen</td>
	<td width="10px" style="font-size: 10px; font-weight: bold;">:</td>
	<td width="410px">$fila[TIPO]</td> 
	<td width="136px" align="rigth" style="font-size: 10px; font-weight: bold;">Nro. :$fila[NUMERO]</td> 
</tr>
<tr nobr="true">
	<td width="80px" align="left" style="font-size: 10px; font-weight: bold;" >Fecha - Hora</td>
	<td width="10px" style="font-size: 10px; font-weight: bold;">:</td>
	<td width="410px">$fecha - $fila[HORA2]</td> 
	<td width="136px" align="rigth" style="font-size: 10px; font-weight: bold;">Ref. : Confirmado</td> 
</tr>
<tr nobr="true">
	<td align="left" style="font-size: 10px; font-weight: bold;">Tipo de cambio</td> 
	<td style="font-size: 10px; font-weight: bold;">:</td><td>$fila[TIPO_CAMBIO]</td>
	<td></td> 
</tr>
<tr nobr="true">
	<td align="left" style="font-size: 10px; font-weight: bold;">Concepto</td>
	<td style="font-size: 10px; font-weight: bold;">:</td>
	<td style="text-align:justify; " colspan="2">$fila[CONCEPTO]</td>
</tr>
</table>
<br><br><br><br>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$query="
Select 
	conta_asientos_det.idasiento, 
	con_plan_cuentas_safi.cuenta_plcs, 
	concat(con_plan_cuentas_safi.nivel0_plcs,con_plan_cuentas_safi.nivel1_plcs,con_plan_cuentas_safi.nivel2_plcs,con_plan_cuentas_safi.nivel3_plcs,
	con_plan_cuentas_safi.nivel4_plcs,con_plan_cuentas_safi.nivel5_plcs) AS cuentas,
	con_plan_cuentas_safi.descripcion_plcs, 
	conta_asientos_det.moneda,
	conta_asientos_det.tipo, 
	conta_asientos_det.original,
	conta_asientos_det.bolivianos, 
	conta_asientos_det.usuario,
	cnf_moneda.siglarept_mone
from 
	conta_asientos_det , 
	con_plan_cuentas_safi ,
	cnf_moneda  
where 
	conta_asientos_det.idcuenta=con_plan_cuentas_safi.id_plcs AND 
	conta_asientos_det.moneda=cnf_moneda.id_mone AND
	conta_asientos_det.idasiento=".$id_asiento." 
order by 
	CONTA_ASIENTOS_DET.tipo
";
$dt=$ht=0;
$resultado=sqlsrv_query($con, $query);
while($row=sqlsrv_fetch_array($resultado))
			{
	if($row['tipo']=='DEBE'){$d=number_format($row['bolivianos'], 2, ',', '.');$h='';$dt=$dt+$row['bolivianos'];}
	else if($row['tipo']=='HABER'){$h=number_format($row['bolivianos'], 2, ',', '.');$d='';$ht=$ht+$row['bolivianos'];}
	if($row['moneda']<>1){$otramoneda=number_format($row['original'], 2, ',', '.').' '.$row['siglarept_mone'];}else{$otramoneda='';}
			$x=$x.'<tr nobr="true">
<td align="center" bgcolor="#FFF">'.$row['cuentas'].'</td>
<td style="text-align:justify;" bgcolor="#FFF">'.$row['descripcion_plcs'].'</td>
<td align="rigth" bgcolor="#FCFCFC">'.$otramoneda.'</td>
<td align="rigth" bgcolor="#FFF7FF">'.$d.'</td>
<td align="rigth" bgcolor="#FAFAFA">'.$h.'</td>
</tr>';	
$preparado=$row['usuario'];
				}
				
			$dtx=number_format($dt, 2, ',', '.');
			$htx=number_format($ht, 2, ',', '.');
			$literal=ucfirst(NumeroLetra($dt))."/100 Bolivianos";
$tbl1 = <<<EOD
<table border="0" cellpadding="3" cellspacing="1" width="636px" >
<tr nobr="true">
<td width="66px"   align="center" style="font-size: 10px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Cuenta</td>
<td width="270px"  align="center" style="font-size: 10px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Descripción</td>
<td width="100px"  align="center" style="font-size: 10px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Otras monedas</td>
<td width="100px"  align="center" style="font-size: 10px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Debe</td>
<td width="100px"  align="center" style="font-size: 10px; border-bottom: 0.5px solid #000; border-top: 0.5px solid #000; font-weight: bold;" bgcolor="#FFF">Haber</td></tr>
$x
<tr nobr="true" >
<td align="center" style="font-size: 9px; border-top: 0.5px solid #000;font-weight: bold;" bgcolor="#EFEFEF" colspan="3">Total (expresado en bolivianos)</td>
<td align="rigth"  style="font-size: 9px; border-top: 0.5px solid #000;font-weight: bold;" bgcolor="#eddff2">$dtx</td>
<td align="rigth"  style="font-size: 9px; border-top: 0.5px solid #000;font-weight: bold;" bgcolor="#eae8e8">$htx</td>
</tr>
<tr nobr="true" >
<td align="LEFT" style="font-size: 9px; border-top: 0.5px solid #000; border-bottom: 0.5px solid #000; font-weight: bold;" colspan="5">Son: $literal</td>
</tr>
</table>
<br><br><br>
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');



$tbl1 = <<<EOD
<br><br><br>
<br><br><br>
<br><br>
<table border="0" cellpadding="0" cellspacing="0" width="636px" >
<tr nobr="true" >
<td align="center" style="font-size: 9px; font-weight: bold;" >___________________________</td>
<td align="center" style="font-size: 9px; font-weight: bold;">___________________________</td>
</tr>
<tr nobr="true" >
<td align="center" style="font-size: 9px; font-weight: bold;">Preparado por: $preparado</td>
<td align="center" style="font-size: 9px; font-weight: bold;">Usuario: $preparado </td>
</tr>
</table>	
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');



// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('comprobante_contable_sofi.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+