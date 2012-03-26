<?
class Contact extends CI_model{
	public $contact_id;
	public $contact_name;
	public $contact_phone;
	public $contact_gsm;
	public $contact_createUser;

	function add_contact(){
		$this->contact_createUser = $this->session->userdata("user_id");
		$this->db->insert("Contact", $this);
		return $this->db->insert_id();
	}
}
?>