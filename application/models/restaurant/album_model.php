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

	public function delete_album($albumId) {
		$this->load->model('restaurant/media_model');
		$this->media_model->delete_all_album_medias($albumId);

		$this->db->where('id', $albumId);
		$this->db->delete('albums');
	}
}
