<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo_model extends CI_Model
{
	protected $articulo_table = 'bam_articulos';
	
	public function crear_articulo(array $data)
	{
		$this->db->insert($this->articulo_table,$data);
		return $this->db->insert_id();
	}
}