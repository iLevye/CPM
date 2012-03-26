<?php
class Customerservice extends CI_Model{
	
	public $customerService_id;
	public $customerService_customer_id;
	public $customerService_service_id;
	public $customerService_domain;
	public $customerService_cost;
	public $customerService_taxesPercent;
	public $customerService_totalAmount;
	public $customerService_paid;
	public $customerService_start;
	public $customerService_finish;
	public $customerService_note;
	public $customerService_adminName;
	public $customerService_adminMail;
	public $customerService_adminPass;
	public $customerService_group;
	
	function get_services_by_service($select){
		$this->db->where('customerService_customer_id', $this->customerService_customer_id);
		$this->db->where('customerService_service_id', $this->customerService_service_id);
		$this->db->select($select);
		$sql = $this->db->get('Customerservice');
		return $sql->result_array();
	}
	
	function get_hostings(){
		$this->db->select("host_id, host_domain");
		$this->db->where('customerService_service_id', "2");
		$this->db->where("customerService_customer_id", $this->customerService_customer_id);
		$this->db->join('Host', 'customerService_hosting = host_id', "left");
		$sql = $this->db->get('Customerservice');
		$row = $sql->result_array();
		return $row;
	}
	
	function add_service(){
		$this->db->insert('Customerservice', $this);
		return $this->db->insert_id();
	}

	function get_debt(){
		$this->db->select("sum(kalan) as kalan");
		$this->db->where("customerService_customer_id", $this->Customer->customer_id);
		$sql = $this->db->get("vw_getcustomerservices");
		//echo $this->db->last_query();
		$row = $sql->result_array();
		return $row[0]['kalan'];
	}

	function get_note(){
		$this->db->select("customerService_note");
		$this->db->where("customerService_id", $this->customerService_id);
		$sql = $this->db->get("Customerservice");
		$row = $sql->result_array();
		return $row[0];
	}
	
}