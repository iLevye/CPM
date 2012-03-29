mysql = 0;
agent_id = null;
var customer = [];

function temsilciler(element, selected){
    $.getJSON(base_url + "personel_management/personels/", function(JSON){
        var str = "";
        for(var i in JSON){
            str += "<option value='" + JSON[i]['user_id'] + "'";
            if(selected == JSON[i]['user_id']){
                str += " selected='selected' ";
            }
            str += ">" + JSON[i]['user_name'] + "</option>";
        }
        $(element).html(str);
    });
}

function tagler(element){
    $(element).html("");
    $.getJSON(base_url + "customer_management/get_note_tags/", function(JSON){
        for(var i in JSON){
            $(element).append("<option value='" + JSON[i]['noteTag_id'] + "'>" + JSON[i]['noteTag_name'] + "</option>");
        }
    });
}


function sektorler(element, selected){
    $.getJSON(base_url + "customer_management/get_sectors/", function(JSON){
        var str = "";
        for(var i in JSON){
            str += "<option value='" + JSON[i]['sector_id'] + "'";
            if(selected == JSON[i]['sector_id']){
                str += " selected='selected' ";
            }
            str += ">" + JSON[i]['sector_name'] + "</option>";
        }
        $(element).html(str);
    });
}

function notlar(customer_id){
    $("#not_listesi").html("");
    $("#not_listesi").ajaxTemplate({
        source : base_url + "customer_management/get_notes/" + customer_id,
        template : "#not_template"
    });
}


function hostingler(){
    $("#y_hosting").html("<option value='0' selected='selected'>Başka bir firma</option>");
    $.getJSON(base_url + "customer_management/get_hostings/" + customer_id, function(JSON){
        for(var i in JSON){
            $("#y_hosting").append("<option value='" + JSON[i]['host_id'] + "'>" + JSON[i]['host_domain'] + "</option>");
        }
    });
}


function projeler(){
    
    if($("#y_hizmet").val() == "0"){
        $("#y_proje").html("<option value='' selected='selected'>Proje Yok</option>");
        $("#y_proje").append("<option value='yeni_proje'>Yeni Proje</option>");
    }else{
        $("#y_proje").html("<option value='yeni_proje' selected='selected'>Yeni Proje</option>");
    }
		
    $.getJSON(base_url + "customer_management/get_projects/" + customer_id, function(JSON){
        for(var i in JSON){
            $("#y_proje").append("<option value='" + JSON[i]['project_id'] + "'>" + JSON[i]['project_name'] + "</option>");
        }
    });

    proje_select();
}

function randomString() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    return randomstring;
}

function hizmet_select(){
    $(".option").hide();
		
    switch($("#y_hizmet").val())
    {
        case "1": // domain
            $(".domain_tr, .hosting_tr").show();
            $(".date1").html("Sözleşme Tarihi");
            $(".date2").html("Domain Kayıt Bitiş Tarihi");
            hostingler();
            break;
        case "2": // hosting
            $(".domain_tr, .host_data_tr, .mysql_olustur_tr").show();
            $(".date1").html("Hosting Başlangıç Tarihi");
            $(".date2").html("Hosting Bitiş Tarihi");
            break;
        case "3": // ATACFS
            $(".domain_tr, .atacfs_kota_tr").show();
            $(".date1").html("Sözleşme Başlangıç Tarihi");
            $(".date2").html("Sözleşme Bitiş Tarihi");
            break;
        case "4": // google adwords
            $(".domain_tr").show();
            $(".date1").html("Sözleşme Başlangıç Tarihi");
            $(".date2").html("Sözleşme Bitiş Tarihi");
            break;
        case "5": // google SEO
            $(".proje_tr, .proje_ozeti_tr").show();
            $(".yeni_proje_tr span").html("(Domainler)");
            $(".proje_ozeti_tr span").html("<br>(Anahtar kelimeler ve hedeflenen sıralar)");
            projeler();
            break;
        case "6": // Iphone yazılım
            $(".proje_tr, .proje_ozeti_tr").show();
            $(".yeni_proje_tr span").html("(Domainler)");
            $(".proje_ozeti_tr span").html("<br>(Uygulama hakkında kısa bilgi)");
            projeler();
            break;
        case "7": // Android Yazılım
            $(".proje_tr, .proje_ozeti_tr").show();
            $(".yeni_proje_tr span").html("(Domainler)");
            $(".proje_ozeti_tr span").html("<br>(Uygulama hakkında kısa bilgi)");
            projeler();
            break;
        case "8": // Web Sitesi
            $(".proje_tr, .proje_ozeti_tr").show();
            $(".yeni_proje_tr span").html("(Domainler)");
            $(".proje_ozeti_tr span").html("<br>(Tasarım hakkında genel bilgi / Varsa özel istekler)");

            $('.date1').html("Sözleşme Tarihi");
            $('.date2').html("Proje Teslim Tarihi");
            projeler();
            break;
        case "9": // Web Eklenti
            $(".proje_tr, .proje_ozeti_tr").show();
            $(".yeni_proje_tr span").html("(Domainler)");
            $(".proje_ozeti_tr span").html("<br>(Yapılacak güncellemeler hakkında genel bilgi)");
            projeler();
            break;
        case "10": // E-ticaret
            $(".date1").html("Hizmet Başlangıç Tarihi");
            $(".date2").html("Hizmet Bitiş Tarihi");
            $(".eticaret_tr, .domain_tr").show();
            break;
        case "0": // Diğer !!
            $(".domain_tr, .proje_tr").show();
                        
            projeler();
            break;	
        default:
            location.href = base_url + "error_report/send/undefined service key";
    }
		
}

function proje_select(){
    //projeler();
           
    if($("#y_proje").val() == "yeni_proje"){
        $(".yeni_proje_tr, .proje_ozeti_tr").show();
    }else{
        $(".yeni_proje_tr, .proje_ozeti_tr").hide();
    }
}


$(document).ready(function(){

    notlar(customer_id);


    $("#y_domain").autocomplete({
        source: base_url + "customer_management/get_domains/",
        minLength: 1
    });

    $("#y_user").autocomplete({
        source: base_url + "personel_management/get_users/",
        minLength: 1
    });

    $("#action_check").live('click', function(){
        $.post(base_url + "customer_management/check/", {customer_id: customer_id, checked : 1}, function(data){
            if(data > 0){
                $("#action_check").after("<img src='" + base_url + "images/checked.png' id='action_uncheck' />").remove();
            }
        });
    });

    $("#action_uncheck").live('click', function(){
        $.post(base_url + "customer_management/check/", {customer_id: customer_id, checked : 0}, function(data){
            if(data > 0){
                $("#action_uncheck").after("<img src='" + base_url + "images/unchecked.png' id='action_check' />").remove();
            }
        });
    });

    // müsteri notlari slider event 
        $(".alert").live('click', function(){
            var note_id = $(this).attr("note_id");
            var alert = $(".alert[note_id=" + note_id + "]");
            $(alert).next(".alert-detail").slideToggle(100).find("p").html("<img src='" + base_url + "images/loader.gif'>");

            $.getJSON(base_url + "customer_management/note_detail/" + note_id, function(JSON){
                var border_bottom = $(alert).attr("border-bottom");
                
                if(border_bottom != "true"){
                    $(alert).css("border-bottom", "none");
                    $(alert).attr("border-bottom", "true");
                }else{
                    $(alert).css("border-bottom", "1px solid #e2e2e2");
                    $(alert).attr("border-bottom", "false");
                }

                $(alert).next(".alert-detail").find("p").html(JSON['customerNote_note']);
            });

        });
		
    ///// müşteri düzenleme fonksiyonları
    $("#musteri_duzenle_buton").click(function(){
        $.each($(".editable"), function(index, element){
            if($(element).find("select").html() == undefined){
                val = $(element).find("p").html();
                key = $(element).attr("id");
                $(element).find("p").hide();
                $(element).append("<input type='text' class='line_input'>");
                $(element).find("input").val($.trim(val));
            }else{
                $(element).find("p").hide();
                $(element).find("select").fadeIn();
            }

            if($(element).attr("function") != undefined){
                eval($(element).attr("function"));
            }
        });

        $("#musteri_duzenle_buton").hide(500);
        $("#musteri_vazgec_buton, #musteri_kaydet_buton").fadeIn(500);
        return false;
    });

    $("#musteri_vazgec_buton").click(function(){
        $.each($(".editable"), function(index, element){
            val = $(element).find("p").val();
            key = $(element).attr("id");

            $(element).find("input").remove();
            $(element).find("p").fadeIn();
            $(element).find("select").hide();
        });
        $("#musteri_vazgec_buton, #musteri_kaydet_buton").hide(500);
        $("#musteri_duzenle_buton").fadeIn(500);
        return false;
    });
		
    $("#musteri_kaydet_buton").click(function(){

        $.post(base_url + "customer_management/edit/" + customer_id, {
            customer_title : $("#customer_title input").val(),
            customer_phone: $("#customer_phone input").val(),
            customer_fax : $("#customer_fax input").val(),
            customer_www : $("#customer_www input").val(),
            customer_email : $("#customer_email input").val(),
            customer_sector : $("#customer_sector select").val(),
            customer_address : $("#customer_address input").val(),
            customer_taxOffice : $("#customer_taxOffice input").val(),
            customer_taxNumber : $("#customer_taxNumber input").val(),
            customer_user_id : $("#customer_user_id select").val(),
            customer_status : $("#customer_status select").val(),
            agent_name : $("#agent_name input").val(),
            agent_phone : $("#agent_phone input").val(),
            agent_gsm : $("#agent_gsm input").val(),
            agent_email : $("#agent_email input").val(),
            agent_id : $("#agent_name").attr("agent_id")

        }, function(data){
            if(data == 1){
                $("#musteri_vazgec_buton, #musteri_kaydet_buton").fadeOut(500);
                $("#musteri_duzenle_buton").fadeIn(500);
                location.reload(true);
            }
        });
			
        return false;
    });

    ///// not fonksiyonları 
    $("#yeni_not_buton").live('click', function(){
        $.getJSON(base_url + "customer_management/get_note_tags", function(j){
            var options = '';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].noteTag_id + '">' + j[i].noteTag_name + '</option>';
            }
            $("select#y_not_tipi").html(options);
        });

        $("#yeni_not").dialog({
            width: "500px",
            buttons : {
                "Kaydet" : function(){
                    //$(this).validate();
                    //$(this).form_check();
                    if($("#y_not_tipi").val() == "yeni_tip"){
                        alert("Lütfen bir not kategorisi seçin.");
                        return false;
                    }
                    $.post(base_url + "customer_management/new_note", {
                        customer_id : customer_id,
                        category : $("#y_not_tipi").val(),
                        not : $("#y_not_text").val(),
                        date : $("#y_not_tarih").val(),
                        yetkili : $("#y_note_yetkili").val(),
                        important : $("#important:checked").val()

                    }, function(data){
                        if(data > 0){
                            alert("Notunuz eklendi");
                            $("#yeni_not").dialog("close");
                            notlar(customer_id);
                        }
                    });
                },
                "Vazgeç" : function(){
                    $(this).dialog("close");
                }
            }
        });
    });

    $("#yeni_etiket").live("click", function(){
            $("#yeni_not_tipi").dialog({
                width:"320px",
                buttons : {
                    "Ekle" : function(){
                        $.post(base_url + "customer_management/new_note_category/", {
                           title : $("#y_not_tipi_baslik").val()
                        },function(data){
                            if(data > 0){
                                $.getJSON(base_url + "customer_management/get_note_tags", function(j){
                                    var options = '';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].noteTag_id + '">' + j[i].noteTag_name + '</option>';
                                    }
                                    $("select#y_not_tipi").html(options);
                                    $("select#y_not_tipi option[value=" + data + "]").attr("selected", "selected");
                                    $("#yeni_not_tipi").dialog("close");
                                });
                            }
                        });
                    },
                    "Vazgeç" : function(){

                        $("select#y_not_tipi option:first-child").attr("selected", "selected");
                        $(this).dialog("close");
                    }
                }
            });
    });

    $("#not_filtre_buton").live('click', function(){
        tagler("#filtre_select");
        $("#not_filtre").slideToggle();
    });

    $("#get_filtre").live('click', function(){
        var str = $("#filtre_select").val();
        var new_str = str.join("-");

        notlar(customer_id + "/" + new_str);
    });
		
		

		
		
    // tabları oluştur
    $( "#tabs" ).tabs({
        ajaxOptions: {
            selected: '0',
            width: '1000px',
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                    "If this wouldn't be a demo." );
            }
        }
    }).find( ".ui-tabs-nav" ).sortable({
        axis: "x"
    });

    // Sekme eventları
    $('#tabs').bind('tabsselect', function(event, ui) {
        
        switch(ui.index){
            case 1: // Ödemeler
                $('#odemeler_tablo').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,
                    "sAjaxSource": base_url + "customer_management/payments/" + customer_id
                } );
                break;
            case 2: // Projeler
                $('#projeler_tablo').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,
                    "sAjaxSource": base_url + "customer_management/projects/" + customer_id
                } );
                break;
            case 3: // Firma Yetkilileri
                $('#yetkililer_tablo').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,
                    "sAjaxSource": base_url + "customer_management/agents/" + customer_id
                } );
        }
                
    });
    
		
    // notları akordiyon yap
    $("#not_listesi").accordion({
        icons: false
    });

    // hizmetler tablosunu oluştur
    $('#hizmetler_tablo').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bRetrieve": true,
        "bPaginate": false,
        "sAjaxSource": base_url + "customer_management/services/" + customer_id,
        "fnDrawCallback" : function() {
            $("#hizmetler_tablo span.hizmet_baslik").parents("tr").css({"border-bottom":"2px solid #b5dfa3", "color":"#41742c", "background" : "#ddfad1"});
            $("#hizmetler_tablo span.hizmet_baslik").parents("tr").find("td").css({"padding":"16px 0 16px 8px"});
        }
    });

    // yeni ödeme penceresi
    $("#yeni_odeme_buton").live('click', function(){
        $("#yeni_odeme").dialog({
            modal:true, 
            width: "500px"
        });
        return false;
    });
                
    $("#odeme_kanali").live('change', function(){
        var odeme_kanali = $("#odeme_kanali").val();
        if(odeme_kanali == "3"){
            $("#cek_vaade_tr").fadeIn();
        }else{
            $("#cek_vaade_tr").fadeOut();
        }
    });

    // yeni hizmet penceresi
    $("#yeni_hizmet_buton").live('click', function(){
        proje_select();
        hizmet_select();
			
        $("#yeni_hizmet").dialog({
            modal:true, 
            width:"500px"
        });
        return false;
    });

    // mysql oluştur fonksiyonları
    $(".mysql_olustur_tr td .olustur").live('click', function(){
        $(".mysql_data_tr").fadeIn();
        $(".mysql_olustur_tr .olustur").hide();
        $(".mysql_olustur_tr .vazgec").show();
        $(".ekle_tr").css({
            "border-top": "2px solid gray"
        });
        $(".mysql_olustur_tr").css({
            "border-bottom": "none"
        });
        mysql = 1;
        return false;
    });

    $(".mysql_olustur_tr td .vazgec").live('click', function(){
        $(".mysql_data_tr").fadeOut();
        $(".mysql_olustur_tr .olustur").show();
        $(".mysql_olustur_tr .vazgec").hide();
        $(".ekle_tr").css({
            "border-top": "none"
        });
        $(".mysql_olustur_tr").css({
            "border-bottom": "2px solid gray"
        });
        mysql = 0;
        return false;
    });

    $(".domain_tr").live("keyup", function(){
        var data = $("#y_domain").val().split(".");
        try {
            if(data[1] != ""){
                sol = data[0].substr("0", 15 - data[1].length);
                sag = data[1].substr("0", 15 - sol.length);
                $("#y_mysql_dbname, #y_mysql_username").val(sol + "." + sag);
                $("#y_mysql_pass").val(randomString());
            }
        }catch(error){
        // kullanıcı nokta yazmadığında data[1] boş olduğu için hata veriyor.
        }
			
    });

		

		

    // kdv hesaplama
    $("#y_kdv, #y_ucret").live('keyup', function(){
        $("#y_toplam_tutar").val( Math.round( (parseFloat($("#y_ucret").val() * ($("#y_kdv").val() / 100)) + parseFloat($("#y_ucret").val())) * 100 )  / 100);
        if($("#y_toplam_tutar").val() == "NaN"){
            $("#y_toplam_tutar").val("0");
        }
    });

    $("#y_toplam_tutar").live('keyup', function(){
        $("#y_ucret").val( Math.round(($("#y_toplam_tutar").val() / 118 * 100) * 100) / 100 );
    });

    // kalan tutar hesaplama
    $("#y_alinan_tutar").live("keyup", function(){
        $("#y_kalan_tutar").val($("#y_toplam_tutar").val() - $("#y_alinan_tutar").val());
    });

    // hizmete göre inputlar
    $("#y_hizmet").live('change', function(){
        hizmet_select();
    });

    // hizmet ekle action
    $("#hizmet_ekle_buton").live('click', function(){
        $.post(base_url + "customer_management/add_service", 
        {
            customer_id:	customer_id,
            hizmet: 		$("#y_hizmet").val(),
            domain: 		$("#y_domain").val(),
            host: 			$("#y_hosting").val(),
            proje: 			$("#y_proje").val(),
            proje_adi: 		$("#y_proje_adi").val(),
            proje_ozeti:	$("#y_proje_ozeti").val(),
            admin_isim:		$("#y_isim_soyisim").val(),
            admin_eposta:	$("#y_eposta").val(),
            admin_sifre:	$("#y_sifre").val(),
            site_grubu: 	$("#y_site_grubu").val(),
            tutar:			$("#y_ucret").val(),
            kdv:			$("#y_kdv").val(),
            toplam_tutar:	$("#y_toplam_tutar").val(),
            date1:			$("#y_date1").val(),
            date2:			$("#y_date2").val(),
            kota:			$("#y_kota").val(),
            ftp_username:	$("#y_ftp_username").val(),
            ftp_pass:		$("#y_ftp_password").val(),
            sozlesme_notu:	$("#y_not").val(),
            mysql:			mysql,
            mysql_dbname:	$("#y_mysql_dbname").val(),
            mysql_username: $("#y_mysql_username").val(),
            mysql_pass:		$("#y_mysql_pass").val()
						
        }, function(data){
            alert(data);
        });
        return false;
    });
    
    
    // yeni proje
    $("#yeni_proje_buton").live('click', function(){
        $.getJSON(base_url + "personel_management/personels/", function(j){
            var options = '';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].user_id + '">' + j[i].user_name + '</option>';
            }
            $("select#proje_yoneticisi").html(options);

        });
        $("#yeni_proje").dialog({modal:true, width:'430px', buttons:{
            "Vazgeç" : function(){
                $(this).dialog("close");
            },
            "Oluştur" : function (){
                $.post(base_url + "project_management/new_project/", {
                    project_customer_id : customer_id,
                    project_name : $("#proje_adi").val(),
                    project_date1 : $("#proje_baslangic").val(),
                    project_date2 : $("#proje_bitis").val(),
                    project_user_id : $("#proje_yoneticisi").val()
                }, function(data){
                    if(data > 0){
                        alert("Proje oluşturuldu");
                    }else{
                        alert("Bir sorun oluştu");
                    }
                });
            }
        }});
    });
    
                
    // proje seçimi
    $("#y_proje").live('change', function(){
        proje_select();
    });

    // proje tikkk
    $("#projeler_tablo tr").live('click', function(){
        project_id = $(this).find("td:first span").attr("project_id");
        if(project_id == null){
            return false;
        } 
        
        location.href = base_url + "project_management/detail/" + project_id; 
    });

    // yetkili düzenleme
    
    $("#yetkililer_tablo tr").live('click', function(){
        agent_id = $(this).find("td:first span").attr("agent_id");
        if(agent_id == null){
            return false;
        }
        $("#yetkili_edit").dialog({
            modal:true, 
            width:'430px',
            buttons:{
                "Yetkiliyi Sil" : function(){
                    $("#yetkili_sil_confirm").dialog({
                        modal:true,
                        buttons:{
                            "Sil" : function(){
                                $.post(base_url + "customer_management/remove_agent/",{agent_id : agent_id}, function(data){
                                    if(data == 1){
                                        $("#notice").html("Yetkili silindi");
                                        $("#notice").dialog({
                                            modal:true, 
                                                buttons: {
                                                    "Tamam" : function(){
                                                        $("#notice, #yetkili_sil_confirm, #yetkili_sil_buton, #yetkili_edit").dialog( "close" );
                                                    }
                                                }
                                        });
                                    }
                                });
                            },
                            "Vazgeç" : function(){
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                },
                "Güncelle" : function(){
                    $.post(base_url + "customer_management/edit_agent/",
                    {
                        agent_id : agent_id,
                        agent_name : $("#d_agent_name").val(),
                        agent_phone : $("#d_agent_phone").val(),
                        agent_gsm : $("#d_agent_gsm").val(),
                        agent_email : $("#d_agent_email").val(),
                        agent_title : $("#d_agent_title").val()
                    },function(data){
                        alert(data);
                    }); 
                }
            }
        });
        $.getJSON(base_url + "customer_management/get_agent/" + agent_id, function(JSON){
            $.each(JSON, function(key, val){
                $("#yetkili_edit tr td #d_" + key).val(val);
            });
        });
    });
	

    $("#yetkili_ekle_buton").live('click', function(){
        $("#yetkili_ekle").dialog({
           modal:true,
           width:'430px',
           buttons:{
               "Ekle" : function(){
                   $.post(base_url + "customer_management/add_agent/",
                    {
                        agent_customer_id : customer_id,
                        agent_name : $("#y_agent_name").val(),
                        agent_phone : $("#y_agent_phone").val(),
                        agent_gsm : $("#y_agent_gsm").val(),
                        agent_email : $("#y_agent_email").val(),
                        agent_title : $("#y_agent_title").val()
                    },function(data){
                        alert(data);
                    }); 
               },
               "Vazgeç" : function(){
                    $( this ).dialog( "close" );
                }
           }
        });
    });

		
		
});