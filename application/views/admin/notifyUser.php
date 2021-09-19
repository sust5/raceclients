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
								<input type="text"   class="form-control" name="title" id="input-1"  value="Dear <?php echo $userlist[0]->fullname; ?> , Your bill on date -- <?php echo $date; ?> -- have some issues.">
							</div>
							<div class="form-group">
								<label for="input-1">User</label>
								<input type="text"   class="form-control" name="username" id="input-1"  value="<?php echo $userlist[0]->fullname; ?>" readonly>
								<input type="text"   class="form-control" name="select_user" id="input-1"  value="<?php echo $userlist[0]->id;?>" hidden readonly>
							</div>

							<div class="form-group">
								<label for="input-2">Message</label>
								<textarea name="body" value="msg" class="form-control"></textarea>
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
