<?
class Contract_management extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view("contracts.php");
	}

	function get_contracts($customer_id){
		$this->load->model('Contract');
		$this->Contract->contract_customer_id = $customer_id;
		echo json_encode($this->Contract->get_list());
	}

	function get_services($customer_id){
		$this->load->model('Customerservice');
		$this->Customerservice->customerService_customer_id = $customer_id;
		echo json_encode($this->Customerservice->get_list());
	}

	function new_contract(){
		$this->load->model('Contract');
		$this->load->helper('date');
		$this->Contract->contract_customer_id = $this->input->post('customer_id');
		$this->Contract->contract_user_id = $this->input->post('user_id');
		$this->Contract->contract_name = $this->input->post('name');
		$this->Contract->contract_date = datepicker($this->input->post('date'));
		$contract_id = $this->Contract->create();

		$hizmetler = $this->input->post('services');
		foreach($hizmetler as $hizmet){
			$this->load->model('ServiceContract');
			$this->ServiceContract->serviceContract_service_id = $hizmet['hizmet_id'];
			$this->ServiceContract->serviceContract_contract_id = $contract_id;
			$this->ServiceContract->serviceContract_start = datepicker($hizmet['start_date']);
			$this->ServiceContract->serviceContract_finish = datepicker($hizmet['finish_date']);
			$this->ServiceContract->serviceContract_cost = $hizmet['ucret'];
			$this->ServiceContract->serviceContract_taxesPercent = $hizmet['kdv'];
			$this->ServiceContract->serviceContract_totalAmount = $hizmet['toplam_tutar'];
			$this->ServiceContract->add_new();
		}

		echo $contract_id;
	}

	function get_contract_list($customer_id){
		$this->load->library("datatables");
		$this->datatables->select("
			contract_id, contract_name, customer_title, contract_date, user_name, 
			(select count(*) from ServiceContract where serviceContract_contract_id = contract_id) as hizmet_sayisi, 
			COALESCE((select sum(payment_amount) as total from Payment where payment_contract_id = contract_id), 0) as alinan,
			((select sum(serviceContract_totalAmount) as totalamount from ServiceContract where serviceContract_contract_id = contract_id) - COALESCE( (select sum(payment_amount) as total from Payment where payment_contract_id = contract_id), '0' ) ) as kalan
		", false);
		$this->datatables->from("Contract");
		$this->datatables->join("User", "user_id = contract_user_id", "left");
		$this->datatables->join("Customer", "customer_id = contract_customer_id", "left");
		$this->datatables->where("contract_customer_id", $customer_id);
		$this->datatables->edit_column("contract_name", "<span row_id='$1'>$2</span>", "contract_id,contract_name");
		$this->datatables->unset_column("contract_id");
		echo $this->datatables->generate();
	}

}
?>