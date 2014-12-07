<?php

class Manage_model extends CI_Model{
	// --------------------------------------------------------------------
	/**
	 * Update account by username
	 * Return null if username does not exists
	 * Return full userdata otherwise
	 *
	 */
	function update_account($username, $data){
		$this->db->where('username', $username);
		$query = $this->db->update('users', $data);
	}

}