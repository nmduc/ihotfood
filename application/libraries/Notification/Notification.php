<?php
class Notification{
	private $CI;
	private $pusher;
	public function __construct() {
		$this->CI = get_instance();
		$this->CI->load->library('Pusher/Pusher');
		$this->CI->load->model("notification/notification_model");
		
		$this->pusher = new Pusher(PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET);
	}
	public function mark_notification_seen($notification_id) {
		$this->CI->notification_model->mark_notification_seen($notification_id);
	}
	public function get_all_notification($user_id) {
		$notificationArr =  $this->CI->notification_model->get_all_notification($user_id);
		
		if ($notificationArr) {
			$messageTop = array();
			$messageTop['unseen_notification'] = 0;
			$messageTop['results'] = array();
			
			foreach ($notificationArr as $n) {
				$data = array();
				$data['id'] 			= $n['id'];
				$data['title'] 			= 'User_ID ' . $n['user_id']. ' gives a new Review_ID ' . $n['review_id'];
				$data['created_date']	= $n['created_date'];
				$data['status']			= $n['status'];
				$data['url']			= base_url("index.php/user/notify/click_notification/restaurant_id/") . '/' . $n['restaurant_id'] . '/notification_id/' . $n['id'];
				
				array_push($messageTop['results'], $data);
				
				if($data['status'] == 'unseen') {
					$messageTop['unseen_notification'] += 1;
				}
			}
			$messageTopJson = json_encode($messageTop);
			echo($messageTopJson);
		} else {
			echo('');
		}
	}
	/**
	 * Notify when there is a new restaurant review 
	 *
	 */
	public function notify_new_restaurant_review($restaurant_id, $user_id, $review_id, $socket_id){
		//save notification for other user
		$this->save_notification($restaurant_id, $review_id);
		
		//notification at right hand
		$messagePanel = '<p>User_ID ' . $user_id. ' gives a new Review_ID ' . $review_id;
		$messagePanel = $messagePanel . ' to your Restaurant_ID ' . $restaurant_id;
		
		//notification at top
		$notificationArr = $this->get_notification($user_id, $restaurant_id, $review_id);
		$messageTop = array();
		$messageTop['id'] 		= $notificationArr['id'];
		$messageTop['title'] 	= 'User_ID ' . $user_id. ' gives a new Review_ID ' . $review_id;
		$messageTop['created_date']		= $notificationArr['created_date'];
		$messageTopJson = json_encode($messageTop);
		//add data
		$data = array(
				'message_panel' => $messagePanel,
				'message_top' => $messageTopJson, 
				'dest' =>base_url("index.php/restaurant/show_restaurant/" . $restaurant_id)
		);
		
		//push data
		$this->pusher->trigger(NEW_REVIEW_NOTIFCATION_CHANNEL .$restaurant_id,
				NEW_REVIEW_NOTIFCATION_EVENT,
				$data,
				$socket_id);
	}
	/**
	 * Save notification for user
	 *
	 */
	public function save_notification ($restaurant_id, $review_id) {
		$userArr = $this->CI->notification_model->get_subscriber_by_channel($restaurant_id);
		
		if ($userArr) {
			foreach($userArr as $user) {
				$user_id = $user['user_id'];
				$this->CI->notification_model->save_notification($user_id, $restaurant_id, $review_id);
			}
		}
		
	}
	/**
	 * Get notification made by a user
	 *
	 */
	public function get_notification ($user_id, $restaurant_id, $review_id) {
		$notificationArr = $this->CI->notification_model->get_notification($user_id, $restaurant_id, $review_id);
		return $notificationArr;
	}
}