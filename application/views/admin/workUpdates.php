<?php
$this->load->view('admin/comman/header');
?>

<link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

<!-- WorkList Data Show -->
<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Work List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Work updates</a></li>
					<li class="breadcrumb-item active" aria-current="page">Work List</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addWorkUpdate" class="btn btn-outline-primary waves-effect waves-light">Add work Updates</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i> Work List</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>user</th>
								<th>work title</th>
								<th>updates</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($workUpdateList as $use){ ?>
								<tr>
									<td><?php echo $i?></td>
									<td><?php echo $use->fullname;?></td>
									<td><?php echo $use->w_work_title;?></td>
									<td><?php echo $use->title; ?></td>
									<td>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->u_id; ?>','work_updates')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
									</td>
								</tr>
								<?php $i++;} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>Id</th>
									<th>user</th>
									<th>work title</th>
									<th>updates</th>
									<th>status</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div><!-- End Row-->


	<?php
	$this->load->view('admin/comman/footerpage');
	?>

	<script>
		$(document).ready(function() {
			$('#default-datatable').DataTable();
		} );
	</script>
