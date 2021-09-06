<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Add Course</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Course</a></li>
					<li class="breadcrumb-item active" aria-current="page">Update Course</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/courselist" class="btn btn-outline-primary waves-effect waves-light">Course List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<?php // print_r($category);?>
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Update Course</div>
						<hr>
						<form id="edit_course_form"  enctype="multipart/form-data">
							<div class="form-group">
								<label for="input-1">Course Name</label>
								<input type="text" name="course_name" class="form-control" id="input-1" placeholder="Enter Your Course Name" value="<?php echo $course[0]->course_name?>">
							</div>
							<input type="hidden" name="id" value="<?PHP echo $course[0]->course_id; ?>"></div>
							</div>
							<div class="form-group">
								<button type="button" onclick="updatecourse()" class="btn btn-primary shadow-primary px-5">Update</button>
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
			function updatecourse(){
				var course_name=jQuery('input[name=course_name]').val();
				if(course_name==''){
					toastr.error('Please enter course name','failed');
					return false;
				}
				$("#dvloader").show();

				var formData = new FormData($("#edit_course_form")[0]);
				$.ajax({
					type:'POST',
					url:'<?php echo base_url(); ?>index.php/admin/updatecourse',
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					dataType: 'json', 
					success:function(resp){
						$("#dvloader").hide();
						if(resp.status=='200'){
							document.getElementById("edit_course_form").reset();
							toastr.success(resp.msg);
							window.location.replace('<?php echo base_url(); ?>index.php/admin/courselist');
						}else{
							toastr.error(resp.msg);
						}
					}
				});
			}
		</script>