<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//use libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';


class Users extends REST_Controller {
	
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //load User Model
        $this->load->model('User_model','UserModel');
        //$this->methods['add_users_post']['limit'] = 500; // 500 requests per hour per user/key
        //$this->methods['fetch_all_users_get']['limit'] = 100; // 100 requests per hour per user/key        
    }
	
	
	/**
	* Add New User 
	* @method : POST
	* user/add
	*/
	public function add_users_post()
	{
		header("Access-Control-Allow-Origin: * ");
		
		# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
		$_POST = $this->security->xss_clean($_POST);
		
	    # Form Validation
		//$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname','Full Name','trim|required|max_length[50]');
		$this->form_validation->set_rules('username','Username','trim|required|is_unique[bam_usuarios.username]|alpha_numeric|max_length[20]',array('is_unique'=>'%s ya Existente'));
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]|is_unique[bam_usuarios.email]',array('is_unique'=>'%s ya Existente'));
		$this->form_validation->set_rules('password','Password','trim|required|max_length[200]');
		   if ($this->form_validation->run() == FALSE)
		   {
		      //$this->load->view('myform');
		      //echo "Validacion con errores";
		      $message = array('status' => false,
		                       'error' => $this->form_validation->error_array(),
		                       'message' => validation_errors()
		                       );
		      //print_r($message);                
		      $this->response($message,REST_Controller::HTTP_NOT_FOUND);
		   }
		   else
		   {
		   		//Load Autorizathion Token
		      	$this->load->library('Authorization_Token');
		      	
		      	//Generate Token
		      	//$token_data['user_id'] = $output->id;
		      	//$token_data['fullname'] = $output->fullname;
		      	//$token_data['username'] = $output->username;
		      	//$token_data['email'] = $output->email;
		      	//$token_data['insert'] = $output->insert;
		      	//$token_data['update'] = $output->update;
		      	//$token_data['time'] = time();
		      	
		      	//$user_token = $this->authorization_token->generateToken($token_data);
		      	
		      	//print_r($this->authorization_token->userData());
		      	//exit;
		      	
		      //$this->load->view('formsuccess');	
		      //echo "Validacion sin errores";
		      //print_r($_POST);
		      $insert_data =[
		           'fullname' => $this->input->post('fullname',TRUE),
		           'email' => $this->input->post('email',TRUE),
		           'username' => $this->input->post('username',TRUE),
		           'password' => md5($this->input->post('password',TRUE)),	
		           'insert' => time(),
		           'update' => time(),		           	           
		      ];
		      //print_r($insert_data);
		      
		      // insert user in database
		      $output = $this->UserModel->insert_user($insert_data);
		      //var_dump($output);
		      if ($output > 0 AND !empty($output)){
		      	
		      	//success 200 code send
		      	$message = [
		      	            'status' => true,
		                    'message' => "User Registrado con Exito"
		      	];
			  	$this->response($message,REST_Controller::HTTP_OK);
			  } else{
		      	//Error
		      	$message = [
		      	            'status' => false,
		                    'message' => "No se Registro la Cuenta"
		      	];			  	
			  	$this->response($message,REST_Controller::HTTP_NOT_FOUND);
			  }
		   }
		
		//print_r($data);
		//echo "Usuario Registrado";
	}
	
	/**
	* Fetch All User Data
	* @method : GET
	*/	
	public function fetch_all_users_get()
	{
		header("Access-Control-Allow-Origin: * ");
		//Load Autorizathion Token
		$this->load->library('Authorization_Token');
		
		$is_valid_token = $this->authorization_token->validateToken();
		//var_dump($is_valid_token);
		if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
		{
		   $data = $this->UserModel->fetch_all_users();
		   //$data = array('returned');
		   $this->response($data);
		}
		else
		{
		   $this->response(['status' => FALSE,'message'=> $is_valid_token['message']],REST_Controller::HTTP_NOT_FOUND);
		}		
	}

	/**
	* Fetch Dominios Data
	* @method : GET
	*/	
	public function dominios_get()
	{
		header("Access-Control-Allow-Origin: * ");
		//Load Autorizathion Token
		$this->load->library('Authorization_Token');
		
		$is_valid_token = $this->authorization_token->validateToken();
		//var_dump($is_valid_token);
		if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
		{
		   $data = $this->UserModel->dominios();
		   //$data = array('returned');
		   $this->response($data);
		}
		else
		{
		   $this->response(['status' => FALSE,'message'=> $is_valid_token['message']],REST_Controller::HTTP_NOT_FOUND);
		}		
	}

	
	/**
	* User Login API
	* ---------------------
	* @param: username o email
	* @param: password
	* Fetch All User Data
	* @method : POST
	* @link: api/user/login
	*/
	public function login_post()
	{
		header("Access-Control-Allow-Origin: * ");
		
		# XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
		$_POST = $this->security->xss_clean($_POST);
		
	    # Form Validation
		//$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required|max_length[100]');
		   if ($this->form_validation->run() == FALSE)
		   {
		      //echo "Validacion con errores";
		      $message = array('status' => false,
		                       'error' => $this->form_validation->error_array(),
		                       'message' => validation_errors()
		                       );
		      //print_r($message);                
		      $this->response($message,REST_Controller::HTTP_NOT_FOUND);
		   }
		   else
		   {
		   	  //print_r($_POST);
		   	  //Load Login function
		   	  $output = $this->UserModel->user_login($this->input->post('username'),$this->input->post('password'));
		   	  //var_dump($output);
		      if (!empty($output) AND $output != FALSE){
		      	//Load Autorizathion Token
		      	$this->load->library('Authorization_Token');
		      	
		      	//Generate Token
		      	$token_data['id'] = $output->id;
		      	$token_data['fullname'] = $output->fullname;
		      	$token_data['username'] = $output->username;
		      	$token_data['email'] = $output->email;
		      	$token_data['insert'] = $output->insert;
		      	$token_data['update'] = $output->update;
		      	$token_data['time'] = time();
		      	
		      	$user_token = $this->authorization_token->generateToken($token_data);
		      	
		      	//print_r($this->authorization_token->userData());
		      	//exit;
		      	
		      	$insert_data =[
		           'token' => $user_token,		           	           
		         ];
		         // insert user in database
		        $this->UserModel->insert_token($insert_data);
		      	 
		      	//login asatisfactorio
		      	$return_data = [
		      	    'user_id' => $output->id,
		      	    'fullname' => $output->fullname,
		      	    'email' => $output->email,
		      	    'token' => $user_token,
		      	]; 
		      	
		      	$message = [
		      	            'status' => true,
		      	            'data' => $return_data, // $output,
		                    'message' => "Login con Exito"
		      	];
			  	$this->response($message,REST_Controller::HTTP_OK);
			  } else{
		      	//Login Error
		      	$message = [
		      	            'status' => false,
		                    'message' => "Username o Password "
		      	];			  	
			  	$this->response($message,REST_Controller::HTTP_NOT_FOUND);
			  }		   	  
		   }
		//echo "user login";
	}
	    
}