<? include('header.php'); ?>

<style>
    #projeler_tablo tr td {cursor:pointer;}
    #projeler_tablo tr:hover {border-bottom:1px solid gray;}
    table#musteri_bilgileri tr td .editer {display:none;}
    #note {border:1px solid gray; border-radius: 3px; background:#ff4545; font-weight:thin; font-size:12px; color:white; font-family:sans-serif; padding:10px;}
</style>
<script src="<?=base_url()?>js/jquery.uploadify.v2.1.4.min.js"></script>
<script src="<?=base_url()?>js/swfobject.js"></script>

<script type="text/javascript">
var dosyalar = "";
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
                "Vazgeç" : function(){
                    $("#yeni_teklif").dialog("close");
                },
                "Kaydet" : function(){
                    $.post(base_url + "offer_management/new_offer/", {
                        offer_date : $("#y_offer_date").val(),
                        musteri_tip : $("#y_musteri_tip").val(),
                        offer_customer_title : $("#y_offer_customer_title").val(),
                        offer_customer_phone : $("#y_offer_customer_phone").val(),
                        offer_customer_id : $("#y_offer_customer_id").val(),
                        offer_customer_agent_name : $("#y_offer_customer_agent_name").val(),
                        offer_customer_agent_phone : $("#y_offer_customer_agent_phone").val(),
                        offer_note : $("#y_offer_note").val(),
                        dosyalar : dosyalar
                    }, function(data){
                        if(data > 0){
                            alert("Teklif oluşturuldu.");
                            $("#yeni_teklif").dialog("close");
                        }
                    });
                }
            }})
        });

        $('#uploadify').uploadify({
            'buttonText' : "Teklif Dosyasi",
            'uploader'  : base_url + 'js/uploadify.swf',
            'script'    : base_url + 'file_management/upload_file/offer',
            'cancelImg' : base_url + '/images/cancel.png',
            'folder'    : '',
            'auto'      : true,
            'multi'     : true,
            'queueID'        : 'custom-queue',
            'queueSizeLimit' : 10,
            'simUploadLimit' : 10,
            'sizeLimit'   : 102400,
            'removeCompleted': false,
            'onComplete' : function(event, ID, fileObj, response, data){
                    $("#uploaded_files").slideDown();
                    if(dosyalar == ""){
                        dosyalar = response;
                    }else{
                        dosyalar += "," + response;
                    }
                    html = $("#yuklenen_dosyalar").html();
                    $("#yuklenen_dosyalar").html(html + "<li>" + response + "</li>");
                }
        });

        $("#teklifler_tablo tr").live('click', function(){
            var teklif_id = $(this).find("td:first").html();
            if(teklif_id == undefined){
                return false;
            }
            $("#teklif_goster").dialog({modal:true, width:600, buttons:{
                "Kapat" : function(){
                    $(this).dialog("close");
                }
            }})
            $.getJSON(base_url + "offer_management/get_offer/" + teklif_id, function(JSON){
                $("#d_user_name").html(JSON['offer']['user_name']);
                $("#d_offer_date").html(JSON['offer']['offer_date']);
                if(JSON['offer']['offer_customer_id'] == null){
                    $("#d_customer_title").html(JSON['offer']['offer_customer_title']);
                    $("#d_customer_phone").html(JSON['offer']['offer_customer_phone']);
                }else{
                    $("#d_customer_title").html(JSON['offer']['customer_title']);
                    $("#d_customer_phone").html(JSON['offer']['customer_phone']);
                }
                $("#d_customer_agent_name").html(JSON['offer']['offer_customer_agent_name']);
                $("#d_customer_agent_phone").html(JSON['offer']['offer_customer_agent_phone']);
                $("#d_offer_note").html(JSON['offer']['offer_note']);

                $("#d_yuklenen_dosyalar").html("");
                for(var i in JSON['files']){
                    $("#d_yuklenen_dosyalar").append("<li><a href='" + base_url + "uploaded_files/" + JSON['files'][i]['file_name'] + "'>" + JSON['files'][i]['file_name'] + "</a></li>");
                };

            });
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
                    Teklifi İleten
                </td>
                <td style="width:350px;">
                    <input type="text" disabled="disabled" value="<?=$this->session->userdata('user_name');?>"/>
                </td>
            </tr>

            <tr>
                <td>Teklif dosyası</td>
                <td>
                    <input type="file" id="uploadify" />
                </td>
            </tr>

            <tr id="uploaded_files" style="display: none">
                <td>Yüklenen Dosyalar</td>
                <td><ul id="yuklenen_dosyalar"></ul></td>
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
                <td style="width:120px;">Notunuz<br><br><span style="font-size:11">Yalnızca sizin ve diğer personellerin görebileceği not alanı (Teklifte çıkmaz).</span></td><td><textarea id="y_offer_note" style="width:80%; height:70px;"></textarea></td>
            </tr>
        </table>
    </div>


    <div id="teklif_goster" style="display:none;" title="Teklif Detayı <span class='border'></span>">
        <table class="input_table display" style="width:564px;">
            <tr>
                <td style="width:140px;">
                    Teklifi İleten
                </td>
                <td>
                    <span id="d_user_name"></span>
                </td>
            </tr>

            <tr>
                <td>Teklif Dosyaları</td>
                <td><ul id="d_yuklenen_dosyalar"></ul></td>
            </tr>
            
            <tr>
                <td>
                    Teklif Tarihi
                </td>
                <td>
                    <span id="d_offer_date"></span>
                </td>
            </tr>

            <tr>
                <td>Müşteri Ünvanı</td>
                <td><span id="d_customer_title"></span></td>
            </tr>

            <tr>
                <td>Müşteri Telefonu</td>
                <td><span id="d_customer_phone"></span></td>
            </tr>

            <tr>
                <td>Yetkili İsmi</td>
                <td><span id="d_customer_agent_name"></span></td>
            </tr>

            <tr>
                <td>Yetkili Numarası</td>
                <td><span id="d_customer_agent_phone"></span></td>
            </tr>

            <tr>
                <td>Teklif Notu</td>
                <td><span id="d_offer_note"></span></td>
            </tr>
        </table>
    </div>


</div>

<? include('footer.php'); ?>