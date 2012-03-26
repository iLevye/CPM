<?php
class Domain extends CI_Model{
	public $domain_id;
	public $domain_name;
	public $domain_access;
	
	function __construct(){
		parent::__construct();
	}
	
	function get_domains($term, $autocompleter = true){
		if($term != ""){
			$this->db->like("domain_name", "$term");
			$this->db->limit(10);
		}

		$this->db->select("domain_name");
		$sql = $this->db->get('Domain');
		
		if($autocompleter){
			foreach($sql->result_array() as $row){
				$rowd['id'] = $row['domain_name'];
				$rowd['label'] = $row['domain_name'];
				$rowd['value'] = $row['domain_name'];
				$data[] = $rowd;
			}
			return $data;
		}else{
			return $sql->result_array();
		}
		
	}
	
	function add_outside_domain(){
		$this->db->where("domain_name", $this->Customerservice->customerService_domain);
		$count = $this->db->count_all_results("Domain");
		
		if($count > 0){
			return false;
		}else{
			$this->domain_name = $this->Customerservice->customerService_domain;
			$this->domain_access = "0";
			$this->db->insert("Domain", $this);
		}
	}
	
	function add_domain(){
		$this->db->insert("Domain", $this);
		return $this->db->insert_id();
	}
}