<?php include 'metadata.php'?>
<?php $date = new DateTime($this->session->userdata('dob')); ?>
<body>
	<?php require 'nav.php'?>
	<?php require 'header.php'?>
	<div class="row">
		<div class="microheader">
			<div class="main-image" style="position:relative;">
                <div class="img">
                    <a href="/">
                        <img class="pic-place" itemprop="photo" src="<?php echo base_url(); ?>static/frontend/img/no-image.png" width="220" height="280" alt="Test">
                    </a>
                </div>
            </div>
            <div class="main-information">
            	<div class="res-common">
	            	<div class="res-common-info">
	            		<div class="main-info-title">
	            			<h1> Test restaurant </h1>
	            		</div>
	            		
	            	</div>
        		</div>
            </div>
		</div>
	</div>
	<?php require 'scripts.php'?>
</body>
</html>
