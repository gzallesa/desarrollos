<?php

if (isset($pageFormat)){
	$pdf_page_format = $pageFormat;
} else{
	$pdf_page_format = PDF_PAGE_FORMAT;
}

//log_message('debug','Format: ' . $pdf_page_format);

$pdf = new Pdf('P', PDF_UNIT, $pdf_page_format, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$title = $titulo;
$pdf->SetTitle($title);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, '');
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$pdf->SetDefaultMonospacedFont('helvetica');
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(false);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
if (isset($margin1) && isset($margin2) && isset($margin3)) {
	$pdf->SetMargins($margin1, $margin2, $margin3);
} else {
	$pdf->SetMargins(10, 15, 10);
}

//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setPageOrientation($orientation);

if (isset($font) && isset($fontSize)) {
	$pdf->SetFont($font, '', $fontSize);
} else {
	$pdf->SetFont('helvetica', '', 9);
}

$pdf->setFontSubsetting(false);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

if (isset($pageFormat)){
	$pdf->AddPage($orientation, $pdf_page_format);
} else {
	$pdf->AddPage();
}


/*$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetTitle('My Title');
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');*/
/*ob_start();
    // we can have any view part here like HTML, PHP etc
    $content = ob_get_contents();
ob_end_clean();*/
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output($nom_pdf, 'I');
?>