<?
class Contract extends CI_Model{
	public $contract_id;
	public $contract_customer_id;
	public $contract_date;
	public $contract_createdDate;
	public $contract_createdUser;
	public $contract_user_id;
	public $contract_name;

	public function get_list(){
		$this->db->select("contract_id, contract_name");
		$this->db->where("contract_customer_id", $this->contract_customer_id);
		$sql = $this->db->get("Contract");
		return $sql->result_array();
	}

	public function create(){
		$this->contract_createdDate = date("Y-m-d");
		$this->contract_createdUser = $this->session->userdata('user_id');
		$this->db->insert("Contract", $this);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}

}
?>