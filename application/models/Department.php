<?
class Department extends CI_Model{
	public $department_id;
	public $department_name;
	
	function __construct(){
		parent::__construct();
	}
	
	function get_department_list(){
		$sql = $this->db->get('Department');
		$row = $sql->result_array();
		return $row;
	}
	
	function get_department(){
		$this->db->select("Department.*, (select count(user_id) from User where user_department_id = department_id) as count_personel");
		$this->db->where('department_id', $this->department_id);
		$sql = $this->db->get('Department');
		$row = $sql->result_array();
		return $row[0];
		
	}
	
	function insert(){
		$this->db->insert('Department', $this);
		return $this->db->insert_id();
	}
}
?>