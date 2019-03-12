<?php

class Acceso_model extends CI_Model{

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
    
	public function Listar($codPersonal) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getAccesoTotal(?)',array($codPersonal));
		//mysqli_next_result($this->db->conn_id);
		log_message('debug','Acceso getAccesoTotal: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getIndividual($codAcceso) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getAccesoIndividual(?)', array($codAcceso));
		//mysqli_next_result($this->db->conn_id);
		log_message('debug','Acceso getIndividual: ' . $this->db->last_query());
		return $query->row_array();
	}
	
	public function abm($operacion, $codAcceso, $codPersonal, $acceso, $valor, $usuario){
		$query = $this->db->query('call abm_acceso(?, ?, ?, ?, ?, ?, @estado, @error)', array($operacion, $codAcceso, $codPersonal, $acceso, $valor, $usuario));
		log_message('debug','Acceso abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>