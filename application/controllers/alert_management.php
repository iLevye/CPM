<?
class Alert_management extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(@$this->session->userdata('user_id') == ""){
			header("Location: " . base_url());
			return false;
		}
	}

	function new_alert(){
		$this->load->model('Alert');
		$this->load->helper('date');
		if(strtotime(datepicker($this->input->post('alert_datetime'))) < time()){
			echo "-1";
			return false;
		}
		$this->Alert->alert_tag = "Özel";
		$this->Alert->alert_user_id = $this->session->userdata('user_id');
		$this->Alert->alert_text = $this->input->post('alert_text');
		$this->Alert->alert_datetime = datepicker($this->input->post('alert_datetime'));
		echo $this->Alert->new_alert();
	}

	function my_alerts(){
		$this->load->model('Alert');
		$this->Alert->alert_user_id = $this->session->userdata('user_id');
		echo json_encode($this->Alert->get_alerts());
	}

	function delete(){
		$this->load->model('Alert');
		$this->Alert->alert_id = $this->input->post('alert_id');
		$this->Alert->alert_user_id = $this->session->userdata('user_id');
		echo $this->Alert->delete();
	}

	function snooze(){
		$this->load->model('Alert');
		$this->load->helper("date");
		$this->Alert->alert_id = $this->input->post('alert_id');
		$this->Alert->alert_user_id = $this->session->userdata('user_id');
		$this->Alert->alert_datetime = datepicker($this->input->post('snooze_date'));
		echo $this->Alert->snooze();
	}
}
?>