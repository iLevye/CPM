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
		$this->datatables->select("offer_id, offer_customer_title, offer_customer_agent_name, offer_customer_agent_phone, offer_date, user_name, customer_title");
		$this->datatables->from("Offer");
		$this->datatables->join("User", "offer_personel_id = user_id", "left");
		$this->datatables->join("Customer", "offer_customer_id = Customer.customer_id", "left");
		$nesne = json_decode($this->datatables->generate());
		if(count($nesne->aaData) < 1){
			echo json_encode($nesne);
			return false;
		}
		foreach($nesne->aaData as $n){
			$n[4] = datepicker_en($n[4]);
			if($n[1] == ""){
				$n[1] = $n[6];
			}
			$dizi[] = $n;
		}
		$nesne->aaData = $dizi;
		echo json_encode($nesne);

	}

	function new_offer(){
		$this->load->model('Offer');
		$this->Offer->offer_personel_id = $this->session->userdata('user_id');
		$post = $this->input->post(null,true);

		foreach($post as $k => $v){
			$this->Offer->{$k} = $v;
		}

		$this->load->helper("date");
		$this->Offer->offer_date = datepicker($this->Offer->offer_date);
		
		if($this->Offer->musteri_tip == "0"){
			unset($this->Offer->offer_customer_id);
		}else{
			unset($this->Offer->offer_customer_title);
			unset($this->Offer->offer_customer_phone);
		}
		unset($this->Offer->musteri_tip);

		$dosyalar = explode(",", $this->Offer->dosyalar);
		unset($this->Offer->dosyalar);
		
		$offer_id = $this->Offer->new_offer();

		$this->load->model('File');
		foreach($dosyalar as $dosya){
			$this->File->file_type = "offer";
			$this->File->file_rel_id = $offer_id;
			$this->File->file_name = $dosya;
			$this->File->insert();
		}

		echo $offer_id;
	}

	function get_offer($id){
		$this->load->model('Offer');
		$this->Offer->offer_id = $id;
		$data['offer'] = $this->Offer->get_detail();
		$this->load->helper("date");
		$data['offer']['offer_date'] = datepicker_en($data['offer']['offer_date']);


		$this->load->model('File');
		$this->File->file_type = "offer";
		$this->File->file_rel_id = $this->Offer->offer_id;
		$data['files'] = $this->File->get_files();
		echo json_encode($data);
	}
}

?>