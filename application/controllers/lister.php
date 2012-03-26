<?
class Lister extends CI_Controller{

	function __construct(){
		parent::__construct();
	}


	function customer_services_data($day){
		$this->load->helper("date");
		$this->load->library("datatables");
		$this->datatables->select("customer_id, customer_mno, customer_title, aciklama, service_name, customerService_start, customerService_finish, host_server, host_status, customerService_id");
		$this->datatables->from("vw_getCustomerServices");
		$this->datatables->join("Customer", "customerService_customer_id = customer_id", "left");
		$this->datatables->where("customerService_finish >= ", "DATE(NOW())", false);
		$this->datatables->where("customerService_finish <= ", "DATE(DATE_ADD(NOW(), INTERVAL $day DAY))", false);
		
		$this->datatables->order_by("customerService_customer_id");
		$this->datatables->order_by("customerService_finish");
		$this->datatables->unset_column("customer_id");
		$this->datatables->edit_column("customer_mno", "<span row_id='$1'>$2</span>", "customer_id, customer_mno");
		$list = json_decode($this->datatables->generate());

		$musteri = "";
		$dizi = array();
		for($i = 0; $i < count($list->aaData); $i++){
			if($musteri != $list->aaData[$i][1]){
				$musteri = $list->aaData[$i][1];
				$mno = $list->aaData[$i][0];
				$baslik[1] = "<span class='hizmet_baslik'>$musteri</span>";
				$baslik[0] = $mno;
				$baslik[2] = "";
				$baslik[3] = "";
				$baslik[4] = "";
				$baslik[5] = "";
				$baslik[6] = "";
				$baslik[7] = "";


				$dizi[] = $baslik;
			}
			$host_status[0] = "<span style='color:red'>Pasif</span>";
			$host_status[1] = "<span style='color:green'>Aktif</span>";
			$list->aaData[$i][7] = @$host_status[$list->aaData[$i][7]];
			$list->aaData[$i][4] = datepicker_en($list->aaData[$i][4]);
			$list->aaData[$i][5] = datepicker_en($list->aaData[$i][5]);
			$list->aaData[$i][1] = " ";
			$list->aaData[$i][0] = "<span service_id='" . $list->aaData[$i][8] . "'></span>";
			unset($list->aaData[$i][8]);
			$dizi[] = $list->aaData[$i];
		}
		$list->aaData = $dizi;
		//print_r($list);
		echo json_encode($list);

/*

		$hizmet = "";
			if(count(@$dizi) > 0){
				foreach(@$dizi as $out){
					if($hizmet != $out[0]){
						$hizmet = $out[0];
						$baslik[0] = "<span class='hizmet_baslik'>$hizmet</span>";
							for($i = 1; $i < count($aColumns); $i++){
								$baslik[$i] = "";
							}
						$aaData[] = $baslik;
					}
					
					$baslik[0] = $out[1];
					
						for($i = 1; $i < count($aColumns); $i++){
							$baslik[$i] = $out[$i];
						}
						
						$baslik = array_splice($baslik, 1, 8);
						
				
					$aaData[] = $baslik;
				}
			}else{
				$aaData = "";
			}
			*/
	}
	
	function test($day){
		$this->db->select("customer_mno, customer_title, service_name, aciklama, customerService_start, customerService_finish");
		$this->db->from("vw_getCustomerServices");
		$this->db->join("Customer", "customerService_customer_id = customer_id", "left");
		$this->db->where("customerService_finish > ", "DATE(NOW())", false);
		$this->db->where("customerService_finish < ", "DATE(DATE_ADD(NOW(), INTERVAL $day DAY))", false);
		$sql = $this->db->get();
		echo $this->db->last_query();
		print_r($sql->result_array());
	}

	function customer_service(){
		$this->load->view("customer_service_list");
	}

	function get_service_note($service_id){
		$this->load->model('Customerservice');
		$this->Customerservice->customerService_id = $service_id;
		echo json_encode($this->Customerservice->get_note());
	}

}
?>