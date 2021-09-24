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
				<h4 class="page-title">Review List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Work</a></li>
					<li class="breadcrumb-item active" aria-current="page">Work progress</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addReview" class="btn btn-outline-primary waves-effect waves-light">Add Review</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i> Review List</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">
						<thead>
							<tr>
                <!-- adjust these in the table  wp_title as 'Progress_title',wp_date as 'date' ,wp_percent_complete as 'complete_percent', w_work_title as work_title,fullname -->
								<th>Id</th>
								<th>Name</th>
								<th>Image</th>
								<th>Description</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($reviewdata as $use){ ?>
								<tr>
									<td><?php echo $use->r_id;?></td>
									<td><?php echo $use->r_name; ?></td>
									<td><?php echo $use->r_image_url; ?></td>
									<td><?php echo $use->r_desc; ?></td>
									<td><?php  echo $use->r_date ?></td>

									<td>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->r_id; ?>','review')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
										<input type="hidden" name="status_change" id="status_change_user<?php echo $use->r_id; ?>" value="<?php echo $use->r_id; ?>">
									</td>
								</tr>
								<?php $i++;} ?>
							</tbody>
							<tfoot>
								<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Image</th>
								<th>Description</th>
								<th>Date</th>
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
