<? include('header.php'); ?>

<style>
    #projeler_tablo tr td {cursor:pointer;}
    #projeler_tablo tr:hover {border-bottom:1px solid gray;}
    table#musteri_bilgileri tr td .editer {display:none;}
    #note {border:1px solid gray; border-radius: 3px; background:#ff4545; font-weight:thin; font-size:12px; color:white; font-family:sans-serif; padding:10px;}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
        {
            if ( typeof sNewSource != 'undefined' && sNewSource != null )
            {
                oSettings.sAjaxSource = sNewSource;
            }
            this.oApi._fnProcessingDisplay( oSettings, true );
            var that = this;
            var iStart = oSettings._iDisplayStart;

            oSettings.fnServerData( oSettings.sAjaxSource, [], function(json) {
                /* Clear the old information from the table */
                that.oApi._fnClearTable( oSettings );

                /* Got the data - add it to the table */
                var aData =  (oSettings.sAjaxDataProp !== "") ?
                    that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;

                for ( var i=0 ; i<json.aaData.length ; i++ )
                {
                    that.oApi._fnAddData( oSettings, json.aaData[i] );
                }

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                that.fnDraw();

                if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
                {
                    oSettings._iDisplayStart = iStart;
                    that.fnDraw( false );
                }

                that.oApi._fnProcessingDisplay( oSettings, false );

                /* Callback user function - for event handlers etc */
                if ( typeof fnCallback == 'function' && fnCallback != null )
                {
                    fnCallback( oSettings );
                }
            }, oSettings );
        }

        oTable = $('#hizmetler_tablo').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "bRetrieve": true,
                "bPaginate": false,
                "sAjaxSource": base_url + "lister/customer_services_data/" + 30,
                "fnDrawCallback" : function() {
                    $("#hizmetler_tablo span.hizmet_baslik").parents("tr").css({"cursor":"pointer", "border-bottom":"2px solid #b5dfa3", "color":"#41742c", "background" : "#ddfad1"});
                    $("#hizmetler_tablo span.hizmet_baslik").parents("tr").find("td").css({"padding":"16px 0 16px 8px"});
                }
            });

        $("#getir").live('click', function(){
            oTable.fnReloadAjax(base_url + "lister/customer_services_data/" + $("#day").val());
        });

        $("#hizmetler_tablo tr").live('click', function(){
            musteri_id = $(this).find("td:first-child span").attr("row_id");
            if(musteri_id == undefined){
                return false;
            }
            location.href = base_url + "customer_management/detail/"+ musteri_id;
        });

        $("#hizmetler_tablo tr").live('mouseenter', function(e){
            var service_id = $(this).find("td:first-child span").attr("service_id");
            if(service_id == undefined){
                return false;
            }

            $.getJSON(base_url + "lister/get_service_note/" + service_id, function(JSON){
                if(JSON['customerService_note'] == ""){
                    return false;
                }
                
                $("body").append("<div id='note' style='z-index:999; position:absolute; left:" + (e.pageX + 20) + "; top:" + e.pageY + ");'>" + JSON['customerService_note'] + "</div>");
                $("#note").css({"left" : (e.pageX + 20), "top" :  e.pageY}).html(JSON['customerService_note']);
            });
        }); 

        $("#hizmetler_tablo tr").live('mouseleave', function(e){
            $("#note").remove();
        });
        
    });
</script>
<? $this->load->javascript("jquery.ajaxTemplate"); ?>
<? $this->load->javascript('customer_detail'); ?>

<div id="notice"></div>
    
    <div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
       
                        <div style="width:100%; float:left;"><input type="text" id="day" style="border:1px solid gray; height:26px; width:30px;" /> <a id="getir" class="buton">Getir</a></div>

                        <table id="hizmetler_tablo" class="display clickable grouptable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
                            <thead>
                                <tr>
                                    <th style="width:40px;">Müşteri No</th>
                                    <th	style="width:280px;">Müşteri Ünvanı</th>
                                    <th style="width:100px;">Diğer</th>
                                    <th style="width:100px;">Hizmet</th>
                                    <th style="width:150px;">Başlangıç</th>
                                    <th style="width:150px;">Bitiş</th>
                                    <th>Sunucu</th>
                                    <th>Yayın</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    

                    
    </div>

<? include('footer.php'); ?>