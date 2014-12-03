<nav class="top-bar" data-topbar role="navigation">
	<ul class="title-area">
		<li class="name">
			<h1 class="logo">
				<a href="<?php echo base_url()?>">iHotFood</a>
			</h1>
		</li>
		<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li><a href="#">Reviews</a></li>
			<li class="divider"></li>
			<li><a href="#">Photos</a></li>
			<li class="divider"></li>
			<li><a href="#">Collection</a></li>
			<li class="divider"></li>
			<?php if ( ! $this->session->userdata('username')) { ?>
			<li>
				<a href="<?php echo base_url()?>index.php/user/login/show_login">Login</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="<?php echo base_url()?>index.php/user/login/show_register">Register</a>
			</li>

			<?php if ($this->session->userdata('facebookLoginURL')) { ?>
				<li class='divider'></li> 
				<li><a href="<?php echo $this->session->userdata('facebookLoginURL')?>">Facebook</a></li>
			<?php } ?>	

			<?php } else { $username = $this->session->userdata('username'); ?>
			<li class="has-dropdown">
				<a href="#">
					<?php echo $username?>
				</a>
				<ul class="dropdown">
					<li><a href="<?php echo base_url()?>index.php/user/manage/show_add_location">Add location</a></li>
					<?php if( $this->session->userdata("user-restaurants")) { ?>
						<li class="has-dropdown">
							<a href="#">Manage locations </a>
							<ul class="dropdown">
								<?php foreach ( $this->session->userdata("user-restaurants") as $res) { 
									echo( "<li><a href=" . base_url() . "index.php/user/manage/manage_restaurant/" . $res[0] . ">" . $res[1] . "</a></li>");
								} ?>
							</ul>
						</li>
					<?php } ?>

					<li><a href="<?php echo base_url()?>index.php/user/manage">Edit profile</a></li>
					<li><a href="<?php echo base_url()?>index.php/user/login/do_logout">Logout</a></li>
		        </ul>
			
			</li>
			<?php } ?>
			
		</ul>
	</section>
</nav>