<?php

class Language_Restaurant_Model extends CI_Model{
	// --------------------------------------------------------------------
 	/**
	  * Create new restaurant
	  *
	  */
	public function get_language_list() {
		$query = $this->db->get('languages');
		$languageList = array();
		foreach($query->result() as $row) {
			$languageList[$row->abbrev] = $row->name;
		}
		return $languageList;
	}

	public function create_language_restaurant_link($restaurant_id,$language_abbrev) {
		$data=array(
			'restaurant_id' => $restaurant_id,
			'language_abbrev' => $language_abbrev,
		);
		$q = $this->db->insert('restaurant_language_links', $data);
		return $q;
	}

	// validate list of country abbrevations selected
	public function validateLanguageAbbrev($abbrev) {
		$this->db->where('abbrev', $abbrev);
		$query = $this->db->get('languages');
		if($query->num_rows == 1) {
			return true;
		}
	}

	public function delete_all_language_link_to_restaurant($resId) {
		$this->db->where('restaurant_id', $resId);
		$this->db->delete('restaurant_language_links');
	}
}

