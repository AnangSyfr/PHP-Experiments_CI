<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('AuthLibrary');
		$this->authlibrary->check_login();
	}

	function index(){
		echo 'Hello ,'.$this->session->userdata('username');
		echo "<a href='".base_url()."Auth/logout'> Logout</a>";
	}

}
?>