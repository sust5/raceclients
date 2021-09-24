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
					<li class="breadcrumb-item active" aria-current="page">Work progress</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addFaq" class="btn btn-outline-primary waves-effect waves-light">Add FAQ</a>
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
                <!-- adjust these in the table  wp_title as 'Progress_title',wp_date as 'date' ,wp_percent_complete as 'complete_percent', w_work_title as work_title,fullname -->
								<th>Id</th>
								<th>question</th>
								<th>answer</th>
								<th>date</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($faqdata as $use){ ?>
								<tr>
									<td><?php echo $use->f_id;?></td>
									<td><?php echo $use->f_question; ?></td>
									<td><?php echo $use->f_answer; ?></td>
									<td><?php  echo $use->f_date ?></td>

									<td>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->f_id; ?>','faq')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
										<input type="hidden" name="status_change" id="status_change_user<?php echo $use->f_id; ?>" value="<?php echo $use->f_id; ?>">
									</td>
								</tr>
								<?php $i++;} ?>
							</tbody>
							<tfoot>
								<tr>
								<th>Id</th>
								<th>question</th>
								<th>answer</th>
								<th>date</th>
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
