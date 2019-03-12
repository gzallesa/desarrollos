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

// lista desde dominios
	function getListaDominio($dominio) {
		$CI =& get_instance();
		$query = $CI->db->query('call getDominios(?)', array($dominio));
		return $query->result_array();
	}

// Lista de Personal
    function Combo($select=null)
    	{$CI =& get_instance();
        $query= $CI->db->query("call getPersonalTotal()");
        //mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val)
        {
            if ($val['cod_personal'] == $select) {
			    $cadena.='<option value="'.$val['cod_personal'].'" selected="true">'.$val['nombre_completo'].'</option>';
		    }else{
                $cadena.='<option value="'.$val['cod_personal'].'">'.$val['nombre_completo'].'</option>';
            }
        }
        return $cadena;
    }

	function tcpdf()
	{
	    require_once('tcpdf/tcpdf.php');
	}

?>