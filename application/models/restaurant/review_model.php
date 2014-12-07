<?php

class Review_Model extends CI_Model{
	public function create_review($resId) {
		$this->load->helper('date');
		$datetime = date('Y-m-d H:i:s'); 
		
		$this->load->model("restaurant/album_model");
		$album_id = $this->album_model->create_album($this->session->userdata('username') . '_' . $resId);
		
		$data=array(
			'user_id' => $this->session->userdata('id'),
			'restaurant_id' => $resId,
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'rating' => $this->input->post('score-add'),
			'publish_time' => $datetime,
			'album_id' => $album_id,
		);

		$q = $this->db->insert('reviews', $data);
		return $this->db->insert_id();
	} 

	public function get_restaurant_reviews($resId, $offset=0, $nRows=0) {
		$reviews = array();
		$this->db->where('restaurant_id', $resId);
		$this->db->order_by("publish_time", "desc");
		if($nRows > 0 ) {
			$query = $this->db->get('reviews', $nRows, $offset);
		}
		else {
			$query = $this->db->get('reviews');	
		}
		foreach ($query->result() as $row) {
			array_push($reviews, $row);
		}
		return $reviews;
	}

	public function get_review($reviewId) {
		$this->db->where('id', $reviewId);
		$query = $this->db->get('reviews');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	public function delete_review($reviewId) {
		$this->db->where('id', $reviewId);
		$q = $this->db->delete('reviews');
		return $q;
	}

	public function update_review($reviewId) {
		$this->db->where('id', $reviewId);
		$data=array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'rating' => $this->input->post('score-edit'),
		);
		$q = $this->db->update("reviews", $data);
		return $q;
	}

	public function create_review_for_search($resId, $title = 'A review', $content, $rating) {
		$this->load->helper('date');
		$datetime = date('Y-m-d H:i:s');
	
		$data=array(
				'restaurant_id' => $resId,
				'title' => $title,
				'content' => $content,
				'rating' => $rating,
				'publish_time' => $datetime,
		);
		
		$q = $this->db->insert('reviews', $data);
		
		//update restaurant updated time
		$data = array(
			'updated_time' => $datetime	
		);
		$this->db->insert('restaurants', $data);
		return $this->db->insert_id();
	}
}