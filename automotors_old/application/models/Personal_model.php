<?php

class Personal_model extends CI_Model{

	public function __construct(){
	}

	public function getPersonal($codPersonal) {
		$query = $this->db->query("SELECT * FROM mte_personal mta WHERE mta.COD_PERSONAL = ? ", array($codPersonal));
		//mysqli_next_result($this->db->conn_id);
		return $query->row_array();
	}
	
	public function actualizarUbicacion($latitud, $longitud, $usuarioModificacion, $codPersonal) {
//        $sql="call abm_mte_almacen (?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)";
//		$query= $this->db->query("call abm_mte_almacen(?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', '', '', '', $this->session->usuario));
        $sql="UPDATE mte_personal SET latitud = ?, longitud = ?, usuario_modificacion = ? WHERE cod_personal = ?; ";
        $this->db->query($sql, array($latitud, $longitud, $usuarioModificacion, $codPersonal));
        $query = $this->db->query('select @estado,@error');
        return $query->row_array();
    }
    
    public function GuardarEncargadoAlmacen($operacion, $codPersonal, $codAlmacen) {
        $query= $this->db->query("call abm_encargado_almacen(?, ?, ?, ?, @estado, @error)",array($operacion, $codAlmacen, $codPersonal, $this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function ComboAlmacenTotal($select = null) {
        $query= $this->db->query("call getAlmacenes()");
        mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val) {
            if ($val['cod_almacen'] == $select) {
			    $cadena.='<option value="'.$val['cod_almacen'].'" selected="true">'.$val['direccion'].'</option>';
		    } else {
                $cadena.='<option value="'.$val['cod_almacen'].'">'.$val['direccion'].'</option>';
            }
        }
        return $cadena;
    }
    
    public function GetEncargadoAlmacenAAsignar($id) {
        $query = $this->db->query("call getEncargadoAlmacenAAsignar ()");
        mysqli_next_result($this->db->conn_id);
        $con = $query->result_array();
        $cadena = "";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['cod_personal'].'">'.$val['nombre_completo'].'</li>';
        }
        return $cadena;
    }
    
    public function GetEncargadoAlmacenAsignados($id) {
        $query= $this->db->query("call getEncargadoAlmacenAsignado(?)", array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['cod_personal'].'">'.$val['nombre_completo'].'</li>';
        }
        return $cadena;
    }
}
?>