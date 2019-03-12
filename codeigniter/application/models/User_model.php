<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	protected $user_table = 'bam_usuarios';
	protected $user_table1 = 'oauth';
	
	public function insert_user(array $data)
	{
		$this->db->insert($this->user_table,$data);
		return $this->db->insert_id();
	}

	public function insert_token(array $data1)
	{
		$this->db->insert($this->user_table1,$data1);
		return $this->db->insert_id();
	}
	
	public function fetch_all_users()
	{
		$query = $this->db->get('bam_usuarios');
		foreach ($query->result() as $row)
		{
			$user_data[] = [
			     'username' => $row->username,
			     'email' => $row->email,
			     'fullname' => $row->fullname,
			     'insert' => $row->insert,
			     'update' => $row->update,      
			];
		}
        return $user_data;
	}
	
	
	public function dominios()
	{
		$query = $this->db->get('v_app_dominio');
		foreach ($query->result() as $row)
		{
			$user_data[] = [
			     'dominio' => $row->dominio,
			     'codigo' => $row->codigo,
			     'descripcion' => $row->descripcion,
			     'valor_caracter' => $row->valor_caracter,
			];
		}
        return $user_data;
	}	
	
	/**
	* User Login
	* ---------------------
	* @param: username o email
	* @param: password
	* Fetch All User Data
	*/
	public function user_login($username,$password)
	{
		$this->db->where('email',$username);
		$this->db->or_where('username',$username);
		$q = $this->db->get($this->user_table);
		if($q->num_rows())
		{
			$user_pass = $q->row('password');
			if(md5($password) === $user_pass){
				//$this->db->insert($this->user_table1,$data1);
				return $q->row();
			}
			return FALSE;
		} else{
		   return FALSE;			
		}
	}	
	
	
}