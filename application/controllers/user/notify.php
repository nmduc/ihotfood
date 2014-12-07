<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify extends CI_Controller {
	public function retrieve_all(){
		$user_id = $this->input->post('user_id');
		$this->notification->get_all_notification($user_id);
	}
	
	public function click_notification() {
		$array = $this->uri->uri_to_assoc(2);
		$notification_id = $array['notification_id'];
		$restaurant_id = $array['restaurant_id'];
		
		$this->notification->mark_notification_seen($notification_id);
		redirect('restaurant/show_restaurant/'. $restaurant_id, 'refresh');
	}
}