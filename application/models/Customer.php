<?
class Customer extends CI_Model{
	public $customer_id;
	public $customer_title;
	public $customer_phone;
	public $customer_www;
	public $customer_email;
	public $customer_sector;
	public $customer_address;
	public $customer_taxOffice;
	public $customer_taxNumber;
	public $customer_mno;
	public $customer_createDate;
	public $customer_fax;
	public $customer_user_id;
	
	public function get_customer($basic = true, $by = "customer_id"){
	
		if($basic){
			$this->db->select("customer_id, customer_title");
		}else{
			$this->db->select("Customer.*, sector_name, user_name");
			$this->db->join("Sector", "customer_sector = sector_id", "left");
			$this->db->join("User", "customer_user_id = user_id", "left");
		}
	
		if($by == "customer_id"){
			$this->db->where('customer_id', $this->customer_id);
		}else{
			$this->db->like('customer_title', $this->customer_title);
		}
	
		$sql = $this->db->get('Customer');
		$row = $sql->result();
	
		if(count(@$row[0]) == 0){
			return false;
		}

		foreach($row[0] as $rk => $rv ){
			$this->$rk = $rv;
		}
	}
	
	public function insert(){
		$this->customer_mno = $this->new_meno();
		$this->db->insert('Customer', $this);
		$this->customer_id = $this->db->insert_id();
		return;
	}
	
	public function update($by = "user"){
		$this->db->where('customer_id', $this->customer_id);
		
		if($by == "user"){
			foreach($this as $rk => $rv ){
				$data[$rk] = $rv;
			}
			$this->db->update('Customer', $data);
		}else{
			$this->db->update('Customer', $this);
		}
		
		return $this->db->affected_rows();
	}

	public function update_check_status(){
		$dizi['customer_checked'] = $this->customer_checked;
		$this->db->where("customer_id", $this->customer_id);
		$this->db->update("Customer", $dizi);
		return $this->db->affected_rows();
	}

	public function basic_search($key){
		$key = str_replace(" ", "%", $key);
		//$this->db->select("customer_id as id, (CASE WHEN LENGTH(customer_title) > 30 THEN CONCAT(SUBSTR(customer_title, 1, 30), '...') ELSE SUBSTR(customer_title, 1, 30) END)as value, SUBSTR(customer_phone, 1, 20) as customer_phone", false);
		
		$this->db->select("customer_id as id, customer_title as value, customer_phone");
		
		//$this->db->like('customer_title', $key);
		//$this->db->or_like("customer_phone", $key);
		//$this->db->or_like("customer_www", $key);
		//$this->db->or_like("customer_address", $key);
		//$this->db->or_like("customer_mno", $key);
		//$this->db->or_like("customer_email", $key);		
		$this->db->where("customer_title like '%$key%' or customer_email like '%$key%' or customer_mno like '%$key%' or customer_address like '%$key%' or customer_www like '%$key%' or customer_phone like '%$key%'");
		$this->db->limit("10");
		$sql = $this->db->get("Customer");
		
		//$this->db->query("Select customer_id as id, customer_title as value from Customer where ")
		//echo $this->db->last_query();
		return $sql->result_array();
	}

	public function check_same_customer(){
		$this->db->select("customer_id, customer_title");
		$this->db->where("customer_title like '%" . str_replace(" ", "%", trim($this->customer_title)) . "%'");

		if($this->customer_www != ""){
			$this->db->or_where("customer_www like '%" . str_replace("", "www.", $this->customer_www) . "%'");
		}

		if($this->customer_phone != ""){
			$this->db->or_where("customer_phone like '%" . $this->customer_phone . "%'");
		}

		if($this->Agent->agent_name != ""){
			$this->db->or_where("agent_name like '%" . $this->Agent->agent_name . "%'");
		}

		if($this->Agent->agent_email != ""){
			$this->db->or_where("agent_email", $this->Agent->agent_email);
		}

		if($this->Agent->agent_phone != ""){
			$this->db->or_where("agent_phone like '" . str_replace(" ", "%", trim($this->Agent->agent_phone)) . "%'");
			$this->db->or_where("agent_gsm like '" . str_replace(" ", "%", trim($this->Agent->agent_phone)) . "%'");
		}

		if($this->customer_fax != ""){
			$this->db->or_where("customer_fax like '%" . $this->customer_fax . "%'");
		}

		if($this->customer_taxNumber != ""){
			$this->db->or_where("customer_taxNumber", $this->customer_taxNumber);
		}


		$this->db->from("Customer");
		$this->db->join("Agent", "agent_customer_id = customer_id", "left");
		$this->db->limit("5");
		$sql = $this->db->get();
		//echo $this->db->last_query();
		$row = $sql->result_array();
		return $row;
	}

	private function new_meno(){
		$sql = $this->db->query("SELECT customer_mno FROM Customer where customer_mno like CONCAT(DATE_FORMAT(NOW(), '%Y%m'), '%') order by customer_mno desc limit 1");
		$row = $sql->result_array();
		return $row[0]['customer_mno'] + 1;
	}

	public function get_list(){
		$this->db->select("customer_id, customer_title");
		$this->db->order_by("customer_title");
		$sql = $this->db->get("Customer");
		return $sql->result_array();
	}
	

	
	
}
?>