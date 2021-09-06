<?php
$this->load->view('admin/comman/header');
?>


?> 

<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">

    <!--Start Dashboard Content-->
    <div class="row mt-4">
      <div class="col-12 col-lg-6 col-xl-3">
        <div class="card gradient-knight">
          <div class="card-body">
            <div class="media">
              <span class="text-white" style="font-size:30px;"><i class="fa fa-home"></i></span>
              <div class="media-body text-left" style="margin-left: 10px">
                <a href="<?php echo base_url();?>index.php/admin/userlist">
                  <h4 class="text-white"><?php echo $totalUser;?></h4>
                  <h5 class="text-white">Total Users</<h5>
                </div>
                <div class="align-self-center"><span id="dash-chart-1"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-scooter">
            <div class="card-body">
              <div class="media">
                <span class="text-white" style="font-size:30px;"><i class="fa fa-book"></i></span>
               <div class="media-body text-left" style="margin-left: 10px">
                <a href="<?php echo base_url();?>index.php/admin/userlist">
                  <h4 class="text-white"><?php echo $totalClient;?></h4>
                  <h5 class="text-white">Total Client</h5>
                </div>
                <div class="align-self-center"><span id="dash-chart-3"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
          <div class="card gradient-blooker">
            <div class="card-body">
              <div class="media">
                <span class="text-white" style="font-size:30px;"><i class="fa fa-download"></i></span>
                <div class="media-body text-left" style="margin-left: 10px">
                <a href="<?php echo base_url();?>index.php/admin/userlist">
                    <h4 class="text-white"><?php echo $totalVendor;?></h4>
                    <h5 class="text-white">Total Vendor</h5>
                  </div>
                  <div class="align-self-center"><span id="dash-chart-1"></span></div>
                </div>
              </div>
            </div>
          </div>

        </div><!--End Row-->

    

        </div><!--End content-wrapper-->
        <?php
        $this->load->view('admin/comman/footerpage');
        ?>

