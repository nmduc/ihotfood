<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index() {
		if(! $this->session->userdata('facebookLoginURL')) {
			$this->load->library("../controllers/user/facebook_login");
			$this->session->set_userdata('facebookLoginURL', $this->facebook_login->get_facebook_login_url());
		}

		$this->load->model('restaurant/restaurant_model');
		if( $this->session->userdata ( 'username' )) {
			$restaurantList = $this->restaurant_model->get_restaurant_by_user((int)$this->session->userdata ( 'id' ));
			// add items to session
			$res = array();
			foreach ($restaurantList as $restaurant) {
				array_push($res, array( $restaurant->id, $restaurant->name));
			}
			$this->session->set_userdata('user-restaurants', $res);
		}

		$data = array(
			'restaurants' => $this->restaurant_model->get_restaurant_list(),
		);
		$this->load->view('frontend/index', $data);
	}
}