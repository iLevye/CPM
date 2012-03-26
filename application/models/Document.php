<?
class Document extends CI_Model{
	public $document_id;
	public $document_name;
	public $document_file;
	public $document_date;

	function add_document(){
		$this->document_date = date("Y-m-d");
		$this->db->insert("Document", $this);
		return $this->db->insert_id();
	}

	function delete_document(){
		$this->db->where("document_id", $this->document_id);
		$this->db->delete("Document");
	}
}
?>