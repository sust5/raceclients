<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Notification</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Notification</a></li>
					<li class="breadcrumb-item active" aria-current="page">Send Notification</li>
				</ol>
			</div>
		</div>
		<!-- End Breadcrumb-->

		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Send Notification</div>
						<hr>
						<form id="savenotifi" name='Notification' enctype="multipart/form-data" action="">
							<div class="form-group">
								<label for="input-1">Title</label>
								<input type="text" required  class="form-control" name="title" id="input-1" value="title" placeholder="Enter title">
							</div>

							<div class="form-group">
								<label for="input-2">Message</label>
								<textarea name="body" value="msg" class="form-control"></textarea>
							</div>

							
						<!-- 	<div class="form-group">
								<label for="input-1">Image (Optional)</label>
								<input type="file" required  class="form-control" name="thumbnail" id="input-1" placeholder="Enter Video Name">
								<p class="noteMsg">Note: Image Size Minimum - 512x256 & Maximum - 2880x1440</p>
							</div> -->

							<div class="form-group">
								<label for="input-2">Select User</label>
								<!-- DropDown -->
								<select name="select_user" required  class="form-control">
									<option value="0">All User</option>
									<?php $i=1;foreach($userList as $user){ ?>
										<option required value="<?php echo $user->id; ?>"><?php echo $user->fullname; ?></option>
										<?php $i++;
									} ?>
								</select>
							</div>

							<div class="form-group">
								<button type="button" onclick="saveNotification()" class="btn btn-primary shadow-primary px-5"> Save</button>
							</div>
						</form>
					</div>
				</div>


			</div></div>


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
