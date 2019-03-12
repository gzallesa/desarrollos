<?php

class ComprobanteEgreso_model extends CI_Model{

	public function __construct(){
	}
    
	public function Listar() {
		$query = $this->db->query('call get_comprobanteEgresoTotal()');
		return $query->result_array();
	}

	public function getIndividual($nroComprobante) {
		$query = $this->db->query('call get_comprobanteEgresoIndividual(?)', array($nroComprobante));
		log_message('debug','Comprobante Egreso query: ' . $this->db->last_query());
		return $query->row_array();
	}

	public function getCheque($nroComprobante) {
		$query = $this->db->query('call get_comprobanteEgresoCheque(?)', array($nroComprobante));
		log_message('debug','Comprobante Egreso cheque query: ' . $this->db->last_query());
		return $query->row_array();
	}

	public function abm($operacion, $nroComprobante, $ordenDe, $nitCi, $concepto, $banco, $montoPagar, $fechaRegistro, $usuario){
		$query = $this->db->query("call abm_comprobante_egreso(?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, @estado, @error)", array($operacion, $nroComprobante, $ordenDe, $nitCi, $concepto, $banco, $montoPagar, $fechaRegistro, $usuario));
		log_message('debug','Comprobante Egreso abm: ' . $this->db->last_query());
		$query=$this->db->query("select @estado, @error");
		return $query->row_array();
	}

}
?>