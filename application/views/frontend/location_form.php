<?php include 'metadata.php'?>
<script src="<?php echo base_url(); ?>static/frontend/js/zmultiselect/zurb5-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>static/frontend/js/zmultiselect/zurb5-multiselect.css" />
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
				          	<input type="text" name="name" placeholder="Restaurant name" />
				        	<?php echo form_error('name', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address number <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="address_number" placeholder="Address number" />
				        	<?php echo form_error('address_number', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address ward <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="address_ward" placeholder="Address ward" />
				        	<?php echo form_error('address_ward', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address street <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="address_street" placeholder="Address street" />
				        	<?php echo form_error('address_street', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Address city <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="address_city" placeholder="Address city" />
				        	<?php echo form_error('address_city', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>

				    <div class="row">
						<div class="small-3 columns">
							<label>Zipcode <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<select name="zipcode">
								<option value="1050">Ixelles</option>
								<option value="1000">Etterbeek</option>
								<option value="1040">Hot Ixelles</option>
								<option value="1060">Scharbeek</option>
							</select>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Phone number</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="phone_number" placeholder="Restaurant phone number" />
				        	<?php echo form_error('phone_number', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Email</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="email" placeholder="Restaurant email" />
				        	<?php echo form_error('email', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Website</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="website" placeholder="Restaurant website" />
				        	<?php echo form_error('website', '<small class="error">', '</small>'); ?>
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
				          	<input type="text" name="capacity" placeholder="Restaurant capacity" />
				        	<?php echo form_error('capacity', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
					<div class="row">
						<div class="small-3 columns">
							<label>Opening hour <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="opening_hour" placeholder="Opening hour" />
				        	<?php echo form_error('opening_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
						<div class="small-3 columns">
							<label>Closing hour <small>required</small></label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="closing_hour" placeholder="Closing hour" />
				        	<?php echo form_error('closing_hour', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Lowest price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="loweset_price" placeholder="Lowest price" />
				        	<?php echo form_error('lowest_price', '<small class="error">', '</small>'); ?>
				        </div>
				    </div>
				    <div class="row">
				    	<div class="small-3 columns">
							<label>Highest price</label>
				        </div>
				        <div class="small-9 columns">
				          	<input type="text" name="highest_price" placeholder="Highest price" />
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
							<label>Types</label>
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
							<label>Country</label>
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
				    </div>
				</fieldset>
				<div class="large-12">
					<input class="button expand" type="submit" value="Post new restaurant"/>
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
	<?php require 'scripts.php'?>
	<?php require 'footer.php';?>
</body>
</html>