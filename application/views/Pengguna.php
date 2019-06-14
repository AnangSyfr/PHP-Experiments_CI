
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
			