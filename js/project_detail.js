today = "asdf";

$(document).ready(function(){
    $.getJSON(base_url + "project_management/project_info/" + project_id + "/?html=html", function(JSON){
        $.each(JSON, function(span, fval){
            $('p#' + span).html(fval);
        });
    });
    
    $.getJSON(base_url + "project_management/status_list/", function(JSON){
        project_status = JSON;
    });
    
    $('#gorevler_tablo').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bRetrieve": true,
        "sAjaxSource": base_url + "project_management/tasks/" + project_id
    } );
    
    
    $("#y_task_feedback").live('change', function(){
        if($(this).val() != "0"){
            $(".feedback_user").slideDown();
        }else{
            $(".feedback_user").slideUp();
        }
    });
    
    // proje düzenleme fonksiyonları

    $("#proje_duzenle_buton").click(function(){
        $.getJSON(base_url + "personel_management/personels/", function(j){
            var options = '';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].user_id + '">' + j[i].user_name + '</option>';
            }
            $("select#d_project_user_id").html(options);
            
            options = "";
            for (var i = 0; i < project_status.length; i++){
                options += '<option value="' + i + '">' + project_status[i] + '</option>';
            }
            $("select#d_project_status").html(options);
            
                    
            $.getJSON(base_url + "project_management/project_info/" + project_id, function(JSON){
                $.each(JSON, function(span, fval){
                    $('#d_' + span).val(fval);
                });
            });
                
                
        });
                            
                            
        
        $("#proje_duzenle_buton, table#proje_bilgileri tr td p").fadeOut(500);
        setTimeout('$("#proje_vazgec_buton, #proje_kaydet_buton, table#proje_bilgileri tr td .editer").fadeIn(500)', 500);
        return false;
    });

    $("#proje_vazgec_buton").click(function(){
        $("#proje_vazgec_buton, #proje_kaydet_buton, table#proje_bilgileri tr td .editer").fadeOut(500);
        setTimeout('$("#proje_duzenle_buton, table#proje_bilgileri tr td p").fadeIn(500)', 500);
        return false;
    });
		
    $("#proje_kaydet_buton").click(function(){
        $.post(base_url + "project_management/edit_project/", {
            project_id : project_id,
            project_name : $("#d_project_name").val(),
            project_status : $("#d_project_status").val(),
            project_date1 : $("#d_project_date1").val(),
            project_date2 : $("#d_project_date2").val(),
            project_user_id : $("#d_project_user_id").val()
        }, function(data){
            $.getJSON(base_url + "project_management/project_info/" + project_id + "/?html=html", function(JSON){
                $.each(JSON, function(span, fval){
                    $('p#' + span).html(fval);
                    $('#d_' + span).val(fval);
                });
            });
                                             
            if(data == 1){
                $("#proje_vazgec_buton, #proje_kaydet_buton, table#proje_bilgileri tr td .editer").fadeOut(500);
                setTimeout('$("#proje_duzenle_buton, table#proje_bilgileri tr td p").fadeIn(500)', 500);
	
            }
        });
			
        return false;
    });

// görevler

    $("#y_gorev_buton").live('click', function(){
        $.getJSON(base_url + "project_management/get_project_start_date/" + project_id, function(j){
            $("#y_task_plannedStart").val(j[0]);
            $("#y_task_plannedFinish").val(j[1]);
        });

        $.getJSON(base_url + "personel_management/personels/", function(j){
            var options = '';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].user_id + '">' + j[i].user_name + '</option>';
            }
            $("select#y_task_user_id").html(options);
            $("select#y_task_feedback_user_id").html(options);
        });
        
        $("#yeni_gorev").dialog({width:"500px", modal: true,
            buttons: {
                "Vazgeç" : function(){
                    $(this).dialog("close");
                },
                "Kaydet" : function(){
                    if($("#y_task_user_id").val() == $("#y_task_feedback_user_id").val() && $("#y_task_feedback").val() != "0"){
                        alert("Görevin sorumlusu ve geri bildirim kullanıcısı aynı olamaz.");
                        return false;
                    }
                    $.post(base_url + "project_management/add_task/", {
                        task_project_id : project_id,
                        task_name : $("#y_task_name").val(),
                        task_not : $("#y_task_not").val(),
                        task_user_id : $("#y_task_user_id").val(),
                        task_plannedTime : $("#y_task_plannedTime").val(),
                        task_plannedStart : $("#y_task_plannedStart").val(),
                        task_plannedFinish : $("#y_task_plannedFinish").val(),
                        task_feedback : $("#y_task_feedback").val(),
                        task_feedback_user_id : $("#y_task_feedback_user_id").val()
                    },function(data){
                        alert(data);
                    });
                }
            }
        });
    });

    
    

});