<?php
$this->load->view('admin/comman/header');
?>


<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Offer</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javaScript:void();">Offer</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Update Offer</a></li>
				</ol>
			</div>

		</div>



			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">

						<ul class="nav nav-pills nav-pills-danger nav-justified top-icon" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="pill" href="#piil-17"><i class="fa fa-picture-o"></i> <span class="hidden-xs">Add Offer Image</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="pill" href="#piil-20"><i class="fa fa-pencil-square-o"></i> <span class="hidden-xs">Update Offer Image</span></a>
							</li>

						</ul>

						<!-- Tab panes -->
						<div class="tab-content">

							<div id="piil-17" class="container tab-pane active show">
									<hr>
									<div class="card-title">Save Offer Image</div>
									<hr>
						<form id="savenotifi" name='Notification' enctype="multipart/form-data" action="">
							<div class="form-group">
								<label for="input-1">Title</label>
								<input type="text" required  class="form-control" name="o_title" id="input-1" value="" placeholder="Enter title">
							</div>
							<div class="form-group">
								<label for="input-1">description</label>
								<input type="text" required  class="form-control" name="o_desc" id="input-1" value="" placeholder="Enter title">
							</div>
							<div class="form-group">
								<label for="input-1">URL</label>
								<input type="text" required  class="form-control" name="o_url" id="input-1" value="" placeholder="Enter title">
							</div>

							<div class="form-group">
								<label for="input-1">Image</label>
								<input type="file" required  class="form-control" name="userfile" id="input-1" placeholder="Enter Video Name">
								<p class="noteMsg">Note: Image Size Minimum - 512x256 & Maximum - 2880x1440</p>
							</div>
							<div class="form-group">
								<button type="button" onclick="saveOffer()" class="btn btn-primary shadow-primary px-5"> Save</button>
							</div>
						</form>
							</div>

							<div id="piil-20" class="container tab-pane fade">
								  <!-- End Breadcrumb-->
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">

		<div class="card">
			<div class="card-header"><i class="fa fa-table"></i>Gallery</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="default-datatable" class="table table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>title</th>
								<th>desc</th>
								<th>url</th>
								<th>image</th>
								<th>date</th>
								<th>option</th>
							</tr>
						</thead>
						<tbody>
							<?php  $i=1;foreach($cList as $use){ ?>
								<tr>
									<td><?php echo $use->o_id;?></td>
									<td><?php echo $use->o_title; ?></td>
									<td><?php echo $use->o_desc; ?></td>
									<td><?php echo $use->o_url; ?></td>
									<td><img src="<?php echo base_url().$use->o_image_url; ?>" height="250px" width="250px"></td>
									<td><?php  echo $use->o_date; ?></td>
									<td>
										<a class="btn btn-danger" href="javaScript:void(0)"  onclick="delete_record('<?php echo $use->o_id; ?>','offer')" >delete &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
										<input type="hidden" name="status_change" id="status_change_user <?php echo $use->o_id; ?>" value="<?php echo $use->o_id; ?>">
									</td>
								</tr>
								<?php $i++;} ?>

							</tbody>
							<tfoot>
								<tr>
								<th>Id</th>
								<th>title</th>
								<th>desc</th>
								<th>url</th>
								<th>image</th>
								<th>date</th>
								<th>option</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div><!-- End Row-->

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
		<script>
			$(document).ready(function() {
			$('#default-datatable').DataTable();
		} );
		
			function saveOffer(){
				$("#dvloader").show();
				var formData = new FormData($("#savenotifi")[0]);
				$.ajax({
					type:'POST',
					url:'<?php echo base_url(); ?>index.php/admin/saveOffer',
					data:formData,
					dataType: "json",
					cache:false,
					contentType: false,
					processData: false,
					success:function(resp){
						document.getElementById("savenotifi").reset();
						$("#dvloader").hide();
						toastr.success('saved into gallery.');
							setTimeout(function(){ location.reload();
							}, 500);
							console.log(resp);
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							$("#dvloader").hide();
							toastr.error(errorThrown.msg,errorThrown+" rename your file and try again");

						}
					,complete: function () {
        // Handle the complete event
        // setTimeout(function(){ location.reload();
				// 			}, 500);
							// toastr.success('Operation Completed.');
      }
 });


			}


		</script>
			
		