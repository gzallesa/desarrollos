<?php

class Comision_model extends CI_Model{

	public function __construct(){
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
		$query = $this->db->query('call get_variables_comisiones_total (?)',array($codPersonal));
		return $query->result_array();
	}

	public function getIndividual($codComision) {
		$query = $this->db->query('call get_variables_comisiones_tindividual (?)', array($codComision));
		return $query->row_array();
	}
	
	public function abm($operacion, $codComision, $codPersonal, $gestion, $tipoPlanilla, $comision, $descripcion, $monto, $usuario){
		/*try{
			$query = $this->db->query('call abm_comision_variables (?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)', array($operacion, $codComision, $codPersonal, $gestion, $tipoPlanilla, $comision, $descripcion, $monto, $usuario));
			if ($this->db->error() == null) {
				throw new Exception("Error de base de datos: " . $this->db->error());
			}
			log_message('debug','Comision abm: ' . $this->db->last_query());
			$query=$this->db->query("select @estado, @error");
			$result = $query->row_array();
		} catch (Exception $e){
			$result["@estado"] = '1';
			$result["@error"] = $e->getMessage();
		} finally{
			return $result;
		}*/
		$query = $this->db->query('call abm_comision_variables (?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)', array($operacion, $codComision, $codPersonal, $gestion, $tipoPlanilla, $comision, $descripcion, $monto, $usuario));
		log_message('debug','Comision abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>