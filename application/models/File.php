<?
class File extends CI_Model{
	public $file_id;
	public $file_type;
	public $file_name;
	public $file_rel_id;

	function insert(){
		$this->db->insert("File", $this);
		return $this->db->insert_id();
	}

	function get_files(){
		$this->db->where("file_type", $this->file_type);
		$this->db->where("file_rel_id", $this->file_rel_id);
		$sql = $this->db->get("File");
		return $sql->result_array();
	}

}
?>