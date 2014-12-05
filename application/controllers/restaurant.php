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
			$data = array (
				'restaurant' => $restaurant,
				'num_reviews' => sizeof($review_list),
				'review_per_load' => 3,
			);
			$this->load->view ( 'frontend/view_restaurant', $data );
		}
	}

	/**
	* Show photo gallery of a specific restaurant
	*
	*/
	public function photo_gallery($resId) {
		$this->load->model( 'restaurant/restaurant_model' );
		$restaurant = $this->restaurant_model->get_restaurant_by_id($resId);
		$data = array(
			'restaurant' => $restaurant,
		);
		$this->load->view ( 'frontend/restaurant_photo_gallery', $data);
	}

	/**
	* Get a limited number of reviews for a specific restaurant
	* Used to serve ajax load function from view
	*
	*/
	public function show_reviews($resId) {
		$offset = $this->input->post('offset');
		$nReviews = $this->input->post('review_per_load');
		$this->load->model( 'restaurant/review_model' );
		$review_list = $this->review_model->get_restaurant_reviews($resId, $offset, $nReviews+1);
		$this->load->model("user/basic_user_model");
		$reviews = array();
		for ($i = 0; $i < sizeof($review_list); $i++) {
			if($i == $nReviews) break;
			$review = $review_list[$i];
			$review->user_info = $this->basic_user_model->get_user_info_by_id($review->user_id);
			array_push($reviews, $review);
		}
		$data = array(
			'reviews' => $reviews,
		);

		if(sizeof($review_list) > $nReviews) {
			$data['offset'] = $offset + $nReviews;
			$data['review_per_load'] = $nReviews;
		}
		$this->load->view( 'frontend/user_reviews', $data);
	}


	/**
	* 
	*
	*/
	public function user_write_review($resId) {
		$this->load->model( 'restaurant/restaurant_model' );
		$this->load->model("user/basic_user_model");

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
	 	$this->form_validation->set_rules ( 'score-add', 'Review score', 'required|trim|max_length[1]|is_natural|less_than[6]|greater_than[0]|xss_clean' );

		if ($this->form_validation->run () == TRUE) {
			$this->load->model("restaurant/review_model");
			if(! $this->review_model->create_review($resId) ) {
				$data = array(
					"heading" => "Unexpected error",
					"message" => "Something went wrong, please try again later",
				);	
				$this->load->view("../errors/error_db", $data);
				return;
			}
			redirect( base_url() . 'index.php/restaurant/show_restaurant/' . $resId);
	 	}
 		$this->show_restaurant($resId);
	}


	/**
	*
	*
	*/
	public function user_delete_review() {
		$reviewId = $this->input->post('review_id');
		$this->load->model('restaurant/review_model');

		$review = $this->review_model->get_review($reviewId);
		$message = "failed";

		if($review) {
			// check ownership
			if(!$this->session->userdata('id') || 
				$this->session->userdata('id') != $review->user_id ) {
				$message = "failed";
			}
			else {
				$this->review_model->delete_review($reviewId);
				$message = "success";
			}
		}
		echo $message;
	}


	/**
	*
	*
	*/
	public function user_edit_review($resId) {
		$reviewId = $this->input->post('review_id');
		$this->load->model('restaurant/review_model');
		$this->load->model('user/basic_user_model');

		$review = $this->review_model->get_review($reviewId);
		if(! $review) {
			$data = array(
				"heading" => "Error 404",
				"message" => "Restaurant not found",
			);	
			$this->load->view("../errors/error_404", $data);
			return;
		}
		if(!$this->session->userdata('id') || 
			$this->session->userdata('id') != $review->user_id ) {
			$data = array(
				"heading" => "Permission denied",
				"message" => "You do not have permission to edit this review",
			);	
			$this->load->view("../errors/error_403", $data);	
			return;
		}

		// set review form rules
	 	$this->form_validation->set_rules ( 'title', 'Review title', 'required|trim|max_length[100]|xss_clean' );
	 	$this->form_validation->set_rules ( 'content', 'Review content', 'required|trim|xss_clean' );
	 	$this->form_validation->set_rules ( 'score-edit', 'Review score', 'required|trim|max_length[1]|is_natural|less_than[6]|greater_than[0]|xss_clean' );

	 	if ($this->form_validation->run () == TRUE) {
	 		if(! $this->review_model->update_review($reviewId) ) {
				$data = array(
					"heading" => "Unexpected error",
					"message" => "Something went wrong, please try again later",
				);	
				$this->load->view("../errors/error_db", $data);
				return;
			}
			redirect( base_url() . 'index.php/restaurant/show_restaurant/' . $resId);
 		}
 		$this->show_restaurant($resId);
	}
}