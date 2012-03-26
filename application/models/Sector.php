<?php
class Sector extends CI_Model{
	public $sector_id;
	public $sector_name;
	
	function get_sectors(){
		$sql = $this->db->get('Sector');
		$row = $sql->result_array();
		return $row;
	}
}