<?php

class Almacen_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}

	public function getAlmacen($codAlmacen) {
		$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		//mysqli_next_result($this->db->conn_id);
		return $query->row_array();
	}
	
	public function actualizarUbicacion($latitud, $longitud, $usuarioModificacion, $codAlmacen) {
//        $sql="call abm_mte_almacen (?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)";
//		$query= $this->db->query("call abm_mte_almacen(?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array('D', $primary_key, '', '', '', '', '', $this->session->usuario));
        $sql="UPDATE mte_almacen SET latitud = ?, longitud = ?, usuario_modificacion = ? WHERE COD_SUCURSAL = ?; ";
        $this->db->query($sql, array($latitud, $longitud, $usuarioModificacion, $codAlmacen));
        $query = $this->db->query('select @estado,@error');
        return $query->row_array();
    }
    
    public function ComboAlmacenesTotal($select = null) {
        $query= $this->db->query("call getAlmacenes()");
        mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val) {
            if ($val['COD_SUCURSAL'] == $select) {
//			    $cadena.='<option value="'.$val['COD_SUCURSAL'].'" selected="true">'.$val['direccion'].'</option>';
			    $cadena.='<option value="'.$val['COD_SUCURSAL'].'" selected="true">'.$val['COD_SUCURSAL'].'</option>';
		    } else {
//                $cadena.='<option value="'.$val['COD_SUCURSAL'].'">'.$val['direccion'].'</option>';
                $cadena.='<option value="'.$val['COD_SUCURSAL'].'">'.$val['COD_SUCURSAL'].'</option>';
            }
        }
        return $cadena;
    }
    
    public function GetAlmacenCamionAAsignar($id) {
        //$query = $this->db->query("call getAlmacenCamionAAsignar(?)",array($id));
        $query = $this->db->query("call getAlmacenCamionAAsignar()");
        mysqli_next_result($this->db->conn_id);
        $con = $query->result_array();
        $cadena = "";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['cod_camion'].'">'.$val['cod_camion'].'</li>';
        }
        return $cadena;
    }
    
    public function GetAlmacenCamionAsignados($id) {
        $query= $this->db->query("call getAlmacenCamionAsignado(?)",array($id));
        mysqli_next_result($this->db->conn_id);
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['cod_camion'].'">'.$val['descripcion'].'</li>';
//            $cadena.='<li value="'.$val['cod_camion'].'">'.$val['cod_camion'].'</li>';
        }
        return $cadena;
    }
    
    public function GuardarAlmacenCamion($operacion, $codAlmacen, $codCamion) {
        $query= $this->db->query("call abm_camion_almacen(?, ?, ?, ?,@estado,@error)",array($operacion, $codAlmacen, $codCamion, $this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
}
?>