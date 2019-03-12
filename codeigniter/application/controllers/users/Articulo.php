<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//use libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';


class Articulo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
    }
 	/**
	* Add New Articulo con API 
	* @method : POST
	* user/add
	*/   
	public function crearArticulo_post()
	{
		header("Access-Control-Allow-Origin: * ");
		
		//Load Autorizathion Token
		$this->load->library('Authorization_Token');
		
		/**
		* User Token Validation
		*/	
		$is_valid_token = $this->authorization_token->validateToken();
		//var_dump($is_valid_token);
		if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
		{
			# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
		    $_POST = $this->security->xss_clean($_POST);
		
	        # Form Validation
		    $this->form_validation->set_rules('titulo','Titulo','trim|required|max_length[50]');
		    $this->form_validation->set_rules('descripcion','Descripcion','trim|required|max_length[200]');
		    if ($this->form_validation->run() == FALSE)
		    {
		      $message = array('status' => false,
		                       'error' => $this->form_validation->error_array(),
		                       'message' => validation_errors()
		                       );
		      $this->response($message,REST_Controller::HTTP_NOT_FOUND);
		    }
		    else
		    {
		   	  //print_r($_POST); 
		   	  //llamando el articulo model
		   	  $this->load->model('articulo_model','ArticuloModel');
		   	  //print_r($is_valid_token['data']->id);exit;
		   	  $insert_data =[
		   	       'user_id' => $is_valid_token['data']->id,
		           'titulo' => $this->input->post('titulo',TRUE),
		           'descripcion' => $this->input->post('descripcion',TRUE),
		           'ucreacion' => time(),
		           'umodificacion' => time(),          	           
		      ];
		   	  //insertar 
		   	  $output = $this->ArticuloModel->crear_articulo($insert_data);
		   	  if ($output > 0 AND !empty($output)){
		       	//success 200 code send
		      	$message = [
		      	            'status' => true,
		                    'message' => "Articulo Registrado con Exito"
		      	];
			  	$this->response($message,REST_Controller::HTTP_OK);
			  } else{
		      	//Error
		      	$message = [
		      	            'status' => false,
		                    'message' => "No se Registro el Articulo"
		      	];			  	
			  	$this->response($message,REST_Controller::HTTP_NOT_FOUND);
			  }
		   	  
		    }
		}
		else
		{
			$this->response(['status' => FALSE,'message'=> $is_valid_token['message']],REST_Controller::HTTP_NOT_FOUND);
		}
	}
}