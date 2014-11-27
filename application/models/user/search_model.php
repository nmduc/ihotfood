<?php

class Search_Model extends CI_Model{
	// --------------------------------------------------------------------
	/**
	 * Verify if restaurant is stored in db
	 * Return true if exists, otherwhise false
	 *
	 */
	public function is_res_stored($name) {
		$this->db->where('name', $name);
		$query = $this->db->get('restaurant');
		if($query->num_rows == 1){
			return true;
		} 
		return false;
	}
	public function insert_res($data){
		$q = $this->db->insert('restaurant', $data);
		return $q;
	}
}