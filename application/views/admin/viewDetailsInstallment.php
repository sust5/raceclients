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
					<li class="breadcrumb-item"><a href="javaScript:void();">User</a></li>
					<li class="breadcrumb-item active" aria-current="page">Installment Details</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url().'index.php/admin/add_installment_record?id='.$client_id;?>" class="btn btn-outline-primary waves-effect waves-light">Add record</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i>Installment Details of<b> <?php echo $user[0]->fullname ?></b> </div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">

            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>date</th>
                    <th>total_amt</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
              <?php  $i=1;$total_paid=0;foreach($details as $use){ ?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $use->cph_title; ?></td>
                  <td><?php echo $use->cph_date; ?></td>
                  <td><?php echo $use->cph_paid_amt;$total_paid=$total_paid+$use->cph_paid_amt?></td>
                                <td>
                    <a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->cph_id; ?>','client_payment_history')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tfoot>
                <tr>
                  <th>id</th>
                  <th>name</th>
                  <th>date</th>
                  <th>total_amt</th>
                  <th>Update</th>

                </tr>
            </tfoot>


						</table>
					</div>
				</div>
			</div>
		</div>
		<h5>Total paid amount is &nbsp;</h5>	<h4><?php echo $total_paid; ?></h4> <br/> <br>
		<h5>&nbsp; Remaining  amount is &nbsp;</h5>	<h4><?php echo  $total_amount[0]->id_total_amt -$total_paid ; ?></h4>

	</div><!-- End Row-->


	<?php
	$this->load->view('admin/comman/footerpage');
	?>

	<script>
		$(document).ready(function() {
			$('#default-datatable').DataTable();
		} );
	</script>
