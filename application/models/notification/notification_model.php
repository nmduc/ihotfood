<?php
class Notification_Model extends CI_Model {
	const COMMENT_ON_RESTAURANT = 1;
	
	/**
	 * Get all subscribers for a channel
	 * In this case, it could be a restaurant_id in this case
	 *
	 */
	public function get_subscriber_by_channel($channel_id) {
		$this->db->select('user_id');
		$this->db->where('channel_id', $channel_id);
		$query = $this->db->get('notification_subscribe');
		if($query->num_rows() > 0){
		  	return $query->result_array();
		}
	}
	/**
	 * Get all channel subscribed by a user
	 * In this case, it could be a restaurant_id in this case
	 *
	 */
	public function get_channel_by_user_id($user_id) {
		$this->db->select('channel_id');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('notification_subscribe');
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	/**
	 * Make user subscribe for a specific a channel
	 * In this case, it could be a restaurant_id in this case
	 *
	 */
	public function subsribe_channel($user_id, $channel_id) {
		 $q = $this->db->insert('notification_subscribe', array(
		  		'user_id' => $user_id,
		 		'channel_id' => $channel_id
		  ));
		  return $this->db->insert_id();
	}
	/**
	 * Check if user subscribes for a channel
	 * In this case, it could be a restaurant_id in this case
	 *
	 */
	public function is_user_subscribed($user_id, $channel_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('channel_id', $channel_id);
		$query = $this->db->get('notification_subscribe');
		if($query->num_rows == 1){
			return true;
		}
		return false;
	}
	/**
	 * Save notification for target user
	 *
	 */
	public function save_notification($user_id, $restaurant_id, $review_id) {
		$created_date = date ( "Y-m-d H:i:s" );
		$this->db->query( "INSERT INTO notifications
				(user_id, restaurant_id, review_id, type_id, status, count, created_date, updated_date)
				VALUES ($user_id, $restaurant_id, $review_id, 1, 'unseen', 1, '$created_date', '')" );
	}
	/**
	 * Get notification made by a user 
	 *
	 */
	public function get_notification($user_id, $restaurant_id, $review_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('restaurant_id', $restaurant_id);
		$this->db->where('review_id', $review_id);
		$query = $this->db->get('notifications');
		if($query->num_rows == 1){
			return $query->row_array();
		}
	}
	/**
	 * Get all notifications
	 *
	 */
	public function get_all_notification($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('notifications');
		
		if ($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function mark_notification_seen($notification_id){
		$data = array(
			'status' => 'seen'	
		);
		$this->db->where('id', $notification_id);
		$query = $this->db->update('notifications', $data);
	}
}