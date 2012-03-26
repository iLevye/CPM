<?
class Salary extends CI_Model{
    public $salary_id;
    public $salary_user_id;
    public $salary_paymentDate;
    public $salary_wageCut;
    public $salary_advance;
    public $salary_bonus;
    public $salary_travelFoodExpense;
    public $salary_agi;
    public $salary_netAmount;
    //public $salary_paidAmount;
    //public $salary_personelCost;
    public $salary_insuranceAmount;
    public $salary_active;
    
    public function add_salary(){
        $this->salary_active = 1;
        $this->db->insert('Salary', $this);
        echo $this->db->last_query();
        return intval($this->db->insert_id());
    }

    public function remove(){
        $this->db->where("salary_id", $this->salary_id);
        $update['salary_active'] = 0;
        $this->db->update("Salary", $update);
        return $this->db->affected_rows();
    }
}