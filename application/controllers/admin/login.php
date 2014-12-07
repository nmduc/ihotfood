<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function show_login() {
		$this->load->view('admin/index');
	}
	public function show_register() {
		$this->load->view('admin/register');
	}
	
	public function do_login() {
		$this->form_validation->set_rules('username', 'User Name', 'required|trim|max_length[50]|xss_clean|callback_validateUsername');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[200]|xss_clean|callback_validatePwd');
		
		if ($this->form_validation->run()==TRUE) {
			$data = array(
					'username'=> $this->input->post('username'),
					'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect('admin/manage');
		} 
		$this->show_login();
	}
	
	public function validateUsername(){
		$this->load->model('admin/login_model');
		$username = $this->input->post('username');
		$q = $this->login_model->validateUsername($username);
		if(! $q) {
			$this->form_validation->set_message('validateUsername',
					'Invalid username!');
			return FALSE;
		}
	}
	
	public function validatePwd() {
		$this->load->model('admin/login_model');
		$pwd = $this->input->post('password');
		$q = $this->login_model->validatePwd($pwd);
		
		if (! $q) {
			$this->form_validation->set_message('validatePwd', 
					'The password you entered is incorrect. Lost your password?');
			return FALSE;
		}
	}
	
	public function create_member() {
		$this->form_validation->set_rules('username', 'User Name', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		if($this->form_validation->run()==FALSE) {
			$this->show_register();
		} else {
			$this->load->model('admin/login_model');
			if($query = $this->login_model->create_member()) {
				$data['main_content'] = 'signup_successful';
				$this->load->view('admin/index', $data);
			} else{
				$this->load->view('signup_form');
			}
		}
	}
}