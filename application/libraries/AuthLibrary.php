<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthLibrary {
	
	// SET SUPER GLOBAL
	protected $CI;
	public $error_login = 'Username/Password not registered, please try again';
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	// Register 
	public function register($data){
		return $this->CI->db->insert('users',$data);
	}

	// Login
	public function login($data) {
		// Query untuk pencocokan data
		
		$query = $this->CI->db->get_where('users',array('username' => $data['username']));
										
		// Jika ada hasilnya
		if($query->num_rows() == 1) {
			$row 	= $this->CI->db->query('SELECT * FROM users WHERE username = "'.$data['username'].'"');
			$tmp	= $row->row();
			$pass 	= $tmp->password;
			if(password_verify($data['password'],$pass)){
				$this->CI->session->set_userdata(array(
					'id_user'	=> $tmp->id_user,
					'id_role'	=> $tmp->id_role,
					'username'	=> $tmp->username
				));
				if($tmp->id_role==1){
					redirect('Admin/Dashboard');
				} else {
					//user page
				}
			} else {
				$this->CI->session->set_flashdata('error',$this->error_login);
				redirect('Auth');
			}
		}else{
			$this->CI->session->set_flashdata('error',$this->error_login);
			redirect('Auth');
		}
	}
	
	// Check login
	public function check_login() {
		if($this->CI->session->userdata('username') == '' && $this->CI->session->userdata('id_role')=='') {
			$this->CI->session->set_flashdata('error','Oops...silakan login dulu');
			redirect('Auth');
		}	
	}
	
	// Logout
	public function logout() {
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('id_user');
		$this->CI->session->unset_userdata('id_role');
		$this->CI->session->set_flashdata('success','Terimakasih, Anda berhasil logout');
		redirect('Auth');
	}
	
}