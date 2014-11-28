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
		$this->load->model( 'restaurant/country_restaurant_model' );
		$this->load->model( 'restaurant/category_restaurant_model' );
		$this->load->model( 'restaurant/language_restaurant_model' );
		$data = array( 
			'countries' => $this->country_restaurant_model->get_country_list(),
			'categories' => $this->category_restaurant_model->get_category_list(),
			'languages' => $this->language_restaurant_model->get_language_list(),
		);
		$this->load->view ( 'frontend/location_form', $data );
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

	 // --------------------------------------------------------------------
	 /**
	 */
	public function add_location() {
		// set rulse for basic information fields
		$this->form_validation->set_rules ( 'name', 'Restaurant Name', 'required|trim|max_length[200]|xss_clean' );
		$this->form_validation->set_rules ( 'address_number', 'Address Number', 'required|trim|max_length[4]|numeric|xss_clean' );
		$this->form_validation->set_rules ( 'address_street', 'Address Street', 'required|trim|max_length[200]|xss_clean' );
		$this->form_validation->set_rules ( 'address_ward', 'Address Ward', 'required|trim|max_length[200]|xss_clean' );
		$this->form_validation->set_rules ( 'address_city', 'Address City', 'required|trim|max_length[200]|xss_clean' );
		$this->form_validation->set_rules ( 'zipcode', 'Zipcode', 'required|trim|max_length[10]|numeric|xss_clean' );
		$this->form_validation->set_rules ( 'latlong', 'Lattitude-Longtitude', 'required|trim|max_length[255]|xss_clean|callback_validate_latlong' );
		$this->form_validation->set_rules ( 'phone_number', 'Phone Number', 'required|trim|max_length[200]|numeric|xss_clean' );
		$this->form_validation->set_rules ( 'email', 'Email', 'trim|max_length[200]|valid_email|xss_clean' );
		$this->form_validation->set_rules ( 'website', 'Website', 'trim|max_length[200]|xss_clean' );
		
		// set rules for other information fields
		$this->form_validation->set_rules ( 'capacity', 'Capacity', 'required|trim|is_natural|xss_clean' );
		$this->form_validation->set_rules ( 'opening_hour', 'Opening Hour', 'required|trim|max_length[2]|is_natural|less_than[24]|xss_clean' );
		$this->form_validation->set_rules ( 'closing_hour', 'Closing Hour', 'required|trim|max_length[2]|is_natural|less_than[24]|xss_clean' );
		$this->form_validation->set_rules ( 'lowest_price', 'Lowest Price', 'trim|max_length[10]|xss_clean' );
		$this->form_validation->set_rules ( 'highest_price', 'Highest Price', 'trim|max_length[10]|xss_clean' );
		
		// set rules for fields related to category
		$this->form_validation->set_rules ( 'countries', 'Country', 'required|xss_clean|callback_validate_country' );
		$this->form_validation->set_rules ( 'categories', 'Type', 'required|xss_clean|callback_validate_category' );
		$this->form_validation->set_rules ( 'languages', 'Language', 'xss_clean|callback_validate_language' );

		if ($this->form_validation->run () == TRUE && $this->session->userdata('username')) {
			$this->load->model ( 'user/basic_user_model' );
			$this->load->model ( 'restaurant_model' );
			$this->load->model ( 'country_restaurant_model' );
			$this->load->model ( 'category_restaurant_model' );
			$this->load->model ( 'language_restaurant_model' );
			
			// get user ID
			$userID = (int)$this->basic_user_model->get_user_info($this->session->userdata('username'))['id'];
			// create new restaurant
			$restaurant_id = $this->restaurant_model->create_restaurant ($userID);
			// create link between restaurant and its corresponding country tags
			foreach(explode(',', $this->input->post('countries')) as $abbrev) {
				$this->country_restaurant_model->create_country_restaurant_link($restaurant_id, $abbrev);
			}

			// create link between restaurant and its corresponding category tags
			foreach(explode(',', $this->input->post('categories')) as $abbrev) {
				$this->category_restaurant_model->create_category_restaurant_link($restaurant_id, $abbrev);
			}

			// create link between restaurant and its spoken languages
			foreach(explode(',', $this->input->post('languages')) as $abbrev) {
				$this->language_restaurant_model->create_language_restaurant_link($restaurant_id, $abbrev);
			}

			//redirect ( 'welcome' );
			//$this->show_user_restaurant();
			redirect( '/restaurant/show_restaurant/' .  $restaurant_id);
		}
		$this->show_add_location ();
	}

	// validate list of country abbrevations selected
	public function validate_country($countries) {
		foreach(explode(',', $countries) as $abbrev) {
			$this->load->model('restaurant/country_restaurant_model');
			$query = $this->country_restaurant_model->validateCountryAbbrev($abbrev);
			if(! $query) {
				$this->form_validation->set_message ( 'validate_country', 'Error with selected country(s)' );
				return FALSE;
			}
		}
	}

	// validate list of category abbrevations selected
	public function validate_category($categories) {
		foreach(explode(',', $categories) as $abbrev) {
			$this->load->model('restaurant/category_restaurant_model');
			$query = $this->category_restaurant_model->validateCategoryAbbrev($abbrev);
			if(! $query) {
				$this->form_validation->set_message ( 'validate_category', 'Error with selected type(s)' );
				return FALSE;
			}
		}
	}

	// validate list of language abbrevations selected
	public function validate_language($languages) {
		if( strlen($languages) == 0) return TRUE;	// this field is not required so if it can be empty
		foreach(explode(',', $languages) as $abbrev) {
			$this->load->model('restaurant/language_restaurant_model');
			$query = $this->language_restaurant_model->validateLanguageAbbrev($abbrev);
			if(! $query) {
				$this->form_validation->set_message ( 'validate_language', 'Error with selected language(s)' );
				return FALSE;
			}
		}
	}

	public function validate_latlong($latlong) {
		$pieces = explode(',', $latlong);
		if(count($pieces) != 2) {
			$this->form_validation->set_message ( 'validate_latlong', 'Lattitude-Longtitude not valid' );
			return FALSE;
		}
		for($i=0; $i < count($pieces); $i++) {
			if(!is_numeric($pieces[$i])) {
				$this->form_validation->set_message ( 'validate_latlong', 'Lattitude-Longtitude not valid' );
				return FALSE;
			}
		}
		return TRUE;
	}

	
}