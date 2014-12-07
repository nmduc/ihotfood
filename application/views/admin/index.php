<?php include 'metadata.php'?>
<body class="login">
	<section>
		<div id="login_form">
			<h1><strong>ihotfood</strong> Dashboard</h1>
			<?php echo form_open('admin/login/do_login'); ?>
				<?php echo form_error('username', '<div class="form_error">', '</div>'); ?>
				<input type="text" name="username" placeholder="Username"/>
				<?php echo form_error('password', '<div class="form_error">', '</div>'); ?>
				<input type="password" name="password" placeholder="Password"/>
				<button class="blue">Login</button>
			</form>
		</div>
		<p><a href="#">Forgot your password?</a> <a href="show_register">Register</a></p>
	</section>
<?php include 'footer.php'?>	
</body>
</html>