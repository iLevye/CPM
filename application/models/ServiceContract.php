<?
class ServiceContract extends CI_Model{
	public $serviceContract_id;
	public $serviceContract_service_id;
	public $serviceContract_contract_id;
	public $serviceContract_start;
	public $serviceContract_finish;
	public $serviceContract_cost;
	public $serviceContract_taxesPercent;
	public $serviceContract_totalAmount;
	public $serviceContract_note;

	public function add_new(){
		$this->db->insert("ServiceContract", $this);
		return $this->db->insert_id();
	}
	
}
?>