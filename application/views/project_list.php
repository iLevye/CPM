<?include('header.php');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#projects').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 99,
            "sAjaxSource": base_url + "project_management/get_project_list/",
        } );

        $("#projects tr").live('click', function(){
            project_id = $(this).find("span").attr('row_id');
            location.href = base_url + 'project_management/detail/' + project_id;
        });
        /*
        $("#yeni_kayit_buton").live('click', function(){
        	$("#yeni_kayit").dialog({width:510,model:true, buttons:{
        		"Vazgeç" : function(){
        			$(this).dialog("close");
        		},
        		"Kaydet" : function(){
        			$.post(base_url + "price_list/new_price/", {
        				Hizmet : $("#y_hizmet").val(),
        				Ücret : $("#y_ucret").val()
        			}, function(data){
        				if(data > 0){
        					alert("Hizmet eklendi");
        					$("#yeni_kayit").dialog("close");
        				}
        			});
        		}
        	}});
        });
        */
	});
</script>

<div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
    
    <!--   
	<div id="yeni_kayit" style="display:none;float:left;" title="Yeni Kayıt<span class='border'></span>">
	    <table class="input_table display" style="width:474px;">
	        <tr>
	            <td style="width:150px;">
					İsim
	            </td>
	            <td style="width:350px;">
	                <input type="text" id="y_isim">
	            </td>
	        </tr>

	        <tr>
	            <td style="width:150px;">
					Numara
	            </td>
	            <td style="width:350px;">
	                <input type="text" id="y_numara">
	            </td>
	        </tr>

	        <tr>
	            <td style="width:150px;">
					GSM
	            </td>
	            <td style="width:350px;">
	                <input type="text" id="y_gsm">
	            </td>
	        </tr>
		</table>
	</div>	        
    
	<div style="width:100%; float:left;">
		<a id="yeni_kayit_buton" class="buton" style="float:left;">Yeni Kayıt</a>
	</div>
    
    -->
    <table id="projects" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
        <thead>
            <tr>
                <th>Proje Adı</th>
                <th style="width:100px">Görev Sayısı</th>
                <th style="width:140px;">Durum</th>
                <th style="width:210px;">Proje Sorumlusu</th>
                <th style="width:120px;">Başlangıç Tarihi</th>
                <th style="width:120px;">Bitiş Tarihi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<?include('footer.php');?>