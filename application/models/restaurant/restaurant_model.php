<?php

class Restaurant_Model extends CI_Model{
	public function get_restaurant_list() {
		$restaurantList = array();
		$query = $this->db->get('restaurants');
		foreach ($query->result() as $row) {
			array_push($restaurantList, $row);
		}
		return $restaurantList;
	}

	public function get_restaurant_by_id($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('restaurants');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	// return list of restaurant created by a specific user
	public function get_restaurant_by_user($userId) {
		$restaurantList = array();
		$this->db->where('owner_id',$userId);
		$query = $this->db->get('restaurants');
		foreach ($query->result() as $row) {
			array_push($restaurantList, $row);
		}
		return $restaurantList;
	}


	// --------------------------------------------------------------------
 	/**
	  * Create new restaurant
	  *
	  */
	public function create_restaurant($ownerID) {
		$this->load->model("restaurant/album_model");
		$album_id = $this->album_model->create_album($this->input->post('name'));
		
		$data=array(
			'owner_id' => $ownerID,
			// basic restaurant information
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'address_number' => $this->input->post('address_number'),
			'address_street' => $this->input->post('address_street'),
			'address_ward' => $this->input->post('address_ward'),
			'address_city' => $this->input->post('address_city'),
			'zipcode' => $this->input->post('zipcode'),
			'latlong' => $this->input->post('latlong'),
			'phone_number' => $this->input->post('phone_number'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),

			// other information
			'capacity' => $this->input->post('capacity'),
			'opening_hour' => $this->input->post('opening_hour'),
			'closing_hour' => $this->input->post('closing_hour'),
			'lowest_price' => $this->input->post('lowest_price'),
			'highest_price' => $this->input->post('highest_price'),
			'album_id' => $album_id,
		);
		$this->db->insert('restaurants', $data);
		$id= $this->db->insert_id();
		return $id;
	}

	public function update_restaurant($resId) {
		$data=array(
			// basic restaurant information
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'address_number' => $this->input->post('address_number'),
			'address_street' => $this->input->post('address_street'),
			'address_ward' => $this->input->post('address_ward'),
			'address_city' => $this->input->post('address_city'),
			'zipcode' => $this->input->post('zipcode'),
			'latlong' => $this->input->post('latlong'),
			'phone_number' => $this->input->post('phone_number'),
			'email' => $this->input->post('email'),
			'website' => $this->input->post('website'),

			// other information
			'capacity' => $this->input->post('capacity'),
			'opening_hour' => $this->input->post('opening_hour'),
			'closing_hour' => $this->input->post('closing_hour'),
			'lowest_price' => $this->input->post('lowest_price'),
			'highest_price' => $this->input->post('highest_price'),
		);
		$this->db->where('id', $resId);
		return $this->db->update('restaurants', $data); 
	}
	
	public function get_updated_time_for_restaurant($restaurant_id) {
		$this->db->select('updated_time');
		$this->db->where('id', $restaurant_id);
		$query = $this->db->get('restaurants');
		if($query->num_rows == 1){
			return $query->row()->updated_time;
		}
		return null;
	}
	public function update_restaurant_for_search($resId, $data) {
		$this->db->where('id', $resId);
		return $this->db->update('restaurants', $data);
	}
}

