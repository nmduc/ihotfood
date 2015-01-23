<?php include 'metadata.php' ?>
<script type="text/javascript" src="<?php echo base_url(); ?>static/frontend/js/rating/jquery.rating.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>static/frontend/js/rating/jquery.rating.css" />
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=590280537744516&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<?php require 'nav.php' ?>
	<!-- Begin Restaurant Navigation bar -->
	<div class="row navigation" style="position: relative; top:20px; background: #565a5c; "> 
 		<div class="large-12 large-centered" > 
 			<a href=""><div class="large-2 columns">  <font color="white">Overview</font> </div></a> 
 			<a href="<?php echo site_url('restaurant/photo_gallery')?>/<?php echo $restaurant->id ?>"><div class="large-2 columns">  <font color="white">Photos</font> </div></a> 
 			<a href="#map"><div class="large-2 columns">  <font color="white">Map</font> </div></a> 
 			<div class="large-4 columns"></div> -->
 		</div>
 	</div>
	
	<!-- Begin Restaurant -->
	<div class="row restaurant">
		<div class="large-12 large-centered">
			<div id="slider_container" class="large-7 columns"
				style="position: relative; top: 0px; left: 0px; width: 612px; height: 350px; background: #191919; overflow: hidden;">
				<!-- Slides Container -->
				<div u="slides"
					style="cursor: move; position: absolute; left: 0px; top: 0px; width: 612px; height: 350px; overflow: hidden;">
					<!-- <div>
						<img u="image"
							src="<?php echo base_url()?>static/user_upload/restaurant_1.jpeg"
							alt="slide 1" /> 
						<img u="thumb"
							src="<?php echo base_url()?>static/user_upload/restaurant_1_thumb.jpg" />
					</div>
					<div>
						<img u="image"
							src="<?php echo base_url()?>static/user_upload/restaurant_2.jpeg"
							alt="slide 2" /> <img u="thumb"
							src="<?php echo base_url()?>static/user_upload/restaurant_2_thumb.jpg" />
					</div>
					<div>
						<img u="image"
							src="<?php echo base_url()?>static/user_upload/restaurant_3.jpeg"
							alt="slide 3" /> <img u="thumb"
							src="<?php echo base_url()?>static/user_upload/restaurant_3_thumb.jpg" />
					</div> -->
					<?php if (count($samplePhotos) > 0 ) { ?>
						<?php for($i = 0; $i < count($samplePhotos); $i++ ) { ?> 
							<div>
								<img u="image"
									src="<?php echo base_url() . 'static/user_upload/' . $samplePhotos[$i]->filename; ?>"
									alt="slide <?php echo $i; ?>" /> 
								<img u="thumb"
									src="<?php echo base_url() . 'static/user_upload/' . $samplePhotos[$i]->thumbnailFilename; ?>" />
							</div>
						<?php } ?>
					<?php } else { ?>
						<div>
							<img u="image"
								src="<?php echo base_url()?>static/user_upload/restaurant_2.jpeg"
								alt="slide 1" /> 
								<img u="thumb"
								src="<?php echo base_url()?>static/user_upload/restaurant_2_thumb.jpg" />
						</div>
					<?php } ?>

				</div>
				<!-- Arrow Navigator Skin Begin -->
				<!-- Arrow Left -->
				<span u="arrowleft" class="jssora05l"
					style="width: 40px; height: 40px; top: 158px; left: 8px;"> </span>
				<!-- Arrow Right -->
				<span u="arrowright" class="jssora05r"
					style="width: 40px; height: 40px; top: 158px; right: 8px"> </span>
				<!-- Arrow Navigator Skin End -->
				<!-- Thumbnail Item Skin Begin -->
				<div u="thumbnavigator" class="jssort01"
					style="position: absolute; width: 800px; height: 100px; left: 0px; bottom: 0px;">
					<div u="slides" style="cursor: move;">
						<div u="prototype" class="p"
							style="position: absolute; width: 72px; height: 72px; top: 0; left: 0;">
							<div class=w>
								<thumbnailtemplate
									style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate>
							</div>
							<div class=c></div>
						</div>	
					</div>
				</div>
				<!-- Thumbnail Item Skin End -->
			</div>
			<div class="large-5 columns">
				<div class="row">
					<h3 class="restaurant-name" property="dc:title"><?php echo $restaurant->name ?></h3>
					<div class="overall-rating" >
						<?php if($restaurant->average_score == 1) { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" checked="checked"/>
		        		<?php } else { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" />
		        		<?php } ?>
			        	<?php if($restaurant->average_score == 2) { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" checked="checked"/>
		        		<?php } else { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" />
		        		<?php } ?>
		        		<?php if($restaurant->average_score == 3) { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" checked="checked"/>
		        		<?php } else { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" />
		        		<?php } ?>
		        		<?php if($restaurant->average_score == 4) { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" checked="checked"/>
		        		<?php } else { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" />
		        		<?php } ?>
		        		<?php if($restaurant->average_score == 5) { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" checked="checked"/>
		        		<?php } else { ?>
			        		<input class="star" type="radio" name="restaurant-score" disabled="disabled" />
		        		<?php } ?>
					</div>
					<br>
					<p class="restaurant-description">
						<?php echo ( ((strlen($restaurant->description)) > 200) ? 
								substr($restaurant->description, 0, 200) . "..." . "(<a href='#description'> read more</a>)" 
							: 	$restaurant->description) ?> </p>
				</div>
				<div class="row">
					<p class="restaurant-info">
						<i class="fa fa-location-arrow"></i>&nbsp; 
						<?php echo "". $restaurant->address_number . " , " . $restaurant->address_street .
								   " , " . $restaurant->address_ward . " , " . $restaurant->address_city;
						?>
					</p>
				</div>
				<div class="row">
					<p class="restaurant-info">
						<i class="fa fa-phone"></i>&nbsp; <?php echo $restaurant->phone_number ?>
					</p>
				</div>
				<div class="row">
					<p class="restaurant-info">
						<i class="fa fa-clock-o"></i>&nbsp; 
						<?php echo "" . $restaurant->opening_hour . ".00 - " . $restaurant->closing_hour . ".00" ?>
					</p>
				</div>
				<div class="row">
					<p class="restaurant-info">
						<i class="fa fa-money"></i>&nbsp; 
						<?php echo "" . $restaurant->lowest_price . " - " . $restaurant->highest_price ?>
					</p>
				</div>
				<?php if($this->session->userdata('id')) { ?> 
					<?php if($this->session->userdata('id')  == $restaurant->owner_id) { ?> 
						<div class="row">
							<a href="<?php echo base_url()?>index.php/user/manage/show_edit_location/<?php echo $restaurant->id ?>" > 
								<input class="button tiny" type="button" value="Edit location" style="position:absolute;"> </a>
						</div>
					<?php } else { ?>
						<div class="row">
							<input class="button tiny" type="button" value="Write a review" style="position:absolute;" onclick="open_review_form()"> 
						</div>
					<?php } ?>
					<br>
					<br>
				<?php } ?>
				<div class="row">
					<div class="fb-like" 
						data-href="http://ihotfood.com/index.php/restaurant/show_restaurant/<?php echo $restaurant->id; ?>" 
						data-layout="standard" data-action="like" data-show-faces="true" data-share="true">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Restaurant -->
	<!-- Begin Restaurant Additions -->
	<div class="row restaurant-addition">
		<!-- Begin Comment Container-->
		<div class="large-9 columns">
			<div class="row comment-container">
				<div class="large-12 comments" id="comments-listing">
					<!-- Write review form -->
					<?php include_once 'review_form.php';?>
					<!-- End review form -->
					
					<span>All Reviews (<?php if (sizeof($reviews) < 1) {
							echo '0';
						}  else {
							echo sizeof($reviews);
						}
					?>)</span>
					<!-- User reviews -->
					<?php include_once 'review_listing.php';?>
				</div>
			</div>
		</div>

		<!-- End comment -->
		<!-- Begin Sidebar -->
		<div class="large-3 columns">
			<div class="row">
			</div>
		</div>
		<!-- End Sidebar -->
	</div>
	<!-- End Restaurant Additions -->
	
	<!-- Restaurant details -->
	<div class="row restaurant-detail">
		<div class="large-9 columns">
			<div class="row map-container">
				<div class="large-12 comments">
					<a name="map"><h5>Restaurant Location </h5></a>
					<div class="row description-map">
			          	<div id="map-canvas" style="width: 100%; height: 400px; margin: 0; "></div>
					</div>
				</div>
			</div>
			&nbsp
			<div class="row map-container">
				<div class="large-12 comments">
					<a name="description" property="dc:description"><h5>Restaurant Description </h5></a>
					<p><?php echo($restaurant->description) ?></p>
				</div>
			</div>
			&nbsp
		</div>
		<div class="large-3 columns">
			<div class="row">
			</div>
		</div>
	</div>
	<!-- End Restaurant details -->
	<?php require 'scripts.php'?>
	<?php require 'footer.php'?>
	
	<?php if (isset($restaurant->latlong)) { ?>
		<script type="text/javascript">
			function initialize() {
			  	var map = new google.maps.Map(document.getElementById('map-canvas'), {
			    	mapTypeId: google.maps.MapTypeId.ROADMAP,
			  	});
					var bounds = new google.maps.LatLngBounds();
					var initialLocation = new google.maps.LatLng(<?php echo($restaurant->latlong); ?>);
			  		bounds.extend(initialLocation);
			  		map.fitBounds(bounds);
			  		setMarker(initialLocation);
					var listener = google.maps.event.addListener(map, "idle", function() { 
						if (map.getZoom() > 16) map.setZoom(16); 
						google.maps.event.removeListener(listener); 
					});

					google.maps.event.addListener(map, 'click', function(event) {
				        mapZoom = map.getZoom();
				        startLocation = event.latLng;
				        setMarker(startLocation );
				    });

					function setMarker(location) {
					  	var myMarker = new google.maps.Marker({
					    	position: location,
					    	map: map
					  	});
					  	myMarker.setMap(map);
					}
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	<?php } ?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#input-review-title").keydown(function(event){
				if(event.keyCode == 13) {
		      		event.preventDefault();
		      		return false;
		    	}
		  	});
		});
	</script>
	<script type="text/javascript">
		function open_review_form() {
			clear_edit_form();
			$("#review-form").show();
		}
	</script>
	
</body>
</html>