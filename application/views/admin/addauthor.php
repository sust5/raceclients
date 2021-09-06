<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Add Teacher</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Authors</a></li>
					<li class="breadcrumb-item active" aria-current="page">Add Teacher</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/authorlist" class="btn btn-outline-primary waves-effect waves-light">Teacher List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Add Teacher
							<form id="edit_video_form"  enctype="multipart/form-data">

								<div class="form-group">
									<label for="input-1">Teacher Name</label>
									<input type="text" required value="" class="form-control" name="input_name" id="input-1" >
								</div>

								<input type="hidden" name="id" value="">

								<div class="form-group">
									<label for="input-1">Teacher Address</label>
									<input type="text" required value="" class="form-control" name="input_address" id="input-1" >
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
									<label for="input-1"> Teacher Profile Picture</label>
									<input type="file" required  class="form-control" name="input_profile" id="input-1" onchange="readURL(this,'showImage')">
									<input type="hidden" name="input_bookcover" value="">
									<p class="noteMsg">Note: Image Size must be less than 2MB.Image Height and Width less than 1000px.</p>
									<img id="showImage" src="<?php echo base_url().'assets/images/placeholder.png';?>" height="150" width="150" alt="your image" />
								</div>



								<div class="form-group">
									<label for="input-1">Book Description</label>
									<textarea cols="40" rows="5" style="height: 150px" type="text" required value="" class="form-control" name="input_description" id="input-1" ></textarea>
								</div>

								<div class="form-group">
									<button type="button" onclick="saveauthor()" class="btn btn-primary shadow-primary px-5">Save</button>
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

				function saveauthor(){

					$("#dvloader").show();
					var formData = new FormData($("#edit_video_form")[0]);
					$.ajax({
						type:'POST',
						url:'<?php echo base_url(); ?>index.php/admin/saveauthor',
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