<?
class Customernote extends CI_Model{
	public $customerNote_id;
	public $customerNote_user_id;
	public $customerNote_customer_id;
	public $customerNote_date;
	public $customerNote_note;
	public $customerNote_important;
	public $customerNote_agent_id;
	public $customerNote_tags;

	function get_notes($filtre){
		if(!empty($this->customerNote_customer_id)){
			$this->db->where('customerNote_customer_id', $this->customerNote_customer_id);
		}

		if($filtre != false){
			$filtre = explode("-", $filtre);
			$str = "( ";
			$or = "";
			foreach($filtre as $fil){
				$str .= $or . "customerNote_tags like '%$fil%'";
				$or = " OR ";
			}
			$str .= " )";
			$this->db->where($str);
		}

		$this->db->select("customerNote_date, customerNote_tags, customerNote_id, customerNote_important, User.user_name", false);
		$this->db->join("User", "customerNote_user_id = user_id", "left");
		$sql = $this->db->get("Customernote");
		//echo $this->db->last_query();
		$row = $sql->result_array();
		$this->load->helper("date");
		$this->load->model('Notetag');

		$etiketler = $this->Notetag->get_list();
		foreach($etiketler as $etiket){
			$n[$etiket['noteTag_id']] = $etiket['noteTag_name'];
		}

		foreach($row as $r){
			$r['customerNote_date'] = datepicker_en($r['customerNote_date']);
			$tags = explode(",", $r['customerNote_tags']);
			$r['tags'] = "";

			foreach($tags as $tag){
				$r['tags'] .= "<span class='etiket'>" . $n[$tag] . "</span> ";
			}
			$r['tags'] = substr($r['tags'], 0, -1);
		 	$dizi[] = $r;
		}
		return $dizi;
	}

	function get_note(){
		if(intval($this->customerNote_id) == ""){
			return false;
		}
		$this->db->select("customerNote_note, customerNote_date");
		$this->db->where("customerNote_id", $this->customerNote_id);
		$sql = $this->db->get("Customernote");
		$row = $sql->result_array();
		return $row[0];
	}

	function add_note(){
		$this->db->insert("Customernote", $this);
		return $this->db->insert_id();
	}
}
?>