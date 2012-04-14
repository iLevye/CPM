<?php

class User extends CI_Model {

    public $user_id;
    public $user_email;
    public $user_password;
    public $user_name;
    public $user_address;
    public $user_phone;
    public $user_gsm;
    public $user_title;
    public $user_department_id;
    public $user_access;

    function __construct() {
        parent::__construct();
    }

    public function edit() {
        if ($this->user_id == "") {
            return false;
            $this->load->model('ErrorLog');
            $this->ErrorLog->log("user id is null !!");
        }

        foreach ($this as $k => $v) {
            if (!empty($v) && $k != "user_id") {
                $update[$k] = $v;
            }
        }

        $this->db->where('user_id', $this->user_id);
        $this->db->update('User', $update);
        return $this->db->affected_rows();
    }

    /*
    bu fonksiyon kullanılmıyor. insert fonksiyonunu kullanabilirsiniz
    public function create() {
        $this->db->insert('User', $this);
        if ($this->db->insert_id()) {
            $this->user_id = $this->db->insert_id();
            return true;
        }
    }
    */

    public function get_user($basic = true, $by = "user_id") {

        if ($basic) {
            $this->db->select("user_id, user_email, user_name, user_title, user_access");
        } else {
            $this->db->select("User.*, department_name");
            $this->db->join('Department', 'user_department_id = department_id', "left");
        }

        if ($by == "user_id") {
            $this->db->where('user_id', $this->user_id);
        } else {
            $this->db->where('user_id', $this->user_email);
        }

        $sql = $this->db->get('User');
        $row = $sql->result();


        foreach ($row[0] as $rk => $rv) {
            $this->$rk = $rv;
        }
        if($basic){
            $this->user_access = json_decode($this->user_access);    
        }
    
        unset($this->user_password);
    }

    public function login() {
        $this->db->where('user_email', $this->user_email);
        $this->db->where('user_password', $this->user_password);
        $this->db->select("user_id");
        $sql = $this->db->get('User');
        $row = $sql->result_array();
        if (intval(@$row[0]['user_id'])) {
            $this->user_id = $row[0]['user_id'];
            return true;
        } else {
            return false;
        }
    }

    public function get_user_list($basic = false) {
        if ($basic) {
            $this->db->select('user_id, user_name');
        } else {
            $this->db->select('user_id, user_name, user_email, user_phone, user_gsm, user_title');
        }
        $sql = $this->db->get('User');
        $row = $sql->result_array();
        return $row;
    }

    public function count_users() {
        $this->db->select('count(user_id) as total');
        $sql = $this->db->get('User');
        $row = $sql->result_array();
        return $row[0]['total'];
    }

    public function insert() {
        $this->db->insert('User', $this);
        $this->user_id = $this->db->insert_id();
        return;
    }

    public function edit_access(){
        $update['user_access'] = $this->user_access;
        $this->db->where("user_id", $this->user_id);
        $this->db->update("User", $update);
        return $this->db->affected_rows();
    }

}

?>