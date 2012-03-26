<?
class Dayoff extends CI_Model{
	public $dayoff_id;
	public $dayoff_start;
	public $dayoff_finish;
	public $dayoff_user;
	public $dayoff_createdUser;
	public $dayoff_active;

	function add(){
		$this->dayoff_active = 1;
		$this->dayoff_createdUser = $this->session->userdata("user_id");
		$this->db->insert("Dayoff", $this);
		return $this->db->insert_id();
	}

	function delete(){
		$data['dayoff_active'] = 0;
		$this->db->where("dayoff_id", $this->dayoff_id);
		$this->db->update("Dayoff", $data);
		return $this->db->affected_rows();
	}

}

?>