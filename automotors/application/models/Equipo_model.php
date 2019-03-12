<?php

class Equipo_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
	public function Listar() {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getEquipoTotal()');
		//mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function getIndividual($codEquipo) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getEquipoIndividual(?)', array($codEquipo));
		//mysqli_next_result($this->db->conn_id);
		log_message('debug','query: ' . $this->db->last_query());
		return $query->row_array();
	}
	
	public function abm($operacion, $codEquipo, $tipoEquipo, $marca, $descripcion, $observacion, $serie, $tipo, $proveedor, $moneda, $valor, $fechaRegistro, $usuario){
		$query = $this->db->query("call abm_equipo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, @estado, @error)", array($operacion, $codEquipo, $tipoEquipo, $marca, $descripcion, $observacion, $serie, $tipo, $proveedor, $moneda, $valor, $fechaRegistro, $usuario));
		log_message('debug','Equipo abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

	public function getProveedor(){
		$query = $this->db->query('call getProveedor()', array());
		return $query->result_array();
	}
}
?>