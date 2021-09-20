<?php
$this->load->view('admin/comman/header');
?>

<link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

<!-- UserList Data Show -->
<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Social Media List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Social Media</a></li>
					<li class="breadcrumb-item active" aria-current="page">Social Media List</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addSocialLink" class="btn btn-outline-primary waves-effect waves-light">Add link</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i>Register User List</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>icon</th>
								<th>name</th>
								<th>link</th>
								<th>date</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($sm_list as $use){ ?>
								<tr>
									<td><?php echo $use->s_id;?></td>
									<td><i style="color:<?php echo $use->	front_color;?>;padding: 5px;background-color: <?php echo $use->back_color;?>;" class="<?php echo $use->icon;?>"></i></td>
									<td><?php echo $use->s_name; ?></td>
									<td><?php echo $use->s_link; ?></td>
									<td><?php echo $use->s_date;?></td>
									<td>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->s_id; ?>','social_media')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
										<input type="hidden" name="status_change" id="status_change_user<?php echo $use->s_id; ?>" value="<?php echo $use->s_id; ?>">
									</td>
								</tr>
								<?php $i++;} ?>

							</tbody>
							<tfoot>
								<tr>
									<tr>
								<th>Id</th>
								<th>icon</th>
								<th>name</th>
								<th>link</th>
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
