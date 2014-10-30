<div id="bigmap">
	<div id="map_canvas"></div>
</div>
<div class="row search-box-wrapper">
		<div class="large-12 columns search-box">
			<select>
				<option value="husker">Location</option>
				<option value="starbuck">Etterbeek</option>
				<option value="hotdog">Hot Ixelles</option>
				<option value="apollo">Scharbeek</option>
			</select>
			
			<select>
				<option value="husker">Food</option>
				<option value="starbuck">Starbuck</option>
				<option value="hotdog">Hot Dog</option>
				<option value="apollo">Apollo</option>
			</select>
			
			<select>
				<option value="husker">Taste</option>
				<option value="starbuck">Starbuck</option>
				<option value="hotdog">Hot Dog</option>
				<option value="apollo">Apollo</option>
			</select>
			
			<input type="text" placeholder="Value">
			<a href="#" class="button expand search-btn tiny">SEARCH</a>
		</div>
	</div>
<script>
	function initialize() {
        var mapCanvas = document.getElementById('map_canvas');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          scrollwheel: false,
          navigationControl: false,
          mapTypeControl: false,
          scaleControl: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>