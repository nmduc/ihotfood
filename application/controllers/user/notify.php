<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Notify extends CI_Controller {
	public function notify_new_review() {
		$this->load->library('Pusher/Pusher');
		$pusher = new Pusher(PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET);
		
		$restaurant_id = $this->input->post('restaurant_id');
		$user_id = $this->input->post('user_id');
		$socket_id = $this->input->post('socket_id');
		$this->session->set_userdata('socket_id', $socket_id);
		$pusher->trigger(NEW_REVIEW_NOTIFCATION_CHANNEL . '361', 
				NEW_REVIEW_NOTIFCATION_EVENT, 
				array('message' => 'hello world'),
				$socket_id);
		//echo('yessss');
	}
}