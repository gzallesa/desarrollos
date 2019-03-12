<?php

class PersonalEquipo_model extends CI_Model{

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
		$query = $this->db->query('call getEquipoPeronalIndividual(?)',array($codPersonal));
		//mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}

	public function getIndividual($codPersonalEquipo) {
		//$query = $this->db->query("SELECT * FROM mte_almacen mta WHERE mta.COD_SUCURSAL = ? ", array($codAlmacen));
		$query = $this->db->query('call getEquipoPeronalIndividualInd(?)', array($codPersonalEquipo));
		//mysqli_next_result($this->db->conn_id);
		return $query->row_array();
	}

	public function getAsignado($codPersonal) {
		$query = $this->db->query('call getEquipoPersonalAsignado(?)', array($codPersonal));
        //mysqli_next_result($this->db->conn_id);
        log_message('debug','Personal_Equipo getAsignado: ' . $this->db->last_query());
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['cod_personal_equipo'].'">'.$val['Descripcion'].'</li>';
        }

        return $cadena;
    }	

	public function getAAsignar($tipoEquipo, $marca) {
		$query = $this->db->query('call getEquipoPersonalAAsignar(?, ?)', array($tipoEquipo, $marca));
        log_message('debug','Personal_Equipo getAAsignar: ' . $this->db->last_query());
        $con= $query->result_array();
        $cadena="";
        foreach($con as  $val)
        {
            $cadena.='<li value="'.$val['cod_equipo'].'">'.$val['Descripcion'].'</li>';
        }

        return $cadena;
    }	

	public function abm($operacion, $codPersonalEquipo, $codEquipo, $codPersonal, $nombreEquipo, $descripcion, $observacion, $usuario){
		$query = $this->db->query('call abm_equipo_personal(?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)', array($operacion, $codPersonalEquipo, $codEquipo, $codPersonal, $nombreEquipo, $descripcion, $observacion, $usuario));
		log_message('debug','Personal_Equipo abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}
	
	public function getDetalleReporteAsignacion($codPersonal){
		$query = $this->db->query('call getDetalleReporteAsignacion(?)', array($codPersonal));
		log_message('debug','Personal_Equipo getDetalleReporteAsignacion: ' . $this->db->last_query());
		return $query->result_array();
	}
	
	public function getCabeceraReporteAsignacion($codPersonal){
		$query = $this->db->query('call getCabeceraReporteAsignacion(?)', array($codPersonal));
		log_message('debug','Personal_Equipo getCabeceraReporteAsignacion: ' . $this->db->last_query());
		return $query->result_array();
	}
	
}
?>