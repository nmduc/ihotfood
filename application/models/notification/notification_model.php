<?php
class Notification_Model extends CI_Model {
	const COMMENT_ON_RESTAURANT = 1;
	
	public function notify_new_restaurant_review($restaurant_id, $user_id, $review_id, $socket_id){
		$this->load->library('Pusher/Pusher');
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
	
	public function save_notification($object_id, $subject_id, $actor_id, $type_id) {
		$created_date = date ( "Y-m-d H:i:s" );
		$this->db->query( "INSERT INTO notifications 
		(actor_id, subject_id, object_id, type_id, status, count, created_date, updated_date)
		VALUES ($actor_id, $subject_id, $object_id, $type_id, 'unseen', 1, '$created_date', '')" );
	}
	public function get_subscriber_by_channel($channel_id) {
		$this->db->select('user_id');
		$this->db->where('channel_id', $channel_id);
		$query = $this->db->get('notification_subscribe');
		if($query->num_rows() > 0){
		  	return $query->result_array();
		}
	}
	public function get_channel_by_user_id($user_id) {
		$this->db->select('channel_id');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('notification_subscribe');
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function subsribe_channel($user_id, $channel_id) {
		 $q = $this->db->insert('notification_subscribe', array(
		  		'user_id' => $user_id,
		 		'channel_id' => $channel_id
		  ));
		  return $this->db->insert_id();
	}
	public function is_user_subscribed($user_id, $channel_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('channel_id', $channel_id);
		$query = $this->db->get('notification_subscribe');
		if($query->num_rows == 1){
			return true;
		}
		return false;
	}
	public function getNotifications($subjectId, $page = 1) {
		$result = $this->db->query ( "SELECT nf.*, actor.name AS actor_name, subject.name AS subject_name
				FROM notifications nf
				INNER JOIN users actor ON nf.actor_id = actor.id
				INNER JOIN users SUBJECT ON nf.subject_id = SUBJECT.id
				WHERE subject_id = $subjectId
				AND status = 'unseen'
				LIMIT $offset, 5" );
		$rows = array ();
		while ( $row = $result->fetch_assoc () ) {
			$rows [] = $row;
		}
	}
	protected function getObjectRow($typeId, $objectId) {
		switch ($typeId) {
			case self::COMMENT_ON_RESTAURANT :
				return $this->db->query ( "SELECT name FROM restaurants WHERE id = $objectId" )->fetch_assoc ();
		}
	}
	protected function getNotificationMessage($row) {
		switch ($row ['type_id']) {
			case self::COMMENT_ON_RESTAURANT :
				return "{$row['actor_name']} commented on {$row['subject_name']} review {$row['object']['status']}";
		}
	}
	public function markSubjectNotificationsSeen($subjectId){
		$result = $this->db->query("SELECT nf.* FROM notifications nf WHERE subject_id = $subjectId");
		$rows = array();
		while($row = $result->fetch_assoc()){
			$this->db->query("Update notifications SET status = 'seen' Where id = {$row['id']}");
		}
		return;
	}
}