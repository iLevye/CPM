<?
class Price_list extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view('price_list');
	}

	function get_list(){
		$this->load->library('datatables');
		$this->datatables->select("price_serviceName, price_cost");
		$this->datatables->from("Price");
		echo $this->datatables->generate();
	}

}
?>