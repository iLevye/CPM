<?
class Host extends CI_Model{
	public $host_id;
	public $host_domain;
	public $host_quota;
	public $host_mysqldbname;
	public $host_mysqlusername;
	public $host_mysqlpassword;
	public $host_ftpUser;
	public $host_ftpPass;
	
	function add_host(){
		$this->db->insert('Host', $this);
		return $this->db->insert_id();
	}
}
?>