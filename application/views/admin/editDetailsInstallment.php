<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Edit Installment</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Users</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit installment</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="<?php echo base_url();?>index.php/admin/InstallmentDetails" class="btn btn-outline-primary waves-effect waves-light">Edit Client Installment</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Edit details
              <form id="user_form" >
                <!-- DropDown -->
                <div class="form-group">
                  <label for="input-1">User Name</label>
                  <input type="text" required value="<?php echo $user[0]->fullname; ?>" class="form-control" name="user_name" id="input-1" readonly>
                  <input type="text" required value="<?php echo $user[0]->id; ?>" class="form-control" name="id" id="input-1" hidden >
                </div>
                <div class="form-group">
                  <label for="input-1">total amount</label>
                  <input type="text" required value="<?php echo $installment_details[0]->id_total_amt; ?>" class="form-control" name="total_amt" id="input-1" >
                  <input type="text" required value="<?php echo $installment_details[0]->id_id; ?>" class="form-control" name="id_id" id="input-1" hidden >
                </div>
                <div class="form-group">
                  <label for="input-1">total number of installment</label>
                  <input type="text" required value="<?php echo $installment_details[0]->id_total_installment; ?>" class="form-control" name="total_installment" id="input-1" >
                </div>
                <div class="form-group">
                  <label for="input-1"><?php echo $project_name[0]->wrok_title; ?></label>
                  <input type="text" required value="<?php echo $project_name[0]->wrok_title; ?>" class="form-control" name="work_title" id="input-1" readonly>
                  <input type="text" required value="<?php echo $project_name[0]->w_id; ?>" class="form-control" name="w_id" id="input-1" hidden >
                </div>
                <div class="form-group">
                  <button type="button" onclick="update_installment()" class="btn btn-primary shadow-primary px-5">Save</button>
                </div>

              </form>
            </div>
          </div>


        </div></div></div>
      </div>

      <?php
      $this->load->view('admin/comman/footerpage');
      ?>
      <script type="text/javascript">

      function update_installment(){

        $("#dvloader").show();
        var formData = new FormData($("#user_form")[0]);
        $.ajax({
          type:'POST',
          url:'<?php echo base_url(); ?>index.php/admin/updateInstallment',
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          dataType: "json",
          success:function(resp){
            $("#dvloader").hide();
            if(resp.status=='200'){
              document.getElementById("user_form").reset();
              toastr.success(resp.msg);
              // window.location.replace('<?php echo base_url(); ?>index.php/admin/userlist');
            }else{
              toastr.error(resp.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#dvloader").hide();
            toastr.error(errorThrown.msg,'failed');
          }
        });
      }
      </script>
