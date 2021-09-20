<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Add Social Media Link</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Website</a></li>
					<li class="breadcrumb-item active" aria-current="page">Add Social Media Link</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/socialMedia" class="btn btn-outline-primary waves-effect waves-light">Social Media List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">
							<form id="edit_video_form"  enctype="multipart/form-data">

								<div class="form-group">
									<label for="input-1">Name</label>
									<input type="text" required value="" class="form-control" name="input_name" id="input-1" >
								</div>
								<div class="form-group">
									<label for="input-1">link</label>
									<input type="text" required value="" class="form-control" name="input_address" id="input-1" >
								</div>
								<div class="form-group">
									<label for="input-1">forground color</label>
									<input type="text" required value="" class="form-control" name="input_f_color" id="input-1" >
								</div>
								<div class="form-group">
									<label for="input-1">background color</label>
									<input type="text" required value="" class="form-control" name="input_b_color" id="input-1" >
								</div>
								<div class="form-group">
									<label for="input-1">icon e.g. "fa fa-facebook"</label>
									<input type="text" required value="" class="form-control" name="input_icon" id="input-1" >
								</div>
								<div class="form-group">
									<button type="button" onclick="saveSocialLink()" class="btn btn-primary shadow-primary px-5">Save</button>
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

				function saveSocialLink(){

					$("#dvloader").show();
					var formData = new FormData($("#edit_video_form")[0]);
					$.ajax({
						type:'POST',
						url:'<?php echo base_url(); ?>index.php/admin/saveSocialLink',
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