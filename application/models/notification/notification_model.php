<?php
class Notification_Model extends CI_Model {
	const COMMENT_ON_RESTAURANT = 1;
	
	public function save_notification($object_id, $subject_id, $actor_id, $type_id) {
		$created_date = date ( "Y-m-d H:i:s" );
		$this->db->query( "INSERT INTO notifications 
		(actor_id, subject_id, object_id, type_id, status, count, created_date, updated_date)
		VALUES ($actor_id, $subject_id, $object_id, $type_id, 'unseen', 1, '$created_date', '')" );
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