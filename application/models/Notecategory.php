<?
class Notecategory extends CI_Model{
	public $noteCategory_id;
	public $noteCategory_name;


	function get_list(){
		$sql = $this->db->get("Notecategory");
		$row = $sql->result_array();
		return $row;
	}

	function add_record(){
		if($this->noteCategory_name == ""){
			return false;
			$this->ErrorLog->log("Not kategorisi boş ? model / notecategory / add_record");
		}

		$this->db->insert("Notecategory", $this);
		return $this->db->insert_id();
	}
}
?>