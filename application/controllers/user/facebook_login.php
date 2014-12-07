<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require dirname(__DIR__) . '/facebook_autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphUser;

class Facebook_Login extends CI_Controller {
	private $helper;
	public function __construct() {
		parent::__construct();

		session_start();
		// initialization for user authentication with facebook
		$this->config->load('facebook');
		$appID = $this->config->item('appID', 'facebook');
		$appSecret = $this->config->item('appSecret', 'facebook');
		$redirect_url = $this->config->item('redirect_url', 'facebook');

		FacebookSession::setDefaultApplication($appID, $appSecret);
		$this->helper = new FacebookRedirectLoginHelper($redirect_url);
	}

	/* Function returns facebook login url
	 * Embbed this url to a link/button in a view 
	 * to let users login with facebook
	*/
	public function get_facebook_login_url() {
		$facebookLoginUrl = $this->helper->getLoginUrl(
			array('scope' => 'email, user_friends, user_birthday',));
		return $facebookLoginUrl;
	}

	public function do_facebook_login() {
		
		try {
			$session = $this->helper->getSessionFromRedirect();
			if ($session) {
				$this->load->model('user/basic_user_model');

				// retrieve user profile information
				$userProfile = (new FacebookRequest( $session, 'GET', '/me' ))
									->execute()
									->getGraphObject(GraphUser::className());
				$facebookID = $userProfile->getId();
				$username = 'user' . $facebookID;
				$fullname = $userProfile->getName();
				$dob = date("Y-m-d", strtotime($userProfile->asArray()['birthday']));
				$email = $userProfile->getEmail();
				
				// Check if user with this facebook id exist?
				$this->db->where('username', $username);
				$query = $this->db->get('users');
				
				// if exists, update information
				if($query->num_rows == 1){
					$fbUserdata = array(
						'fullname' => $fullname,
						'dob' => $dob,
						'email' => $email,
					);
					$this->basic_user_model->update_account($username, $fbUserdata);
				}
				// if not exists: create account with retrieved information 
				else {
					$DEFAULT_PASSWORD_LENGTH = 10;

					$password = $this->basic_user_model->generate_password($DEFAULT_PASSWORD_LENGTH);
					$gender = $userProfile->asArray()['gender']=="male"? 'm':'f';
					$fbUserdata =array(
						'username' => $username,
						'password' => password_hash($password, PASSWORD_DEFAULT),
						'email' => $email,
						'fullname' => $fullname,
						'gender' => $gender,
						'dob' => $dob,
						'facebookID' => $facebookID,
					);
					$this->basic_user_model->create_member_from_array($fbUserdata);	
					$message = "Successfully created accout";
					echo "<script type='text/javascript'>alert('$message');</script>";				
				}
				$userdata = $this->basic_user_model->get_user_info ( $username );
				$this->session->set_userdata ( $userdata );
				redirect ( 'welcome' );
			}
		} catch(FacebookRequestException $ex) {
			$message = "Something went wrong when log in with Facebook ";
			echo "<script type='text/javascript'>alert('$message');</script>";
			// When Facebook returns an error
		} catch(\Exception $ex) {
			$message = "Something went wrong when log in with Facebook ";
			echo "<script type='text/javascript'>alert('$message');</script>";
			// When validation fails or other local issues
		}
		
	}
}