<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<head> 
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<title>ATA CRM</title> 
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css" media="screen" /> 
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/grid.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/ui-lightness/jquery-ui-1.8.16.custom.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/styles.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/theme-blue.css" media="screen" /> 

        
		<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.1.min.js"></script> 
		<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.16.custom.min.js"></script> 

<script type="text/javascript">
	$(document).ready(function(){
		$("form").submit(function(){
			$.post("<?=base_url()?>account/login/", {eposta: $("#eposta").val(), sifre : $("#sifre").val()}, function(data){
					if(data == 1){
						location.href = "<?=base_url()?>";
					}else{
						$("#login_error").html("invalid e-mail or password");
						$("#login_error").dialog();
						
					}
				});
			return false;
		});
	});
</script>

</head>
<body>

<div id="login_error" title="login error" style="display:none;"></div>

<div id="header">
	<div id="header-main">
		<div id="logo"></div>
	</div>
</div>

<div class="grid_12">
	<div class="container_12">
		<div class="module" style="width:300px;">
			<h2><span>giriş yap</span></h2>
			<div class="module-body">
				<form class="column" method="post" action="<?=base_url()?>account/login">
					<span style="">e-posta: <input type="text" id="eposta" value="emre.yilmaz@ata.com.tr"> </span><br>
					<span style="">şifre: <input type="password" id="sifre" value="123123"> </span>
					<span><input type="submit" value="giriş" /></span>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('footer.php')?>