<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('encryption');
	}

	public function index(){
		
		$data = array(
			//'key'	=> bin2hex($this->encryption->create_key(16)),
			'id'	=> $this->helperlibrary->encrypt(10)
		);

		$this->load->view('welcome_message',$data);
	}


}
