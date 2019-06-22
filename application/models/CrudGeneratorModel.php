<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudGeneratorModel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function createTable($table_name,$column_name,$type,$length){
		$data = [];
		foreach($column_name as $c){
			array_push($data,$c);
		}
		foreach($type as $t){
			array_push($data,$t);
		}
		foreach($length as $l){
			array_push($data,$l);
		}
		$total_column = count($column_name);
		$query = [];
		for ($i=0; $i < $total_column; $i++) { 
			array_push($query,$data[$i]." ".$data[$i+$total_column].'('.$data[$i+(2*$total_column)].')');	
		}
		//$this->helperlibrary->extract($query);
		$column = implode(" , ",$query);
		return $this->db->query("create table $table_name($column)");
	}

	function createModel($table_name){
		$model_location	= APPPATH . "models/";
		$model_name		= ucwords($table_name).'Model'.".php";	
		$myfile = fopen($model_location.$model_name,"w") or die("error");
		//$txt = $this->load->view('template_crud');
		fwrite($myfile,'<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class '.ucwords($table_name).'Model extends CI_Model {

	protected $table = '."'$table_name'".';
	public function __construct(){
		parent::__construct();

	}

	function getAllColumn(){
	 	return $this->db->query("DESCRIBE $this->table")->result();
	}

	function getAllData(){
		return $this->db->get($this->table)->result();
	}

	function getTable(){
		$arr = [];
		array_push($arr,$this->db->query("DESCRIBE $this->table")->result());
		array_push($arr,$this->db->get($this->table)->result());
		return $arr;
	}

	function getPrimaryKey(){
		return $this->db->query("show index from $this->table where key_name = '."'PRIMARY'".'")->result();
	}

	function insert($data){
		return $this->db->insert($this->table,$data);
	}

	function update($data,$key,$id){
		$this->db->where($key,$id);
		return $this->db->update($this->table,$data);
	}

	function delete($key,$id){
		return $this->db->delete($this->table,array( $key => $id));
	}
}
		');
		fclose($myfile);
	}

	function createView($table_name){
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
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_insert">Tambah Data</button>
					<?php $k =  $this->'.ucwords($table_name).'Model->getPrimaryKey()[0]->Column_name; ?>
					<!-- modal -->
					<div id="modal_insert" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<form method="post" action="<?php echo base_url('."'".ucwords($table_name)."/insert'".')?>">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Tambah Data</h4>
									</div>
									<div class="modal-body">
										<?php foreach ($column as $c): ?>
											<div class="form-group" <?php if( $c->Field == $k){ echo "style='."'display:none;'".'"; } ?> >
												<label><?php echo $c->Field?> </label>
												<?php $r = explode("(",$c->Type); ?>
												<?php if($r[0]=="text"): ?>
													<textarea class="form-control" name="<?php echo $c->Field ?>"></textarea>
												<?php else: ?>
													<input class="form-control" name="<?php echo $c->Field ?>" type="text">
												<?php endif ?>
											</div>
										<?php endforeach ?>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">Send</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- end modal -->
					
				</div>
				<br>
				<br>
				<div style="clear:both"></div>
				<div class="container-fluid">
				<table id="datatable" class="table table-stripped">
					<thead>
						<tr>
							<?php 
							foreach ($column as $c): ?>
								<th><?php echo $c->Field?></th>
							<?php endforeach ?>
								<th>Action</th>
						</tr>
					</thead>
					<tbody>
						
						<?php $i=0; foreach ($data[1] as $r): ?>
							<tr>	
							<?php foreach ($data[0] as $c): ?>
								<?php $field = $c->Field ?>
								<td><?php echo $r->$field ?></td>	
							<?php endforeach ?>
								<td>
									<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_edit<?php echo $i?>"><i class="fa fa-edit"></i></button>
									<a class="btn btn-danger btn-sm" href="<?php echo '."'ucwords($table_name)'".' ?>/delete/<?php echo $this->helperlibrary->encrypt($r->$k) ?>"><i class="fa fa-trash"></i></a></td>
									<div id="modal_edit<?php echo $i ?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<form method="post" action="<?php echo base_url('."'".ucwords($table_name).'/edit/$this->helperlibrary->encrypt($r->$k)'."'".')?>">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Edit Data</h4>
													</div>
													<div class="modal-body">
														<?php foreach ($column as $c): ?>
															<div class="form-group" <?php if( $c->Field == $k){ echo "style='."'display:none;'".'";  } ?> >
																<label><?php echo $f=$c->Field?> </label>
																<?php $d = explode("(",$c->Type); ?>
																<?php if($d[0]=="text"): ?>
																	<textarea class="form-control" name="<?php echo $c->Field ?>"></textarea>
																<?php else: ?>
																	<input class="form-control" name="<?php echo $c->Field ?>" type="text" value="<?php echo $r->$field ?>">
																<?php endif ?>
															</div>
														<?php endforeach ?>
													</div>
													<div class="modal-footer">
														<button class="btn btn-primary">Simpan</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</tr>
						<?php $i++; endforeach ?>
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
	}

	function createController($table_name){
		$controller_location 	= APPPATH . "controllers/";
		$controller_name		= ucwords($table_name).".php";	
		$myController			= fopen($controller_location.$controller_name,"w") or die("error");
		$className 				= ucwords($table_name);
		$modelName 				= $className."Model";
		fwrite($myController,'<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class '.$className.' extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('."'$modelName'".');
	}

	function index(){
		$data = array(
			'."'page'".' => '."'$table_name'".',
			'."'table_name'".' => '."'$table_name'".',
			'."'column'".' => $this->'.$className.'Model->getAllColumn(),
			'."'data'".' => $this->'.$className.'Model->getTable(),
			'."'key'".'	=> $this->'.$className.'Model->getPrimaryKey(),
		);
		
		$this->load->view('."'layout/header'".',$data);
		$this->load->view('."'layout/nav'".');
		$this->load->view('."'$table_name'".');
		$this->load->view('."'layout/footer'".');
	}

	function insert(){
		$key = $this->'.$className.'Model->getPrimaryKey()[0]->Column_name;
		$column = $this->'.$className.'Model->getAllColumn();
		$data = array();
		foreach($column as $c){
			if($c->Field != $key){
				$data[$c->Field] = $this->input->post($c->Field);
			}	
		}
		if($this->'.$className.'Model->insert($data)==1){
			$this->session->set_flashdata('."'Success,Data successfully inserted'".');
			redirect('."'$className'".');
		}
	}

	function edit(){
		$key = $this->'.$className.'Model->getPrimaryKey()[0]->Column_name;
		$id = $this->helperlibrary->decrypt($this->uri->segment(3));
		$column = $this->'.$className.'Model->getAllColumn();
		$data = array();
		foreach($column as $c){
			if($c->Field != $key){
				$data[$c->Field] = $this->input->post($c->Field);
			}	
		}
		if($this->'.$className.'Model->update($data,$key,$id)==1){
			$this->session->set_flashdata('."'Success,Data successfully updated'".');
			redirect('."'$className'".');
		}
	}

	function delete(){
		$key = $this->'.$className.'Model->getPrimaryKey()[0]->Column_name;
		$id = $this->helperlibrary->decrypt($this->uri->segment(3));
		if($this->'.$className.'Model->delete($key,$id)==1){
			$this->session->set_flashdata('."'Success,Data successfully deleted'".');
			redirect('."'$className'".');
		}
	}
}
		');
		fclose($myController);
		return $className;
	}

	function getAllColumn($table){
	 	return $this->db->query("DESCRIBE $table")->result();
	}

	function getAllData($table){
		return $this->db->get($table)->result();
	}
}