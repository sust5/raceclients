<?php
$this->load->view('admin/comman/header');
?>

<div class="content-wrapper">
	<div class="container-fluid">
		<div class="clearfix"></div>
		<div class="row">
			<?php $setn=array(); foreach($settinglist as $set){
				$setn[$set->key]=$set->value;
			}
			?>
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body"> 

						<ul class="nav nav-pills nav-pills-danger nav-justified top-icon" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="pill" href="#piil-17"><i class="icon-home"></i> <span class="hidden-xs">App Setting</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="pill" href="#piil-20"><i class="icon-lock"></i> <span class="hidden-xs">Change Password</span></a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" data-toggle="pill" href="#piil-19"><i class="icon-envelope-open"></i> <span class="hidden-xs">Notification Setting</span></a>
							</li>

							

						</ul>

						<!-- Tab panes -->
						<div class="tab-content">

							<div id="piil-17" class="container tab-pane active show">
								<form id="save_setting"  enctype="multipart/form-data">

									<div class="form-group">
										<label for="input-1">App Name</label>
										<input type="text" name="app_name" required class="form-control" id="input-1" placeholder="Enter Your App Name" value="<?php echo $setn['app_name'];?>">
									</div>

									<div class="form-group">
										<label for="input-1">Company</label>
										<input type="text" name="app_author" required class="form-control" id="input-1" placeholder="Enter Your App Name" value="<?php echo $setn['Author'];?>">
									</div>

									<div class="form-group">
										<label for="input-2">App Image</label>
										<input type="file" name="app_image" required class="form-control" id="input-2" >
										<p></p>
										<input type="hidden" name="app_image_logo" value="<?php echo $setn['app_logo'];?>">
										<div><img src="<?php echo base_url().'assets/images/app/'.$setn['app_logo'];?>" height="100px;" width="100px;"></div>
									</div>
									
									<div class="form-group">
										<label for="input-2">Host Email</label>
										<input type="text" name="host_email" required class="form-control" id="input-2" value="<?php echo $setn['host_email'];?>">
									</div>

									<div class="form-group">
										<label for="input-2">Contact Number</label>
										<input type="text" name="host_contact" required class="form-control" id="input-2" value="<?php echo $setn['contact'];?>">
									</div>

									<div class="form-group">
										<label for="input-2">Website</label>
										<input type="text" name="host_website" required class="form-control" id="input-2" value="<?php echo $setn['website'];?>">
									</div>

									<div class="form-group">
										<label for="input-2">About Us</label>
										<textarea style="height:150px !important;" name="app_desc" required class="form-control" id="input-2" ><?php echo $setn['app_desripation'];?></textarea>
									</div>

									<div class="form-group">
										<label for="input-2">Privacy Policy</label>
										<textarea style="height:250px !important;"  name="app_privacy" required class="form-control" id="input-2" ><?php echo $setn['privacy_policy'];?></textarea>
									</div>

									<div class="form-group">
										<button type="button" class="btn btn-primary shadow-primary px-5" onclick="save_setting()"> Save</button>
									</div>
								</form>
							</div>

							<div id="piil-20" class="container tab-pane fade">
								<form id="save_password" class="mx-auto">
									<div class="form-group">
										<label for="input-1">New Password</label>
										<input type="password" name="password" required class="form-control" id="password" >
									</div>
									<input type="hidden" name="admin_id" value="<?php echo $admin->id;?>">
									<div class="form-group">
										<label for="input-2">Confirm Password</label>
										<input type="password"  name="confirm_password" required class="form-control" id="confirm_password" value="">
									</div>

									<div class="form-group">
										<button type="button" class="btn btn-primary shadow-primary px-5"
										onclick="change_passwords()"> Save</button>
									</div>
								</form>
							</div>

							

							<div id="piil-19" class="container tab-pane fade">
								<form id="save_signal_noti"  enctype="multipart/form-data">
								<!-- 	<div class="form-group">
										<label for="input-1">OneSignal App ID</label>
										<input type="text" name="one_signal" required class="form-control" id="input-1" placeholder="Enter Your App Name" value="<?php 
										//echo $setn['onesignal_apid'];?>">
									</div> -->

									<div class="form-group">
										<label for="input-2">FCM Server Key</label>
										<input type="text" name="rest_key" required class="form-control" id="input-2" value="<?php echo $setn['onesignal_rest_key'];?>">
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-primary shadow-primary px-5" onclick="save_signal_noti()"> Save</button>
									</div>
								</form>
							</div>


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

<script type="text/javascript">

	function save_setting(){
		var formData = new FormData($("#save_setting")[0]);
		displayLoader();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>index.php/admin/savesetting' ,
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(resp){
				hideLoader();
				if(resp.status=='200'){
					document.getElementById("save_password").reset();
					toastr.success(resp.msg,'App Setting change sucessfully.');
					setTimeout(function(){ location.reload(); }, 500);
				}else{
					toastr.error(resp.msg);
				}
			}
		});
	}


	function change_password(){
		var formData = new FormData($("#save_password")[0]);
		var password = jQuery('#password').val();
		var confirm_password = jQuery('#confirm_password').val();
		if(password!=confirm_password){
			toastr.error('Password and confirm password not match.');
			return false;
		}
		displayLoader();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>index.php/admin/change_password' ,
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(resp){
				hideLoader();
				if(resp.status=='200'){
					document.getElementById("save_password").reset();
					toastr.success(resp.msg,'Password change sucessfully.');
					setTimeout(function(){ location.reload(); }, 500);
				}else{
					toastr.error(resp.msg);
				}
			}
		});
	}

	function save_admob(){
		var formData = new FormData($("#save_admob")[0]);
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>index.php/admin/save_admob' ,
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(resp){
				document.getElementById("save_admob").reset();
				toastr.success('Setting saved.');
			}
		});
	}

	function save_signal_noti(){
		var formData = new FormData($("#save_signal_noti")[0]);

		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>index.php/admin/save_signal_noti' ,
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(resp){
              //document.getElementById("save_signal_noti").reset();
              toastr.success('Setting saved.');
          }
      });
	}

	function save_payment(){
		var formData = new FormData($("#save_payment")[0]);

		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>index.php/admin/save_payment' ,
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(resp){
              //document.getElementById("save_signal_noti").reset();
              toastr.success('Payment Setting saved.');
          }
      });
	}

</script>