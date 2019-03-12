<?php

class Falta_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
    public function Combo($select=null)
    {
        $query= $this->db->query("call getPersonalTotal()");
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
    function getTipoPlanilla($codPersonal){
		$query = $this->db->query('call get_tipoplanillapersona (?)',array($codPersonal));
		log_message('debug','Falta tipo planilla: ' . $this->db->last_query());
		return $query->result_array();
	}
    
	public function Listar($codPersonal) {
		$query = $this->db->query('call get_diasfaltatotal (?)',array($codPersonal));
		log_message('debug','Falta Dias Listar: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getIndividual($codDiaFalta) {
		$query = $this->db->query('call get_diasfaltaindividual(?)', array($codDiaFalta));
		return $query->row_array();
	}
	
	public function abm($operacion, $codDiaFalta, $codPersonal, $tipoPlanilla, $descripcion, $periodo, $valor, $usuario){
		
		$query = $this->db->query("call abm_dias_falta(?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, @estado, @error)", array($operacion, $codDiaFalta, $codPersonal, $tipoPlanilla, $descripcion, $periodo, $valor, $usuario));
		log_message('debug','Falta Dias abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>