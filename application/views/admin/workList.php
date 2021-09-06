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
					<li class="breadcrumb-item"><a href="javaScript:void();">Work</a></li>
					<li class="breadcrumb-item active" aria-current="page">Work List</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addWork" class="btn btn-outline-primary waves-effect waves-light">Add Work</a>
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
								<th>title</th>
								<th>user</th>
								<th>start date</th>
								<th>dead line</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($Worklist as $use){ ?>
								<tr>
									<td><?php echo $use->id;?></td>
									<td><?php echo $use->work_title; ?></td>
									<td><?php echo $use->fullname; ?></td>
									<td><?php  echo $use->start_date ?></td>
									<td><?php echo $use->dead_line; ?></td>
									<td><a class="btn btn-primary" href="<?php echo base_url();?>index.php/admin/editWork?id=<?php echo $use->id; ?>">edit &nbsp;&nbsp;<i class="fa fa-pencil-square-o"></i></a>
										<hr>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->id; ?>','work')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
										<input type="hidden" name="status_change" id="status_change_user<?php echo $use->id; ?>" value="<?php echo $use->id; ?>">
									</td>
								</tr>
								<?php $i++;} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>Id</th>
									<th>title</th>
									<th>user</th>
									<th>start date</th>
									<th>dead line</th>
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
