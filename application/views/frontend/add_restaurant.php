<?php include 'metadata.php'?>
<body>
	<?php require 'nav.php'?>
	<div class="row">
		<div class="large-6 large-centered columns container">
			<h3>Login</h3>
			<?php echo form_open('user/contribute/do_add_restaurant'); ?>
				 <fieldset>
    				<legend>Basic information</legend>
					<div class="large-12">
						<div class='form-label'>Restaurant Name <span>*</span> </div>
						<input type="text" name="name" placeholder="Restaurant Name *" />
				        <?php echo form_error('name', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Address Number <span>*</span> </div>
						<input type="number" name="address_number" placeholder="Address Number *" />
				        <?php echo form_error('address_number', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Address Street <span>*</span> </div>
						<input type="text" name="address_street" placeholder="Address Street *" />
				        <?php echo form_error('address_street', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Address Ward <span>*</span> </div>
						<input type="text" name="address_ward" placeholder="Address Ward*" />
				        <?php echo form_error('address_ward', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>City <span>*</span> </div>
						<input type="text" name="address_city" placeholder="Address City *" />
				        <?php echo form_error('address_city', '<small class="error">', '</small>'); ?>
				    </div>
				    <div class="large-12">
						<div class='form-label'>Phone Number <span>*</span> </div>
						<input type="text" name="phone_number" placeholder="Phone Number *" />
				        <?php echo form_error('phone_number', '<small class="error">', '</small>'); ?>
				    </div>
				    <div class="large-12">
						<div class='form-label'>Email <span>*</span> </div>
						<input type="text" name="email" placeholder="Email" />
				        <?php echo form_error('email', '<small class="error">', '</small>'); ?>
				    </div>
				    <div class="large-12">
						<div class='form-label'>Website <span>*</span> </div>
						<input type="text" name="website" placeholder="Website" />
				        <?php echo form_error('website', '<small class="error">', '</small>'); ?>
				    </div>
			    	<legend>Other information</legend>
					<div class="large-12">
						<div class='form-label'>Opening Hour <span>*</span> </div>
						<input type="number" name="opening_hour" placeholder="Opening Hour *" />
				        <?php echo form_error('opening_hour', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Closing Hour <span>*</span> </div>
						<input type="number" name="closing_hour" placeholder="Closing Hour *" />
				        <?php echo form_error('closing_hour', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Lowest Price ($) <span>*</span> </div>
						<input type="number" name="lowest_price" placeholder="Lowest Price" />
				        <?php echo form_error('lowest_price', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<div class='form-label'>Highest Price ($) <span>*</span> </div>
						<input type="number" name="highest_price" placeholder="Highest Price" />
				        <?php echo form_error('highest_price', '<small class="error">', '</small>'); ?>
				    </div>
				</fieldset>
				<div class="large-12">
					<input class="button small" type="submit" value="Add restaurant"/>
				</div>
			</form>
		</div>
	</div>
	<?php require 'scripts.php'?>
	<?php require 'footer.php'?>
</body>
</html>