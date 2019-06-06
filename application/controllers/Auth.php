<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('AuthLibrary');
		$this->load->library('form_validation');
	}

	public function index(){
		$this->load->view('Auth');
	}

	public function register(){
		$validation = $this->form_validation;
		$validation->set_rules('username','Username','required');
		$validation->set_rules('password','Password','required');
		if($validation->run()){
			$data = array(
				'email'			=> $this->input->post('email'),
				'username'		=> $this->input->post('username'),
				'password'		=> password_hash($this->input->post('password'),PASSWORD_DEFAULT),
				'id_role'		=> $this->input->post('access_level'),
				'created_at'	=> date('Y/m/d h:i:s'), 
				'updated_at'	=> date('Y/m/d h:i:s')
			);
			if($this->authlibrary->register($data)==1){
				// Redirect Page with access level
				if($data['id_role']==1){
					redirect('Admin/Dashboard');
				} else {
					//user
				}
			} else {
				$this->session->set_flashdata('error','Cannot Register, Please Try Again');
				redirect('Auth');
			}
		} else {
			$this->session->set_flashdata('error','Please fill all data');
			redirect('Auth');
		}
		
	}

	public function login(){
		$validation = $this->form_validation;
		$validation->set_rules('username','Username','required');
		$validation->set_rules('password','Password','required');
		if($validation->run()){
			$data = array(
				'username'		=> $this->input->post('username'),
				'password'		=> $this->input->post('password')
			);
			$credentials = $this->authlibrary->login($data);
			//$this->helperlibrary->extract($credentials);
		} else {
			$this->session->set_flashdata('error','Silahkan Lengkapi Semua data');
			redirect('Auth');
		}
	}

	public function logout(){
		$this->authlibrary->logout();
	}
}
