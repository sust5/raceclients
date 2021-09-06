<?php
$this->load->view('admin/comman/header');
?>

<link href="<?php echo base_url();?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">vendor payment list</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">vendor payment</a></li>
          <li class="breadcrumb-item active" aria-current="page">vendor transaction list</li>
        </ol>
      </div>
      <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="<?php echo base_url(); ?>index.php/admin/notifyUser?id=<?php echo $user_id; ?>&date_given=<?php echo $date; ?>"  class="btn btn-outline-primary waves-effect waves-light">Report bill</a>

      </div>
    </div>
  </div>
  <!-- End Breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header"><i class="fa fa-table"></i> Vendor Payment Record</div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="default-datatable" class="table table-bordered">
             <thead>
              <tr>
                <th>Id</th>
                <th>particulars</th>
                <th>rate</th>
                <th>no of items </th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
             <?php $i=1;foreach($tlist as $val){ ?>
              <tr>
                <td><?php echo $val->id; ?></td>
                <td> <?php echo $val->particulars; ?>
                  <td> <?php echo $val->rate; ?>
                <td> <?php echo $val->no_of_items; ?>
                <td> <?php echo $val->amount; ?>
            </tr>
            <?php $i++;} ?>

          </tbody>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>particulars</th>
              <th>rate</th>
              <th>no of items </th>
              <th>Amount</th>
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
      //Default data table
      $('#default-datatable').DataTable();
    } );

  </script>
