<?php
class PlanillaCMO_model extends CI_Model {
	
	function __construct() {
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
	
	function getPlanilla($gestion, $usuario){
		$query = $this->db->query("call get_cmototal(?, ?, @estado, @error)", array($gestion, $usuario));
		//log_message('debug','getPlanilla: ' . $this->db->last_query());
		$planilla = $query->result_array();
		$query = $this->db->query('select @estado,@error');
		$resp = $query->row_array();
		if ($resp["@estado"] == "1") {
			return $resp;
		}
		return $planilla;
	}

}
?>