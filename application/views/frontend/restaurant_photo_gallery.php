<?php include 'metadata.php'?>

<body>
	<?php require 'nav.php'?>
	<!-- Begin Restaurant Navigation bar -->
	<div class="row navigation" style="position: relative; top:20px; background: #565a5c;">
		<div class="large-12 large-centered" >
			<a href="<?php echo site_url('restaurant/show_restaurant')?>/<?php echo $restaurant->id ?>">
				<div class="large-2 columns">
					<font color="white">Overview</font>
				</div>
			</a>
			<a href=""><div class="large-2 columns">  <font color="white">Photos</font> </div></a>
			<a href=""><div class="large-2 columns">  <font color="white">Articles</font> </div></a>
			<a href="#map"><div class="large-2 columns">  <font color="white">Map</font> </div></a>
			<div class="large-4 columns"></div>
		</div>
	</div>

	<div class="row restaurant">
		<div class="large-12 large-centered">
			<ul class="clearing-thumbs" data-clearing>
				<?php foreach($photos as $photo) { ?>
					<li>
						<a href="<?php echo base_url() . 'static/user_upload/' . $photo->filename; ?>">
							<img src="<?php echo base_url() . 'static/user_upload/' . $photo->thumbnailFilename; ?>">
						</a>
						<!-- <a href="">
						<img class="delete-photo-button" src="<?php echo base_url() . 'static/frontend/img/close.png' ?>" style="width:15px;height:15px">
					</a> -->
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<?php if($this->session->userdata('id') && ($this->session->userdata('id') == $restaurant->owner_id ) ) { ?> }
		<div class="row restaurant" id="photo-upload">
			<div class="large-12 large-centered">
				<form action="<?php echo site_url('/photo/upload_restaurant_photo'); ?>" class="dropzone" id="dropzone-photo-upload"> 
					<input type="hidden" name="restaurant-id" value="<?php echo $restaurant->id ?>" />
				</form>
			</div>
		</div>
	<?php } ?>

	<?php require 'scripts.php'?>
	<?php require 'footer.php'?>

	<script type="text/javascript">
		var uploadedFiles = [];
		$( document ).ready( function() {
			Dropzone.options.dropzonePhotoUpload = {
				paramName: "file", // The name that will be used to transfer the file
				maxFilesize: 2, // MB
				uploadMultiple: true,
				createImageThumbnails: true,
				acceptedFiles: 'image/*',
				addRemoveLinks: true,
				createImageThumbnails: true,
				parallelUploads: 100,

				//autoProcessQueue: false,	// not uploading each time file added
				// maxFiles: 50,

				init:function() {
					this.on("removedfile", function(file) {
						$.ajax({
				  			type : "POST",
				  			url : "<?php echo site_url('/photo/remove_uploaded_restaurant_photo') ?>",
				  			data: "filename=" + file.serverFileName + "&restaurant-id=" + <?php echo $restaurant->id ?>,
				  			success: function(result) {
				  			}
				  		});
    				});
    				this.on("success", function(file, response) {
    					var nameOnServer = response;
    					file.serverFileName = nameOnServer;
    				});
				}
			};
		});
		
		$(document.body).on("open.fndtn.clearing", function(event) {
		  	$("#photo-upload").hide();
		});

		$(document.body).on("closed.fndtn.clearing", function(event) {
		  	$("#photo-upload").show();
		});

		$(".delete-photo-button").on("click", function() {
			alert("shit");

		});
		
	</script>

</body>	
</html>