<?

class Definition {

    private $project_status;
    private $task_status;
    public $html;

    function __construct() {
        $this->project_status = array("0" => "Henüz başlamadı", "1" => "Devam Ediyor", "2" => "Proje Bitti");
        $this->project_status_html = array("0" => "<span style='color:red'>Henüz başlamadı</span>", "1" => "<span style='color:gray'>Devam Ediyor</span>", "2" => "<span style='color:green'>Proje Bitti</span>");
        /*
        $this->task_status = array("0" => "Duruyor", "1" => "Yapılıyor", "2" => "Görev Bitti");
        $this->task_status_html = array("0" => "<span style='color:red'>Duruyor</span>", "1" => "<span style='color:gray'>Yapılıyor</span>", "2" => "<span style='color:green'>Görev Bitti</span>");
        */
        $this->task_status = array("0" => "Başlamadı", "1" => "Yapılıyor", "2" => "Duraklatıldı",  "3" => "Onay bekliyor", "4" => "Görev Bitti");
        $this->task_status_html = array("0" => "<span style='color:red'>Başlamadı</span>", "1" => "<span style='color:gray'>Yapılıyor</span>", "2" => "<span style='color:red'>Duraklatıldı</span>", "3" => "<span style='color:darkgreen'>", "4" => "<span style='color:green'>Görev Bitti</span>");
        
        
    }

    function get_item($data, $key) {
        if ($this->html) {
            $data .= "_html";
        }

        $return = @$this->{$data}[$key];
        if ($return == null) {
            return "Belirsiz";
        }
        return $return;
    }

    function get_options($data, $selected_key) {
        $dizi = $this->{$data};
        $option = "";
        foreach ($dizi as $k => $v) {
            $option .= "<option value='" . $k . "'";
            if ($k == $selected_key) {
                $option .= " selected='selected'";
            }
            $option .=">" . $v . "</option>";
        }
        return $option;
    }
    
    function get_list($data){
        return $this->{$data};
    }

}

?>
