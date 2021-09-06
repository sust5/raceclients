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
		    <h4 class="page-title">question List</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">question</a></li>
            <li class="breadcrumb-item active" aria-current="page">question List</li>
         </ol>
	   </div>
     <div class="col-sm-3">
       <div class="btn-group float-sm-right">
           <a href="<?php echo base_url();?>index.php/admin/addquestion" class="btn btn-outline-primary waves-effect waves-light">Add question</a>
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> question Record</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Question</th>
                        <th>Created date</th>
                        <th>Action</th>
                    </tr>
                </thead>   
                <tbody>
                     <?php $i=1;foreach($questiondata as $cat){ ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $cat->question; ?></td>
                        <td><?php echo $cat->date; ?></td>
                      <td><a href="">View answer </a> | <a href="javaScript:void(0)" onclick="delete_record('<?php echo $cat->q_id; ?>','question')">Delete</a></td>
                    </tr>
                <?php $i++;} ?>
 
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
<!--                         <th>Image</th>
 -->                        <th>Name</th>
                        <th>Created date</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
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

