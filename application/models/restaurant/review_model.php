<?php

class Review_Model extends CI_Model{
	public function create_review($resId) {
		$this->load->helper('date');
		$datetime = date('Y-m-d H:i:s'); 

		$data=array(
			'user_id' => $this->session->userdata('id'),
			'restaurant_id' => $resId,
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'rating' => $this->input->post('score'),
			'publish_time' => $datetime,
		);

		$q = $this->db->insert('reviews', $data);
		return $q;
	} 

	public function get_restaurant_reviews($resId) {
		$reviews = array();
		$this->db->where('restaurant_id', $resId);
		$query = $this->db->get('reviews');
		foreach ($query->result() as $row) {
			array_push($reviews, $row);
		}
		return $reviews;
	}
}