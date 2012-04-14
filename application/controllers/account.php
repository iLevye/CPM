<?php 
class Account extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	/*
	bu fonksiyon kullanılmıyor. user eklemek için personel_management / new_personel

	function create(){
		$this->User->user_name = $this->input->post('name', true);
		$this->User->user_title = $this->input->post('title', true);
		$this->User->user_email = $this->input->post('email', true);
		$this->User->user_password = $this->input->post('pass', true);
		
		
		//have a session ?
		if($this->session->userdata('id') > 0){
			$this->ErrorLog->log("account/create: session already exist.");
			return false;
		}
		
		//email available ?
		if(!$this->email_available()){
			$this->ErrorLog->log("account/create: email already exist.");
			return false;
		}
		
		//all fields filled ?
		if(empty($this->User->name) || empty($this->User->city) || empty($this->User->birthday) || empty($this->User->password) || empty($this->User->email)){
			$this->ErrorLog->log("account/create: null field(s)");
			return false;
		}
		
		
		if($this->User->create()){
			$styles = $this->input->post('styles', true);
			$this->load->model('UserStyle');
			if($this->UserStyle->add_new_user($styles)){			
				$this->create_session();
			}
		}
		
	}

	*/
	
	public function login(){
		if(!$this->input->is_ajax_request()){
			$this->ErrorLog->log("account/login: is not ajax request");
			return false;
		}
		
		$this->User->user_email = $this->input->post('eposta', true);
		$this->User->user_password = md5($this->input->post('sifre', true));
		
		//login fields filled ?
		if(empty($this->User->user_email) || empty($this->User->user_password)){
			$this->ErrorLog->log("account/login: null field(s)");
			return false;
		}
		
		if($this->User->login()){
			$this->create_session();
			echo "1";
		}else{
			echo "0";
		}
	}
	
	private function create_session(){
		$this->User->get_user(true, 'user_id');
		$this->session->set_userdata($this->User);
	}
	
	public function email_available(){
		if($this->input->post('email', true)){
			$this->User->user_email = $this->input->post('email', true);
		}
		
		$this->User->get_user(true, 'email');
		if($this->User->user_id > 0){
			$return = 1;
		}else{
			$return = 0;
		}
		
		if($this->input->is_ajax_request()){
			echo $return;
		}else{
			return $return;
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
}

?>