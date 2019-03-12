<?php

class Proveedor_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
	public function Listar() {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getProvvedoeTotal()');
		//mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function getIndividual($codProveedor) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getProvvedoeIndividual(?)', array($codProveedor));
		//mysqli_next_result($this->db->conn_id);
		log_message('debug','query: ' . $this->db->last_query());
		return $query->row_array();
	}
	
	public function abm($operacion, $codProveedor, $razonSocial, $contacto, $especialidad, $descripcion, $observacion, $nit, $direccion, $latitud, $longitud, $telefonoFijo, $telefonoCelular, $usuario){
		$query = $this->db->query('call abm_proveedor(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)', array($operacion, $codProveedor, $razonSocial, $contacto, $especialidad, $descripcion, $observacion, $nit, $direccion, $latitud, $longitud, $telefonoFijo, $telefonoCelular, $usuario));
		log_message('debug','abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>