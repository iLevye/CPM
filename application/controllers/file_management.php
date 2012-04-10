<?
class File_management extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	function upload_file($type){
            $this->load->helper("url");
		if (!empty($_FILES)) {
                  $tempFile = $_FILES['Filedata']['tmp_name'];
                  $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->config->item("upload_path") . '/';

                  $ext = explode('.', $_FILES['Filedata']['name']);
                  $fileName = url_title($ext[0]) . "-" . rand(99999999, 9999999999999) . "." . $ext[1];
                  $targetFile =  str_replace('//','/',$targetPath) . $fileName;

                  move_uploaded_file($tempFile,$targetFile);
                  echo $fileName;
                  /*
                  $this->load->model('File');
                  $this->File->file_name = $fileName;
                  $this->File->file_type = $type;
      			*/
            }
	}

}

?>