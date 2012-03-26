<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function datepicker($date){
	if($date == ""){
		return "";
	}
	$aylar['Ocak'] = "01";
	$aylar['Şubat'] = "02";
	$aylar['Mart'] = "03";
	$aylar['Nisan'] = "04";
	$aylar['Mayıs'] = "05";
	$aylar['Haziran'] = "06";
	$aylar['Temmuz'] = "07";
	$aylar['Ağustos'] = "08";
	$aylar['Eylül'] = "09";
	$aylar['Ekim'] = "10";
	$aylar['Kasım'] = "11";
	$aylar['Aralık'] = "12";
	
        try{
            $date = @explode(" ", $date);
            $gun = $date[0];
            //$ay = @explode(",", $date[1]);
            $ay = @$aylar[$date[1]];
            $yil = @$date[2];
        }catch(Exception $e){
            return $date;
        }
        
	return $yil . "-" . $ay . "-" . $gun;
}

function datepicker_en($date, $gun = true){
	$aylar['01'] = "Ocak";
	$aylar['02'] = "Şubat";
	$aylar['03'] = "Mart";
	$aylar['04'] = "Nisan";
	$aylar['05'] = "Mayıs";
	$aylar['06'] = "Haziran";
	$aylar['07'] = "Temmuz";
	$aylar['08'] = "Ağustos";
	$aylar['09'] = "Eylül";
	$aylar['10'] = "Ekim";
	$aylar['11'] = "Kasım";
	$aylar['12'] = "Aralık";
	
        if($date == ""){
            return "Tarih Belirtilmemiş";
        }
        
	$date = explode("-", $date);
	if($date[0] == "0000"){
		return "Tarih bilinmiyor";
	}
	
	$date[2] = explode(" ", $date[2]);
        if($gun){
            return $date[2][0] . " " . $aylar[$date[1]] . " " . $date[0];
        }else{
            return $aylar[$date[1]] . " " . $date[0];
        }
	
}

?>