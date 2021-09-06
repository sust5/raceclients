<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Add Installment</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Users</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add installment</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="<?php echo base_url();?>index.php/admin/InstallmentDetails" class="btn btn-outline-primary waves-effect waves-light">List Client Installment</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Add User
              <form id="user_form"  enctype="multipart/form-data">

                <!-- DropDown -->
                <div class="form-group">
                  <label for="input-2">Select Client</label>
                  <select name="select_user" required  class="form-control">
                    <option value="0">Select Client</option>
                    <?php $i=1;foreach($clientList as $list){ ?>
                      <option required value="<?php echo $list->id; ?>"><?php echo $list->fullname; ?></option>
                      <?php $i++;
                    } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="input-1">total amount</label>
                  <input type="text" required value="" class="form-control" name="total_amt" id="input-1" >
                </div>
                <!-- <div class="form-group">
                  <label for="input-1">total paid</label>
                  <input type="text" required value="" class="form-control" name="total_paid" id="input-1" >
                </div> -->

                <div class="form-group">
                  <label for="input-1">total number of installment</label>
                  <input type="text" required value="" class="form-control" name="total_installment" id="input-1" >
                </div>

                <!-- <div class="form-group">
                  <label for="input-1">paid installment</label>
                  <input type="text" required value="" class="form-control" name="paid_installment" id="input-1" >
                </div> -->
                <div class="form-group">
                  <button type="button" onclick="saveuser()" class="btn btn-primary shadow-primary px-5">Save</button>
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

      function saveuser(){

        $("#dvloader").show();
        var formData = new FormData($("#user_form")[0]);
        $.ajax({
          type:'POST',
          url:'<?php echo base_url(); ?>index.php/admin/saveInstallment',
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
          error: function(data){
         toastr.error(data);
  }
        });
      }
      </script>
