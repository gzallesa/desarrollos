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
//orientacion
$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
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
$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
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
<table border="0" cellpadding="1" cellspacing="3" width="auto">
<tr nobr="true"><th><h3>LIMITES SEGÚN POLITICA DE INVERSIONES - FIDEICOMISO
</h3><br><br></th></tr></table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, 'C');
/////////////////////////////////////////////////////

$con=conectar_oracle();
$query="";	

/////////////////////////////////////////////////////////////////						
/*$tbl=<<<EOD
<table border="0" cellpadding="0" cellspacing="0" align="center" width="auto" style="border: 0.2px solid #aaa;">
 <tr>
    <td width="80px" align="left" style="font-size: 8px; font-weight: bold;" bgcolor="#FFF">Fecha</td>
    <td width="80px" bgcolor="#FFF" style="font-size: 8px; font-weight: bold;">: </td>    
    <td width="30px" align="left" style="font-size: 8px;font-weight: bold;" bgcolor="#FFF">Nro.</td>
    <td width="90px" align="left" style="font-size: 8px;" bgcolor="#FFF"></td>
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
$pdf->writeHTML($tbl, true, false, false, false, 'C');*/

/*	aca */										
/////////////////////////////////////////////////////////////////
			
// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('libro_diario.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+