<?php
class Agent extends CI_Model{
	public $agent_id;
	public $agent_customer_id;
	public $agent_name;
	public $agent_phone;
	public $agent_gsm;
	public $agent_email;
	
	function insert_agent(){
		if(empty($this->agent_customer_id)){
			$this->agent_customer_id = $this->Customer->customer_id;
		}
		$this->db->insert("Agent", $this);
		return $this->db->insert_id();
	}
	
	
	function get_agents(){
		if($this->agent_customer_id != ""){
			$this->db->where('agent_customer_id', $this->agent_customer_id);
		}
        $this->db->where("agent_status", "1");
		$sql = $this->db->get('Agent');
		$row = $sql->result_array();
		return $row;
	}

	/*
	* @param bool $fs firma sahibi
	*/
    function get_agent($fs = false){
    	if($this->agent_customer_id != ""){
			$this->db->where('agent_customer_id', $this->agent_customer_id);
		}

        if($this->agent_id != ""){
        	$this->db->where('agent_id', $this->agent_id);
        }

        if($fs){
        	$this->db->where("agent_title", "Firma Sahibi");
        }

        $sql = $this->db->get('Agent');
        $row = $sql->result_array();
        return @$row[0];
    }
        
    function edit(){
        foreach($this as $key => $val){
            if(!empty($val) && $key != "agent_id"){
                $update[$key] = $val;
            }                
        }
        
        $this->db->where('agent_id', $this->agent_id);
        $this->db->update('Agent', $update);
        return $this->db->affected_rows();
    }
        
    function remove(){
        $this->db->where('agent_id', $this->agent_id);
        $this->db->update("Agent", array("agent_status"=>"0"));
        echo $this->db->affected_rows();
    }
	
}