<?include('header.php');?>

<script type="text/javascript" charset="utf-8">

	function musteri_ekle(){
		$.post(base_url + "customer_management/new_record", {
          		unvan: $("#y_musteri_unvan").val(),
          		web : $("#y_web").val(),
          		tel: $("#y_tel").val(),
          		yetkili_isim : $("#y_yetkili_adi").val(),
          		yetkili_eposta : $("#y_eposta").val(),
          		yetkili_telefon : $("#y_telefon").val(),
          		sektor : $("#y_sektor").val(),
          		vergi_dairesi : $("#y_vergi_dairesi").val(),
          		vergi_no : $("#y_vergi_no").val(),
          		fax : $("#y_fax").val(),
          		adres : $("#y_adres").val()
      		}, 
      		function(data){
				if(data > 0){
					location.href = base_url + "customer_management/detail/" + data;
				}
          	}
        );
	}

	function tagler(element){
	    $(element).html("");
	    $.getJSON(base_url + "customer_management/get_note_tags/", function(JSON){
	        for(var i in JSON){
	            $(element).append("<option value='" + JSON[i]['noteTag_id'] + "'>" + JSON[i]['noteTag_name'] + "</option>");
	        }
	    });
	}

	$(document).ready(function() {

		$("#musteri_filtrele_buton").live('click', function(){
			$(".filtre").fadeIn();
			tagler("#filtre_etiketleri");
		});

		$("#filtre_tip").live('change', function(){
			$(".opt").hide();
			$("." + $(this).val()).fadeIn();
		});

		$("#filtre_getir").live('click', function(){
			if($("#filtre_tip").val() == "musteri_durumu"){
				oTable.fnReloadAjax(base_url + "customer_management/get_list/status/" + $("#musteri_durumu").val());
			}else if($("#filtre_tip").val() == "musteri_notu"){
				if($("#filtre_tarihi").val() == ""){
					$("#filtre_tarihi").val("01 Ocak 1970");
					return false;
				}
				oTable.fnReloadAjax(base_url + "customer_management/get_list/note/" + $("#filtre_tarihi").val() + "/" + $("#filtre_etiketleri").val() + "/" + $("#in").val());
			}
		});
		
		oTable = $('#myTable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bRetrieve": true,
			"iDisplayLength" : 30,
			"sAjaxSource": "<?=base_url()?>customer_management/get_list/"
		} );
		
		$(".dataTables_filter label input").val("Bir şey arayın.");
		$(".dataTables_filter label input").live('click', function(){
			$(this).val("");
		});
        

		$("tr").live('click', function(){
			row_id = $(this).children("td:first").find("span").attr("row_id");
			if(row_id == null){
				return false;
			}

			location.href = base_url + "customer_management/detail/" + row_id;
		});


		$("#yeni_kayit_buton").live('click', function(){
			$.getJSON(base_url + "customer_management/get_sectors/", function(JSON){
				$("#y_sektor").html("<option value=''>Seçiniz</option>");
				for(var i in JSON){
					$("#y_sektor").append("<option value='" + JSON[i]['sector_id'] + "'>" + JSON[i]['sector_name'] + "</option>");
				}
			});
			$("#yeni_kayit_penceresi").dialog({ width:1166, buttons: [
				{
					text: "Vazgeç",
					click: function() { $(this).dialog("close"); }
				},
				{
					text: "Kaydet",
					click: function() { 
						if($("#y_sektor").val() == ""){
							alert("Lütfen firma sektörünü seçin.");
							return false;
						}
				    	$.post(base_url + "customer_management/check_same_customer/",{
				    		customer_title: $("#y_musteri_unvan").val(),
		              		customer_www : $("#y_web").val(),
		              		customer_phone: $("#y_tel").val(),
		              		agent_name : $("#y_yetkili_adi").val(),
		              		agent_email : $("#y_eposta").val(),
		              		agent_phone : $("#y_telefon").val(),
		              		customer_taxNumber : $("#y_vergi_no").val(),
		              		customer_fax : $("#y_fax").val(),
				    	}, function(data){
				    		customers = $.parseJSON(data);
				    		if(customers.length > 0){
				    			$("#benzer_musteriler").dialog({width:600,buttons:{
				    				"Devam Et" : function(){
				    					musteri_ekle();
				    				},
				    				"Vazgeç" : function(){
				    					$("#benzer_musteriler").dialog("close");
				    					$("#yeni_kayit_penceresi").dialog("close");
				    				}
				    			}});
				    			$("#benzer_musteriler ul").html("");
				    			for(var i in customers){
				    				$("#benzer_musteriler ul").append("<li><a href='" + base_url + "customer_management/detail/" + customers[i]['customer_id'] + "' target='_blank'>" + customers[i]['customer_title'] + "</a></li>");
				    			}
				    		}else{
				    			musteri_ekle();
				    		}
				    	});
				      }
				}
			                                              
			] });
		});
	} );
</script>
<style>
	#benzer_musteriler ul li {margin-top:8px;}
	.filtre {margin-top:6px; float:left; width:100%; border:2px solid red;}
</style>
</head>
<body>

<div class="fiftififti">
	<? include('menu.php') ?>
</div>

<div class="fiftififti">
	
</div>

<div id="benzer_musteriler" title="Benzer Müşteriler <span class=border></span>" style="display:none; width:600px;">
	<p style="color:#ff4545;margin: 10px 0px 22px 0px;">Eklemek istediğiniz bilgilere benzeyen müşteri(ler) mevcut. Eklemek istediğiniz müşteri aşağıdaki müşterilerden biri olabilir mi ?</p>
	<ul style="font-size:14px;list-style-type:circle;">

	</ul>
</div>

<div id="yeni_kayit_penceresi" title="Yeni Müşteri <span class='border'></span>" style="display:none; width:400px;">
	<table class="display input_table" style="width:1068px;">
		<tr>
			<td style="min-width:150px;">Müşteri Ünvanı</td>
			<td colspan="3"><input type="text" id="y_musteri_unvan"  style="width:508px;"/></td>
			<td colspan="1">Firma Sektörü</td><td><select id="y_sektor" style="width:200px" id="y_sektor"></select></td>
		</tr>
		<tr>
			<td>Firma Adresi </td>
			<td colspan="1"><textarea id="y_adres" style="width:175px; height:60px;"></textarea></td>
			<td colspan="1">Vergi Dairesi</td><td><input style="margin-top:6px;" type="text" id="y_vergi_dairesi" /></td>
			<td colspan="1">Vergi No</td><td><input style="margin-top:6px;"type="text" id="y_vergi_no" /></td>
		</tr>
		<tr>
			<td>Firma Telefonu</td>
			<td><input type="text" id="y_tel" /></td>
			<td>Fax</td>
			<td><input type="text" id="y_fax" /></td>
			<td>Web Adresi </td>
			<td><input type="text" id="y_web" /></td>
		</tr>
		<tr>
			<td>Firma Sahibi</td>
			<td><input type="text" id="y_yetkili_adi" /></td>
			<td>Telefon</td>
			<td><input type="text" id="y_telefon" /></td>
			<td>E-posta</td>
			<td><input type="text" id="y_eposta" /></td>
		</tr>
	</table>
</div>

<div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
	<h1>Müşteri Listesi</h1>
	<a href="#" class="buton" id="yeni_kayit_buton" style="float:right; margin-top:-6px;">Yeni Müşteri</a><a href="#" class="buton" id="musteri_filtrele_buton" style="float:right; margin-right:6px; margin-top:-6px;">Müşteri Filtrele</a>
	<span class="border"></span>

	<div class='filtre' style="display:none">
		<table class="input_table">
			<tr>
				<td>
					<select id="filtre_tip" style="height:30px;">
						<option value="musteri_notu">Firma notlarında</option>
						<option value="musteri_durumu">Müşteri durumu</option>
					</select>
				</td>

				<td class="musteri_notu opt">
					<input type="text" class="tarih" id="filtre_tarihi">
				</td>
				<td class="musteri_notu opt">
					tarihinden sonra
				</td>
				<td class="musteri_notu opt" style="vertical-align: middle">
					<select id="filtre_etiketleri" multiple="multiple" style="height:100px;">
						<option>asdf</option>
						<option>gfagd</option>
					</select>
				</td>
				
				<td class="musteri_notu opt">
					etiketlerine
				</td>

				<td class="musteri_notu opt">
					<select id="in">
						<option value="1">sahip</option>
						<option value="0">sahip olmayan</option>
					</select>
				</td>

				<td class="musteri_durumu opt" style="display:none;">
					<select id="musteri_durumu">
						<option value="1">Aktif olan</option>
						<option value="0">Pasif olan</option>
					</select>
				</td>
				
				<td>
					<a id="filtre_getir" class="buton">Müşterileri Getir</a>
				</td>
			</tr>
		</table>
	</div>


	<table id="myTable" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left; width:100%;">
	    <thead>
	        <tr>
	            <th style="width: 5%">No</th>
	            <th style="max-width: 5%;">Müşteri Ünvanı</th>
	            <th style="width: 20%;">Yetkili</th>
	            <th style="">Firma Telefonu</th>
	        </tr>
	    </thead>
	    <tbody>
	
	    </tbody>
	</table>

</div>


<?include('footer.php');?>