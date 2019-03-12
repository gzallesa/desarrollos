<?php

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->library('vista');
    }
    
    public function index() {
        if($this->session->has_userdata('logged_in')) {
            $this->vista->SetView("inicio_vista");
        } else
            $this->vista->SetLogin();
    }

    public function login() {
        //$password=password_hash($password, PASSWORD_DEFAULT);
        if( $this->session->has_userdata("logged_in")) {
            $this->vista->SetView("inicio_vista");
        } else {
        	$result = $this->Login_model->autenticar();
			if($result['valor']) {
	            $this->load->model('menuweb_model');
	            $newdata = array(
	                'usuario'  => $this->input->post('usuario'),
	                'logged_in' => TRUE,
	                'nombre' => $result['datos']['NOMBRE_COMPLETO'],
	                'menu' => $menu_usuario = $this->menuweb_model->GetMenuUsuario($this->input->post('usuario'))
	            );
	            $this->session->set_userdata($newdata);
	            $this->vista->SetView("inicio_vista");
	        } else {
	        	$data['error'] = $result['datos']['error'];
	            $this->vista->SetLogin($data);
	        }
		}
    }
    
    public function salir() {
        $this->session->unset_userdata(array('usuario','logged_in','nombre','menu'));
        $this->session->sess_destroy();
        $this->vista->SetLogin();
    }
}