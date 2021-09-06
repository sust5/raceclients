<?php
$this->load->view('admin/comman/header');
?>


<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Gallery</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Gallery</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">Client gallery</a></li>
        </ol>
      </div>

    </div>

    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>
                      <form id="savenotifi" name='Notification'  action="">

                        <div class="form-group">
                          <label for="input-2">Select Client</label>
                          <!-- DropDown -->
                          <select name="select_user" required  class="form-control">
                            <option value="0">All User</option>
                            <?php $i=1;foreach($clientList as $list){ ?>
                              <option required value="<?php echo $list->id; ?>"><?php echo $list->fullname; ?></option>
                              <?php $i++;
                            } ?>
                          </select>
                        </div>
                      </th>
                      <th>  <div class="form-group">
                        <button type="button" onclick="saveNotification()" class="btn btn-primary shadow-primary px-5"> Search</button>
                      </div>
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div><!-- End Row-->


    <div class="row">
      <div class="col-lg-12">

    <div class="card">
      <div class="card-header"><i class="fa fa-table"></i>Register User List</div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="default-datatable" class="table table-bordered">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>total amount</th>
                <th>paid</th>
                <th>Remaining balance</th>
                <th>total installment</th>
                <th>total paid installment</th>
              </tr>
            </thead>
            <tbody>
              <?php  $i=1;foreach($installmentInfo as $use){ ?>
                <tr>
                  <td><?php echo $use->id;?></td>
                  <td><?php echo $use->name; ?></td>
                  <td><?php echo $use->total_amt; ?></td>
                  <td><?php echo $use->paid_installment; ?></td>
                  <td><?php echo $use->total_installment; ?></td>
                  <td><?php echo $use->paid_installment; ?></td>
                  <td><?php echo $use->workName; ?></td>

                </tr>
                <?php $i++;} ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>total amount</th>
                  <th>paid</th>
                  <th>Remaining balance</th>
                  <th>total installment</th>
                  <th>total paid installment</th>
                      </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div><!-- End Row-->

  </div>

</div>
</div>
</div>
</div>

</div>
</div>
<?php
$this->load->view('admin/comman/footerpage');
?>
<script>
function saveNotification(){
  $("#dvloader").show();
  var formData = new FormData($("#savenotifi")[0]);
  $.ajax({
    type:'POST',
    url:'<?php echo base_url(); ?>index.php/admin/savenotification',
    data:formData,
    dataType: "json",
    cache:false,
    contentType: false,
    processData: false,
    success:function(resp){
      document.getElementById("savenotifi").reset();
      $("#dvloader").hide();
      toastr.success('Notification send successfully.');
      setTimeout(function(){ location.reload();
      }, 500);
      console.log(resp);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      $("#dvloader").hide();
      console.log(errorThrown.msg,'STATUS: '+textStatus+'\n ERROR THROWN: '+errorThrown);

    }
    ,complete: function () {
      // Handle the complete event
      setTimeout(function(){ location.reload();
      }, 500);
      toastr.success('Operation Completed.');
    }
  });


}


</script>
