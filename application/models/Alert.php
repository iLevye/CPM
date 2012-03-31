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
		$this->db->where("alert_datetime < NOW()");
		$this->db->where("alert_confirm", "0");
		$this->db->order_by("alert_id", "desc");
		$sql = $this->db->get('Alert');
		return $sql->result_array();
	}

	function delete(){
		$this->db->where("alert_user_id", $this->alert_user_id);
		$this->db->where("alert_id", $this->alert_id);
		$update['alert_confirm'] = "1";
		$this->db->update("Alert", $update);
		return $this->db->affected_rows();
	}

	function snooze(){
		$this->db->where("alert_id", $this->alert_id);
		$this->db->where('alert_user_id', $this->alert_user_id);
		$update['alert_datetime'] = $this->alert_datetime;
		$this->db->update("Alert", $update);
		return $this->db->affected_rows();
	}

}
?>