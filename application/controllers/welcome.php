<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index() {
		if(! $this->session->userdata('facebookLoginURL')) {
			$this->load->library("../controllers/user/facebook_login");
			$this->session->set_userdata('facebookLoginURL', $this->facebook_login->get_facebook_login_url());
		}
		$this->load->view('frontend/index');
	}
}