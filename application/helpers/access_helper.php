<?
if(!function_exists("check_access")){
	function check_access($access){
		$CI =& get_instance();
		
		if(array_search($access, $CI->session->userdata("user_access")) !== false){
			return true;
		}else{
			return false;
		}
		
	}
}
?>