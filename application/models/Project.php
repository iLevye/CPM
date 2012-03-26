<?

class Project extends CI_Model {

    public $project_id;
    public $project_name;
    public $project_description;
    public $project_customer_id;
    public $project_date1;
    public $project_date2;
    public $project_status; // 0: ba�lamam��, 1: ba�lam��, 2: bitmi�

    function get_list() {
        if (!empty($this->project_customer_id)) {
            $this->db->where('project_customer_id', $this->project_customer_id);
            $this->db->where("project_status != 2");
        }

        $sql = $this->db->get('Project');
        return $sql->result_array();
    }

    function add_project() {
        if($this->project_status == null){
            $this->project_status = 0;
        }
        $this->db->insert("Project", $this);
        //echo $this->db->last_query();
        return $this->db->insert_id();
    }

    function get_detail() {
        $this->db->select('Project.*, Customer.customer_title, user_name');
        $this->db->where('Project.project_id', $this->project_id);
        $this->db->join('Customer', "project_customer_id = customer_id", "left");
        $this->db->join('User', 'project_user_id = user_id', 'left');
        $sql = $this->db->get('Project');
        $row = $sql->result_array();
        $this->load->helper('date');
        $row[0]['project_status_t'] = $this->definition->get_item('project_status', $row[0]['project_status']);
        $row[0]['project_date1'] = datepicker_en($row[0]['project_date1']);
        $row[0]['project_date2'] = datepicker_en($row[0]['project_date2']);

        return $row[0];
    }

    public function edit() {
        if ($this->project_id == "") {
            return false;
            $this->load->model('ErrorLog');
            $this->ErrorLog->log("project id is null !!");
        }

        foreach ($this as $k => $v) {
            if($v != ""){
                $update[$k] = $v;
            }   
        }

        $this->db->where('project_id', $this->project_id);
        $this->db->update('Project', $update);
        return $this->db->affected_rows();
    }

    public function get_value($field){
        $this->db->select($field);
        $this->db->where('project_id', $this->project_id);
        $sql = $this->db->get('Project');
        $row = $sql->result_array();
        return $row[0][$field];
    }

}

?>