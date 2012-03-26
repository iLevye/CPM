<?
class getjson extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function customers(){
		$this->load->model('Customer');
		$dizi = $this->Customer->get_list();
		echo json_encode($dizi);
	}
}
?>