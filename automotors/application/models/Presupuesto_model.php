<?php

class Presupuesto_model extends CI_Model {
	
    public function __construct() {
		$this->load->database();
		//$this->CI =& get_instance();
		//$this->Data = '';
	    //$this->ResultSet = array();
	    //$this->mysqli = $this->db->conn_id;
	}
	
	public function cargarItem($periodo) {
        $result = $this->db->query("SELECT distinct cod_item  FROM pre_presupuesto_gestion WHERE gestion = ? ", array($periodo));
        //mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
    
    public function getPresupuestadoTotalNivel1($vendedor, $gestion, $codItem) {
        //$query = $this->db->query("call getAlmacenCamionAAsignar(?)",array($id));
        $query = $this->db->query("call getPresupuestadoTotalNivel1(?, ?, ?)", array($vendedor, $gestion, $codItem));
        mysqli_next_result($this->db->conn_id);
        return $query->result_array();
    }
}
?>