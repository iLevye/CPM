<?
class contacts extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view('contacts');
	}

	function get_list(){
		$this->load->library("datatables");
		$this->datatables->select("isim, telefon, gsm");
		$this->datatables->from("vw_getContacts");
		$this->datatables->order_by("isim");
		$nesne = json_decode($this->datatables->generate());
		foreach($nesne->aaData as $d){
			if(strtoupper(substr($d[0], 0, 1)) != strtoupper($a)){
				$a = strtoupper(substr($d[0], 0, 1));
				$title[0] = "<span class='title'>$a</span>";
				$title[1] = "";
				$title[2] = "";
				$aaData[] = $title;
			}
			$aaData[] = $d;
		}
		$nesne->aaData = $aaData;
		echo json_encode($nesne);
	}

	function new_contact(){
		$this->load->model('Contact');
		$this->Contact->contact_name = $this->input->post('isim');
		$this->Contact->contact_phone = $this->input->post('numara');
		$this->Contact->contact_gsm = $this->input->post('gsm');
		echo $this->Contact->add_contact();

	}
}

?>