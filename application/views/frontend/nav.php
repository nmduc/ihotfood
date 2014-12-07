<div data-magellan-expedition="fixed">
<div class="notifications js-notifications">
	<h3>Notifications</h3>
	<ul class="notifications-list">
	</ul>
	<a href="#" class="show-all">Show all notifications</a>
</div>
<nav class="top-bar" data-topbar role="navigation" >
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
			<li>
				<button type="button" style="background: none !important;" class="button-default show-notifications active js-show-notifications">
				  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 30 32">
				    <defs>
				      <g id="icon-bell">
					      <path class="path1" d="M15.143 30.286q0-0.286-0.286-0.286-1.054 0-1.813-0.759t-0.759-1.813q0-0.286-0.286-0.286t-0.286 0.286q0 1.304 0.92 2.223t2.223 0.92q0.286 0 0.286-0.286zM3.268 25.143h23.179q-2.929-3.232-4.402-7.348t-1.473-8.652q0-4.571-5.714-4.571t-5.714 4.571q0 4.536-1.473 8.652t-4.402 7.348zM29.714 25.143q0 0.929-0.679 1.607t-1.607 0.679h-8q0 1.893-1.339 3.232t-3.232 1.339-3.232-1.339-1.339-3.232h-8q-0.929 0-1.607-0.679t-0.679-1.607q3.393-2.875 5.125-7.098t1.732-8.902q0-2.946 1.714-4.679t4.714-2.089q-0.143-0.321-0.143-0.661 0-0.714 0.5-1.214t1.214-0.5 1.214 0.5 0.5 1.214q0 0.339-0.143 0.661 3 0.357 4.714 2.089t1.714 4.679q0 4.679 1.732 8.902t5.125 7.098z" />
				      </g>
				    </defs>
				    <g fill="#ffffff">
					    <use xlink:href="#icon-bell" transform="translate(0 0)"></use>
				    </g>
				  </svg>
				  <div class="notifications-count js-count"></div>
				</button>
			</li>
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
</div>