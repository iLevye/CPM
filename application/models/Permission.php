<?
class Permission extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get_permissions(){
		$sql = $this->db->get('Permission');
		return $sql->result_array();
	}
}


?>