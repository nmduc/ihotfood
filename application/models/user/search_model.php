<?php

class Search_Model extends CI_Model{
	// --------------------------------------------------------------------
	/**
	 * Verify if restaurant has a tag
	 * Return true if exists, otherwhise false
	 *
	 */
	 public function is_tag_res_linked($tag_id, $restaurant_id) {
		 $this->db->where('tag_id', $tag_id);
		 $this->db->where('restaurant_id', $restaurant_id);
		 $query = $this->db->get('tag_restaurant');
		 if($query->num_rows == 1){
		 	return true;
		 }
		 return false;
	 }
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
	 * Verify if tag is stored in a specific restaurant
	 * Return true if exists, otherwhise false
	 *
	 */
	 public function is_tag_stored($tag_name) {
		 $this->db->where('name', trim($tag_name));
		 $query = $this->db->get('tags');

		 if($query->num_rows == 1){
				return $query->row()->id;
		 }
		 return null;
	 }
	 // --------------------------------------------------------------------
	 /**
	  * Get restaurant id by exact name
	  *
	  */
	  public function get_res_id_by_name($name) {
	  	  $this->db->select('id');
		  $this->db->where('name', $name);
		  $query = $this->db->get('restaurants');
		  
		  if($query->num_rows == 1){
		  	return $query->row()->id;
		  }
		  return false;
	  }
	 // --------------------------------------------------------------------
	 /**
	  * Insert tags into db with tag name and restaurant id
	  *
	  */
	  public function insert_tag($tag_name){
		  $q = $this->db->insert('tags', array(
		  		'name' => $tag_name
		  ));
		  return $this->db->insert_id();
	  }
	  // --------------------------------------------------------------------
	  /**
	   * Create a link betweeen restaurant and tag
	   *
	   */
	   public function insert_tag_and_restaurant_link($tag_id, $restaurant_id){
		   $q = $this->db->insert('tag_restaurant', array(
		   		'tag_id' => $tag_id,
		   		'restaurant_id' => $restaurant_id
		   ));
		   return $this->db->insert_id();
	   }
	  
	// --------------------------------------------------------------------
	/**
	 * Insert restaurant information to db
	 *
	 */
	public function insert_res($data){
		$q = $this->db->insert('restaurants', $data);
		return $this->db->insert_id(); 
	}
	// --------------------------------------------------------------------
	/**
	 * Search for restaurants
	 * 
	 */
	public function search($data){
		$q = "SELECT res.id, res.name, res.address, res.latlong
				res.country, res.postcode, res.tel
				FROM restaurants res
				WHERE res.name LIKE '%" . $data['s_keyword'] . "%'";
		if(isset($data['s_postcode']) && strlen($data['s_postcode']) > 0) {
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
	public function get_res_by_name($data) {
		$this->db->select('name');
		if (isset($data['s_postcode'])) {
			$this->db->where('postcode', $data['s_postcode']);
		}
		$this->db->like('name', $data['query']);
		$r = $this->db->get('restaurants');
		
		if ($r->num_rows() > 0){
			return $r->result_array();
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Get postcode by wildcard for suggestions
	 *
	 */
	public function get_postcode_for_suggestion($data) {
		$this->db->select('postcode');
		
		if (isset($data['s_country'])) {
			$this->db->where('country', $data['s_country']);
		}
		
		$this->db->like('postcode', $data['query'] , 'both');
		$this->db->distinct();
		
		$r = $this->db->get('postcode');
	
		if ($r->num_rows() > 0){
			return $r->result_array();
		}
	}
}