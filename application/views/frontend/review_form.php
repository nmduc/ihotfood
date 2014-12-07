<div id="review-form">
	<?php if($this->session->userdata('username') && $this->session->userdata('id') != $restaurant->owner_id) { ?>
		<?php $attributes = array('name' => 'review_form', 'id' => 'review_form');
			echo form_open('restaurant/user_write_review/' . $restaurant->id, $attributes); ?>
			<fieldset>
    				<legend>Restaurant review</legend>
					<div class="row">
					        <div class="small-6 columns" id="review_title">
					          	<input id="input-review-title" type="text" name="title" placeholder="Review Title" />
					        	<?php echo form_error('title', '<small class="error">', '</small>'); ?>
			        		</div>
			        <div class="small-3 columns">
			        	<div class="row" id="review_score" style="position:absolute; right:0px">
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
			        		style="height:1rem; position:absolute; right:0px" onclick="toogle_review_form()"/>
			        </div>
			    </div>
			    <div class="row">
			        <div class="small-9 columns" id="review_content">
			          	<textarea name="content" placeholder="Review Content" /></textarea>
			        	<?php echo form_error('content', '<small class="error">', '</small>'); ?>
			        </div>
			    </div>
			    <input name="socket_id" type="hidden" value="null" id="review_socket_id">
			    <div class="large-3 large-centered">
					<input class="button tiny" type="submit" value="Post review"/>
				</div>
			</fieldset>	
		</form>
		<hr>
	<?php } ?>
</div>