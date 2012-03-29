<?
class Services extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view('ourservices');
	}

	function get_list(){
		$this->load->library('datatables');
		$this->datatables->select("service_name, action, username_field, username_val, pass_field, pass_val");
		$this->datatables->unset_column('action');
		$this->datatables->unset_column('username_field');
		$this->datatables->unset_column('username_val');
		$this->datatables->unset_column('pass_field');
		$this->datatables->unset_column('pass_val');
		$this->datatables->add_column('action_buton', "<span action='$1' username_field='$2' username_val='$3' pass_field='$4' pass_val='$5'>Login</span>", 'action, username_field, username_val, pass_field, pass_val');
		$this->datatables->from("OurService");
		echo $this->datatables->generate();
	}
}
?>