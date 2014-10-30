<?php include 'metadata.php'?>
<body>
	<?php require 'nav.php'?>
	<div class="row">
		<div class="large-6 large-centered columns container">
			<h3>Login</h3>
			<?php echo form_open('user/login/do_login'); ?>
				 <fieldset>
    				<legend>Login detail</legend>
					<div class="large-12">
						<input type="text" name="username" placeholder="Username" />
				        <?php echo form_error('username', '<small class="error">', '</small>'); ?>
				    </div>
					<div class="large-12">
						<input type="password" name="password" placeholder="Password" />
				        <?php echo form_error('password', '<small class="error">', '</small>'); ?>
				    </div>
<!-- 				    <div class="large-12"> -->
<!-- 						<input type="checkbox" name="is_login_remembered"><label for="checkbox1">Remember my login</label> -->
<!-- 					</div> -->
					<div class="large-12">
						<a href="#">Forgot your password?</a>
					</div>	
				</fieldset>
				<div class="large-12">
					<input class="button small" type="submit" value="Login"/>
				</div>
			</form>
		</div>
	</div>
	<?php require 'scripts.php'?>
	<?php require 'footer.php'?>
</body>
</html>