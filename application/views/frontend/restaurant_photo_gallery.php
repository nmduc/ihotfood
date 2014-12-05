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
			<form action="<?php echo site_url('/photo/upload_photo'); ?>" class="dropzone" id="dropzone-photo-upload"> 
				<input type="hidden" name="restaurant-id" value="<?php echo $restaurant->id ?>" />
			</form>
		</div>
	</div>

	<div class="row restaurant">
		<div class="large-12 large-centered">
		</div>
	</div>

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

				init:function() {
					this.on("removedfile", function(file) {
						$.ajax({
				  			type : "POST",
				  			url : "<?php echo site_url('/photo/remove_uploaded_photo') ?>",
				  			data: "filename=" + file.serverFileName,
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
	</script>

</body>	
</html>