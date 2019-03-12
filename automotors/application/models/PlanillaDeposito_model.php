<?php
class PlanillaDeposito_model extends CI_Model {
	
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
	
	function getPlanilla($gestion, $seccion){
		$query = $this->db->query("call get_reporte_pago_planilla (?, ?)", array($gestion, $seccion));
		return $query->result_array();
	}
}
?>