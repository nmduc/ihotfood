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

	<a name="gallery"> </a>
	<div class="row restaurant">
		<div class="large-12 large-centered">
			<ul class="clearing-thumbs" data-clearing data-options={open_selectors:'.clearing-img'}>
				<?php foreach($photos as $photo) { ?>
					<li>
						<div class="gallery-thumbnails"> 
							<a class="clearing-img" href="<?php echo base_url() . 'static/user_upload/' . $photo->filename; ?>">
								<img src="<?php echo base_url() . 'static/user_upload/' . $photo->thumbnailFilename; ?>">
							</a>
							<input class="delete-photo-button" type="button" value="Delete" onclick="deletePhoto('<?php echo $photo->filename; ?>')" />
						</div>
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
				<a href="#gallery"> <input type="submit" value="Upload photos" onclick="uploadPhotos()" /> </a>
			</div>
		</div>
	<?php } ?>

	<script type="text/javascript">
		$( document ).ready( function() {
			Dropzone.options.dropzonePhotoUpload = {
				paramName: "file", // The name that will be used to transfer the file
				maxFilesize: 2, // MB
				uploadMultiple: true,
				acceptedFiles: 'image/*',
				addRemoveLinks: true,
				createImageThumbnails: true,
				parallelUploads: 100,
				autoProcessQueue: false,

				init:function() {
    				this.on("successmultiple", function(file, response) {
    					refreshGallery();
    				});
				},
			};
		});
		
		$(document.body).on("open.fndtn.clearing", function(event) {
		  	$("#photo-upload").hide();
		});

		$(document.body).on("closed.fndtn.clearing", function(event) {
		  	$("#photo-upload").show();
		});

		function uploadPhotos() {
			var photoUploader = Dropzone.instances[0];
			if(photoUploader.files.length > 0 ) {
				photoUploader.processQueue();	
			}
			else {
				alert("Sorry ! You have to choose photo to upload");
			}
		}

		function deletePhoto(filename) {
			$.ajax({
				type : 'POST',
				url : "<?php echo site_url('photo/remove_photo/'); ?>",
				data : 'filename=' + filename,
				success : function(response) {
					if (response['status'] != 'trt ue') {
						refreshGallery();
					}
					else {
						alert("Something went wrong. Please try again later")
					}
				},
			});
		}		
		
		// user ajax to reload gallery
		function refreshGallery() {
			$('.clearing-thumbs').slideUp(500);
			$.get('<?php echo site_url("/restaurant/photo_gallery/" . $restaurant->id); ?>', function(html){
				new_html = $(html).find('.clearing-thumbs').html();
				$('.clearing-thumbs').html(new_html);
				$('.clearing-thumbs').slideDown(500);
			});
			// clear file from uploader
			Dropzone.instances[0].removeAllFiles();
		}

	</script>

	<?php require 'scripts.php'?> 
	<?php require 'footer.php'?>
</body>	
</html>