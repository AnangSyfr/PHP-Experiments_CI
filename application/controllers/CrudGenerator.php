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
		$check 			= $this->CrudGeneratorModel->createTable($table_name,$column_name,$type,$length);
		
		if($check==1){
			//make view
			$view_location 	= APPPATH . "views/";
			$view_name		= $table_name.".php";	
			$myfile = fopen($view_location.$view_name,"w") or die("error");
			//$txt = $this->load->view('template_crud');
			fwrite($myfile,'
				<div class="main-content">
					<div class="main-content-inner">
						<div class="breadcrumbs ace-save-state" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="ace-icon fa fa-home home-icon"></i>
									<a href="#">Module</a>
								</li>
								<li class="active">Crud Generator</li>
							</ul><!-- /.breadcrumb -->

							<div class="nav-search" id="nav-search">
								<form class="form-search">
									<span class="input-icon">
										<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
										<i class="ace-icon fa fa-search nav-search-icon"></i>
									</span>
								</form>
							</div><!-- /.nav-search -->
						</div>

						<div class="page-content">
							<div class="page-header">
								<h1>
									Crud Generator
									<small>
										<i class="ace-icon fa fa-angle-double-right"></i>
										Create Table
										<i class="ace-icon fa fa-angle-double-right"></i>
										<?php echo $table_name ?>
									</small>
								</h1>
							</div><!-- /.page-header -->

							<div class="row">
								<div class="col-xs-12">
									<!-- PAGE CONTENT BEGINS -->
									<!-- notifikasi -->
									<?php if($this->session->flashdata("success")): ?>
										<div class="alert alert-success">
											<?php echo $this->session->flashdata("success")?>
										</div>
									<?php endif ?>
								</div>
								<div class="container">
									<button class="btn btn-primary btn-sm">Tambah Data</button>
								</div>
								<br>
								<br>
								<div style="clear:both"></div>
								<div class="container-fluid">
								<table id="datatable" class="table table-stripped">
									<thead>
										<tr>
											<?php foreach ($column as $c): ?>
												<th><?php echo $c->Field?></th>
											<?php endforeach ?>
												<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data as $r): ?>
											<tr>
											<?php foreach ($column as $c): ?>
												<?php $field = $c->Field ?>
												<td><?php echo $r->$field?></td>
											<?php endforeach ?>
												<td>
													<button class="btn btn-sm btn-primary">Edit</button>
													<button class="btn btn-sm btn-danger">Delete</button>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(function(){
						$("#datatable").DataTable();
					});
				</script>
			');
			fclose($myfile);

			//make controller
			$controller_location 	= APPPATH . "controllers/";
			$controller_name		= ucwords($table_name).".php";	
			$myController			= fopen($controller_location.$controller_name,"w") or die("error");
			$className 				= ucwords($table_name);
			fwrite($myController,'
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");
	class '.$className.' extends CI_Controller {

		public function __construct(){
			parent::__construct();

		}

		function index(){
			$data = array(
				'."'table_name'".' => '."'$table_name'".',
				'."'column'".' => $this->CrudGeneratorModel->getAllColumn('."'$table_name'".'),
				'."'data'".' => $this->CrudGeneratorModel->getAllData('."'$table_name'".'),
			);
			$this->load->view('."'layout/header'".',$data);
			$this->load->view('."'layout/nav'".');
			$this->load->view('."'$table_name'".');
			$this->load->view('."'layout/footer'".');
		}
	}
			');
			fclose($myController);

			$table_name = $this->helperlibrary->encrypt($table_name);
			$this->session->set_flashdata('success',"Modul Sukses Dibuat ! <a href=".base_url($className).">Lihat</a>");
			redirect('CrudGenerator/table/'.$table_name);
		}
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