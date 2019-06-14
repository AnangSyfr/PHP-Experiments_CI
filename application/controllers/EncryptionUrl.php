<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EncryptionUrl extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('AuthLibrary');
		$this->load->library('Encryption');
	}

	public function index(){
		$this->load->view('encryption_url');
	}

	public function edit(){
		$id = $this->uri->segment(3);
		echo $this->helperlibrary->decrypt($id);
	}
}