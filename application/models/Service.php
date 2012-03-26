<?php
class Service extends CI_Model{
	public $service_id;
	public $service_name;
	
	function get_services(){
		$sql = $this->db->get('Service');
		$row = $sql->result_array();
		return $row;
	}
}