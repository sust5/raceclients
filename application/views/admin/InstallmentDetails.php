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
				<h4 class="page-title">Installment List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/userListClient">User</a></li>
					<li class="breadcrumb-item active" aria-current="page">Installment Details</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addInstallment" class="btn btn-outline-primary waves-effect waves-light">Add Budget allocation</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i>Installment Details</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">

            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>total installment</th>
                    <th>total amount</th>
                    <th>workName</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
              <?php  $i=1;foreach($installmentInfo as $use){ ?>
                <tr>
                  <td><?php echo $use->id_id;?></td>
                  <td><?php echo $use->name; ?></td>
                  <td><?php echo $use->total_installment; ?></td>
                  <td><?php echo $use->total_amt;?></td>
                  <td><?php echo $use->workName; ?></td>
                  <td>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/edit_details_installment?id=<?php echo $use->w_id; ?>&c_id=<?php echo $use->id; ?>&id_id=<?php echo $use->id_id; ?>">edit Details &nbsp; &nbsp;&nbsp;<i class="fa fa-pencil-square-o"></i></a>
										<hr>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/view_details_installment?id=<?php echo $use->id; ?>"  >view Details &nbsp; &nbsp;&nbsp;<i class="fa fa-pencil-square-o"></i></a>
                    <hr>
                    <a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->id_id; ?>','installment_details')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
                    <input type="hidden" name="status_change" id="status_change_user<?php echo $use->id; ?>" value="<?php echo $use->id; ?>">
                  </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tfoot>
                <tr>
                  <th>id</th>
                  <th>name</th>
                  <th>totalinstallment</th>
									<th>total amount</th>
                  <th>workName</th>
                  <th>Update</th>

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
