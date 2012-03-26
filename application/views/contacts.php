<?include('header.php');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#rehber_tablo').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 30,
            "bSort": false,
            "sAjaxSource": base_url + "contacts/get_list/",
            "fnDrawCallback" : function() {
                    $("#rehber_tablo span.title").parents("tr").css({"cursor":"pointer", "border-bottom":"2px solid #b5dfa3", "color":"#41742c", "background" : "#ddfad1"});
                    $("#rehber_tablo span.title").parents("tr").find("td").css({"padding":"16px 0 16px 8px"});
                }
        } );

        $("#yeni_kayit_buton").live('click', function(){
        	$("#yeni_kayit").dialog({width:510,model:true, buttons:{
        		"Vazgeç" : function(){
        			$(this).dialog("close");
        		},
        		"Kaydet" : function(){
        			$.post(base_url + "contacts/new_contact/", {
        				isim : $("#y_isim").val(),
        				numara : $("#y_numara").val(),
        				gsm : $("#y_gsm").val()
        			}, function(data){
        				if(data > 0){
        					alert("Kişi rehbere eklendi");
        					$("#yeni_kayit").dialog("close");
        				}
        			});
        		}
        	}});
        });
	});
</script>

<div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
       
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
    <table id="rehber_tablo" class="display clickable grouptable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
        <thead>
            <tr>
                <th>İsim / Firma</th>
                <th>Numara</th>
                <th>GSM</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<?include('footer.php');?>