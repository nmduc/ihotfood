<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('date');
		$this->load->library('image_lib');
	}

	public function upload_restaurant_photo() {
		$this->load->model("restaurant/restaurant_model");
		$restaurant = $this->restaurant_model->get_restaurant_by_id($this->input->post('restaurant-id'));

		if( ! $this->session->userdata('id') || $this->session->userdata('id') != $restaurant->owner_id ) {
			http_response_code(403);
			echo "Permission denied";
		}
		else {
			if (!empty($_FILES)) {
				$album_id = $restaurant->album_id;
				$len = count($_FILES['file']['tmp_name']);
				for($i=0; $i < $len; $i ++) {
					$tempFile = $_FILES['file']['tmp_name'][$i];
					$fileName = $_FILES['file']['name'][$i];
					$targetPath = 'static/user_upload/';
					$serverFileName = $this->generate_unique_file_name($album_id, $fileName);
					$targetFile = $targetPath . $serverFileName;

					// save file to server
					move_uploaded_file($tempFile, $targetFile);
					
					// save to database
					$this->load->model("restaurant/media_model");
					$this->media_model->create_media($album_id, $serverFileName);

					// create and save image thumbnail
					// configs for image library to create thumbnails
					$config['image_library'] = 'gd2';
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']	= 100;
					$config['height']	= 100;
					$config['source_image']	= $targetFile;
					$this->image_lib->initialize($config);
					$thumbnail = $this->image_lib->resize();

					// return the name as which the file is store in server (for removing if necessary)
					echo($serverFileName);
				}
			}
		}
    }

    // remove just uploaded photo 
    public function remove_uploaded_restaurant_photo() {
    	$this->load->model("restaurant/restaurant_model");
		$restaurant = $this->restaurant_model->get_restaurant_by_id($this->input->post('restaurant-id'));
		
		if( ! $this->session->userdata('id') || $this->session->userdata('id') != $restaurant->owner_id ) {
			http_response_code(403);
			echo "Permission denied";
		}

		$targetPath = 'static/user_upload/';
    	$file_dir = $targetPath . $this->input->post('filename');
    	// delete file
    	// unlink($file_dir);
    	// remove corresponding database record
		$this->load->model("restaurant/media_model");
    	$this->media_model->delete_media($this->input->post('filename'));
    }


    public function upload_review_photo() {
		$this->load->model("restaurant/review_model");
		$review = $this->review_model->get_review($this->input->post('review-id'));

		if( ! $this->session->userdata('id') || $this->session->userdata('id') != $review->user_id ) {
			http_response_code(403);
			echo "Permission denied";
		}
		else {
			if (!empty($_FILES)) {
				$album_id = $review->album_id;
				$len = count($_FILES['file']['tmp_name']);
				for($i=0; $i < $len; $i ++) {
					$tempFile = $_FILES['file']['tmp_name'][$i];
					$fileName = $_FILES['file']['name'][$i];
					$targetPath = 'static/user_upload/';
					$serverFileName = $this->generate_unique_file_name($album_id, $fileName);
					$targetFile = $targetPath . $serverFileName;

					// save file to server
					move_uploaded_file($tempFile, $targetFile);
					
					$config['image_library'] = 'gd2';
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']	= 100;
					$config['height']	= 100;
					$config['source_image']	= $targetFile;
					$this->image_lib->initialize($config);
					$thumbnail = $this->image_lib->resize();
					// save to database
					$this->load->model("restaurant/media_model");
					$this->media_model->create_media($album_id, $serverFileName);

					// return the name as which the file is store in server (for removing if necessary)
					echo($serverFileName);
				}
			}
		}
    }

    public function remove_photo($filename) {
		$this->load->model("restaurant/media_model");
	 	$this->media_model->delete_media($this->input->post('filename'));
	 	$jsonArr['status'] = 'true';
	 	echo(json_encode($jsonArr));
    }

    public function generate_unique_file_name($album_id, $fileName) {
    	$tempFilename = tempnam('static/user_upload/', '');
    	unlink($tempFilename);
    	// tempFilename = "directory/<unique>.tmp"
    	$temp = explode('\\', $tempFilename);
    	// get file extension
    	$temp2 = explode('.', $fileName);
    	return explode('.', $temp[count($temp)-1])[0] . $_SERVER['REQUEST_TIME'] . '.' . $temp2[count($temp2) -1 ];
    }
}