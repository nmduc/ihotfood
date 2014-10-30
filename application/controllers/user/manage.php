<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Manage extends MY_Controller {
	public function index() {
		$this->load->view ( 'frontend/profile' );
	}
	public function show_account() {
		$this->load->view ( 'frontend/profile' );
	}
	
	public function show_change_password() {
		$this->load->view ( 'frontend/pwd_edit' );
	}
	public function show_add_location() {
		$this->load->view ( 'frontend/location_form' );
	}
	// --------------------------------------------------------------------
	/**
	 * Update account
	 */
	public function update_account() {
		$username = $this->session->userdata ( 'username' );
		$fullname = $this->input->post ( 'fullname' );
		$dob = $this->input->post ( 'dob' );

		$data = array (
				'fullname' => $fullname,
				'dob' => date('Y-m-d', strtotime($dob)) 
		);
		
		$this->load->model ( 'user/basic_user_model' );
		
		$this->basic_user_model->update_account ( $username, $data );
		$userdata = $this->basic_user_model->get_user_info ( $username );
		
		if (isset ( $userdata )) {
			$this->session->set_userdata ( $userdata );
		}
		
		$this->show_account ();
	}
	// --------------------------------------------------------------------
	/**
	 * Update password
	 */
	public function update_password() {
		$this->form_validation->set_rules ( 'old_password', 'Old Password', 'trim|required|min_length[4]|callback_validatePwd' );
		$this->form_validation->set_rules ( 'new_password', 'New Password', 'trim|required|min_length[4]|callback_validatePwdStr' );
		$this->form_validation->set_rules ( 'password_confirm', 'New Password Confirmation', 'trim|required|matches[new_password]' );
		
		if ($this->form_validation->run () == TRUE) {
			$this->load->model ( 'user/basic_user_model' );
			
			$data = array(
				'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
			);
			
			$this->basic_user_model->update_account( $this->session->userdata('username'), $data );
		}
		$this->show_change_password();
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if password is strong enough
	 * Error if weak
	 * Used for register
	 */
	public function validatePwdStr($password) {
		if (strlen ( $password ) < 8) {
			$this->form_validation->set_message ( 'validatePwdStr', 'Password too short!' );
			return FALSE;
		}
		
		if (! preg_match ( "#[0-9]+#", $password )) {
			$this->form_validation->set_message ( 'validatePwdStr', 'Password must include at least one number!' );
			return FALSE;
		}
		
		if (! preg_match ( "#[a-zA-Z]+#", $password )) {
			$this->form_validation->set_message ( 'validatePwdStr', 'Password must include at least one letter!' );
			return FALSE;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if email is duplicated
	 * Error if duplicated
	 * Used for register
	 */
	public function validateEmail($email) {
		$this->load->model ( 'user/basic_user_model' );
		$query = $this->basic_user_model->validateEmail ( $email );
		if ($query) {
			$this->form_validation->set_message ( 'validateEmail', 'Your email is registered for another account' );
			return FALSE;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if password is correct when compared to DB
	 * Error if does not match
	 * Used for login
	 */
	 public function validatePwd($password) {
	 	$this->load->model ( 'user/basic_user_model' );
	 	$pwdHash = $this->basic_user_model->getPwdHashUser ();
	
		if (isset ( $pwdHash )) {
			if (! $this->basic_user_model->validatePwd ( $password, $pwdHash )) {
	 			$this->form_validation->set_message ( 'validatePwd', 
	 				'The password you entered is incorrect. Lost your password?' );
	 			return FALSE;
	 		}
	 	}
	 }
}