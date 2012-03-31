<?php
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(@$this->session->userdata('user_id') == ""){
			header("Location: " . base_url());
			return false;
		}
	}
	
	public function index(){
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

    public function following_task(){
        $this->load->model('Task');
        $this->Task->task_create_user_id = $this->session->userdata('user_id');
        $this->Task->task_feedback_user_id = $this->session->userdata('user_id');
        $this->Task->task_feedback = 2;
        echo json_encode($this->Task->get_tasks());
    }

    public function confirm_task(){
        $this->load->model('Task');
        $this->Task->task_id = $this->input->post('task_id');
        $this->Task->task_feedback_user_id = $this->session->userdata('user_id');
        echo $this->Task->confirm_task();
    }

    public function revised_task(){
        $this->load->model('Task');
        $this->Task->task_id = $this->input->post('task_id');
        $this->Task->task_feedback_user_id = $this->session->userdata('user_id');

        $note['text'] = $this->input->post('revised_note');
        $note['name'] = $this->session->userdata('user_name');
        $note['time'] = date('Y-m-d H-i-s');
        $this->Task->task_not = $note;
        $this->Task->add_note();
        
        echo $this->Task->revised_task($this->input->post('revised_note'));
    }

}

?>