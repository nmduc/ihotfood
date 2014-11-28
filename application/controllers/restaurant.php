<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant extends CI_Controller {
	
	// show restaurant details
	// http://ihotfood.com/index.php/restaurant/show_restaurant/restaurantID
	public function show_restaurant($id) {
		$this->load->model( 'restaurant/restaurant_model' );
		$restaurant = $this->restaurant_model->get_restaurant_by_id($id);
		if(! $restaurant ) {
		}
		$data = array (
			'restaurant' => $restaurant,
		);
		$this->load->view ( 'frontend/show_restaurant', $data );
	}
}