<? include('header.php'); ?>

<style>
    #projeler_tablo tr td {cursor:pointer;}
    #projeler_tablo tr:hover {border-bottom:1px solid gray;}
    table#musteri_bilgileri tr td .editer {display:none;}
    #note {border:1px solid gray; border-radius: 3px; background:#ff4545; font-weight:thin; font-size:12px; color:white; font-family:sans-serif; padding:10px;}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $('#teklifler_tablo').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bRetrieve": true,
            "bPaginate": false,
            "sAjaxSource": base_url + "offer_management/get_offers/"
        });

        $("#yeni_teklif_buton").live('click', function(){
            $("#yeni_teklif").dialog({model:true, width: 1000, buttons:{
                "Oluştur" : function(){
                    alert("Teklif oluşturuldu.")
                }
            }})
        });

        $("#y_musteri_tip").live('change', function(){
            if($(this).val() == 1){
                $(".kayitli_musteri").show();
                $(".yeni_musteri").hide();
                $.getJSON(base_url + "getjson/customers/", function(JSON){
                    var option = "";
                    for(var i in JSON){
                        option += "<option value='" + JSON[i]['customer_id'] + "'>" + JSON[i]['customer_title'] + "</option>";
                    };
                    $("#y_offer_customer_id").html(option);
                });
            }else{
                $(".yeni_musteri").show();
                $(".kayitli_musteri").hide();
            }
        });
    });
</script>


<div id="notice"></div>
    
    <div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
       
        <div style="width:100%; float:left;">
            <input type="text" id="day" style="border:1px solid gray; height:26px; width:30px;" />
            <a id="getir" class="buton">Getir</a>
            <a class="buton" style="float:right;" id="yeni_teklif_buton">Yeni Teklif</a>
        </div>
        <table id="teklifler_tablo" class="display clickable grouptable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
            <thead>
                <tr>
                    <th style="width:40px;">Teklif No</th>
                    <th	style="width:280px;">Müşteri Ünvanı</th>
                    <th style="width:100px;">Yetkili</th>
                    <th style="width:100px;">Yetkili Telefonu</th>
                    <th style="width:150px;">Teklif Tarihi</th>
                    <th style="width:150px;">Satış Temsilcisi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <div id="yeni_teklif" style="display:none;" title="Yeni Teklif <span class='border'></span>">
                    <table class="input_table display" style="width:964px;">
                        
                        <tr>
                            <td style="width:80px;">
                                Satış Temsilcisi
                            </td>
                            <td style="width:350px;">
                                <input type="text" disabled="disabled" value="<?=$this->session->userdata('user_name');?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:80px;">
                                Teklif Tarihi
                            </td>
                            <td style="width:350px;">
                                <input type="text" class="tarih" id="y_offer_date" />
                            </td>
                        </tr>

                        <tr>
                            <td>Müşteri</td>
                            <td><select id="y_musteri_tip">
                                <option value="0" selected="selected">Yeni Müşteri</option><option value="1">Kayıtlı Müşteri</option>
                                </select>
                            </td>
                        </tr>

                        <tr class="yeni_musteri">
                            <td>Müşteri Ünvanı</td>
                            <td><input style="width:500px;" type="text" id="y_offer_customer_title"></td>
                        </tr>

                        <tr class="yeni_musteri">
                            <td>Müşteri Telefonu</td>
                            <td><input type="text" id="y_offer_customer_phone"></td>
                        </tr>


                        <tr class="kayitli_musteri" style="display:none;">
                            <td>Müşteri Ünvanı</td>
                            <td><select id="y_offer_customer_id" style="width:500px"></select></td>
                        </tr>

                        <tr>
                            <td>Yetkili İsmi</td>
                            <td style="width:350px;"><input type="text" id="y_offer_customer_agent_name"/></td>
                        </tr>

                        <tr>
                            <td>Yetkili Numarası</td>
                            <td style="width:350px;"><input type="text" id="y_offer_customer_agent_phone"/></td>
                        </tr>

                        <tr>
                            <td style="width:120px;">Notunuz<br><br><span style="font-size:11">Yalnızca sizin ve diğer personellerin görebileceği not alanı (Teklifte çıkmaz).</span></td><td><textarea id="y_not_text" style="width:80%; height:70px;"></textarea></td>
                        </tr>

                    </table>
                </div>
        </div>
    </div>

<? include('footer.php'); ?>