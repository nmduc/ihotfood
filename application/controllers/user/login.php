<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Login extends CI_Controller {
	public function index() {
		if (! $this->session->userdata ( 'username' )) {
			$this->show_login ();
		}
	}
	public function pusher_authentication() {
		if ($this->session->userdata('username') && $this->session->userdata('id')) {
			$this->load->library('Pusher/Pusher');
			$app_id 	= '98512';
			$app_key 	= 'cf584ed819ea7556d59f';
			$app_secret = '3678c474706b21612a64';
			
			$pusher = new Pusher($app_key, $app_secret, $app_id);
			$presencedata = array(
				'id' => $this->session->userdata('id')
			);
			echo $pusher->presence_auth($_POST['channel_name'], 
					$this->session->userdata('uuid'), 
					$presencedata);
		}
	}
	// --------------------------------------------------------------------
	public function show_login() {
		if (! $this->session->userdata ( 'username' )) {
			$this->load->library("../controllers/user/facebook_login");
			$facebookLoginURL = $this->facebook_login->get_facebook_login_url();

			$data['facebookLoginURL'] = $facebookLoginURL;
			$data ['username_cookie'] = $this->input->cookie ( 'ihf_usr_ck' );
			
			$this->load->view ( 'frontend/login', $data );
		} else {
			redirect ( 'welcome' );
		}
	}
	// --------------------------------------------------------------------
	public function show_register() {
		if (! $this->session->userdata ( 'username' )) {
			$this->load->library("../controllers/user/facebook_login");
			$facebookLoginURL = $this->facebook_login->get_facebook_login_url();

			$data['facebookLoginURL'] = $facebookLoginURL;

			$this->load->view ( 'frontend/register', $data );
		} else {
			redirect ( 'welcome' );
		}
	}
	// --------------------------------------------------------------------
	public function do_login() {
		$this->load->model("notification/notification_model");
		
		$this->form_validation->set_rules ( 'username', 'User Name', 'required|trim|max_length[50]|xss_clean|callback_validateUsernameEx' );
		$this->form_validation->set_rules ( 'password', 'Password', 'required|trim|max_length[200]|xss_clean|callback_validatePwd' );
		
		if ($this->form_validation->run () == TRUE) {
			$this->load->model ( 'user/basic_user_model' );
			// get variables
			$username = $this->input->post ( 'username' );
			$password = $this->input->post ( 'password' );
			$is_login_remembered = $this->input->post ( 'is_login_remembered' );
			
			// get everything about users 
			$userdata = $this->basic_user_model->get_user_info ( $username );
			
			//and store in session
			$this->session->set_userdata ( $userdata );
			
			// get subscribing channels
			$userid = $this->session->userdata('id');
			$channelArr = $this->notification_model->get_channel_by_user_id($userid);
			$is_notification_channel_subscribed = false;
			
			
			//and update session
			$this->session->set_userdata('is_notification_channel_subscribed', $is_notification_channel_subscribed);
			$this->session->set_userdata('channels', $channelArr);
			redirect ( 'welcome' );
		}
		$this->show_login ();
	}
	// --------------------------------------------------------------------
	/**
	 * Used to create new member
	 */
	public function create_member() {
		$this->form_validation->set_rules ( 'username', 'User Name', 'trim|required|min_length[4]|callback_validateUsernameSp|callback_validateUsernameNotEx' );
		$this->form_validation->set_rules ( 'password', 'Password', 'trim|required|min_length[4]|callback_validatePwdStr' );
		$this->form_validation->set_rules ( 'password_confirm', 'Password Confirmation', 'trim|required|matches[password]' );
		$this->form_validation->set_rules ( 'email', 'Email Address', 'trim|required|valid_email|callback_validateEmail' );
		$this->form_validation->set_rules ( 'email_confirm', 'Email Address', 'trim|required|valid_email|matches[email]|callback_validateEmail' );
		
		if ($this->form_validation->run () == FALSE) {
			$this->show_register ();
		} else {
			$this->load->model ( 'user/basic_user_model' );
			if ($query = $this->basic_user_model->create_member ()) {
				$this->show_login ();
			} else {
				$this->load->view ( 'frontend/user/register' );
			}
		}
	}
	// --------------------------------------------------------------------
	public function do_logout() {
		$this->session->sess_destroy ();
		redirect ( 'welcome' );
	}
	// --------------------------------------------------------------------
	/**
	 * The callback to validate if username exists.
	 *
	 * Error if does not exist.
	 * Used for login
	 */
	public function validateUsernameEx() {
		$this->load->model ( 'user/basic_user_model' );
		$username = $this->input->post ( 'username' );
		$q = $this->basic_user_model->validateUsername ( $username );
		if (! $q) {
			$this->form_validation->set_message ( 'validateUsernameEx', 'Invalid username!' );
			return FALSE;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * The callback to validate if username is not duplicated
	 * Error if exists.
	 *
	 * Used for register.
	 */
	public function validateUsernameNotEx() {
		$this->load->model ( 'user/basic_user_model' );
		$username = $this->input->post ( 'username' );
		$q = $this->basic_user_model->validateUsername ( $username );
		if ($q) {
			$this->form_validation->set_message ( 'validateUsernameNotEx', 'Username ' . $username . ' already exists!' );
			return FALSE;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if password is correct when compared to DB
	 * Error if does not match
	 * Used for login
	 */
	public function validatePwd() {
		$this->load->model ( 'user/basic_user_model' );
		$pwdHash = $this->basic_user_model->getPwdHashUser ();
		$password = $this->input->post ( 'password' );
		
		if (isset ( $pwdHash )) {
			if (! $this->basic_user_model->validatePwd ( $password, $pwdHash )) {
				$this->form_validation->set_message ( 'validatePwd', 'The password you entered is incorrect. Lost your password?' );
				return FALSE;
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if username contains no special characters
	 * Error if contains
	 * Used for register
	 */
	public function validateUsernameSp() {
		$username = $this->input->post ( 'username' );
		if (! ctype_alnum ( $username )) {
			$this->form_validation->set_message ( 'validateUsernameSp', 'No special characters in username!' );
			return FALSE;
		}
	}
	// --------------------------------------------------------------------
	/**
	 * Validate if password is strong enough
	 * Error if weak
	 * Used for register
	 */
	public function validatePwdStr() {
		$password = $this->input->post ( 'password' );
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
	public function validateEmail() {
		$this->load->model ( 'user/basic_user_model' );
		$email = $this->input->post ( 'email' );
		$query = $this->basic_user_model->validateEmail ( $email );
		
		if ($query) {
			$this->form_validation->set_message ( 'validateEmail', 'Your email is registered for another account' );
			return FALSE;
		}
	}
}