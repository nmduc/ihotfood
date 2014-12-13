<?php

class Tag_Restaurant_Model extends CI_Model{
	public function get_restaurant_tag_list($resId) {
		$this->load->model('restaurant/tag_model');
		$this->db->where('restaurant_id', $resId);
		$query = $this->db->get('tag_restaurant');

		$tagList = array();
		foreach($query->result() as $row) {
			$tag = $this->tag_model->get_tag_by_id($row->tag_id);
			if($tag) {
				array_push( $tagList, $tag->name);
			}
		}
		return $tagList;
	}

	public function create_tag_restaurant_link($resID, $tagID) {
		$data=array(
			'restaurant_id' => $resID,
			'tag_id' => $tagID,
		);
		$q = $this->db->insert('tag_restaurant', $data);
		return $q;
	}

	public function delete_all_tag_link_to_restaurant($resId) {
		$this->db->where('restaurant_id', $resId);
		$this->db->delete('tag_restaurant');
	}
}