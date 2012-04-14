<?
class Payment extends CI_Model{
	public $payment_id;
	public $payment_contract_id;
	public $payment_timestamp;
	public $payment_datetime;
	public $payment_user_id;
	public $payment_amount;
	public $payment_channel;
	public $payment_expiry;

	function add_payment(){
		$this->payment_timestamp = time();
		$this->db->insert("Payment", $this);
		return $this->db->insert_id();
	}
}
?>