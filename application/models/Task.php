<?
class Task extends CI_Model{
    public $task_id;
    public $task_project_id;
    public $task_user_id;
    public $task_name;
    public $task_not;
    public $task_status;
    public $task_plannedStart;
    public $task_start;
    public $task_plannedFinish;
    public $task_finish;
    public $task_resume;
    public $task_plannedTime;
    public $task_totalTime;
    public $task_feedback;
    public $task_feedback_user_id;
    public $task_confirm;
    public $task_create_date;
    public $task_create_user_id;

    function __construct() {
        parent::__construct();
    }
    
    function add_task(){
        $dizi = array($this->task_project_id, $this->task_user_id, $this->task_name, $this->task_not, $this->task_plannedStart, $this->task_plannedFinish, $this->task_plannedTime, $this->task_feedback, $this->task_feedback_user_id, $this->task_confirm, $this->task_create_user);
        //print_r($dizi);
        $sql = $this->db->query("call sp_newTask(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @a);", $dizi);
        echo $this->db->last_query();
        $sql = $this->db->query("select @a as task_id;");
        //echo $this->db->last_query();
        $row = $sql->result_array();
        return $row[0]['task_id'];
    }

    function start_task(){
        $dizi = array($this->task_id, $this->task_user_id);
        //print_r($dizi);
        $sql = $this->db->query("call sp_startTask(?, ?)", $dizi);
        //echo $this->db->last_query();
        $row = $sql->result_array();
        return $row[0]['started'];
    }

    function finish_task(){
        $dizi = array($this->task_id, $this->task_user_id);
        //print_r($dizi);
        $sql = $this->db->query("call sp_finishTask(?, ?, null, null, @a);", $dizi);
        //echo $this->db->last_query();
        $sql = $this->db->query("select @a as sonuc;");
        //echo $this->db->last_query();
        $row = $sql->result_array();
        return $row[0]['sonuc'];
    }
    
    function pause_task(){
        $dizi = array($this->task_id, $this->task_user_id);
        //print_r($dizi);
        $sql = $this->db->query("call sp_pauseTask(?, ?, @a);", $dizi);
        $sql = $this->db->query("Select @a as paused;");
        
        $row = $sql->result_array();
        return $row[0]['paused'];
    }

    function add_note(){
        $sql = $this->db->get_where('Task', array('task_id' => $this->task_id));
        $row = $sql->result_array();
        $notes = json_decode($row[0]['task_not']);
        $notes[] = $this->task_not;
        $array['task_not'] = json_encode($notes);
        $this->db->where('task_id', $this->task_id);
        return $this->db->update('Task', $array);
    }

    function get_tasks(){
        $this->load->library('definition');
        $this->definition->html = TRUE;
        $this->load->helper('date');

        $this->db->select("create_name, task_create_date, task_status, task_feedback, task_id, task_name, task_plannedTime, usedTime, task_finish, task_not, task_start, task_real_start, task_real_finish");
        $this->db->from("vw_gettasks");

        if($this->task_create_user_id != ""){
            $this->db->where("task_create_user_id = '" . $this->task_create_user_id . "' or (task_feedback_user_id = '" . $this->task_feedback_user_id . "' and task_feedback = '" . $this->task_feedback . "')");
        }

        if($this->task_user_id != ""){
            $this->db->where('user_id', $this->task_user_id);
        }
        
        $this->db->order_by("task_status");
        $sql = $this->db->get();
        //echo $this->db->last_query();

        $row = $sql->result_array();
        //print_r($row);

        foreach($row as $r){
            $r['buttons'] = "";
            $r['detail'] = "";
            $r['task_status_t'] = $this->definition->get_item("task_status", $r['task_status']);
            $r['task_finish_t'] = datepicker_en($r['task_finish']);
            $r['task_start_t'] = datepicker_en($r['task_start']);

            if($r['task_status'] == 0  && $this->task_user_id != ""){
                $r['buttons'] = '<img class="task_finish_buton" src="images/finish.png" /><img class="task_play_buton" src="images/play.png" />';
            }
            
            if($r['task_status'] == "3"){
                $r['buttons'] = "<img src='images/wait.gif' style='margin-right:28px;'/>";
            }

            
            if($r['task_status'] == "1" && $this->task_user_id != ""){
                $r['buttons'] = '<img class="task_finish_buton" src="images/finish.png" /><img class="task_pause_buton" src="images/pause.png" />';
            }
        

            if($r['task_status'] == 4){
                $r['buttons'] = '<img src="images/status-finished.png" style="width:24px; margin-right:24px;"/>';
            }

            $r['detail'] .= "<span class='log'>" . $r['create_name'] . " oluşturdu (" . datepicker_en($r['task_create_date']) . ") </span>";

            if(!empty($r['task_real_start'])){
                $r['detail'] .= "<span class='log'>" .$r['task_start_t'] . " tarihinde başlandı. </span>";
            }

            $notes = json_decode($r['task_not']);

            $r['detail'] .= "<span class='note' task_id='" . $r['task_id'] . "'>";
            if(@count($notes) > 0){
                
                foreach($notes as $note){
                    $r['detail'] .= "<span class='not_satir' task_id='" . $r['task_id'] . "'>";
                    $r['detail'] .= "<span class='not_text'>" . $note->text . "</span>" . "<span style='font-weight:bold;'>" . $note->name . " - " . datepicker_en($note->time) . "</span>";
                    $r['detail'] .= "</span>";
                }
                
            }else{
                $r['detail'] .= "<span class='not_satir hic_not' style='text-align:center;'>Hiç not bırakılmamış.</span>";
            }
            $r['detail'] .= "</span>";
            
            $r['detail'] .= "<input type='text' class='yeni_not' task_id='" . $r['task_id'] . "' value='Yeni not eklemek için tıklayın.'>
            <div style='display:none;' class='not_gonder' task_id='" . $r['task_id'] . "'><input class='not_gonder_buton' style='float:right; margin-right:2%;' type='button' value='Gönder' task_id='" . $r['task_id'] . "'>
            <span class='yeni_not_info' task_id='" . $r['task_id'] . "'>" . $this->session->userdata('user_name') . " - " . datepicker_en(date('Y-m-d H:i:s')) . "</span></div>";
            
        
            if($r['task_real_finish'] != ""){
                $r['detail'] .= "<span class='log' style='margin-top: 4px;'>" .$r['task_finish_t'] . " tarihinde bitti. </span>";
            }

            $dizi[] = $r;
        }
        return $dizi;
    }

}
?>
