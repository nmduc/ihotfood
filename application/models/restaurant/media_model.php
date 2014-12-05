<?php

class Media_Model extends CI_Model{
	public function create_media($album_id, $filename) {
		$data=array(
			'album_id' => $album_id,
			'user_id' => $this->session->userdata('id'),
			'filename' => $filename,
		);
		$this->db->insert('medias', $data);
	}

	public function delete_media($filename) {
		$this->db->where('filename', $filename);
		$this->db->delete('medias');
	}
}