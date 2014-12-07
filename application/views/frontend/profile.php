<?php include 'metadata.php'?>
<?php $date = new DateTime($this->session->userdata('dob')); ?>
<body>
	<?php require 'nav.php'?>
	<?php require 'header.php'?>
	<div class="row">
		<div class="large-4 columns wow fadeInLeft">
			<ul class="side-nav">
					<li class="active">
						<a href="<?php echo base_url()?>index.php/user/manage/show_account">Edit Profile</a>
					</li>
					<li>
						<a href="<?php echo base_url()?>index.php/user/manage/show_change_password">Change password</a>
					</li>
					<li>
						<a href="#">Email settings</a>
					</li>
				</ul>
		</div>
		<div class="large-8 columns container wow fadeInRight">
			<h3>Edit profile</h3>
			<?php echo form_open('user/manage/update_account'); ?>
				<fieldset>
					<legend>Manage your basic profile settings</legend>
					<div class="large-12">
						<label>Username</label>
						<input disabled type="text" name="username" value="<?php echo $this->session->userdata('username');?>" />
					</div>

					<div class="large-12">
						<label>Full name</label>
						<input type="text" name="fullname" placeholder="i.e. Trung Ngoc Tran" value="<?php echo $this->session->userdata('fullname');?>"/>
						<?php echo form_error('fullname', '<small class="error">', '</small>'); ?>
					</div>
					
					<div class="large-12">
						<label>Birthday</label>
						<input id="dob" type="datetime" name="dob" placeholder="i.e. 02/08/1988" value="<?php echo $date->format('d-m-Y'); ?>"/>
						<?php echo form_error('datetime', '<small class="error">', '</small>'); ?>
					</div>					
				</fieldset>
				<div class="large-12">
					<input class="button small" type="submit" value="Update"/>
				</div>	
			</form>
		</div>
	</div>
	<?php require 'scripts.php'?>
</body>
</html>
