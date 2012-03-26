departments = "";

function tl_get(divID){
    data = parseFloat($("#" + divID).val());
    if(isNaN(data)){
        return parseFloat("0");
    }else{
        return data;
    }
}

$(document).ready(function() {

				
    // Kullanıcı Listesi Tablosu
    $('#myTable').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bRetrieve": true,
        "sAjaxSource": base_url + "personel_management/get_list/"
    } );



    // Sekme eventları
    $('#tabs').bind('tabsselect', function(event, ui) {
        
        switch(ui.index){
            case 1: // Yetkiler
                newlink = document.createElement('link');
                newlink.setAttribute('rel', 'stylesheet');
                newlink.setAttribute('type', 'text/css');
                newlink.setAttribute('href', base_url + 'css/jquery.tree.css');
                newlink.setAttribute('media', 'screen');

                head = document.getElementsByTagName("head").item(0);
                head.appendChild(newlink);

                $('#yetki_agaci').tree({
                    components: ['checkbox', 'collapse']
                });

                /*tree({ 
                        }
                        components: ['checkbox'], 
                        onCheck: { 
                            node : 'collapse',
                            ancestors: 'checkIfFull', 
                            descendants: 'check'}, 
                        onUncheck: { 
                            ancestors: 'uncheck'} 
                    }); */
                $("#yetki_agaci input").attr('checked', false);            
                break;
            case 3: // Maaş tablosu
                $('#maas_table').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,                        
                    "sAjaxSource": base_url + "personel_management/get_salaries/" + row_id + "/"
                } );
            case 2: // görev tablosu
                $('#personel_task').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,
                    "iDisplayLength" : 10,
                    "sAjaxSource": base_url + "personel_management/get_tasks/" + row_id
                } );

            case 4: // izin dökümü
                $('#dayoff_table').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bRetrieve": true,
                    "iDisplayLength" : 10,
                    "sAjaxSource": base_url + "personel_management/list_offdays/" + row_id
                } );

                break;
        }
                
    });



        
        
    // Yetki Şablonları
    $("#sablon_select").live('change', function(){
        $("#yetki_agaci input").attr('checked', false);
            
        var sablon_val = $("#sablon_select").val();

        if(sablon_val == "1"){ // standart yetki
            $('.t_musteriler .in input, .t_musteriler .out .read input, .t_personel .in .read input, .t_rehber .read input').attr('checked', true);
        }else if(sablon_val == "2"){ // Müşteri yönetimi yetkisi
            $('.t_musteriler input, .t_personel .in .read input, .t_personel .out .read input, .t_rehber input').attr('checked', true);
        }
    });


    // Maaş Hesapla - Ekle - sil
    $("#yeni_maas_odeme td input").live('keyup', function(){
        var odenen_maas =  tl_get("net_maas") + tl_get('agi') + tl_get("yol_yemek") + tl_get("prim") - tl_get("avans") - tl_get("kesinti");
        $("#odenen_maas").val(odenen_maas);
        $("#maliyet").val(odenen_maas + tl_get("sigorta") + tl_get("avans"));
    });
    
    $("#maas_ekle_buton").live('click', function(){
        $.post(base_url + "personel_management/add_salary/" + row_id, {
            odeme_tarihi : $("#odeme_tarihi").val(),
            odenen_maas : $("#odenen_maas").val(),
            net_maas : $("#net_maas").val(),
            agi : $("#agi").val(),
            yol_yemek : $("#yol_yemek").val(),
            prim : $("#prim").val(),
            avans : $("#avans").val(),
            kesinti : $("#kesinti").val(),
            sigorta : $("#sigorta").val(),
            maliyet : $("#maliyet").val()
        }, function(data){
            alert(data);
        });
    });


    $(".maas_sil").live('click', function(){
        if(!confirm("Maaş bilgisi silinecek ! Emin misiniz ?")){
            return false;
        }
        maas_id = $(this).attr("salary_id");
        $.post(base_url + "personel_management/delete_salary/", {salary_id : maas_id}, function(data){
            if(data > 0){
                alert("Maaş bilgisi silindi");
            }
        })
    });



    ///// personel düzenleme fonksiyonları
    $("#personel_duzenle_buton").click(function(){
        if(departments == ""){
            $.getJSON(base_url + "department_management/get_departments/" + row_id, function(j){
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].department_id + '">' + j[i].department_name + '</option>';
                }
                $("select#d_user_department_id").html(options);
                                
                $.getJSON(base_url + "personel_management/personel_info/" + row_id, function(JSON){
                    $.each(JSON, function(span, fval){
                        $('#d_' + span).val(fval);
                    });
                });
            });
                            
                            
        }
        $("#personel_duzenle_buton, table#personel_bilgileri tr td p").fadeOut(500);
        setTimeout('$("#personel_vazgec_buton, #personel_kaydet_buton, table#personel_bilgileri tr td .editer").fadeIn(500)', 500);
        return false;
    });

    $("#personel_vazgec_buton").click(function(){
        $("#personel_vazgec_buton, #personel_kaydet_buton, table#personel_bilgileri tr td .editer").fadeOut(500);
        setTimeout('$("#personel_duzenle_buton, table#personel_bilgileri tr td p").fadeIn(500)', 500);
        return false;
    });
		
    $("#personel_kaydet_buton").click(function(){
			
                        
        $.post(base_url + "personel_management/edit_personel/", {
            user_id : row_id,
            user_email : $("#d_user_email").val(),
            user_name : $("#d_user_name").val(),
            user_address : $("#d_user_address").val(),
            user_phone : $("#d_user_phone").val(),
            user_gsm : $("#d_user_gsm").val(),
            user_title : $("#d_user_title").val(),
            user_department_id : $("#d_user_department_id").val(),
	
        }, function(data){
            $.getJSON(base_url + "personel_management/personel_info/" + row_id, function(JSON){
                $.each(JSON, function(span, fval){
                    $('p#' + span).html(fval);
                    $('#d_' + span).val(fval);
                });
            });
                                             
            if(data == 1){
                $("#personel_vazgec_buton, #personel_kaydet_buton, table#personel_bilgileri tr td .editer").fadeOut(500);
                setTimeout('$("#personel_duzenle_buton, table#personel_bilgileri tr td p").fadeIn(500)', 500);
					 		
            }
        });
			
        return false;
    });


    // yeni odeme
    $("#yeni_odeme_buton").live('click', function(){
        $("#yeni_odeme").dialog({
            width: '400px'
        });
    });

    // yeni izin
    $("#yeni_izin_buton").live('click', function(){
        $("#yeni_izin").dialog({
            width: '536px',
            buttons : {
                "Vazgeç" : function(){
                    $(this).dialog("close");
                },
                "Ekle" : function(){
                    $.post(base_url + "personel_management/add_dayoff", {
                        dayoff_start : $("#y_dayoff_start").val(),
                        dayoff_finish : $("#y_dayoff_finish").val(),
                        dayoff_user : row_id
                    }, function (data){
                        alert("İzin kaydı eklendi.");
                        $("#yeni_izin").dialog("close");
                    });
                }
            }
        });
    });

    // izin sil

    $(".izin_sil_buton").live('click', function(){
        dayoff_id = $(this).attr("dayoff_id");
        if(!confirm("İzin kaydını silmek istediğinize emin misiniz ?")){
            return false;
        }
        $.post(base_url + "personel_management/delete_dayoff/", {dayoff_id: dayoff_id}, function(data){
            if(data > 0){
                alert("İzin kaydı silindi");
            }
        });
    });


				
    // Yeni Kullanıcı Kaydı !!
    $("#yeni_kayit_buton").live('click', function(){
        $("#yeni_kayit_penceresi").dialog({
            width: '400px', 
            buttons: [

            {
                text: "Vazgeç",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                text: "Kaydet",
                click: function() { 
                    $(this).dialog("close");
                    $.post(base_url + "personel_management/new_personel", {
                        isim: $("#y_personel_isim").val(),
                        eposta : $("#y_personel_eposta").val(),
                        telefon : $("#y_personel_telefon").val(),
                        gsm : $("#y_personel_gsm").val(),
                        title : $("#y_personel_title").val(),
                        adres : $("#y_personel_adres").val(),
                        yetki : $("#y_personel_yetki").val(),
                        departman : $("#y_personel_departman").val()
								                                                  		
                    }, function(data){
                        alert("sonuc" + data);
                    });
                }
            }
					                                              
            ]
            });
					
    });


    // tab açma !!
    $("#myTable tr").live('click', function(){
        
        // tabları oluştur
        $("#tabs").tabs({
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
            
        // row id yi al
        row_id = $(this).children("td:first").html();
        if(row_id == null){
            return false;
        }
            
        $( "#tabs" ).tabs( "option", "selected", 0 );
					
        $("#kayit_bilgi_penceresi").dialog({
            modal:true,
            width: '1000px'
        });
        $.getJSON(base_url + "personel_management/personel_info/" + row_id, function(JSON){
            $.each(JSON, function(span, fval){
                $('p#' + span).html(fval);
            });
        });

					
    } );
} );