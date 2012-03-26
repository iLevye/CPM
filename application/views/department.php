<?include('header.php');?>

<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				
				$('#ajaxTablo').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"bRetrieve": true,
					"sAjaxSource": "<?=base_url()?>department_management/get_list"
				} );
				
				$("#yeni_kayit_buton").live('click', function(){
					$("#yeni_kayit_penceresi").dialog({ buttons: [
					                                              {
					                                                  text: "Vazgeç",
					                                                  click: function() { $(this).dialog("close"); }
					                                              },
					                                              {
					                                                  text: "Kaydet",
					                                                  click: function() { 
						                                                  $(this).dialog("close");
						                                                  		$.post("<?=base_url()?>department_management/new_record", {
								                                                  		departman_adi: $("#y_departman_adi").val(),
							                                                  		}, function(data){
																							alert("sonuc" + data);
								                                                  		});
						                                                  }
					                                              }
					                                              
					                                          ] });
					
				});

				$("span.row").live('click', function(){
					$("#kayit_bilgi_penceresi").dialog({ buttons: [
			                                              {
			                                                  text: "Kapat",
			                                                  click: function() { $(this).dialog("close"); }
			                                              },
			                                              {
															text: "Güncelle",
															click: function() {
																$(this).dialog("close");
																	//$.each(info, function(span, fval){
																    //    $('span#' + span).html(fval);
																    //});
																
																$("#kayit_guncelle").dialog();
															}
				                                          }
				                                          ]});
					var row_id = $(this).attr("row_id");
					$.getJSON("<?=base_url()?>department_management/info/" + row_id, function(JSON){
						var info = JSON;
						$.each(info, function(span, fval){
					        $('span#' + span).html(fval);
					    });
					});

					
				} );
			} );
		</script>
</head>
<body>

<?include('menu.php')?>

<div id="kayit_bilgi_penceresi" class="info_popup" title="Departman Bilgileri <span class='border'></span>" style="display:none;">
	<p>Departman ID: <span id="department_id"></span></p>
	<p>Departman Adı: <span id="department_name"></span></p>
	<p>Personel Sayısı: <span id="count_personel"></span></p>
	
</div>

<div id="kayit_guncelle" class="info_popup" title="Departman Bilgilerini Güncelleyin <span class='border'></span>" style="display:none;">
	<form class="column">
		<span>Departman Adı: <input type="text" id="d_departman_adi"></span>
	</form>
</div>

<div id="yeni_kayit_penceresi" title="Yeni Departman <span class='border'></span>" style="display:none;">
	<form id="yeni_kayit_form" class="column">
		<span>Departman Adı: <input type="text" id="y_departman_adi"></span>		
	</form>
</div>

<button id="yeni_kayit_buton">Yeni Departman</button>

<table id="ajaxTablo" class="display" cellspacing="0" cellpadding="0" border="0" style="margin:20px;">
    <thead>
        <tr>
            <th style="width: 10px;">Departman ID</th>
            <th style="">Departman Adı</th>
            <th style="">Personel Sayısı</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>



<?include('footer.php');?>