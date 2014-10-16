<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	public function showLogin() {
		$this->load->view('welcome_message');
	}
	public function doLogin () {
		$this->load->view('user/login_view');
	}
}