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
				<h4 class="page-title">User List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">User Suggestion List</li>
				</ol>
			</div>
			
					</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i>User Suggestion List</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>FullName</th>
								<th>Account Type</th>
								<th>subject</th>
								<th>message</th>
								<th>date</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($reportList as $val){ ?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $val->fullname; ?></td>
									<td><?php  if( $val->account_type==1){echo "client";} else{echo "vendor";}?></td>
									<td><?php echo $val->subject; ?></td>
									<td><?php echo $val->message;?></td>
									<td><?php echo $val->date;?></td>
								</tr>
								<?php $i++;} ?>

							</tbody>
							<tfoot>
								<tr>
								<th>Id</th>
								<th>FullName</th>
								<th>Account Type</th>
								<th>subject</th>
								<th>message</th>
								<th>date</th>
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
