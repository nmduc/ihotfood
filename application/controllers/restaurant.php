<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant extends CI_Controller {
	// show restaurant details
	// http://ihotfood.com/index.php/restaurant/show_restaurant/restaurantID
	public function show_restaurant($id) {
		$this->load->model( 'restaurant/restaurant_model' );
		$this->load->model( 'restaurant/review_model' );
		$restaurant = $this->restaurant_model->get_restaurant_by_id($id);
		if(! $restaurant ) {
			$data = array (
				'heading' => "Error 404",
				'message' => "Restaurant does not exist"
			);
			$this->load->view('../errors/error_404', $data);
		}
		else {
			$review_list = $this->review_model->get_restaurant_reviews($id);
			$this->load->model("user/basic_user_model");
			$this->load->model("restaurant/media_model");

			$reviews = array();
			foreach ($review_list as $review) {
				$review->user_info = $this->basic_user_model->get_user_info_by_id($review->user_id);
				$review->photos = $this->media_model->get_all_album_medias($review->album_id);
				foreach($review->photos as $photo) {
					$temp = explode('.',$photo->filename);
					$photo->thumbnailFilename = $temp[0] . '_thumb.' . $temp[1];
				}
				array_push($reviews, $review);
			}

			// get sample photos 
			$this->load->model( 'restaurant/media_model' );
			$photos = $this->media_model->get_sample_album_medias($restaurant->album_id, 3);
			$samplePhotos = array();
			foreach ($photos as $photo) {
				$temp = explode('.',$photo->filename);
				$photo->thumbnailFilename = $temp[0] . '_thumb.' . $temp[1];
				array_push($samplePhotos, $photo);
			}

			$this->load->library("../controllers/user/facebook_login");
			$facebookLoginURL = $this->facebook_login->get_facebook_login_url();
			$data = array (
				'restaurant' => $restaurant,
				'reviews' => $reviews,
				'samplePhotos' => $samplePhotos,
				'facebookLoginURL' => $facebookLoginURL,
			);
			
			$this->load->view ( 'frontend/view_restaurant', $data );
		}
	}

	public function user_write_review($resId) {
		$this->load->model( 'restaurant/restaurant_model' );
		$this->load->model("user/basic_user_model");
		$this->load->model("notification/notification_model");

		$userid = $this->session->userdata('id');
		$socket_id =$this->input->post('socket_id');
		$restaurant = $this->restaurant_model->get_restaurant_by_id($resId);
		
		if(! $restaurant) {
			$data = array(
				"heading" => "Error 404",
				"message" => "Restaurant not found",
			);	
			$this->load->view("../errors/error_404", $data);
		}
		if( ! $this->session->userdata("username") ) {
			// raise 403
			$data = array(
				"heading" => "Permission denied",
				"message" => "You must login first to write review",
			);
			$this->load->view("../errors/error_403", $data);	
			return;
		}
		if($this->session->userdata('id') == $restaurant->owner_id) {
			// raise 403
			$data = array(
				"heading" => "Permission denied",
				"message" => "You cannot write review about your own restaurant",
			);	
			$this->load->view("../errors/error_403", $data);	
			return;
		}
		// set review form rules
	 	$this->form_validation->set_rules ( 'title', 'Review title', 'required|trim|max_length[100]|xss_clean' );
	 	$this->form_validation->set_rules ( 'content', 'Review content', 'required|trim|xss_clean' );
	 	$this->form_validation->set_rules ( 'score', 'Review score', 'required|trim|max_length[1]|is_natural|less_than[6]|greater_than[0]|xss_clean' );
		
	 	
	 	$jsonArr = array();
	 	$jsonArr['status'] = 'false';
		if ($this->form_validation->run () == TRUE) {
			$this->load->model("restaurant/review_model");
			
			if(! $this->input->post('review-id')) {
				$new_review_id = $this->review_model->create_review($resId);
				$this->restaurant_model->update_average_rating($resId);
				if(! $new_review_id ) {
					$data = array(
						"heading" => "Unexpected error",
						"message" => "Something went wrong, please try again later",
					);	
					$this->load->view("../errors/error_db", $data);
					return;
				}
				
				
				/****************** NOTIFICATION SHIT BEGINS ******************/
				//subscribe for notification
				if (!$this->notification_model->is_user_subscribed($userid, $resId)) {
					$this->notification_model->subsribe_channel($userid, $resId);
					//update channels in session
					$channelArr = $this->notification_model->get_channel_by_user_id($userid);
					$this->session->set_userdata('channels', $channelArr);
				}
				
				//notify
				$this->notification->notify_new_restaurant_review($resId, $userid, $new_review_id, $socket_id);
				/****************** NOTIFICATION SHIT ENDS ******************/
					
				$jsonArr['status'] = 'true';
				$jsonArr['new-review-id'] = $new_review_id;
			}
			else {
				$this->review_model->update_review($this->input->post('review-id'));
				$this->restaurant_model->update_average_rating($resId);
				$jsonArr['status'] = 'true';
				$jsonArr['new-review-id'] = $this->input->post('review-id');
			}
	 	} else {
	 		$jsonArr['error'] = $this->form_validation->error_array();;
	 	}
	 	echo(json_encode($jsonArr));
 		//$this->show_restaurant($resId);
	}

	/**
	*
	*
	*/
	public function user_delete_review() {
		$reviewId = $this->input->post('review_id');
		$this->load->model('restaurant/review_model');

		$review = $this->review_model->get_review($reviewId);

		$jsonArr = array();
	 	$jsonArr['status'] = 'false';
		
		if($review) {
			// check ownership
			if(!$this->session->userdata('id') || 
				$this->session->userdata('id') != $review->user_id ) {
	 			$jsonArr['status'] = 'false';	// permission denied
			}
			else {
				$albumId = $review->album_id;
				$this->load->model('restaurant/album_model');
				$this->album_model->delete_album($albumId);

				$this->review_model->delete_review($reviewId);

				// update restaurant average score
				$this->load->model( 'restaurant/restaurant_model' );
				$this->restaurant_model->update_average_rating($review->restaurant_id);

				$jsonArr['status'] = 'true';
			}
		}
	 	echo(json_encode($jsonArr));
	}

	/**
	* Show photo gallery of a specific restaurant
	*
	*/
	public function photo_gallery($resId) {
		$this->load->model( 'restaurant/restaurant_model' );
		$restaurant = $this->restaurant_model->get_restaurant_by_id($resId);

		// load photos
		$this->load->model( 'restaurant/media_model' );
		$allPhotos = $this->media_model->get_all_album_medias($restaurant->album_id);
		$photos = array();
		foreach ($allPhotos as $photo) {
			$temp = explode('.',$photo->filename);
			$photo->thumbnailFilename = $temp[0] . '_thumb.' . $temp[1];
			array_push($photos, $photo);
		}

		$this->load->library("../controllers/user/facebook_login");
		$facebookLoginURL = $this->facebook_login->get_facebook_login_url();
		$data = array(
			'restaurant' => $restaurant,
			'photos' => $photos,
			'facebookLoginURL' => $facebookLoginURL,
		);
		$this->load->view ( 'frontend/restaurant_photo_gallery', $data);
	}
}