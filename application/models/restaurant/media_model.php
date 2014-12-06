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
    	// delete the file in image folders
    	unlink($filename);
	}

	public function delete_all_album_medias($albumId) {
		$this->db->where('album_id', $albumId);
		$query = $this->db->get('medias');
		foreach( $query->result() as $row) {
			$this->delete_media($row->filename);
		}
	}
}