<?php
$this->load->view('admin/comman/header');
?>

<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">add vendor payment </h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/admin/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Books</a></li>
					<li class="breadcrumb-item active" aria-current="page">add vendor payment </li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="btn-group float-sm-right">
					<a href="<?php echo base_url();?>index.php/admin/vendorPayment" class="btn btn-outline-primary waves-effect waves-light">Vendor payment List</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">add vendor payment
							<form id="edit_video_form">

								<div class="form-group">
                  <label for="input-1">select Vendor</label>
                  <select name="select_vendor_id" required  class="form-control">
										<?php $i=1;foreach($userlist as $ulist){ ?>
											<option required value="<?php echo $ulist->id; ?>"><?php echo $ulist->fullname; ?></option>
											<?php $i++;
										} ?>
										</select>
								</div>

										<div class="form-group">
											<label for="input-1">currency(Rs.)</label>
                      <input type="text" placeholder="amount" name="amount" class="form-control" required>
                      <input type="text" placeholder="Rs." value="Rs" name="currency" hidden>
										</div>

										<div class="form-group">
											<button type="button" onclick="savebook()" class="btn btn-primary shadow-primary px-5">Save</button>
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

						$('#purpose').on('change', function () {
							if (this.value === '1'){
								$("#business").show();
							} else {
								$("#business").hide();
							}
						});

						function savebook(){

							// var wallpaper_title=jQuery('input[name=wallpaper_title]').val();
							// if(wallpaper_title==''){
							// 	toastr.error('Please enter Book Name','failed');
							// 	return false;
							// }
							$("#dvloader").show();
							var formData = new FormData($("#edit_video_form")[0]);
							$.ajax({
								type:'POST',
								url:'<?php echo base_url(); ?>index.php/admin/vendorPaymentSave',
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
									toastr.error(errorThrown.msg,'STATUS: '+textStatus+'\nERROR THROWN: '+errorThrown);
									console.log('STATUS: '+textStatus+'\nERROR THROWN: '+errorThrown);
								}
							});
						}
						function checkVtype(server){
					if(server!='Server Video'){
						$('#videoLink').html('<label for="input-1">Video url</label><input type="text" required  class="form-control" name="video_url" id="input-1" placeholder="Enter Video url">');
					}else{
						$('#videoLink').html('<label for="input-1">Upload Video</label><input type="file" required  class="form-control" name="video_upload" id="input-1" placeholder="Enter Video Name">');
					}
				}
					</script>
