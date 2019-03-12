<?php

class DatosPersonal_model extends CI_Model{

	public function __construct(){
		//$this->load->database();
	}
    
    public function Combo($select=null)
    {
        $query= $this->db->query("call getPersonalTotal()");
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
		$query = $this->db->query('call get_datospersonaltotal(?)',array($codPersonal));
		log_message('debug','Listar DatosPersonal: ' . $this->db->last_query());
		return $query->result_array();
	}

	public function getIndividual($codPersonalPlanilla) {
		$query = $this->db->query('call get_datospersonalindividual(?)', array($codPersonalPlanilla));
		log_message('debug','DatosPersonal query: ' . $this->db->last_query());
		return $query->row_array();
	}
	
	public function getCentroGestion($divisionNegocio){
		$query = $this->db->query('call getCentroGestion(?)', array($divisionNegocio));
		log_message('debug','DatosPersonal getCentroGestion: ' . $this->db->last_query());
		return $query->result_array();
	}
	
	public function abm($operacion,
						$cod_personal_planilla,
						$cod_personal,
						$division_negocio,
						$centro_gestion,
						$fecha_ingreso,
						$fecha_salida,
						$sueldo_basico,
						$fecha_nacimiento,
						$tipo_documento,
						$numero_documento,
						$expedido,
						$matricula,
						$afp,
						$desc_afp,
						$tipo_planilla,
						$tipo_empleado,
						$cuenta,
						$excepcionado,
						$pago_aguinaldo,
						$usuario_reg){
        $query= $this->db->query("call abm_personal_datos(?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @estado, @error)",array($operacion,
																																									$cod_personal_planilla,
																																									$cod_personal,
																																									$division_negocio,
																																									$centro_gestion,
																																									$fecha_ingreso,
																																									$fecha_salida,
																																									$sueldo_basico,
																																									$fecha_nacimiento,
																																									$tipo_documento,
																																									$numero_documento,
																																									$expedido,
																																									$matricula,
																																									$afp,
																																									$desc_afp,
																																									$tipo_planilla,
																																									$tipo_empleado,
																																									$cuenta,
																																									$excepcionado,
																																									$pago_aguinaldo,
																																									$usuario_reg));
		log_message('debug','DatosPersonal abm: ' . $this->db->last_query());
        $query=$this->db->query("select @estado, @error");
        return $query->row_array();
	}

}
?>