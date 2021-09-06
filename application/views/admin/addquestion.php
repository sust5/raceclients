<?php
$this->load->view('admin/comman/header');
?>

<?php $setn=array(); 
foreach($settinglist as $set){
  $setn[$set->key]=$set->value;
}
?> 

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Add Question</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Question</a></li>
          <li class="breadcrumb-item active" aria-current="page">Add Question</li>
        </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="<?php echo base_url();?>index.php/admin/courselist" class="btn btn-outline-primary waves-effect waves-light">Question List</a>
        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->

    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Add Question</div>
            <hr>
            <form id="question_form"  enctype="multipart/form-data">
              <div class="form-group">
                <label for="input-1">Question</label>
                <input type="text" name="question" class="form-control" id="name">
              </div>

                  <div class="form-group">
                  <label for="input-4"> Course</label>
                  <!-- DropDown -->
                  <select name="input_course" required  class="form-control">
                    <option value="">Select Course</option>
                    <?php $i=1;foreach($courselist as $cat){ ?>
                      <option required value="<?php echo $cat->course_id; ?>"><?php echo $cat->course_name; ?></option>            
                      <?php $i++;} ?>
                    </select>
                  </div>


              <div class="form-group">
                <button type="button" onclick="savequestion()" class="btn btn-primary shadow-primary px-5">Save</button>
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
     
      function savequestion(){

          $("#dvloader").show();
          var formData = new FormData($("#question_form")[0]);
          $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>index.php/admin/savequestion',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(resp){
              $("#dvloader").hide();
              if(resp.status=='200'){
                document.getElementById("question_form").reset();
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