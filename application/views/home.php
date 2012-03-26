<?php include('header.php');?>

<script type="text/javascript" src="<?=base_url()?>js/jquery.ajaxTemplate.js"></script>

<script type="text/javascript">
	
	function gorevler(){
		$("#gorev_listesi").html("");
		$("#gorev_listesi").ajaxTemplate({
			source : base_url + "home/tasks/", 
			template : "#gorev_template"
		});
	}

	$(document).ready(function(){

		gorevler();
		$("#hatirlatmalar").accordion({icons: false});


		// eventlar 
		$(".kalip").live('click', function(){
			$(this).next(".task_detail").slideToggle(100);
		});

		$(".alert").live('click', function(){
			var border_bottom = $(this).attr("border-bottom");
			if(border_bottom != "true"){
    			$(this).css("border-bottom", "none");
				$(this).attr("border-bottom", "true");
			}else{
				$(this).css("border-bottom", "1px solid #e2e2e2");
				$(this).attr("border-bottom", "false");
			}
			$(this).next(".alert-detail").slideToggle(100);
		});

		$(".task_play_buton").live('click', function(){
			task_id = $(this).parents('.kalip').attr("task_id");
			$.post(base_url + "home/start_task", {task_id : task_id}, function(data){
				if(data == 1){
					alert("Görev başladı");
					gorevler();
				}else{
					alert("Bir sorun oluştu");
				}
			});
			return false;
		});

		$(".task_pause_buton").live('click', function(){
			task_id = $(this).parents('.kalip').attr("task_id");
			$.post(base_url + "home/pause_task", {task_id : task_id}, function(data){
				if(data == 1){
					alert("Görev durduruldu");
					gorevler();
				}else{
					alert("Bir sorun oluştu");
				}
			});
			return false;
		});

		$(".task_finish_buton").live('click', function(){
			task_id = $(this).parents('.kalip').attr("task_id");
			$.post(base_url + "home/finish_task", {task_id : task_id}, function(data){
				if(data > 0){
					alert("Görev bitirildi");
					gorevler();
				}else{
					alert("Bir sorun oluştu");
				}
			});
			return false;
		});

		$(".yeni_not").live('click', function(){
			if($(this).val() == "Yeni not eklemek için tıklayın."){
				$(this).val("");
				$(this).css("text-align", "left");
				$(".not_gonder").fadeIn();
			}
		});

		$(".yeni_not").live('blur',function(){
			if($(this).val() == ""){
				$(this).val("Yeni not eklemek için tıklayın.");
				$(this).css("text-align", "center");
				$(".not_gonder").fadeOut();
			}
		});

		$(".not_gonder_buton").live('click', function(){
			task_id = $(this).attr('task_id');
			note = $(".yeni_not[task_id=" + task_id + "]").val();
			$.post(base_url + "project_management/add_task_note", {
				task_id : task_id,
				note : note
			}, function(data){
				if(data > 0){
					var str = '<span class="not_satir"><span class="not_text">' + note + '</span><span style="font-weight:bold;">' + $.trim($(".yeni_not_info[task_id=" + task_id + "]").text()) + '</span></span>';
					$(".note[task_id=" + task_id + "]").append(str);
					$(".note[task_id=" + task_id + "] .hic_not").remove();
					$(".yeni_not[task_id=" + task_id + "]").val("Yeni not eklemek için tıklayın.").css("text-align", "center");
					$(".not_gonder[task_id=" + task_id + "]").fadeOut();
				}
			});
		});

	});

		

</script>

<style type="text/css">
	ul#icons li {
		cursor: pointer;
		float: left;
		list-style: none outside none;
		margin: 2px;
		padding: 4px;
		position: relative;
	}
	</style>

</head>
<body>

<div id="gorev_template" test="asdf" style="display:none">
	<div class="kalip first" task_id="{$task_id}">
		<div class="{if $task_status == 1}yesil{else}pembe{/if}-box"></div>
		<div class="serit-dis">
			<div class="serit-ic">
				<p style='color:{if $task_status == 2}#C9C9C9{/if}'>{$task_name}
				<span class="img">{$buttons}</span>
				<span class="time_info">{$task_plannedTime} / {$usedTime}</span>
				</p>
			</div>
		</div>
	</div>

	<div class="task_detail">
		<span>{$detail}</span>
	</div>
</div>

<div id="finish_task" style="display:none;">
	<p>Görevin bittiğini bildirdiğinizde 
</div>

<div class="blok" style="width:51%; margin-left:2%; margin-right:2%;">
	<h1>Görevler</h1>
	<span class="border"></span>

	<div id="gorev_listesi">
	</div>

</div>

<div class="blok" style="width:41%; margin-left:2%; margin-right:2%;">
	<h1>Hatırlatmalar</h1>
	<span class="border"></span>
	
	<div class="alert first">
		<div class="etiket">GÖRÜŞME</div><div class="ozet">Donec adipiscing nunc tellus a sapien a erosest congue...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Maecenas et adipiscing nunc enim, a elementum quam...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Pellentesque eiusmod feugiat sapien a eros vulputate nec...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">TEKLİF</div><div class="ozet">Sed rutrum egestas felis, at euismod eros convallis...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">ÖZEL NOT</div><div class="ozet">Cras eu neque eu augue pretium sollicitudin consectetur...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">TEKLİF</div><div class="ozet">Nullam non nisl mi, non varius nostrud exercitation tortor....</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Sed dignissim erat aliquet eu convallis sem condimentum...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

	<div class="alert">
		<div class="etiket">GÖRÜŞME</div><div class="ozet">Donec adipiscing nunc tellus a sapien a erosest congue...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Maecenas et adipiscing nunc enim, a elementum quam...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Pellentesque eiusmod feugiat sapien a eros vulputate nec...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">TEKLİF</div><div class="ozet">Sed rutrum egestas felis, at euismod eros convallis...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">ÖZEL NOT</div><div class="ozet">Cras eu neque eu augue pretium sollicitudin consectetur...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">TEKLİF</div><div class="ozet">Nullam non nisl mi, non varius nostrud exercitation tortor....</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>
	<div class="alert">
		<div class="etiket">SÖZLEŞME</div><div class="ozet">Sed dignissim erat aliquet eu convallis sem condimentum...</div>
	</div>
	
	<div class="alert-detail">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
	</div>

</div>


<? /*
<div class="container_12">

	<div class="grid_6">
		<div class="module">
			<h2><span>Görevler</span></h2>
			<div class="module-body">
				<table id="gorevler_tablo" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
				    <thead>
				        <tr>
				        	<div class="headtr">
				        		<th></th>
					            <th style="">Görev</th>
					            <th style="width:130px;">Süre</th>
					            <th style="width: 130px;">Bitiş Tarihi</th>
				            </div>
				        </tr>
				    </thead>
				    <tbody>
				
				    </tbody>
				</table>
			</div>
		</div>
	</div>
		
	<div class="grid_6">
		<div class="module">
		<h2><span>Hatırlatmalar</span></h2>
		<div class="module-body">
			<div id="hatirlatmalar" style="max-width:400px;">
				<h3>Hatırlatma 1</h3>
				<div>hatırlatma 1 detay metay</div>
				<h3>Hatırlatma 2</h3>
				<div>hatırlatma 2 detay metay</div>
				<h3>Hatırlatma 3</h3>
				<div>hatırlatma 3 detay metay</div>
				<h3>Hatırlatma 4</h3>
				<div>hatırlatma 4 detay metay</div>
			</div>
		</div>
		</div>
	</div>
</div>


*/?>




<?php include('footer.php')?>