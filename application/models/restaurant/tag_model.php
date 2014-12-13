<?php

class Tag_Model extends CI_Model{
	public function create_tag($tagName) {
		$data = array('name'=> $tagName);
		$this->db->insert('tags', $data);
		return $this->db->insert_id();
	}

	public function get_tag($tag) {
		$this->db->where('name', $tag);
		$query = $this->db->get('tags');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	public function get_tag_by_id($tagID) {
		$this->db->where('id', $tagID);
		$query = $this->db->get('tags');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	public function get_all_tags() {
		$query = $this->db->get('tags');
		$tagList = array();
		foreach($query->result() as $row) {
			array_push($tagList, $row->name);
		}
		return $tagList;
	}
}