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
			<ul class="clearing-thumbs" data-clearing>
				
				<?php foreach($photos as $photo) { ?>
					<li>
						<div class="gallery-thumbnails"> 
							<a href="<?php echo base_url() . 'static/user_upload/' . $photo->filename; ?>">
								<img src="<?php echo base_url() . 'static/user_upload/' . $photo->thumbnailFilename; ?>">
								<input class="delete-photo" type="button" value="Delete" />
							</a>
						</div>
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
    					// user ajax to reload gallery
						$('.clearing-thumbs').slideUp(1500);
						$.get('<?php echo site_url("/restaurant/photo_gallery/" . $restaurant->id); ?>', function(html){
							new_html = $(html).find('.clearing-thumbs').html();
							$('.clearing-thumbs').html(new_html);
							$('.clearing-thumbs').slideDown(1500);
						});
						// clear file from uploader
						Dropzone.instances[0].removeAllFiles();
						$("#dropzone-photo-upload").dropzone();
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

		$(".delete-photo-button").on("click", function() {
			alert("shit");
		});

		function uploadPhotos() {
			var photoUploader = Dropzone.instances[0];
			if(photoUploader.files.length > 0 ) {
				photoUploader.processQueue();	
			}
			else {
				alert("Sorry ! You have to choose photo to upload");
			}
		};
		
	</script>

	<?php require 'scripts.php'?> 
	<?php require 'footer.php'?>
</body>	
</html>