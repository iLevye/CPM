<?php 
class ErrorLog extends CI_Model{
	public $errorlog_id;
	public $errorlog_message;
	public $errorlog_time;
	public $errorlog_ref;
	public $errorlog_url;
	public $errorlog_sessData;
	
	public function log($message, $whathappend = false){
		$debugging = true;
		$this->errorlog_message = $message;
		$this->errorlog_time = time();
		$this->errorlog_ref = @$_SERVER['HTTP_REFERER'];
		$this->errorlog_url = $this->uri->uri_string();
		$this->errorlog_sessData = json_encode($this->session->all_userdata());
		$this->db->insert('ErrorLog', $this);
		echo "Bir sorun olustu.";
		if($whathappend || $debugging){
			echo "<br> . $message";
		}
	}
}

?>