<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Add Installment record</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">installment record</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add Installment record</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="<?php echo base_url();?>index.php/admin/booklist" class="btn btn-outline-primary waves-effect waves-light">Books List</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Add Installment
              <form id="installment_form"  enctype="multipart/form-data">

                <div class="form-group">
                  <label for="input-1">Title</label>
                  <input type="text" required value="" class="form-control" name="input_title" id="input-1"  placeholder="Enter Title">
                </div>
                <input type="hidden" id="client_id" name="client_id" value="<?php echo $_GET['id'] ?>">

                <div class="form-group"  >
                  <label for="input-1"> Amount</label>
                  <input type="text" required value="" class="form-control"  name="input_amt" id="input-1" placeholder="Enter Amount">
                </div>
                    <div class="form-group">
                      <button type="button" onclick="saveInstallmentRecord()" class="btn btn-primary shadow-primary px-5">Save</button>
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
          function saveInstallmentRecord(){

            $("#dvloader").show();
            var formData = new FormData($("#installment_form")[0]);
            $.ajax({
              type:'POST',
              url:'<?php echo base_url(); ?>index.php/admin/saveInstallmentRecords',
              data:formData,
              cache:false,
              contentType: false,
              processData: false,
              dataType: "json",
              success:function(resp){
                $("#dvloader").hide();
                if(resp.status=='200'){
                  document.getElementById("installment_form").reset();
                  toastr.success(resp.msg,'success');
                  setTimeout(function(){ location.reload(); }, 500);
                }else{
                  toastr.error(resp.msg);
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                $("#dvloader").hide();
                toastr.error(errorThrown.msg,'STATUS: '+textStatus+'\nERROR THROWN: '+errorThrown);
                console.log('STATUS: '+textStatus+'\nERROR THROWN: '+errorThrown);
              }
            });
          }
          function checkVtype(server){
            if(server!='Server Video'){
              $('#videoLink').html('<label for="input-1">Video url</label><input type="text" required  class="form-control" name="video_url" id="input-1" placeholder="Enter Video url">');
            }else{
              $('#videoLink').html('<label for="input-1">Upload Video</label><input type="file" required  class="form-control" name="video_upload" id="input-1" placeholder="Enter Video Name">');
            }
          }
          </script>
