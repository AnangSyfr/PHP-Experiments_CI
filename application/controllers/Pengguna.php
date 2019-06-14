
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");
	class Pengguna extends CI_Controller {

		public function __construct(){
			parent::__construct();

		}

		function index(){
			$data = array(
				'table_name' => 'Pengguna',
				'column' => $this->CrudGeneratorModel->getAllColumn('Pengguna'),
				'data' => $this->CrudGeneratorModel->getAllData('Pengguna'),
			);
			$this->load->view('layout/header',$data);
			$this->load->view('layout/nav');
			$this->load->view('Pengguna');
			$this->load->view('layout/footer');
		}
	}
			