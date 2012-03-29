<?
class Alert extends CI_Model{
	public $alert_id;
	public $alert_user_id;
	public $alert_text;
	public $alert_datetime;
	public $alert_confirm;

	function new_alert(){
		$this->alert_confirm = "0";
		$this->db->insert("Alert", $this);
		return $this->db->insert_id();
	}

	function get_alerts(){
		$this->db->where('alert_user_id', $this->alert_user_id);
		$this->db->where("alert_datetime > NOW()");
		$this->db->where("alert_confirm", "0");
		$sql = $this->db->get('Alert');
		foreach($sql->result_array() as $row){
			$row['tag'] = "Özel";
			$row['alert_ozet'] = substr($row['alert_text'], 0, 70);
			$cikti[] = $row;
		}
		return $cikti;
	}
}
?>