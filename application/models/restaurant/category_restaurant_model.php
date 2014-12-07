<?php

class Category_Restaurant_Model extends CI_Model{
	// --------------------------------------------------------------------
 	/**
	  * Create new restaurant
	  *
	  */
	public function get_category_list() {
		$query = $this->db->get('categories');
		$categoryList = array();
		foreach($query->result() as $row) {
			$categoryList[$row->abbrev] = $row->description;
		}
		return $categoryList;
	}

	public function create_category_restaurant_link($restaurant_id, $category_abbrev) {
		$data=array(
			'restaurant_id' => $restaurant_id,
			'category_abbrev' => $category_abbrev,
		);
		$q = $this->db->insert('restaurant_category_links', $data);
		return $q;
	}

	// validate list of country abbrevations selected
	public function validateCategoryAbbrev($abbrev) {
		$this->db->where('abbrev', $abbrev);
		$query = $this->db->get('categories');
		if($query->num_rows == 1) {
			return true;
		}
	}

	public function delete_all_category_link_to_restaurant($resId) {
		$this->db->where('restaurant_id', $resId);
		$this->db->delete('restaurant_category_links');
	}
}

