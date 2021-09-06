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
				<h4 class="page-title">Add course</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">course</a></li>
					<li class="breadcrumb-item active" aria-current="page">Add course</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/courselist" class="btn btn-outline-primary waves-effect waves-light">course List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->

		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Add course</div>
						<hr>
						<form id="category_form"  enctype="multipart/form-data">
							<div class="form-group">
								<label for="input-1">course Name</label>
								<input type="text" name="course_name" class="form-control" id="name">
							</div>
							<div class="form-group">
								<button type="button" onclick="saveCourse()" class="btn btn-primary shadow-primary px-5">Save</button>
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
			function saveCourse(){

				var formData = new FormData($("#category_form")[0]);
				var category = $("#name").val();
				if(category == '') {
					toastr.error('Please enter course Name.');
					$("#category").focus();
					return false;
				}
				$("#dvloader").show();
				$.ajax({
					type:'POST',
					url:'<?php echo base_url(); ?>index.php/admin/savecourse',
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					dataType: 'json', 
					success:function(resp){
						$("#dvloader").hide();
						if(resp.status=='200'){
							document.getElementById("category_form").reset();
							toastr.success(resp.msg);
							// window.location.replace('<?php echo base_url(); ?>index.php/admin/categorylist');
						}else{
							toastr.error(resp.msg);
						}
					}
				});
			}
		</script>