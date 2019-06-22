
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
					<?php $k =  $this->MahasiswaModel->getPrimaryKey()[0]->Column_name; ?>
					<!-- modal -->
					<div id="modal_insert" class="modal fade" role="dialog">
						<form method="post" action="<?php echo base_url('Mahasiswa/insert')?>">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Tambah Data</h4>
								</div>
								<div class="modal-body">
									<?php foreach ($column as $c): ?>
										<div class="form-group" <?php if( $c->Field == $k){ echo "style='display:none;'"; } ?> >
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
									<a class="btn btn-danger btn-sm" href="<?php echo 'Mahasiswa' ?>/delete/<?php echo $this->helperlibrary->encrypt($r->$k) ?>"><i class="fa fa-trash"></i></a></td>
									<div id="modal_edit<?php echo $i ?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<form method="post" action="<?php echo base_url('Mahasiswa/edit/'.$this->helperlibrary->encrypt($r->$k)) ?>">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Edit Data</h4>
													</div>
													<div class="modal-body">
														<?php foreach ($column as $c): ?>
															<div class="form-group" <?php if( $c->Field == $k){ echo "style='display:none;'";  } ?> >
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
		