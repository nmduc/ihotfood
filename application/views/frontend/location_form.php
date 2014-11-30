<?php include 'metadata.php'?>
<script src="<?php echo base_url(); ?>static/frontend/js/zmultiselect/zurb5-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>static/frontend/js/zmultiselect/zurb5-multiselect.css" />

<script type="text/javascript">
var lat, long;

function initialize() {
	var markers = [];
	var myMarker = null;
  	var map = new google.maps.Map(document.getElementById('map-canvas'), {
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	});

  	var defaultBounds = new google.maps.LatLngBounds(
      	new google.maps.LatLng(-33.8902, 151.1759),
      	new google.maps.LatLng(-33.8474, 151.2631));
  	map.fitBounds(defaultBounds);

  	// Create the search box and link it to the UI element.
  	var input = (document.getElementById('pac-input'));
  	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  	var searchBox = new google.maps.places.SearchBox((input));

  	// [START region_getplaces]
  	// Listen for the event fired when the user selects an item from the
  	// pick list. Retrieve the matching places for that item.
  	google.maps.event.addListener(searchBox, 'places_changed', function() {
    	var places = searchBox.getPlaces();

    	if (places.length == 0) {
      		return;
    	}
    	var myPlace = places[0];
    	if(myMarker) {
    		clear_marker(myMarker);
    	}
  		myMarker = new google.maps.Marker({
    		map: map,
    		icon: image,
    		title: myPlace.name,
    		position: myPlace.geometry.location
  		});

  		setLatLong();

    	// For each place, get the icon, place name, and location.
    	//markers = [];
    	var bounds = new google.maps.LatLngBounds();
    	for (var i = 0, place; place = places[i]; i++) {
      		var image = {
        		url: place.icon,
        		size: new google.maps.Size(71, 71),
        		origin: new google.maps.Point(0, 0),
        		anchor: new google.maps.Point(17, 34),
        		scaledSize: new google.maps.Size(25, 25)
      		};
      		bounds.extend(place.geometry.location);
    	}

    	map.fitBounds(bounds);
  	});
  	// [END region_getplaces]

	google.maps.event.addListener(map, 'click', function(event) {
        mapZoom = map.getZoom();
        startLocation = event.latLng;
        setMarker(startLocation );
    });

    function setMarker(location) {
    	if(myMarker) {
    		clear_marker(myMarker);
    	}
	  	myMarker = new google.maps.Marker({
	    	position: location,
	    	map: map
	  	});
	  	setLatLong();
	}

	function setLatLong() {
		lat = myMarker.position.k;
	  	long = myMarker.position.B;
	  	document.getElementById("latlong").value = "" + lat +"," + long;
	}

	function setMap(map) {
		myMarker.setMap(map);
	}

	function clear_marker(marker) {
		marker.setMap(null);
	}
	
  	// Bias the SearchBox results towards places that are within the bounds of the
  	// current map's viewport.
  	google.maps.event.addListener(map, 'bounds_changed', function() {
    	var bounds = map.getBounds();
    	searchBox.setBounds(bounds);
  	});

  	  	// set map to restaurant location if restaurant exists (edit restaurant)
	<?php if(isset($restaurant)) { 
		echo("
			var bounds = new google.maps.LatLngBounds();
			var initialLocation = new google.maps.LatLng($restaurant->latlong);
	  		bounds.extend(initialLocation);
	  		map.fitBounds(bounds);
	  		setMarker(initialLocation );
	  		");
		}
	?>
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script type="text/javascript">
$(document).ready(function() {
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
      		event.preventDefault();
      		return false;
    	}
  	});
});
</script>
<body>
	<?php require 'nav.php'?>
	<?php require 'static_header.php'?>
	<div class="row">
		<div class="large-8 large-centered columns container">
			<?php 
				if(isset($restaurant))  {
					echo("<h3>Edit your restaurant</h3>");
				}
				else {
					echo("<h3>Add new restaurant</h3>");
				}
			?>

			<p>Your favorite restaurants is not in iHootFood? Let's share it!</p>
			<?php 
				if(isset($restaurant)) {
					echo form_open('user/manage/edit_location/' . $restaurant->id); 
				}
				else {
					echo form_open('user/manage/add_location'); 
				}
			?>

				<!-------- BASIC INFORMATION -------->
				<fieldset>
    				<legend>Basic information</legend>
					<div class="row">
						<div class="small-3 columns">
							<label>Name <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="name" placeholder="Restaurant name" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->name . "'")?> 
			          		/>
				        	<?php echo form_error('name', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Description <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="description" placeholder="Restaurant description" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->description . "'") ?>
				          	/>
				        	<?php echo form_error('description', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address number <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" id="address-number" name="address_number" placeholder="Address number" onkeyup="changeMapSearchBox()"
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->address_number . "'") ?>
				          	/>
				        	<?php echo form_error('address_number', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address ward <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" id="address-ward" name="address_ward" placeholder="Address ward" onkeyup="changeMapSearchBox()"
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->address_ward . "'") ?>
				          	/>
				        	<?php echo form_error('address_ward', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address street <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" id="address-street" name="address_street" placeholder="Address street" onkeyup="changeMapSearchBox()"
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->address_street . "'") ?>
				          	/>
				        	<?php echo form_error('address_street', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address city <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" id="address-city" name="address_city" placeholder="Address city" onkeyup="changeMapSearchBox()"
			          			<?php if(isset($restaurant)) echo ("value='" . $restaurant->address_city . "'") ?>
				          	/> 
				        	<?php echo form_error('address_city', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>

				    <div class="row">
						<div class="small-3 columns">
							<label>Zipcode <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
							<input type="text" id="zipcode" name="zipcode" placeholder="Zipcode" 
			          			<?php if(isset($restaurant)) echo ("value='" . $restaurant->zipcode . "'" ) ?>
				          	/>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Phone number</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="phone_number" placeholder="Restaurant phone number" 
			          			<?php if(isset($restaurant)) echo ("value='" . $restaurant->phone_number . "'") ?>
				          	/>
				        	<?php echo form_error('phone_number', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Email</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="email" placeholder="Restaurant email" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->email . "'") ?>
				          	/>
				        	<?php echo form_error('email', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Website</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="website" placeholder="Restaurant website" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->website . "'") ?>
				          	/>
				        	<?php echo form_error('website', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Map location <small>required</small> </label>
				        </div>
				        <div class="small-9 columns">
				        	<input id="pac-input" style="width: 30%; margin: 10px;" class="controls" type="text" placeholder="Search Box">
				          	<div id="map-canvas" style="width: 100%; height: 400px; margin: 0; "></div>
				          	<input type="hidden" name="latlong" id="latlong"
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->latlong . "'") ?>
				          	></input>
				        	<?php echo form_error('latlong', '<small class="error">', '</small>'); ?> 
				        </div>
				    </div>
				</fieldset>
				<!-------- EXTRA INFORMATION -------->
				<fieldset>
    				<legend>Other information</legend>
					<div class="row">
						<div class="small-3 columns">
							<label>Capacity <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="capacity" placeholder="Restaurant capacity" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->capacity . "'") ?>
				          	/>
				        	<?php echo form_error('capacity', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Opening hour <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="opening_hour" placeholder="Opening hour" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->opening_hour . "'") ?>
				          	/>
				        	<?php echo form_error('opening_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Closing hour <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="closing_hour" placeholder="Closing hour" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->closing_hour . "'") ?>
				          	/>
				        	<?php echo form_error('closing_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Lowest price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="loweset_price" placeholder="Lowest price" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->lowest_price . "'") ?>
				          	/>
				        	<?php echo form_error('lowest_price', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Highest price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="highest_price" placeholder="Highest price" 
				          		<?php if(isset($restaurant)) echo ("value='" . $restaurant->highest_price . "'") ?>
				          	/>
				        	<?php echo form_error('highest_price', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Language</label>
				        </div>
				        <div class="small-9 columns">
				          	<select id="language-select">
				          		<?php 
				          			foreach($languages as $abbrev => $name) {
				          				echo "<option value='$abbrev'>$name</option>\n";	
				          			}
				          		?>
							</optgroup>
			                </select>
			                <?php echo form_error('languages', '<small class="error">', '</small>'); ?>
				        </div>
				        <input type="hidden" name="languages" id="selected-languages">
				    </div>
				</fieldset>
				<fieldset>
    				<legend>Category</legend>
				    <div class="row">
						<div class="small-3 columns">
							<label>Types <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<select id="type-select">
				          		<?php 
				          			foreach($categories as $abbrev => $description) {
				          				echo "<option value='$abbrev'>$description</option>\n";	
				          			}
				          		?>
							</optgroup>
			                </select>
			                <?php echo form_error('categories', '<small class="error">', '</small>'); ?>
				        </div>
				        <input type="hidden" name="categories" id="selected-categories">
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Country <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<select id="country-select">
				          		<?php 
				          			foreach($countries as $abbrev => $name) {
				          				echo "<option value='$abbrev'>$name</option>\n";	
				          			}
				          		?>
							</optgroup>
			                </select>
			                <?php echo form_error('countries', '<small class="error">', '</small>'); ?>
				        </div>
				        <input type="hidden" name="countries" id="selected-countries">
				        <?php 
				        	if(isset($restaurant)) {
				        		echo("<input type='hidden' name='restaurant_id' value='$restaurant->id'");
				        	}
				        ?>
				    </div>
				</fieldset>
				<div class="large-12">
					<input class="button expand" type="submit" 
						<?php 
							if(isset($restaurant)) {
								echo("value='Update restaurant'");
							}
							else {
								echo("value='Post new restaurant'");
							}
						?>
					/>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$("select#language-select").zmultiselect({
			live: "#selected-languages",
		    filter: true,
		    filterPlaceholder: 'filter...',
		    filterResult: true,
		    filterResultText: "Showed",
		    selectedText: ['Selected','of']
		});

		$("select#type-select").zmultiselect({
			live: "#selected-categories",
		    filter: true,
		    filterPlaceholder: 'filter...',
		    filterResult: true,
		    filterResultText: "Showed",
		    selectedText: ['Selected','of']
		});

		$("select#country-select").zmultiselect({
			live : "#selected-countries",
		    filter: true,
		    filterPlaceholder: 'filter...',
		    filterResult: true,
		    filterResultText: "Showed",
		    selectedText: ['Selected','of']
		});
	</script>

	<script>
		function changeMapSearchBox() {
			var number = document.getElementById("address-number").value;
			var ward = document.getElementById("address-ward").value;
			var street = document.getElementById("address-street").value;
			var city = document.getElementById("address-city").value;
			document.getElementById("pac-input").value = number + " " + ward + " " + street + " " + city;
		}
	</script>

	<?php require 'scripts.php'?>
	<?php require 'footer.php';?>
</body>
</html>