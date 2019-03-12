<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

function fechaMenorIgualQue($fecha_ini, $fecha_fin = FALSE) {
	$CI   = & get_instance();
	if(!$fecha_fin) {
		$date_fin = date("d/m/Y");
	} else {
		$date_fin = date_create_from_format('d/m/Y', $fecha_fin);
	}
//	$CI->session->set_userdata('DH', $date_fin);
	
	$date_ini = date_create_from_format('d/m/Y', $fecha_ini);
//	$CI->session->set_userdata('DI', $date_ini);
	if($date_ini <= $date_fin) {
//		$CI->session->set_userdata('R', 'SI');
		return TRUE;
	} else {
//		$CI->session->set_userdata('R', 'NO');
		return FALSE;
	}
}
?>