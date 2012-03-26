<?php
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(@$this->session->userdata('user_id') == ""){
			header("Location: " . base_url());
			return false;
		}
	}
	
	function index(){
		$this->load->view('home');
	}

    public function tasks(){
        $this->load->model('Task');
        $this->Task->task_user_id = $this->session->userdata('user_id');
        echo json_encode($this->Task->get_tasks());
    }

    public function start_task(){
    	$this->load->model('Task');
    	$this->Task->task_id = $this->input->post('task_id');
    	$this->Task->task_user_id = $this->session->userdata('user_id');
    	echo $this->Task->start_task();
    }
    
    public function pause_task(){
    	$this->load->model('Task');
    	$this->Task->task_id = $this->input->post('task_id');
    	$this->Task->task_user_id = $this->session->userdata('user_id');
    	echo $this->Task->pause_task();
    }

    public function finish_task(){
        $this->load->model("Task");
        $this->Task->task_id = $this->input->post('task_id');
        $this->Task->task_user_id = $this->session->userdata('user_id');
        echo $this->Task->finish_task();
    }

}

?>