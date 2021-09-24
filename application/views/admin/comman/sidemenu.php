<!-- Start wrapper-->
<div id="wrapper">

  <!--Start sidebar-wrapper-->
  <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
      <a href="<?php echo base_url();?>index.php/admin">
        <!--  <img src="<?php echo base_url().'assets/images/app/'.$setn['app_logo']; ?>" class="logo-icon" > -->
        <!-- <h5 class="logo-text"><?php echo $setn['app_name'];?></h5> -->
        <h5 class="logo-text" style="color: #ee4748">Race Groups</h5>
      </a>
    </div>

    <ul class="sidebar-menu do-nicescrol">

      <li>
        <a href="<?php echo base_url();?>index.php/admin/dashboard" class="waves-effect">
          <i class="icon-home"></i><span>Dashboard</span><i class="fa fa-angle-right pull-right"></i>
        </a>
      </li>

      <li>
        <a class="waves-effect">
          <i class="fa fa-user"></i><span>User</span>
          <i class="fa fa-angle-right float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?php echo base_url();?>index.php/admin/addUser"><i class="fa fa-user-plus"></i> Add User</a>
          </li>
          <li>
            <a href="<?php echo base_url();?>index.php/admin/userList" class="waves-effect">
              <i class="fa fa-user"></i><span>Client</span>
              <i class="fa fa-angle-right float-right"></i>
            </a>
            <ul class="sidebar-submenu">

              <li><a href="<?php echo base_url();?>index.php/admin/userListClient"><i class="fa fa-list"></i>Client List</a></li>
          <li><a href="<?php echo base_url();?>index.php/admin/InstallmentDetails">
            <i class="fa fa-list"></i>Installment details</a></li>
          </ul>


          </li>

          <li>
            <a href="<?php echo base_url();?>index.php/admin/userlist" class="waves-effect">
              <i class="fa fa-user"></i><span>vendor</span>
              <i class="fa fa-angle-right float-right"></i>
            </a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo base_url();?>index.php/admin/userlistVendor"><i class="fa fa-list"></i> List User</a></li>
              <li><a href="<?php echo base_url();?>index.php/admin/billsDetails"><i class="fa fa-list"></i> Bills details</a></li>
              <li><a href="<?php echo base_url();?>index.php/admin/vendorPayment"><i class="fa fa-list"></i> vendor Payment</a></li>
            </ul>
          </li>

        </ul>
      </li>

      <li>
        <a class="waves-effect">
          <i class="fa fa-briefcase"></i><span>Work</span> <i class="fa fa-angle-right float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="<?php echo base_url();?>index.php/admin/addwork" class="waves-effect">
            <i class="fa fa-plus"></i><span>add work</span></a>
          </li>

          <li><a href="<?php echo base_url();?>index.php/admin/gallery" class="waves-effect">
            <i class="fa fa-picture-o"></i><span>Gallery</span></a>
          </li>

          <li><a href="<?php echo base_url();?>index.php/admin/workProgress" class="waves-effect">
            <i class="fa fa-picture-o"></i><span>work progress</span></a>
          </li>

          <li><a href="<?php echo base_url();?>index.php/admin/workUpdates" class="waves-effect">
            <i class="fa fa-picture-o"></i><span>Daily updates</span></a>
          </li>

          <li><a href="<?php echo base_url();?>index.php/admin/workList" class="waves-effect">
            <i class="fa fa-list"></i><span>work list</span></a>
          </li>


        </ul>
      </li>
      <li>
        <a href="<?php echo base_url();?>index.php/admin/userSuggest" class="waves-effect">
          <i class="fa fa-envelope"></i><span>User Suggestion</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url();?>index.php/admin/notification" class="waves-effect">
          <i class="fa fa-bell"></i><span>Notification</span>
        </a>
      </li>

      <li>
        <a href="<?php echo base_url();?>index.php/admin/settingpage" class="waves-effect">
          <i class="fa fa-cogs"></i><span>Setting</span>
        </a>
      </li>

           <li>
            <a href="" class="waves-effect">
              <i class="fa fa-user"></i><span>Mobile App</span>
              <i class="fa fa-angle-right float-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="<?php echo base_url();?>index.php/admin/carouselPage" class="waves-effect"><i class="fa fa-cogs"></i><span>carousel Images</span></a></li>
                <li><a href="<?php echo base_url();?>index.php/admin/update_text"><i class="fa fa-list"></i> Update Text</a></li>
                <li><a href="<?php echo base_url();?>index.php/admin/offer"><i class="fa fa-list"></i> Offer</a></li>
                <li><a href="<?php echo base_url();?>index.php/admin/socialMedia"><i class="fa fa-list"></i> Social Media</a></li>
                <li><a href="<?php echo base_url();?>index.php/admin/siteGallery"><i class="fa fa-list"></i> Gallery</a></li>
                <li><a href="<?php echo base_url();?>index.php/admin/faqPage"><i class="fa fa-list"></i> FAQ</a></li>
<li><a href="<?php echo base_url();?>index.php/admin/reviewPage"><i class="fa fa-list"></i> Review</a></li>

           </ul>
          </li>

      <li>
        <a href="<?php echo base_url();?>index.php/admin/logout" class="waves-effect">
          <i class="icon-power mr-2"></i><span>Logout</span>

        </a>
      </li>
    </ul>

  </div>
  <!--End sidebar-wrapper-->
