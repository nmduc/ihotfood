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

	public function get_media($filename) {
		$this->db->where('filename', $filename);
		$query = $this->db->get('medias');
		if($query->num_rows == 1){
			return $query->row();
		} 
		return null;
	}

	public function get_all_album_medias($albumId) {
		$this->db->where('album_id', $albumId);
		$query = $this->db->get('medias');
		$media_list = array();
		foreach($query->result() as $media) {
			array_push($media_list, $media);
		}
		return $media_list;
	}

	public function delete_media($filename) {
		$this->db->where('filename', $filename);
		$this->db->delete('medias');

    	$temp = explode('.', $filename);
    	$thumbnail = $temp[0] . '_thumb.' . $temp[1];
    	
		$targetPath = 'static/user_upload/';
    	// delete the file in image folders
    	unlink($targetPath . $filename);
    	// delete thumbnail
    	unlink($targetPath . $thumbnail);
	}

	public function delete_all_album_medias($albumId) {
		$this->db->where('album_id', $albumId);
		$query = $this->db->get('medias');
		foreach( $query->result() as $row) {
			$this->delete_media($row->filename);
		}
	}
}