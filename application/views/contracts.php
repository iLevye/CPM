<?include('header.php');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#projects').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "iDisplayLength" : 99,
            "sAjaxSource": base_url + "contract_management/get_contract_list/",
        } );

        $("#contracts tr").live('click', function(){
            contract_id = $(this).find("span").attr('row_id');
            //location.href = base_url + 'contract_management/detail/' + contract_id;
        });
	});
</script>

<div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
    
    <table id="contracts" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
        <thead>
            <tr>
                <th>Sözleşme Adı</th>
                <th style="">Müşteri</th>
                <th style="">Sözleşme Tarihi</th>
                <th style="">Satış Temsilcisi</th>
                <th style="">Hizmet Sayısı</th>
                <th style="">Toplam Tutar</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<?include('footer.php');?>