<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('notify_new_restaurant_review'))
{
	function notify_new_restaurant_review($restaurant_id, $user_id, $review_id, $socket_id) {
		$this->load->library('Pusher/Pusher');
		$this->load->model("notification/notification_model");
		
		$pusher = new Pusher(PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET);
		
		$message = '<p>User_ID ' . $user_id. ' gives a new Review_ID ' . $review_id;
		$message = $message . ' to your Restaurant_ID ' . $restaurant_id;
		
		$data = array(
			'message' => $message,
			'dest' =>base_url("index.php/restaurant/show_restaurant/" . $restaurant_id) 
		);
		$pusher->trigger(NEW_REVIEW_NOTIFCATION_CHANNEL .$restaurant_id,
				NEW_REVIEW_NOTIFCATION_EVENT,
				$data,
				$socket_id);
	} 
}