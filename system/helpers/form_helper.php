<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function selected($data1, $data2){
	if($data1 == $data2){
		echo ' selected="selected" ';
	}

}

?>