<?php

class Usuario_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function Index() {
        
    }

    public function get_UsuarioActual() {
        $query = $this->db->get_where('mon_usuario', array('USUARIO' => $this->session->usuario));
        return $query->row_array();
    }

//    public function listarUsuarios() {
//        $this->db->select('*');
//        $this->db->from('mon_usuario');
//        $query = $this->db->get();
//        return $query->result_array();
//    }

}
