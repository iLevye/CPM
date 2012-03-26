<?
class Notetag extends CI_Model{
	public $noteTag_id;
	public $noteTag_name;

	function add_tag(){
		$this->db->insert("Notetag", $this);
		return $this->db->insert_id();
	}

	function get_list(){
		$sql = $this->db->get("Notetag");
		$row = $sql->result_array();
		return $row;
	}

}
?>