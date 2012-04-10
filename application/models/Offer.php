<?
class Offer extends CI_Model{
	public $offer_id;
	public $offer_date;
	public $offer_customer_id;
	public $offer_customer_title;
	public $offer_customer_phone;
	public $offer_customer_agent_name;
	public $offer_customer_agent_phone;
	public $offer_customer_sector;
	public $offer_personel_id;
	public $offer_total_cost;
	public $offer_note;

	function new_offer(){
		$this->db->insert("Offer", $this);
		return $this->db->insert_id();
	}

	function get_detail(){
		$this->db->select("Offer.*, user_name, customer_title, customer_phone");
		$this->db->where("offer_id", $this->offer_id);
		$this->db->join("User", "offer_personel_id = user_id", "left");
		$this->db->join("Customer", "offer_customer_id = customer_id", "left");
		$sql = $this->db->get("Offer");
		//echo $this->db->last_query();
		$row = $sql->result_array();
		return $row[0];
	}

}
?>