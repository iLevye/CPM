<?php include('header.php');?>

<script type="text/javascript" src="<?=base_url()?>js/jquery.ajaxTemplate.js"></script>

<script type="text/javascript">
	
	function gorevler(){
		$("#gorev_listesi").html("");
		$("#gorev_listesi").ajaxTemplate({
			source : base_url + "home/tasks/", 
			template : "#gorev_template",
			list : "#gorev_listesi"
		});
	}

	function takip_ettiklerim(){
		$("#gorev_listesi").html("");
		$("#gorev_listesi").ajaxTemplate({
			source : base_url + "home/following_task/", 
			template : "#gorev_template2",
			list : "#gorev_listesi"
		});
	}


	function hatirlatmalar(){
		$("#hatirlatma_listesi").html("");
		$("#hatirlatma_listesi").ajaxTemplate({
			source : base_url + "alert_management/my_alerts",
			template : "#hatirlatma_template",
			list : "#hatirlatma_listesi"
		});
	}

	$(document).ready(function(){
		
		$("#gorevlerim").live('click', function(){
			$(".gorevler_tab a").css("text-decoration", "none");
			$(this).css("text-decoration", "underline");
			gorevler();
		});

		$("#takip_ettiklerim").live('click', function(){
			$(".gorevler_tab a").css("text-decoration", "none");
			$(this).css("text-decoration", "underline");
			takip_ettiklerim();
		});

		hatirlatmalar();
		$("#hatirlatmalar").accordion({icons: false});
		gorevler();

		// eventlar 

		$(".alert_sil").live('click', function(){
			var alert_id = $(this).parents(".alert-detail").attr("alert_id");
			$.post(base_url + "alert_management/delete/", {
				alert_id : alert_id
			}, function(data){
				if(data > 0){
					alert("Bildirim silindi.");
					$(".alert-detail[alert_id=" + alert_id + "]").slideUp(800);
					$(".alert[alert_id=" + alert_id + "]").slideUp(800);
					setTimeout("hatirlatmalar();", 800);
				}
			});
		});

		$(".alert_ertele").live('click', function(){
			var alert_id = $(this).parents(".alert-detail").attr("alert_id");
			$("#hatirlatma_erteleme").dialog({
				model:true,
				width:'600px',
				buttons:{
					"Vazgeç" : function(){
						$(this).dialog("close");
					},
					"Ertele" : function(){
						$.post(base_url + "alert_management/snooze/", {
							alert_id : alert_id,
							snooze_date : $("#y_snooze_date").val()
						}, function(data){
							if(data > 0){
								alert("Bildirim " + $("#y_snooze_date").val() + " tarihinde yeniden hatırlatılacak.");
								$("#hatirlatma_erteleme").dialog("close");
								$(".alert-detail[alert_id=" + alert_id + "]").slideUp(800);
								$(".alert[alert_id=" + alert_id + "]").slideUp(800);
								setTimeout("hatirlatmalar();", 800);
							}
						});
					}
				}
			});
		});

		$("#yeni_hatirlatma_buton").live('click', function(){
			$("#yeni_hatirlatma").dialog({
				model:true,
				width:'600px',
				buttons:{
					"Vazgeç" : function(){
						$(this).dialog("close");
					},
					"Kaydet" : function(){
						$.post(base_url + "alert_management/new_alert/", {
							alert_text : $("#y_hatirlatma_not").val(),
							alert_datetime : $("#y_hatirlatma_tarih").val()
						}, function(data){
							if(data == -1){
								alert("Geçmiş tarihe hatırlatma ekleyemezsiniz");		
							}
							if(data > 0){
								hatirlatmalar();
								alert("Hatırlatma eklendi. " + $("#y_hatirlatma_tarih").val() + " tarihinde hatırlatılacak.");
							}
						});
						$("#yeni_hatirlatma").dialog("close");
					}
				}
			});
		});

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

		$(".task_confirm_buton").live('click', function(){
			task_id = $(this).parents('.kalip').attr("task_id");
			$.post(base_url + "home/confirm_task", {task_id : task_id}, function(data){
				if(data > 0){
					alert("Görev onaylandı");
					takip_ettiklerim();
				}else{
					alert("Bir sorun oluştu");
				}
			});
			return false;
		});

		$(".task_revised_buton").live('click', function(){
			task_id = $(this).parents('.kalip').attr("task_id");
			$("#revize_notu").dialog({
				width: "660px", 
				buttons:{
					"Vazgeç" : function(){
						$(this).dialog("close");
					},
					"Gönder" : function(){
						if($("#y_revize_not").val().length < 2){
							alert("Revize notu girmelisiniz.");
							return false;
						}
						$.post(base_url + "home/revised_task", {task_id : task_id, revised_note : $("#y_revize_not").val()}, function(data){
							if(data > 0){
								$("#revize_notu").dialog("close");
								alert("Revize gönderildi");
								takip_ettiklerim();
							}else{
								alert("Bir sorun oluştu");
							}
						});
					}
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
			if(note == "Yeni not eklemek için tıklayın."){
				if(<?=$this->session->userdata('user_id')?> == 34){
					alert("Derdin ne evladım ?");
				}
				return false;
			}
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

	.gorevler_tab {font-family: sans-serif; font-size:14px; color:#41802D;}
	.gorevler_tab a {float:left; margin-top:10px; cursor:pointer;margin-left: 20px;}
	.gorevler_tab a:hover {text-decoration:underline;}

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

<div id="gorev_template2" style="display:none">
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

<div id="revize_notu" style="display:none" title="Revize Notu">
	<table class="input_table display" style="width:564px;">
		<tr>
			<td>Revize notunuz</td>
			<td><textarea id="y_revize_not" style="width:300px; height:80px"></textarea></td>
		</tr>
	</table>
</div>

<div id="finish_task" style="display:none;">
	<p>Görevin bittiğini bildirdiğinizde onay kullanıcısına görevi onaylaması için bir istek gönderilir.</p>
</div>

<div class="blok" style="width:51%; margin-left:2%; margin-right:2%;">
	<h1>Görevler</h1> <span class="gorevler_tab" style="float:right;"><a style="text-decoration: underline;"id="gorevlerim">Görevlerim</a> <a id="takip_ettiklerim">Takip ettiğim görevler</a></span>
	<span class="border"></span>
	<div id="gorev_listesi"></div>
	<div id="gorev_listesi2" style="display:none;"></div>
</div>

<div id="yeni_hatirlatma" style="display:none" title="Yeni Hatırlatma<span class='border'></span>">
	<table class="input_table display" style="width:564px;">
		<tr>
			<td>Hatırlatma Tarihi</td><td><input type="text" id="y_hatirlatma_tarih" class="tarih" /></td>
		</tr>
		<tr>
			<td>Notunuz</td>
			<td><textarea id="y_hatirlatma_not" style="width:300px; height:80px"></textarea></td>
		</tr>
	</table>
</div>

<div id="hatirlatma_erteleme" style="display:none" title="Daha sonra hatırlat <span class='border'></span>">
	<table class="input_table display" style="width:564px;">
		<tr>
			<td>Hatırlatma Tarihi</td><td><input type="text" id="y_snooze_date" class="tarih" /></td>
		</tr>
	</table>
</div>

<div class="blok" style="width:41%; margin-left:2%; margin-right:2%;">
	<h1>Bildirimler</h1>
	<a id="yeni_hatirlatma_buton" class="buton" style="float:right; margin-top:-6px">Yeni Hatırlatma</a>
	<span class="border"></span>
	<div id="hatirlatma_template" style="display:none">
		<div class="alert first" alert_id="{$alert_id}">
			<div class="etiket">{$alert_tag}</div><div class="ozet">{$alert_text}...</div>
		</div>
		
		<div class="alert-detail" alert_id="{$alert_id}">
			<p>{$alert_text}</p>
			<span style="float:right; margin-right:10px; margin-bottom:10px;"><a style="margin-right:10px;" class="buton alert_ertele">Sonra Hatırlat</a><a class="buton alert_sil">Sil</a></span>
		</div>
	</div>

	<div id="hatirlatma_listesi"></div>

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