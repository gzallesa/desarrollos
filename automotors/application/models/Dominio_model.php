<?php
Class Dominio_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
    public function comboDominios($select=null)
    {
        $dominios= $this->listaDominios();
        //mysqli_next_result($this->db->conn_id);
        $cadena="";
        //foreach($query->result_array() as  $val)
        foreach($dominios as  $val)
        {
            if ($val['DOMINIO'] == $select) {
			    $cadena.='<option value="'.$val['DOMINIO'].'" selected="true">'.$val['DOMINIO'].'</option>';
		    }else{
                $cadena.='<option value="'.$val['DOMINIO'].'">'.$val['DOMINIO'].'</option>';
            }
        }
        return $cadena;
    }
    
	public function listaDominios() {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call get_listadodominios()');
		//mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function listaDetalleDominio($dominio) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call get_dominiototal(?)',array($dominio));
		//mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function getIndividual($dominio, $codigo) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call get_dominioindividual(?, ?)', array($codigo, $dominio));
		//mysqli_next_result($this->db->conn_id);
		log_message('debug','Dominio query: ' . $this->db->last_query());
		return $query->row_array();
	}
	
	public function abm($operacion, $dominio, $codigo, $descripcion, $usuario){
		$query = $this->db->query('call abm_dominios(?, ?, ?, ?, ?, @estado, @error)', array($operacion, $dominio, $codigo, $descripcion, $usuario));
		log_message('debug','Dominio abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>