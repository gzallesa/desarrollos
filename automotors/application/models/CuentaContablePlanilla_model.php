<?php
class CuentaContablePlanilla_model extends CI_Model{

	public function __construct(){
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

	public function Listar($gestion) {
		$query = $this->db->query('call get_cabecera_cta_planilla  (?)',array($gestion));
		//log_message('debug','Listar BonoDeduccion: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getIndividual($gestion, $planilla) {
		$query = $this->db->query('call get_cabecera_cta_planilla_desc  (?, ?)', array($gestion, $planilla));
		//log_message('debug','BonoDeduccion query: ' . $this->db->last_query());
		return $query->result_array();
	}


}
?>