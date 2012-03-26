<?
class notes extends CI_Controller{

	function index(){
		$this->ajax->controller("notes");
		$this->ajax->on('load', "document", "#not_listesi ul", "not_list()");
		$this->ajax->on('click', '#yeni_not_buton', '#yeni_not_pencere', 'dialog', array("width" => "500px", "model" = true));
		$this->ajax->on('click', '#yeni_not_buton', '#yeni_not_pencere select.tags', 'tag_list()', array("kategori" => "1"));
	}

	private function tag_list($ayarlar){
		$this->load->model('Tags');
		if(intval($ayarlar['kategori'])){
			$this->Tags->category_id = $ayarlar['kategori'];
		}
		$data['method'] = "option";
		$data['source'] = $this->Tags->list();
		return $data;
	}

	private function not_list(){
		$this->load->model('Not');
		return $this->Not->list();
	}
}
?>

<div id="not_listesi">
	<ul>
	</ul>
</div>

<a id="new_not_buton">Yeni Not</a>

<div id="yeni_not_pencere">
	not tarihi : <input type="text">
	not : <input type="text">
	etiketler : <select class="tags"></select>

</div>