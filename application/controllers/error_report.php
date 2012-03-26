<?php
class Error_report extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('ErrorLog');
	}
	
	function index(){
		echo "";
	}
	
	function send($message){
		$this->ErrorLog->log($message);
		echo "Sorun bize ulaştı. En kısa zamanda çözeceğiz.";
	}
}