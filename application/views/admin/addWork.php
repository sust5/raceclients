<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Add work</h4>
				<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Work</a></li>
					<li class="breadcrumb-item active" aria-current="page">Add work</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/workList" class="btn btn-outline-primary waves-effect waves-light">Work List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Add work
							<form id="user_form"  enctype="multipart/form-data">

								<div class="form-group">
									<label for="input-1">title</label>
									<input type="text" required value="" class="form-control" name="title" id="input-1" >
								</div>

								<div class="form-group">
									<label for="input-1">date start</label>
									<input type="date" required value="<?php echo date('Y-m-d'); ?>" class="form-control" name="start_date" id="input-1" >
								</div>
								<div class="form-group">
									<label for="input-1">deadline</label>
									<input type="date" required value="" class="form-control" name="dead_line" id="input-1" >
								</div>

									<div class="form-group">
										<label for="input-1">mentor name</label>
										<input type="text" required value="" class="form-control" name="m_name" id="input-1" >
									</div>
									<div class="form-group">
										<label for="input-1">mentor phone number</label>
										<input type="number" required value="" class="form-control" name="m_phone" id="input-1" >
									</div>

									<!-- DropDown -->
									<div class="form-group">
									<label for="input-4">Client</label>
									<select name="user_id" required  class="form-control">
										<option value="">Select Client</option>
                    <?php foreach ($userlist as $key => $value): ?>
                      <?php echo "<option required value=  '$value->id'>"?>  <?php echo  $value->fullname;?></option>
                    <?php endforeach; ?>

										</select>
									</div>
								<div class="form-group">
									<button type="button" onclick="saveWork()" class="btn btn-primary shadow-primary px-5">Save</button>
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

				function saveWork(){

					$("#dvloader").show();
					var formData = new FormData($("#user_form")[0]);
					$.ajax({
						type:'POST',
						url:'<?php echo base_url(); ?>index.php/admin/saveWork',
						data:formData,
						cache:false,
						contentType: false,
						processData: false,
						dataType: "json",
						success:function(resp){
							$("#dvloader").hide();
							if(resp.status=='200'){
								document.getElementById("user_form").reset();
								toastr.success(resp.msg);
								// window.location.replace('<?php echo base_url(); ?>index.php/admin/userlist');
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
