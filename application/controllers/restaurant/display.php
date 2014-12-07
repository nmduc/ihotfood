<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Display extends CI_Controller {
	public function index() {
		$this->load->view ( 'frontend/view_restaurant' );
	}
}