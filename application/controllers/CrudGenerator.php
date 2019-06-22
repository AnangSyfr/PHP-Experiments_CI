<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudGenerator extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('CrudGeneratorModel');
	}

	public function index(){
		$data = array(
			'page' => $this->uri->segment(1),
		);
		$this->load->view('layout/header',$data);
		$this->load->view('layout/nav');
		$this->load->view('crud_generator');
		$this->load->view('layout/footer');
	}

	public function generate(){
		$table_name 	= $this->input->post('table_name');
		$column_name 	= $this->input->post('column_name');
		$type 			= $this->input->post('type');
		$length			= $this->input->post('length');
		//$check 			= $this->CrudGeneratorModel->createTable($table_name,$column_name,$type,$length);
		
		//if($check==1){
			//make model
			$this->CrudGeneratorModel->createModel($table_name);
			//make view
			$this->CrudGeneratorModel->createView($table_name);
			//make controller
			$className = $this->CrudGeneratorModel->createController($table_name);
			
			$table_name = $this->helperlibrary->encrypt($table_name);
			$this->session->set_flashdata('success',"Modul Sukses Dibuat ! <a href=".base_url($className).">Lihat</a>");
			redirect('CrudGenerator/table/'.$table_name);
		//}
	}

	function table(){
		$table_name = $this->helperlibrary->decrypt($this->uri->segment(3));
		$data = array(
			'table_name'	=> $table_name,
			'page' 			=> $this->uri->segment(1),
			'column' 		=> $this->CrudGeneratorModel->getAllColumn($table_name),
			'data' 			=> $this->CrudGeneratorModel->getAllData($table_name),
		);
		$this->load->view('layout/header',$data);
		$this->load->view('layout/nav');
		$this->load->view('template_crud');
		$this->load->view('layout/footer');
	}
}