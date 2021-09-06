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
				<h4 class="page-title">Bill List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/userListClient">User</a></li>
					<li class="breadcrumb-item active" aria-current="page">Bill List Details</li>
				</ol>
			</div>
			<!-- <div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/addInstallment" class="btn btn-outline-primary waves-effect waves-light">Add installment</a>
				</div>
			</div> -->
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
                  <th>ID</th>
                  <th>Name</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Image</th>
                  <th>Update</th>
              </tr>
            </tfead>

            <tbody>
              <?php  $i=1;foreach($billsDetailsList as $use){ ?>
                <tr>
                  <td><?php echo $use->bill_id;?></td>
                  <td><?php echo $use->fullname; ?></td>
                  <td><?php echo $use->amount; ?></td>
                  <td><?php echo $use->date;?></td>
                  <td>
                    <a target="_blank" href="<?php echo base_url(); ?>/<?php echo $use->bill_url; ?>">View Bill Image &nbsp;<i class="fa fa-pencil-square-o"></i></a>
                  </td>
                  <td>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/billsTransaction?bill_id=<?php echo $use->bill_id; ?>&id=<?php echo $use->vendor_id; ?>&date_given=<?php echo $use->date; ?>" > view transaction Details &nbsp; &nbsp;&nbsp;<i class="fa fa-pencil-square-o"></i></a>
                    <hr>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/notifyUser?id=<?php echo $use->vendor_id; ?>&date_given=<?php echo $use->date; ?>"  >Notify User &nbsp; &nbsp;&nbsp;<i class="fa fa-pencil-square-o"></i></a>
                  </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tfoot>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Image</th>
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
