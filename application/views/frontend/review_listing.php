<?php foreach ($reviews as $review) { ?>
	<div class="row single-comment">
		<div class="large-1 columns user-avatar">
			<img src="<?php echo base_url()?>static/frontend/img/unnamed.png"
				alt="slide 1" /> 
		</div>
		<div class="large-11 columns user-comments">
			<div class="row">
				<div class="large-12">
					<a href=""><?php echo($review->user_info['username']); ?></a>
					<span style="font-size:12px"><i>Posted on: (<?php echo($review->publish_time); ?>)</i></span>
				</div>
				<div class="row">
					<div class="large-8 columns">
						<h5><?php echo($review->title); ?></h5>
					</div>
					<div class="large-2 columns">
			        	<div class="row" style="position:relative; right:0px">
			        		<?php if($review->rating == 1) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
				        	<?php if($review->rating == 2) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 3) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 4) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        		<?php if($review->rating == 5) { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" checked="checked"/>
			        		<?php } else { ?>
				        		<input class="star" type="radio" name="rating-<?php echo($review->id)?>" disabled="disabled" />
			        		<?php } ?>
			        	</div>
					</div>
				</div>
				<div class="large-12">
					<span><?php echo(strip_tags($review->content));?></span>
				</div>
			</div>
		</div>
	</div>
	<hr>
<?php } ?>