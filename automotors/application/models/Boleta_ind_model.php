<?php

class Boleta_ind_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
    public function Combo($select=null)
    {
        $query= $this->db->query("call getPersonalTotal()");
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
    
	public function Listar($codPersonal) {
		$query = $this->db->query('call get_datospersonaltotal(?)',array($codPersonal));
		log_message('debug','Listar DatosPersonal: ' . $this->db->last_query());
		return $query->result_array();
	}

	
    public function getComboDominio($select=null,$dominio)
    {
        $query= $this->db->query("call getDominios('{$dominio}')");
        $cadena="";
        foreach($query->result_array() as  $val)
        {
            if ($val['codigo'] == $select) {
			    $cadena.='<option value="'.$val['codigo'].'" selected="true">'.$val['descripcion'].'</option>';
		    }else{
                $cadena.='<option value="'.$val['codigo'].'">'.$val['descripcion'].'</option>';
            }
        }
        return $cadena;
    }	
	
    public function getBoletaPagoIndividual($codPersonal, $gestion, $tipoPlanilla) {
		$query = $this->db->query('call get_boleta_pago_individual(?, ?, ?)',array($codPersonal, $gestion, $tipoPlanilla));
		return $query->row_array();
	}	
}
?>