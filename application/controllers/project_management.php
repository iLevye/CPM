<?
class Project_management extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    
    public function detail($project_id){
        $this->load->model('Project');
        $this->load->helper('date');
        $this->Project->project_id = $project_id;
        $data['bugun'] = datepicker_en(date('Y-m-d'));
        $data['project_id'] = $project_id;
        $this->load->view('project_detail', $data);
    }
    
    public function project_info($project_id){
        $this->load->model('Project');
        $this->Project->project_id = $project_id;
        $this->load->library('definition');
        
        if($this->input->get('html') == "html"){
            $this->definition->html = true;
        }
        
        echo json_encode($this->Project->get_detail());
    }

    public function new_project(){
        $this->load->model('Project');
        $this->load->helper('date');
        $post = $this->input->post(null, true);
        foreach($post as $k => $v){
            $this->Project->{$k} = $v;
        }
        $this->Project->project_date1 = datepicker($this->Project->project_date1);
        $this->Project->project_date2 = datepicker($this->Project->project_date2);
        echo $this->Project->add_project();
    }
    
    public function edit_project(){
        $this->load->model('Project');
        $this->load->helper('date');
        
        $data = $this->input->post(null,TRUE);
        foreach($data as $key => $value){
            $this->Project->{$key} = $value;
        }
        $this->Project->project_date1 = datepicker($this->Project->project_date1);
        $this->Project->project_date2 = datepicker($this->Project->project_date2);
        echo $this->Project->edit();
    }
    
    public function status_list(){
        $this->load->library('definition');
        echo json_encode($this->definition->get_list("project_status"));
    }
    
    public function tasks($project_id){
        $this->load->library('datatables');
        $this->load->library('definition');
        $this->definition->html = TRUE;
        $this->load->helper('date');
        
        $this->datatables->select("task_id, user_id, task_name, user_name, task_status, usedTime, task_plannedTime, task_start, task_finish, task_not");
        $this->datatables->from("vw_gettasks");
        $this->datatables->where('task_project_id', $project_id);
        $this->datatables->unset_column("task_id");
        $this->datatables->unset_column("user_id");
        $this->datatables->edit_column("task_name", "<span task_id='$2'>$1</span>", 'task_name, task_id');
        $this->datatables->edit_column("usedTime", "$1 / $2", "usedTime, task_plannedTime");
        $this->datatables->edit_column("task_not", " ", "task_not");
        $this->datatables->unset_column("task_plannedTime");
        $nesne = json_decode($this->datatables->generate());
            for($i = 0; $i < count($nesne->aaData); $i++){
                $nesne->aaData[$i][2] = $this->definition->get_item('task_status', $nesne->aaData[$i][2]);
                $nesne->aaData[$i][4] = datepicker_en($nesne->aaData[$i][4]);
                $nesne->aaData[$i][5] = datepicker_en($nesne->aaData[$i][5]);
            }
            echo json_encode($nesne);
    }

    public function get_project_start_date($project_id){
        $this->load->model('Project');
        $this->load->helper('date');
        $this->Project->project_id = $project_id;
        $date[1] = $this->Project->get_value("project_date1");  // projenin başlangıç tarihi
        $date[0] = date("Y-m-d");  // bugün

        if($date[1] > $date[0]){
            $key = 1;
        }else{
            $key = 0;
        }
            $return[0] = datepicker_en($date[$key]); // görev başlangıç tarihi
            $return[1] = strtotime ( '+1 day' , strtotime ( $date[$key] ) ) ; // başlangıç tarihi + 1 gün
            $return[1] = datepicker_en(date("Y-m-d", $return[1])); // görev bitiş tarihi
        
        echo json_encode($return);
    }

    public function add_task(){
        $this->load->model('Task');
        $this->load->helper('date');

        $data = $this->input->post(null,TRUE);
        foreach($data as $key => $value){
            $this->Task->{$key} = $value;
        }

        $not['text'] = $this->Task->task_not;
        $not['time'] = date("Y-m-d H-i-s");
        $not['name'] = $this->session->userdata('user_name');
        $dizi[] = $not;

        if($this->Task->task_not != ""){
            $this->Task->task_not = json_encode($dizi);
        }
        
        $this->Task->task_plannedStart = datepicker($this->Task->task_plannedStart);
        $this->Task->task_plannedFinish = datepicker($this->Task->task_plannedFinish);
        $this->Task->task_create_user = $this->session->userdata('user_id');
        echo $this->Task->add_task();
        
    }

    public function start_task(){
        $this->load->model('Task');
        $this->Task->task_id = $this->input->post('task_id');
        $this->Task->task_user_id = $this->session->userdata('user_id');
        echo $this->Task->start_task();
    }

    public function add_task_note(){
        $this->load->model('Task');
        $this->Task->task_id = $this->input->post('task_id');
        $note['text'] = $this->input->post('note');
        $note['name'] = $this->session->userdata('user_name');
        $note['time'] = date('Y-m-d H-i-s');
        $this->Task->task_not = $note;
        echo $this->Task->add_note();
    }

    public function project_list(){
        $this->load->view('project_list');
    }

    public function get_project_list(){
        $this->load->library('datatables');
        $this->load->helper('date');
        $this->load->library('definition');
        $this->datatables->select('project_id, project_name, (select count(*) from Task where task_project_id = project_id) as tasks, project_status, user_name, project_date1, project_date2');
        $this->datatables->from('Project');
        $this->datatables->join('User', 'project_user_id = user_id', "Left");
        $this->datatables->unset_column('project_id');
        $this->datatables->edit_column("project_name", "<span row_id='$1'>$2</span>", "project_id, project_name");
        $nesne = $this->datatables->generate();
        $nesne = json_decode($nesne);

        foreach($nesne->aaData as $n){
            $n[4] = datepicker_en($n[4]);
            $n[5] = datepicker_en($n[5]);
            $n[2] = $this->definition->get_item('project_status_html', $n[2]);
            $cikti[] = $n;
        }
        $nesne->aaData = $cikti;
        
        echo json_encode($nesne);
    }


}


?>
