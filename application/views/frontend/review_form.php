<div id="review-form">
	<?php if($this->session->userdata('username') && $this->session->userdata('id') != $restaurant->owner_id) { ?>
		<?php echo form_open('restaurant/user_write_review/' . $restaurant->id); ?>
					<fieldset>
    					<legend>Restaurant review</legend>
						<div class="row">
					        <div class="small-6 columns">
					          	<input id="input-review-title" type="text" name="title" placeholder="Review Title" />
					        	<?php echo form_error('title', '<small class="error">', '</small>'); ?>
			        </div>
			        <div class="small-3 columns">
			        	<div class="row" style="position:absolute; right:0px">
				        	<input class="star" type="radio" name="score" value="1"/>
				        	<input class="star" type="radio" name="score" value="2"/>
				        	<input class="star" type="radio" name="score" value="3"/>
				        	<input class="star" type="radio" name="score" value="4"/>
				        	<input class="star" type="radio" name="score" value="5"/>
			        	</div>
			        	<div class="row"> 
		        			<?php echo form_error('score', '<small class="error">', '</small>'); ?>
	        			</div>
			        </div>
			        <div class="small-3 columns">
			        	<img src="<?php echo base_url()?>static/frontend/img/close.png"
			        		style="height:1rem; position:absolute; right:0px" onclick="toogle_review_form()">
			        	</img>
			        </div>
			    </div>
			    <div class="row">
			        <div class="small-9 columns">
			          	<textarea name="content" placeholder="Review Content" /></textarea>
			        	<?php echo form_error('content', '<small class="error">', '</small>'); ?>
			        </div>
			    </div>
			    <div class="large-3 large-centered">
					<input class="button tiny" type="submit" value="Post review");/>
				</div>
				<!-- <div class="large-3 large-centered">
					<input class="button tiny" value="Cancel" onclick="preventDefault(); toogle_review_form()");/>
				</div> -->
			</fieldset>	
		</form>
		<hr>
	<?php } ?>
</div>