<?php

class Basic_user_model extends CI_Model{
	// --------------------------------------------------------------------
	/**
	 * Get password hash by username
	 * Return null if does not exists
	 *
	 */
	function getPwdHashUser(){
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('users');
		if($query->num_rows == 1){
			return $query->row()->password;
		} 
		return null;
	}
	// --------------------------------------------------------------------
	/**
	 * Verifies that the given hash matches the given password.
	 * Return true if match, otherwise false 
	 *
	 */
	function validatePwd($pwd, $pwdHash) {
		return password_verify($pwd, $pwdHash);
	}
	// --------------------------------------------------------------------
	/**
	* Validate if username exists
	* Return TRUE if exists
	*
	*/
	function validateUsername($username){
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		if($query->num_rows == 1){
			return true;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if email exists
	 * Return TRUE if exists
	 *
	 */
	 function validateEmail($email){
	 	$this->db->where('email', $email);
	 	$query = $this->db->get('users');
	 	if($query->num_rows == 1){
	 		return true;
	 	}
	 }
	// --------------------------------------------------------------------
	 /**
	  * Create new user
	  *
	  */
	function create_member(){
		$data=array(
			'username' => $this->input->post('username'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'account_type' => $this->input->post('account_type')
		);
		$q = $this->db->insert('users', $data);
		return $q;
	}
	// --------------------------------------------------------------------
	 /**
	  * Get user info
	  *
	  */
	
	function get_user_info($username) {
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		if ($query -> num_rows() == 1) {
			return $query->row_array();
		} 
		return false;
	}
	// --------------------------------------------------------------------
	/**
	 * Update user info by username and neccessary data
	 *
	 */
	function update_account($username, $data){
		$this->db->where('username', $username);
		$query = $this->db->update('users', $data);
	}
	
}