<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Update app content</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Web site</a></li>
          <li class="breadcrumb-item active" aria-current="page">General Text</li>
        </ol>
      </div>
    
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <form id="edit_video_form"  enctype="multipart/form-data">
              <?php $i=1;foreach($g_text as $texts){ ?>


                <div class="form-group">
                  <label for="input-1">Title</label>
                  <input type="text" required value="<?php echo $texts->g_title; ?>" class="form-control" name="input_title" id="input-1" >
                </div>

                <input type="hidden" name="id" value="<?php echo $texts->g_id; ?>">

                <div class="form-group">
                  <label for="input-1">Welcome Text</label>
                  <textarea required style="height:150px !important;" class="form-control" name="input_description" id="input-1" ><?php echo $texts->g_desc;?></textarea>
                </div>
                <div class="form-group">
                  <label for="input-1">Youtube URL</label>
                  <input type="text" required value="<?php echo $texts->g_url;}?>" class="form-control" name="input_address" id="input-1" >
                </div>
              
                <div class="form-group">
                  <button type="button" onclick="saveData()" class="btn btn-primary shadow-primary px-5">Save</button>
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

        function saveData(){

          $("#dvloader").show();
          var formData = new FormData($("#edit_video_form")[0]);
          $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>index.php/admin/saveGeneralData',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(resp){
              $("#dvloader").hide();
              if(resp.status=='200'){
                document.getElementById("edit_video_form").reset();
                toastr.success(resp.msg,'success');
                setTimeout(function(){ location.reload(); }, 500);
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