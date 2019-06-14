
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");
	class Mahasiswa extends CI_Controller {

		public function __construct(){
			parent::__construct();

		}

		function index(){
			$data = array(
				'table_name'	=> 'mahasiswa',
				'column' 		=> $this->CrudGeneratorModel->getAllColumn('mahasiswa'),
				'data' 		=> $this->CrudGeneratorModel->getAllData('mahasiswa'),
			);
			$this->load->view('layout/header',$data);
			$this->load->view('layout/nav');
			$this->load->view('mahasiswa');
			$this->load->view('layout/footer');
		}
	}
			