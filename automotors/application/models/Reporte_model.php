<?php

class Reporte_model extends CI_Model {
	
    public function __construct() {
		$this->load->database();
		//$this->CI =& get_instance();
		//$this->Data = '';
	    //$this->ResultSet = array();
	    //$this->mysqli = $this->db->conn_id;
	}
	
	public function cargarMeses() {
        $result = $this->db->query("SELECT descripcion AS label, descripcion AS value FROM mon_dominio WHERE dominio = 'MES';");
        //mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
    
    public function cargarUnidadVenta() {
        $result = $this->db->query("SELECT codigo AS label, codigo AS value FROM mon_dominio WHERE dominio = 'UNINEG';");
        //mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
    
    public function cargarEje() {
        $result = $this->db->query("SELECT usuario AS label, usuario AS value FROM mte_personal WHERE estado = 'A' and cargo = 'EJE';");
        //mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
    
    public function runCargarAuxiliarConsolidado($entidad, $valor, $operacion) {
        $result = $this->db->query("call putCargaAuxiliarConsolidado(?, ?, ?, ?)", array($this->session->usuario, $entidad, $valor, $operacion));
    }
    
    public function limpiarTemporal($entidad) {
        $result = $this->db->query("DELETE FROM pre_tmp_axiliar_consolidado WHERE usuario = ? AND entidad = ?;", array($this->session->usuario, $entidad));
    }
    
    /*public function runConsolidadoPresupuestado($gestion, $mes, $unineg, $vendedor) {
        if (mysqli_multi_query($this->mysqli, $SqlCommand)) {
	        $i=0;
	        do {
	             if ($result = $this->mysqli->store_result()) 
	             {
	                while ($row = $result->fetch_assoc())
	                {
	                    $this->Data[$i][] = $row;
	                }
	                mysqli_free_result($result);
	             }
	            $i++; 
	        }
	        while ($this->mysqli->next_result());
	    }
	    return $this->Data;
    }*/
    
    public function runConsolidadoPresupuestado1($gestion, $mes, $unineg, $vendedor) {
    	echo $gestion .':'. $mes .':'. $unineg .':'. $vendedor;
        $result = $this->db->query("call pr_reporteConsolidadoPresupuestado_1(?, ?, ?, ?, ?)", array($this->session->usuario, $gestion, $mes, $unineg, $vendedor));
        mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
    
    public function runConsolidadoPresupuestado2($gestion, $mes, $unineg, $vendedor) {
        $result = $this->db->query("call pr_reporteConsolidadoPresupuestado_2(?, ?, ?, ?, ?)", array($this->session->usuario, $gestion, $mes, $unineg, $vendedor));
        mysqli_next_result($this->db->conn_id);
        return $result->result_array();
    }
}
?>