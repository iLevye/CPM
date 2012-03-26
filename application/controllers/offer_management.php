<?
class Offer_management extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->model('Offer');

		$this->load->view('offers');
	}

	function get_offers(){
		$this->load->library("datatables");
		$this->load->helper("date");
		$this->datatables->select("offer_id, offer_customer_title, offer_customer_agent_name, offer_customer_agent_phone, offer_date, user_name");
		$this->datatables->from("Offer");
		$this->datatables->join("User", "offer_personel_id = user_id", "left");
		$nesne = json_decode($this->datatables->generate());
		if(count($nesne->aaData) < 1){
			echo json_encode($nesne);
			return false;
		}
		foreach($nesne->aaData as $n){
			$n[4] = datepicker_en($n[4]);
			$dizi[] = $n;
		}
		$nesne->aaData = $dizi;
		echo json_encode($nesne);

	}
}

?>