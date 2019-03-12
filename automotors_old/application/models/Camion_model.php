<?php

class Camion_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
	
	public function ComboCamionesTotal($select = null) {
        $query= $this->db->query("call getCamiones()");
        mysqli_next_result($this->db->conn_id);
        $cadena="";
        foreach($query->result_array() as  $val) {
            if ($val['cod_camion'] == $select) {
//			    $cadena.='<option value="'.$val['cod_almacen'].'" selected="true">'.$val['direccion'].'</option>';
			    $cadena.='<option value="'.$val['cod_camion'].'" selected="true">'.$val['cod_camion'].'</option>';
		    } else {
//                $cadena.='<option value="'.$val['cod_almacen'].'">'.$val['direccion'].'</option>';
                $cadena.='<option value="'.$val['cod_camion'].'">'.$val['cod_camion'].'</option>';
            }
        }
        return $cadena;
    }
    
    public function GuardarCamionChofer($operacion, $codCamion, $codChofer) {
        $query= $this->db->query("call abm_camion_chofer(?, ?, ?, ?,@estado,@error)",array($operacion, $codChofer, $codCamion, $this->session->usuario));
        //mysqli_next_result($this->db->conn_id);
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
    }
    
    public function GetCamionChoferAAsignar($id) {
        $query = $this->db->query("call getChoferCamionAAsignar()");
        mysqli_next_result($this->db->conn_id);
        $con = $query->result_array();
        $cadena = "";
        foreach($con as  $val) {
            $cadena.='<li value="'.$val['cod_personal'].'">'.$val['nombre_completo'].'</li>';
        }
        return $cadena;
    }
    
    public function GetCamionChoferAsignados($id) {
        $query= $this->db->query("call getChoferCamionAsignados(?)", array($id));
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