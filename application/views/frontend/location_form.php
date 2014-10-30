<?php include 'metadata.php'?>
<body>
	<?php require 'nav.php'?>
	<?php require 'static_header.php'?>
	<div class="row">
		<div class="large-8 large-centered columns container">
			<h3>Add new restaurant</h3>
			<p>Your favorite restaurants is not in iHootFood? Let's share it!</p>
			<?php echo form_open('user/manage/add_location'); ?>
				<!-------- BASIC INFORMATION -------->
				<fieldset>
    				<legend>Basic information</legend>
					<div class="row">
						<div class="small-3 columns">
							<label>Name <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_name" placeholder="Restaurant name" />
				        	<?php echo form_error('restaurant_name', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_address" placeholder="Restaurant address" />
				        	<?php echo form_error('res_address', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Zipcode <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<select>
								<option value="husker">Location</option>
								<option value="starbuck">Etterbeek</option>
								<option value="hotdog">Hot Ixelles</option>
								<option value="apollo">Scharbeek</option>
							</select>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Phone</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_phone" placeholder="Restaurant phone" />
				        	<?php echo form_error('res_phone', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Email</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_email" placeholder="Restaurant email" />
				        	<?php echo form_error('res_email', '<small class="error">', '</small>'); ?>
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
				          	<input type="text" name="res_capacity" placeholder="Restaurant name" />
				        	<?php echo form_error('res_capacity', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Opening hour <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_opening_hour" placeholder="Restaurant address" />
				        	<?php echo form_error('res_opening_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Closing hour</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_closing_hour" placeholder="Restaurant address" />
				        	<?php echo form_error('res_closing_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Minimum price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_minimum_price" placeholder="Restaurant address" />
				        	<?php echo form_error('res_minimum_price', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Maximum price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="res_maximum_Price" placeholder="Restaurant address" />
				        	<?php echo form_error('res_maximum_Price', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Language</label>
				        </div>
				        <div class="small-9 columns">
				          	<input id="checkbox1" type="checkbox"><label for="checkbox1">English</label>
				          	<input id="checkbox2" type="checkbox"><label for="checkbox2">French</label>
				        </div>
				    </div>
					
				</fieldset>
				<fieldset>
    				<legend>Category</legend>
					<div class="row">
						<div class="small-3 columns">
							<label>Types</label>
				        </div>
				        <div class="small-9 columns">
				          	<select>
								<option value="husker">Fast food</option>
								<option value="starbuck">Fast casual</option>
								<option value="hotdog">Casual dining</option>
								<option value="apollo">Brasserie and bistro</option>
								<option value="apollo">Coffeehouse</option>
								<option value="apollo">Mongolian barbecue</option>
								<option value="apollo">Pub</option>
							</select>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Country</label>
				        </div>
				        <div class="small-9 columns">
				          	<select>
								<option value="husker">Turkey</option>
								<option value="starbuck">French</option>
								<option value="hotdog">Italy</option>
								<option value="apollo">Holland</option>
							</select>
				        </div>
				    </div>
				</fieldset>
				<div class="large-12">
					<input class="button expand" type="submit" value="Post new restaurant"/>
				</div>
			</form>
		</div>
	</div>
	<?php require 'scripts.php'?>
	<?php require 'footer.php';?>
</body>
</html>