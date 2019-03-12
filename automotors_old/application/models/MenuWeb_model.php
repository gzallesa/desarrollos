<?php

class MenuWeb_model extends CI_Model{

	public function __construct(){
		$this->load->database();
		
	}

	public function Lista(){
		$query=$this->db->query("call getMenuWebTotal()");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function Lista_Padre(){
		$query=$this->db->query("select * from mon_menu_web where MENU_PADRE is null and ESTADO='A'");
		return $query->result_array();
	}
	
	public function Get_menu($id){
		$sql = "call getMenuWebIndividual(?)";
		$query = $this->db->query($sql, array($id));
		mysqli_next_result($this->db->conn_id);
		return $query->row_array();
	}

	public function Abm($datos){
		$sql="call abm_menu_web (?,?,?,?,?,?,@estado, @error)";
		$this->db->query($sql,$datos);
		$query = $this->db->query('select @estado,@error');
		return $query->row_array();
	}

	public function GetMenuUsuario($usuario) {
		$sql = "select NOMBRE_MENU, DESCRIPCION, NOMBRE_MENU_PADRE, MENU, ROL_MENU_WEB from vw_getMenusUsuarios where USUARIO=?";
		$query = $this->db->query($sql,array($usuario));
		return $query->result_array();
	}
}