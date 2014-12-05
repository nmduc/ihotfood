<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	public function upload_photo() {
		if( ! $this->session->userdata('username')) {
			http_response_code(403);
			echo "Permission denied";
		}
		else {
			if (!empty($_FILES)) {
				$this->load->model("restaurant/restaurant_model");
				$restaurant = $this->restaurant_model->get_restaurant_by_id($this->input->post('restaurant-id'));
				$album_id = $restaurant->album_id;

				$tempFile = $_FILES['file']['tmp_name'][0];
				$fileName = $_FILES['file']['name'][0];
				$targetPath = 'static/user_upload/';
				$serverFileName = $this->generate_unique_file_name($album_id, $fileName);
				$targetFile = $targetPath . $serverFileName;

				// save file to server
				move_uploaded_file($tempFile, $targetFile);
				
				// save to database
				$this->load->model("restaurant/media_model");
				$this->media_model->create_media($album_id, $serverFileName);

				// return the name as which the file is store in server (for removing if necessary)
				echo($serverFileName);
			}
		}
    }

    public function remove_uploaded_photo() {
		$targetPath = 'static/user_upload/';
    	$file_dir = $targetPath . $this->input->post('filename');
    	// delete file
    	unlink($file_dir);
    	// remove corresponding database record
		$this->load->model("restaurant/media_model");
    	$this->media_model->delete_media($this->input->post('filename'));
    }

    public function generate_unique_file_name($album_id, $fileName) {
    	return $album_id . "_" . $this->session->userdata('id') . "_" . $_SERVER['REQUEST_TIME'] . "_" . $fileName;
    }
}