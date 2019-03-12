<?php

class Login_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }
    
    public function autenticar() {
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password');      
        $salida = false;
        $query = $this->db->get_where('mon_usuario', array('USUARIO' => $usuario, 'ESTADO' => 'A'));
        $q = $this->db->last_query();
        $row= $query->row_array();
        if (isset($row)) {
        	//print_r($row);
            $hash= $row['CONTRASEÑA'];
            if(sha1($password)==$hash) {
            	$date_now = date("d-m-Y");
	        	$date = date_create($row['FECHA_DESDE']);
	        	$date_desde = date_format($date,"d-m-Y");
	        	if(strtotime($date_desde) <= strtotime($date_now)) {
	        		if($row['FECHA_HASTA'] != '1970-01-01') {
						$date2 = date_create($row['FECHA_HASTA']);
	        			$date_hasta = date_format($date2,"d-m-Y");
	        			if(strtotime($date_hasta) >= strtotime($date_now)) {
	        				$salida = true;
	        			} else {
							$error = 'Fecha final de usuario vencido...';
						}
					} else {
                		$salida = true;
					}
	        	} else {
					$error = 'Usuario todavia no habilitado';
				}
            } else {
				$error = 'Password invalido';
			}
        } else {
			$error = 'No existe Usuario, o esta deshabilitado';
		}
		if(isset($error)) {
        	$row['error'] = $error;		
		}
        return array('valor'=>$salida,'datos'=>$row);
    }
}