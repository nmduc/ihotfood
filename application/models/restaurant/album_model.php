<?php

class Album_Model extends CI_Model{
	public function create_album($album_name="noname") {
		$data = array(
			'name' => $album_name,
		);
		$this->db->insert('albums', $data);
		$id= $this->db->insert_id();
		return $id;
	}
}
