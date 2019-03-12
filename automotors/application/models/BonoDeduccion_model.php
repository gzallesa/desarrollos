<?php

class BonoDeduccion_model extends CI_Model{

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
		$query = $this->db->query('call get_bonosdeducciontotal (?)',array($codPersonal));
		//log_message('debug','Listar BonoDeduccion: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getIndividual($codBonoDeduccion) {
		$query = $this->db->query('call get_bonosdeduccionindividual (?)', array($codBonoDeduccion));
		//log_message('debug','BonoDeduccion query: ' . $this->db->last_query());
		return $query->row_array();
	}
	
    function getTipoPlanilla($codPersonal){
		$query = $this->db->query('call get_tipoplanillapersona (?)',array($codPersonal));
		//log_message('debug','BonoDeduccion tipo planilla: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getValorDeduccion($tipo){
		$query = $this->db->query('call get_valordeducccion(?)', array($tipo));
		//log_message('debug','BonoDeduccion getValorDeduccion: ' . $this->db->last_query());
		return $query->result_array();
	}
	
	public function abm($operacion,
						$cod_bono_deduccion,
						$cod_personal,
						$tipo_planilla,
						$tipo,
						$nivel,
						$descripcion,
						$periodo_inicio,
						$periodo_final,
						$monto,
						$usuario){
        $query= $this->db->query("call abm_bono_deduccion(?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, @estado, @error)",array($operacion,
																																									$cod_bono_deduccion,
																																									$cod_personal,
																																									$tipo_planilla,
																																									$tipo,
																																									$nivel,
																																									$descripcion,
																																									$periodo_inicio,
																																									$periodo_final,
																																									$monto,
																																									$usuario));
		log_message('debug','BonoDeduccion abm: ' . $this->db->last_query());
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
	}

}
?>