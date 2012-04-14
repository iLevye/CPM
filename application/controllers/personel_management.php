<?php

class Personel_management extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (@$this->session->userdata('user_id') == "") {
            header("Location: " . base_url());
            return false;
        }
        $this->load->model('Department');
    }

    public function index() {
        $this->load->model('Permission');
        $data['permissions'] = $this->Permission->get_permissions();
        $data['departments'] = $this->Department->get_department_list();
        $this->load->view('personel', $data);
    }


    public function get_list(){
        $this->load->library('datatables');
        $this->datatables->select("user_id, user_name, user_title, user_gsm, user_email");
        $this->datatables->from("User");
        $this->datatables->edit_column("user_name", "<span class='row' row_id='$1'>$2</span>", "user_id, user_name");
        echo $this->datatables->generate();
    }

    public function new_personel() {
        $this->User->user_name = $this->input->post('isim');
        $this->User->user_email = $this->input->post('eposta');
        $this->User->user_password = md5($this->input->post('pass')); 
        $this->User->user_phone = $this->input->post('telefon');
        $this->User->user_gsm = $this->input->post('gsm');
        $this->User->user_title = $this->input->post('title');
        $this->User->user_address = $this->input->post('adres');
        $this->User->user_department_id = $this->input->post('departman');
        $this->User->user_access = json_encode($this->input->post('yetkiler'));

        $this->User->insert();
        if (intval($this->User->user_id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function edit_personel() {
        $data = $this->input->post(null,TRUE);
        foreach($data as $key => $value){
            $this->User->{$key} = $value;
        }
        echo $this->User->edit();
    }

    public function edit_access($id){
        $this->load->model('User');
        $this->User->user_id = $id;
        $this->User->user_access = json_encode($this->input->post('yetkiler'));
        echo $this->User->edit_access();
    }

    public function personel_info($id) {
        $this->User->user_id = $id;
        $this->User->get_user(false);
        $this->User->user_access = json_decode($this->User->user_access);
        echo json_encode($this->User);
    }

    public function get_salaries($user_id){
        $this->load->library('datatables');
        $select = "salary_paymentDate, salary_paidAmount, salary_netAmount, salary_agi, salary_travelFoodExpense, ";
        $select .= "salary_bonus, salary_advance, salary_wageCut, salary_insuranceAmount, salary_personelCost, salary_id";
        $this->datatables->select($select);
        $this->datatables->from("vw_getsalaries");
        $this->datatables->where('salary_user_id', $user_id);
        $this->datatables->where("salary_active", 1);
        $this->datatables->unset_column("salary_user_id");
        $nesne = json_decode($this->datatables->generate());
        $this->load->helper('date');
        
        for($i = 0; $i < count($nesne->aaData); $i++){
            $nesne->aaData[$i][0] = datepicker_en($nesne->aaData[$i][0], false);
            $nesne->aaData[$i][10] = "<a href='#' salary_id='" . $nesne->aaData[$i][10] . "' class='maas_sil'>Sil</a>";
            
        }    
        echo json_encode($nesne);
    }
    
    public function add_salary($user_id){
        $this->load->model('Salary');
        $this->load->helper("date");
        $this->Salary->salary_user_id = $user_id;
        $this->Salary->salary_paymentDate = datepicker($this->input->post('odeme_tarihi', true));
        //$this->Salary->salary_paidAmount = $this->input->post('odenen_maas', true);
        $this->Salary->salary_netAmount = $this->input->post('net_maas', true);
        $this->Salary->salary_agi = $this->input->post('agi', true);
        $this->Salary->salary_travelFoodExpense = $this->input->post('yol_yemek', true);
        $this->Salary->salary_bonus = $this->input->post('prim', true);
        $this->Salary->salary_advance = $this->input->post('avans', true);
        $this->Salary->salary_wageCut = $this->input->post('kesinti', true);
        $this->Salary->salary_insuranceAmount = $this->input->post('sigorta', true);
        //$this->Salary->salary_personelCost = $this->input->post('maliyet', true);
        if($this->Salary->add_salary()){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function delete_salary(){
        $this->load->model('Salary');
        $this->Salary->salary_id = $this->input->post('salary_id');
        echo $this->Salary->remove();
    }
    
    public function personels(){
        $this->load->model('User');
        echo json_encode($this->User->get_user_list(true));
    }

    public function get_tasks($user_id){
        $this->load->library("datatables");
        $this->load->library("definition");
        $this->load->helper("date");
        $this->datatables->select("task_id, task_name, task_status, usedTime, task_plannedTime, task_start, task_finish");
        $this->datatables->edit_column("task_name", "<span row_id='$1'>$2</span>", "task_id, task_name");
        $this->datatables->unset_column("task_id");
        $this->datatables->edit_column("userTime", "$1 / $2", "usedTime, task_plannedTime");
        $this->datatables->unset_column("task_plannedTime");
        $this->datatables->from("vw_gettasks");
        $this->datatables->where("user_id", $user_id);
        
        $nesne = json_decode($this->datatables->generate());
        foreach($nesne->aaData as $n){
            $n[3] = datepicker_en($n[3]);
            $n[4] = datepicker_en($n[4]);
            $n[1] = $this->definition->get_item("task_status_html", $n[1]);
            $aaData[] = $n;
        }
        $nesne->aaData = $aaData;

        echo json_encode($nesne);
    }

    public function add_dayoff(){
        $this->load->model('Dayoff');
        $this->load->helper('date');
        $this->Dayoff->dayoff_active = 1;
        $this->Dayoff->dayoff_start = datepicker($this->input->post("dayoff_start"));
        $this->Dayoff->dayoff_finish = datepicker($this->input->post('dayoff_finish'));
        $this->Dayoff->dayoff_user = $this->input->post('dayoff_user');
        echo $this->Dayoff->add();
    }

    public function delete_dayoff(){
        $this->load->model('Dayoff');
        $this->Dayoff->dayoff_id = $this->input->post('dayoff_id');
        echo $this->Dayoff->delete();
    }
    
    public function list_offdays($user_id){
        $this->load->library("datatables");
        $this->load->helper("date");
        $this->datatables->select("dayoff_start, dayoff_finish, dayoff_id");
        $this->datatables->edit_column("dayoff_start", "<span row_id='$1'>$2</span>", "dayoff_id, dayoff_start");
        $this->datatables->edit_column("dayoff_id", "<a href='#' class='izin_sil_buton' dayoff_id='$1'>Sil</a>", "dayoff_id");
        $this->datatables->from("Dayoff");
        $this->datatables->where("dayoff_user", $user_id);
        $this->datatables->where("dayoff_active", 1);
        $nesne = json_decode($this->datatables->generate());

        if(count(@$nesne->aaData) > 0){
            foreach($nesne->aaData as $n){
                $n[0] = datepicker_en($n[0]);
                $n[1] = datepicker_en($n[1]);
                $aaData[] = $n;
            }
            $nesne->aaData = $aaData;
        }
        echo json_encode($nesne);
    }


}

?>