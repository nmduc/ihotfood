<?php

class Country_Restaurant_Model extends CI_Model{
	// --------------------------------------------------------------------
 	/**
	  * Create new restaurant
	  *
	  */
	public function get_country_list() {
		$query = $this->db->get('countries');
		$countryList = array();
		foreach($query->result() as $row) {
			$countryList[$row->abbrev] = $row->name;
		}
		return $countryList;
	}

	public function create_country_restaurant_link($restaurant_id,$country_abbrev) {
		$data=array(
			'restaurant_id' => $restaurant_id,
			'country_abbrev' => $country_abbrev,
		);
		$q = $this->db->insert('restaurant_country_links', $data);
		return $q;
	}

	// validate list of country abbrevations selected
	public function validateCountryAbbrev($abbrev) {
		$this->db->where('abbrev', $abbrev);
		$query = $this->db->get('countries');
		if($query->num_rows == 1) {
			return true;
		}
	}
}

