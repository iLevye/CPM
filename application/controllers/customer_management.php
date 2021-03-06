<?
class Customer_management extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(@$this->session->userdata('user_id') == ""){
			header("Location: " . base_url());
			return false;
		}
		$this->load->model('Customer');
	}
	
	public function index(){
		$this->load->view('customer');
	}
	
	public function get_list($filter_type = false, $arg1 = false, $arg2 = false, $arg3 = false){
            $this->load->library('datatables');
            $this->datatables->select("customer_id, customer_address, customer_www,customer_email, customer_mno, customer_title, (select agent_name from Agent where agent_customer_id = customer_id limit 1), customer_phone");
            $this->datatables->from("Customer");
            $this->datatables->unset_column("customer_id");
            $this->datatables->unset_column("customer_www");
            $this->datatables->unset_column("customer_email");
            $this->datatables->unset_column("customer_address");
            $this->datatables->edit_column("customer_mno", "<span hebe='$3 $4 $5' row_id='$1'>$2</span>", "customer_id, customer_mno, customer_www, customer_email, customer_address");
            
            if($filter_type == "status"){
            	$this->datatables->where("customer_status", $arg1);
            }elseif($filter_type == "note"){
            	$this->load->helper("date");
            	$arg1 = datepicker(urldecode($arg1));
            	$arg2 = explode(',', $arg2);
            	//print_r($arg2);
            	foreach($arg2 as $a){
            		$where .= " and customerNote_tags like '%$a%' ";
            	}
            	if($arg3 == "1"){
            		$in = "in";
            	}else{
            		$in = "not in";
            	}

            	$this->datatables->where("customer_id $in (select customerNote_customer_id from Customernote where customerNote_date > '$arg1' $where )");
            }
            echo $this->datatables->generate();
            //echo $this->datatables->last_query();
        }
	
	
	public function new_record(){
		$this->Customer->customer_title = $this->input->post('unvan');
		$this->Customer->customer_phone = $this->input->post('tel');
		$this->Customer->customer_www = $this->input->post('web');
		$this->Customer->customer_fax = $this->input->post('fax');
		$this->Customer->customer_sector = $this->input->post('sektor');
		$this->Customer->customer_taxOffice = $this->input->post('vergi_dairesi');
		$this->Customer->customer_taxNumber = $this->input->post('vergi_no');
		$this->Customer->customer_address = $this->input->post('adres');
		$this->Customer->customer_createDate = date("Y-m-d");

		$this->load->model('Agent');
		$this->Agent->agent_name = $this->input->post('yetkili_isim');
		$this->Agent->agent_email = $this->input->post('yetkili_eposta');
		$this->Agent->agent_phone = $this->input->post('yetkili_telefon');
		$this->Agent->agent_title = "Firma Sahibi";
		
		$this->Customer->insert();
		if(intval($this->Customer->customer_id)){
			$this->Agent->agent_customer_id = $this->Customer->customer_id;
			$this->Agent->insert_agent();
			echo $this->Customer->customer_id;
		}else{
			echo 0;
		}
	}
	
	public function info($id){
		$this->Customer->customer_id = $id;
		$customer = $this->Customer->get_customer(false);
		echo json_encode($customer);
	}
	
	public function detail($id){
		$this->load->model('Service');
		$this->load->model('Customer');	
		$this->load->helper('form');
		$this->load->model('Agent');
		$this->load->helper('date');
		
		$this->Customer->customer_id = $id;
		$this->Customer->get_customer(false);
		$data = $this->Customer;

		$this->Agent->agent_customer_id = $this->Customer->customer_id;
		$data->agent = $this->Agent->get_agent(true);

		if($this->Customer->customer_title == "" && $this->Customer->customer_phone == ""){
			header("Location: " . base_url() . "customer_management/" );
		}
		$this->load->model('Customerservice');
		//$data->borc = $this->Customerservice->get_debt();
		$this->load->view('customer_detail', $data);
	}

	public function check(){
		$this->load->model('Customer');
		$this->Customer->customer_id = $this->input->post('customer_id');
		$this->Customer->customer_checked = $this->input->post("checked");
		echo $this->Customer->update_check_status();
	}
	
	public function services($customer_id){
		$this->load->library('datatables');
		$this->datatables->select('service_name, 
			(select serviceContract_cost from ServiceContract where serviceContract_service_id = customerService_id order by serviceContract_id desc limit 1) as cost,
			(select format((serviceContract_cost * serviceContract_taxesPercent / 100), 2) from ServiceContract where serviceContract_service_id = customerService_id order by serviceContract_id desc limit 1) as taxes,
			(select format((serviceContract_cost * ((serviceContract_taxesPercent / 100) + 1)), 2) from ServiceContract where serviceContract_service_id = customerService_id order by serviceContract_id desc limit 1) as total,
			(select serviceContract_start from ServiceContract where serviceContract_service_id = customerService_id order by serviceContract_id desc limit 1) as start,
			(select serviceContract_finish from ServiceContract where serviceContract_service_id = customerService_id order by serviceContract_id desc limit 1) as finish,
			host_server,
			host_status, 
			(CASE customerService_service_id 
				WHEN 0 THEN customerService_domain
				WHEN 1 THEN (select domain_name from Domain where domain_id = customerService_domain_id)
				WHEN 2 THEN (select host_domain from Host where host_id = customerService_hosting)
				WHEN 3 THEN customerService_domain
				WHEN 4 THEN customerService_domain
				WHEN 7 THEN (select project_name from Project where project_id = customerService_project_id)
				WHEN 8 THEN (select project_name from Project where project_id = customerService_project_id)
				WHEN 9 THEN (select project_name from Project where project_id = customerService_project_id)
				WHEN 10 THEN customerService_domain
			END) as work', false);
		$this->datatables->from("Customerservice");
		$this->datatables->join("Service", "service_id = customerService_service_id", "left");
		$this->datatables->join("Host", "customerService_hosting = host_id", "left");
		$this->datatables->where("customerService_customer_id", $customer_id);

		//$this->datatables->group_by("customerService_service_id", "desc");
		$nesne = json_decode($this->datatables->generate());
		$this->load->helper("date");

		$hizmet = "";
		foreach($nesne->aaData as $n){
			if($n[0] != $hizmet){
				$hizmet = $n[0];
				$baslik[0] = "<span class='hizmet_baslik'>$hizmet</span>";
				$baslik[1] = $mno;
				$baslik[2] = "";
				$baslik[3] = "";
				$baslik[4] = "";
				$baslik[5] = "";
				$baslik[6] = "";
				$baslik[7] = "";
				$baslik[8] = "";
				$aaData[] = $baslik;
			}

			$n[4] = datepicker_en($n[4]);
			$n[5] = datepicker_en($n[5]);
			if($n[8] != ""){
				$n[0] = $n[8];
			}
			$aaData[] = $n;
		}
		$nesne->aaData = $aaData;
	
		echo json_encode($nesne);


	}

	/*
	public function services($customer_id){
		$this->load->helper("date");
			$aColumns = array('service_name', 'aciklama', 'customerService_cost', 'taxes', 'customerService_totalAmount', 'customerService_paid', 'kalan', 'customerService_start', 'customerService_finish', 'host_server', 'host_status');
			$sIndexColumn = "customerService_finish";
			$sTable = "vw_getCustomerServices";
		
			// Database connection information 
			$gaSql['user']       = "root";
			$gaSql['password']   = "root";
			$gaSql['db']         = "atacrm";
			$gaSql['server']     = "localhost";
		
		

			$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
			die( 'Could not open connection to server' );
		
			mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
			die( 'Could not select database '. $gaSql['db'] );
			mysql_query("SET NAMES 'utf8'");
            

			$sLimit = "";
			if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
			{
				$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
						mysql_real_escape_string( $_GET['iDisplayLength'] );
			}
		
		

			$sOrder = "";
			if ( isset( $_GET['iSortCol_0'] ) )
			{
				$sOrder = "ORDER BY  ";
				for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
				{
					if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
					{
						$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
					}
				}
		
				$sOrder = substr_replace( $sOrder, "", -2 );
				if ( $sOrder == "ORDER BY" )
				{
					$sOrder = "";
				}
			}
		
		

			$sWhere = "";
			if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
			{
				$sWhere = "WHERE (";
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
				}
				$sWhere = substr_replace( $sWhere, "", -3 );
				$sWhere .= ')';
			}
		

			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
				{
					if ( $sWhere == "" )
					{
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
				}
			}
		
		

			$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere";
			if($sWhere == ""){
				$sQuery .= " WHERE customerService_customer_id = '$customer_id'";
			}else{
				$sQuery .= " AND (customerService_customer_id = '$customer_id')";
			}
			$sQuery .= "$sOrder
			$sLimit
			";
			
			$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
			
			$sQuery = "
			SELECT FOUND_ROWS()
			";
			$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
			$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		
			$iFilteredTotal = $aResultFilterTotal[0];
		
			
			$sQuery = "
			SELECT COUNT(".$sIndexColumn.")
			FROM   $sTable
			";
			$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
			$aResultTotal = mysql_fetch_array($rResultTotal);
			$iTotal = $aResultTotal[0];
		
		

			$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
			);
		
			while ( $aRow = mysql_fetch_array( $rResult ) )
			{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ( $aColumns[$i] == "version" )
						{
					
							$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
						}
					else if ( $aColumns[$i] != ' ' )
						{
							
							substr(@$aRow[$aColumns[$i]], 0, 1);
							if($i < count($aColumns) - 2 && $i >= count($aColumns) - 4){
								//$row[] = $aRow[$aColumns[$i]];
								$row[] = @datepicker_en($aRow[$aColumns[$i]]);
							}elseif($i == count($aColumns) - 1){
								$durum[0] = "<span style='color:red'>Pasif</span>";
								$durum[1] = "<span style='color:green'>Aktif</span>";
								$row[] = @$durum[$aRow[$aColumns[$i]]];
							}else{
								$row[] = @$aRow[ $aColumns[$i] ];
							}
							
						}
				}
		
				$dizi[] = $row;
				//$output['aaData'][] = $row;
			}
			
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
						
						$baslik = array_splice($baslik, 1, 10);
						
				
					$aaData[] = $baslik;
				}
			}else{
				$aaData = "";
			}
			
			
			$output['aaData'] = $aaData;
		
		echo json_encode( $output );
		
	}

	*/
	
    public function payments($customer_id){
        $this->load->library("datatables");
        $this->load->helper('date');
        
        $this->datatables->select("contract_name, payment_datetime, payment_amount");
        $this->datatables->from("Payment");
        $this->datatables->join("Contract", "payment_contract_id = contract_id", "left");
        $this->datatables->where("contract_customer_id", $customer_id);

        echo $this->datatables->generate();
    }
	
	public function add_service(){
		$this->load->model('Customerservice');
		$this->load->model('Domain');
		$this->load->model('Project');
		$this->load->helper('date');


		$this->Customerservice->customerService_service_id = $this->input->post('hizmet');
		$this->Customerservice->customerService_customer_id = $this->input->post('customer_id');
		//$this->Customerservice->customerService_start = datepicker($this->input->post('date1'));
		//$this->Customerservice->customerService_cost = $this->input->post('tutar');
		//$this->Customerservice->customerService_taxesPercent = $this->input->post('kdv');
		//$this->Customerservice->customerService_totalAmount = $this->input->post('toplam_tutar');
		//$this->customerservice->customerService_note = $this->input->post('sozlesme_notu');
		//$this->Customerservice->customerService_contract_id = $this->input->post('contract_id');
		
		
// Diger hizmet
		if($this->Customerservice->customerService_service_id == 0){
			$this->Customerservice->customerService_domain = $this->input->post('domain');
			$this->Domain->add_outside_domain();
			
			if($this->input->post("proje") == "yeni_proje" && $this->input->post("proje_adi") != ""){
				$this->Project->project_name = $this->input->post('proje_adi');
				$this->Project->project_description = $this->input->post('proje_ozeti');
				$this->Project->project_customer_id = $this->input->post('customer_id');
				$this->Project->project_date1 = datepicker($this->input->post('date1'));
				$this->Project->project_date2 = datepicker($this->input->post('date2'));
				$this->Customerservice->customerService_project_id = $this->Project->add_project();
			}
			
			if(intval($this->input->post("proje"))){
				$this->Customerservice->customerService_project_id = $this->input->post('proje');
				//$this->Customerservice->customerService_finish = datepicker($this->input->post('date2'));
			}
		}

// Domain
		if($this->Customerservice->customerService_service_id == 1){
			$this->Domain->domain_name = $this->input->post('domain');
			$this->Domain->domain_access = "1";
			$this->Customerservice->customerService_domain_id = $this->Domain->add_domain();
			$this->Customerservice->customerService_hosting = $this->input->post('host');
			//$this->Customerservice->customerService_finish = datepicker($this->input->post('date2'));
		}

// Hosting
		if($this->Customerservice->customerService_service_id == 2){
			$this->load->model('Host');
			$this->Customerservice->customerService_domain = $this->input->post('domain');
			$this->Host->host_domain = $this->input->post('domain');
			$this->Host->host_quota = $this->input->post('kota');
			$this->Host->host_ftpUser = $this->input->post('ftp_username');
			$this->Host->host_ftpPass = $this->input->post('ftp_pass');
			
			if($this->input->post('mysql') == 1){
				$this->Host->host_mysqldbname = $this->input->post('mysql_dbname');
				$this->Host->host_mysqlusername = $this->input->post('mysql_username');
				$this->Host->host_mysqlpassword = $this->input->post('mysql_pass');
			}
			
			$this->Customerservice->customerService_hosting = $this->Host->add_host();
			//$this->Customerservice->customerService_finish = datepicker($this->input->post('date2'));
		}
		
// ATACFS ve Adwords
		if($this->Customerservice->customerService_service_id == 3 || $this->Customerservice->customerService_service_id == 4){
			$this->Customerservice->customerService_domain = $this->input->post('domain');
		}

// iphone, android, web sitesi, web eklenti
		if($this->Customerservice->customerService_service_id == 6 || $this->Customerservice->customerService_service_id == 7 || $this->Customerservice->customerService_service_id == 8 || $this->Customerservice->customerService_service_id == 9){

			if($this->input->post("proje") == "yeni_proje"){
				$this->Project->project_name = $this->input->post('proje_adi');
				$this->Project->project_description = $this->input->post('proje_ozeti');
				$this->Project->project_customer_id = $this->input->post('customer_id');
				$this->Project->project_date1 = datepicker($this->input->post('date1'));
				$this->Project->project_date2 = datepicker($this->input->post('date2'));
				$this->Project->project_status = "0";
				$this->Customerservice->customerService_project_id = $this->Project->add_project();
			}
			
			if(intval($this->input->post("proje"))){
				$this->Customerservice->customerService_project_id = $this->input->post('proje');
			}

		}
		
		
// e ticaret paketi
		if($this->Customerservice->customerService_service_id == 10){
			$this->Customerservice->customerService_domain = $this->input->post('domain');
			$this->Customerservice->customerService_adminName = $this->input->post('admin_isim');
			$this->Customerservice->customerService_adminMail = $this->input->post('admin_eposta');
			$this->Customerservice->customerService_adminPass = $this->input->post('admin_sifre');
			$this->Customerservice->customerService_group = $this->input->post('site_grubu');
			//$this->Customerservice->customerService_finish = datepicker($this->input->post('date2'));
		}
		
		echo $this->Customerservice->add_service();
		
	}
	
	public function get_projects($customer_id){
		$this->load->model('Project');
		$this->Project->project_customer_id = $customer_id;
		$projects = $this->Project->get_list();
		echo json_encode($projects);
	}
	
	public function get_hostings($customer_id){
		$this->load->model('Customerservice');
		$this->Customerservice->customerService_customer_id = $customer_id;

		$data = $this->Customerservice->get_hostings();
		echo json_encode($data);
	}
	
	public function get_domains(){
		$this->load->model('Domain');
		$data = $this->Domain->get_domains($this->input->get('term'));
		echo json_encode($data);
	}
	
	public function edit($id){
		$this->Customer->customer_id = $id;
		$this->Customer->customer_title = $this->input->post('customer_title');
		$this->Customer->customer_phone = $this->input->post('customer_phone');
		$this->Customer->customer_fax = $this->input->post('customer_fax');
		$this->Customer->customer_www = $this->input->post('customer_www');
		$this->Customer->customer_email = $this->input->post('customer_email');
		$this->Customer->customer_sector = $this->input->post('customer_sector');
		$this->Customer->customer_address = $this->input->post('customer_address');
		$this->Customer->customer_taxOffice = $this->input->post('customer_taxOffice');
		$this->Customer->customer_taxNumber = $this->input->post('customer_taxNumber');
		$this->Customer->customer_user_id = $this->input->post('customer_user_id');
		$this->Customer->customer_status = $this->input->post('customer_status');

		$this->load->model('Agent');
		$this->Agent->agent_id = $this->input->post('agent_id');
		$this->Agent->agent_name = $this->input->post('agent_name');
		$this->Agent->agent_email = $this->input->post('agent_email');
		$this->Agent->agent_title = "Firma Sahibi";

		if($this->input->post('agent_phone') != ""){
			$this->Agent->agent_phone = $this->input->post('agent_phone');
		}else{
			$this->Agent->agent_gsm = $this->input->post("agent_gsm");
		}

		if(!empty($this->Agent->agent_id) && !empty($this->Agent->agent_name)){
			$edit_agent = $this->Agent->edit();
		}

		if(empty($this->Agent->agent_id) && !empty($this->Agent->agent_name)){
			$insert_agent = $this->Agent->insert_agent();
		}

		$edit_customer = $this->Customer->update();
		if(@$edit_agent > 0 || @$insert_agent > 0 || @$edit_customer > 0){
			echo 1;
		}
	}
	
	public function projects($customer_id){
        $this->load->helper('date');
        $this->load->library("datatables");
        $this->load->library("definition");
        $this->datatables->select("project_id, project_name, project_status, bekleyen_gorevler, tamamlanan_gorevler, project_date1, project_date2");
        $this->datatables->from("vw_getprojects");
        $this->datatables->where('project_customer_id', $customer_id);
        $this->datatables->edit_column('project_name', "<span project_id='$2'>$1</span>", 'project_name, project_id');
        $this->datatables->unset_column('project_id');
        $nesne = json_decode($this->datatables->generate());
        for($i = 0; $i < count($nesne->aaData); $i++){
            $nesne->aaData[$i][1] = $this->definition->get_item('project_status', $nesne->aaData[$i][1]);
            $nesne->aaData[$i][4] = datepicker_en($nesne->aaData[$i][4]);
            $nesne->aaData[$i][5] = datepicker_en($nesne->aaData[$i][5]);
        }
        echo json_encode($nesne);
    }
        
    public function agents($customer_id){
        $this->load->library("datatables");
        $this->datatables->select("agent_id, agent_name, agent_phone, agent_gsm, agent_email, agent_title");
        $this->datatables->from("Agent");
        $this->datatables->where("agent_customer_id", $customer_id);
        $this->datatables->where("agent_status", "1");
        $this->datatables->edit_column("agent_name", "<span agent_id='$1'>$2</span>", "agent_id, agent_name");
        $this->datatables->unset_column('agent_id');
        echo $this->datatables->generate();
    }
    
    public function get_agent($agent_id){
        $this->load->model('Agent');
        $this->Agent->agent_id = $agent_id;
        echo json_encode($this->Agent->get_agent());
    }
    
    public function edit_agent(){
        $this->load->model('Agent');
        $data = $this->input->post(null, true);
        foreach($data as $key => $val){
            $this->Agent->{$key} = $val;
        }
        echo $this->Agent->edit();
    }
    
    public function remove_agent(){
        $this->load->model('Agent');
        $this->Agent->agent_id = $this->input->post('agent_id');
        echo $this->Agent->remove();
    }
    
    public function add_agent(){
        $this->load->model('Agent');
        $data = $this->input->post(null, true);
        foreach($data as $key => $val){
            $this->Agent->{$key} = $val;
        }
        echo $this->Agent->insert_agent();
    }

    public function get_notes($customer_id, $filtre = false){
    	$this->load->model('Customernote');
    	$this->Customernote->customerNote_customer_id = $customer_id;
		
    	$data = $this->Customernote->get_notes($filtre);
    	echo json_encode($data);
    }

    public function note_detail($note_id){
    	$this->load->model('Customernote');
    	$this->Customernote->customerNote_id = $note_id;
    	$data = $this->Customernote->get_note();
    	$this->load->helper('date');
    	$data['customerNote_date'] = datepicker_en($data['customerNote_date']);
    	echo json_encode($data);
    }

    public function get_note_tags(){
    	$this->load->model('Notetag');
    	echo json_encode($this->Notetag->get_list());
    }

    public function new_note(){
    	$this->load->model('Customernote');
    	$this->Customernote->customerNote_user_id = $this->session->userdata('user_id');
    	$this->Customernote->customerNote_customer_id = $this->input->post('customer_id');
    	$this->Customernote->customerNote_date = date("Y-m-d H:i:s");
    	$this->Customernote->customerNote_note = $this->input->post('not');
    	$this->Customernote->customerNote_important = $this->input->post('important');
    	if($this->Customernote->customerNote_important == ""){
    		$this->Customernote->customerNote_important = "0";
    	}
    	
    	$etiketler = $this->input->post('category');
    	$this->Customernote->customerNote_tags = implode(",", $etiketler);

    	if($this->input->post('yetkili') != ""){
    		$this->Customernote->customerNote_agent_id = $this->input->post('yetkili');
    	}
    	echo $this->Customernote->add_note();
    }

    public function new_note_category(){
    	$this->load->model('Notetag');
    	$this->Notetag->noteTag_name = $this->input->post('title');
    	echo $this->Notetag->add_tag();
    }

    public function basic_search(){
    	$this->load->model('Customer');
    	echo json_encode($this->Customer->basic_search($this->input->get('term')));
    }

    public function check_same_customer(){
    	$this->load->model('Customer');
    	$this->load->model('Agent');
    	$this->Customer->customer_title = $this->input->post('customer_title');
    	$this->Customer->customer_www = $this->input->post('customer_www');
    	$this->Customer->customer_phone = $this->input->post('customer_phone');
    	$this->Agent->agent_name = $this->input->post('agent_name');
    	$this->Agent->agent_email = $this->input->post('agent_email');
    	$this->Agent->agent_phone = $this->input->post('agent_phone');
    	$this->Customer->customer_taxNumber = $this->input->post('customer_taxNumber');
    	$this->Customer->customer_fax = $this->input->post('customer_fax');
    	echo json_encode($this->Customer->check_same_customer());
    }

    public function get_sectors(){
    	$this->load->model('Sector');
    	echo json_encode($this->Sector->get_sectors());
    }

    public function new_payment(){
    	$this->load->model('Payment');
    	$this->load->helper("date");
    	$this->Payment->payment_contract_id = $this->input->post('contract_id');
    	$this->Payment->payment_datetime = datepicker($this->input->post('tarih'));
    	$this->Payment->payment_user_id = $this->session->userdata('user_id');
    	$this->Payment->payment_amount = $this->input->post('odenen');
    	$this->Payment->payment_channel = $this->input->post('kanal');
    	$this->Payment->payment_expiry = $this->input->post('cek_vade');
    	echo $this->Payment->add_payment();
    }
        
}
?>