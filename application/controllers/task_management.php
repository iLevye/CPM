<?
class Task_management extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->load->view('takvim');
	}

	function sample(){
		$user['isim'] = "Emre Can Yılmaz";
        $user['user_id'] = "1";

        $task['task_id'] = "34";
        $task['task_name'] = "Falanca Tasarım";
        $task['baslangic'] = "2012-02-23";
        $task['bitis'] = "2012-02-25";
        $task['proje'] = "5";

        $task1['task_name'] = "Filanca Tasarım";
        $task1['task_id'] = "35";
        $task1['baslangic'] = "2012-02-25";
        $task1['bitis'] = "2012-02-26";
        $task1['proje'] = "6";

        $user['task'][] = $task;
        $user['task'][] = $task1;
        $dizi[] = $user;

        unset($user);
        unset($task);
        unset($task1);
        $user['isim'] = "İbrahim Özkan";
        $user['user_id'] = "2";
        $task['task_id'] = "42";
        $task['task_name'] = "Falanca Yazılım";
        $task['baslangic'] = "2012-02-23";
        $task['bitis'] = "2012-02-26";
        $task['proje'] = "5";

        $task1['task_name'] = "Filanca Yazılım";
        $task1['task_id'] = "46";
        $task1['baslangic'] = "2012-02-26";
        $task1['bitis'] = "2012-02-27";
        $task1['proje'] = "6";

        $user['task'][] = $task;
        $user['task'][] = $task1;
        $dizi[] = $user;
        echo json_encode($dizi);
	}
}
?>