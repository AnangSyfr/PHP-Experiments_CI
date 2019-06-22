<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class Mahasiswa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('MahasiswaModel');
	}

	function index(){
		$data = array(
			'page' => 'mahasiswa',
			'table_name' => 'mahasiswa',
			'column' => $this->MahasiswaModel->getAllColumn(),
			'data' => $this->MahasiswaModel->getTable(),
			'key'	=> $this->MahasiswaModel->getPrimaryKey(),
		);
		
		$this->load->view('layout/header',$data);
		$this->load->view('layout/nav');
		$this->load->view('mahasiswa');
		$this->load->view('layout/footer');
	}

	function insert(){
		$key = $this->MahasiswaModel->getPrimaryKey()[0]->Column_name;
		$column = $this->MahasiswaModel->getAllColumn();
		$data = array();
		foreach($column as $c){
			if($c->Field != $key){
				$data[$c->Field] = $this->input->post($c->Field);
			}	
		}
		if($this->MahasiswaModel->insert($data)==1){
			$this->session->set_flashdata('Success,Data successfully inserted');
			redirect('');
		}
	}

	function edit(){
		$key = $this->MahasiswaModel->getPrimaryKey()[0]->Column_name;
		$id = $this->helperlibrary->decrypt($this->uri->segment(3));
		$column = $this->MahasiswaModel->getAllColumn();
		$data = array();
		foreach($column as $c){
			if($c->Field != $key){
				$data[$c->Field] = $this->input->post($c->Field);
			}	
		}
		if($this->MahasiswaModel->update($data,$key,$id)==1){
			$this->session->set_flashdata('Success,Data successfully updated');
			redirect('');
		}
	}

	function delete(){
		$key = $this->MahasiswaModel->getPrimaryKey()[0]->Column_name;
		$id = $this->helperlibrary->decrypt($this->uri->segment(3));
		if($this->MahasiswaModel->delete($key,$id)==1){
			$this->session->set_flashdata('Success,Data successfully deleted');
			redirect('');
		}
	}
}
		