<?php

class Restaurant_Model extends CI_Model{
	// --------------------------------------------------------------------
 	/**
	  * Create new restaurant
	  *
	  */
	public function create_restaurant($ownerID) {
		$data=array(
			'owner_id' => $ownerID,
			// basic restaurant information
			'name' => $this->input->post('name'),
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
		$this->db->insert('restaurants', $data);
		$id= $this->db->insert_id();
		echo $id;
		return $id;
	}
}

