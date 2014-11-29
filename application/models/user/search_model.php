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
		$query = $this->db->get('restaurants');
		if($query->num_rows == 1){
			return true;
		} 
		return false;
	}
	// --------------------------------------------------------------------
	/**
	 * Insert restaurant information to db
	 *
	 */
	public function insert_res($data){
		$q = $this->db->insert('restaurants', $data);
		return $q;
	}
	// --------------------------------------------------------------------
	/**
	 * Search for restaurants
	 * 
	 */
	public function search($data){
		$q = "SELECT res.id, res.name, res.address, res.latitude, res.longitude,
				res.country, res.postcode, res.tel
				FROM restaurants res
				WHERE res.name LIKE '%" . $data['s_keyword'] . "%'";
		if(isset($data['s_postcode'])) {
			$q = $q . " AND res.postcode = '" . $data['s_postcode'] . "'";
		}
		if(isset($data['s_country'])) {
			$q = $q . " AND res.country = '" . $data['s_country'] . "'";
		}

		$r = $this->db->query($q);
		
		if ($r->num_rows() > 0){
			return $r->result_array();
		}
			
	}
	// --------------------------------------------------------------------
	/**
	 * Get restaurants by wildcard
	 *
	 */
	public function get_res_by_name($name) {
		$this->db->select('name');
		$this->db->like('name', $name);
		$r = $this->db->get('restaurants');
		
		if ($r->num_rows() > 0){
			return $r->result_array();
		}
	}
}