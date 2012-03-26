<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <title>ATA CRM</title> 

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/grid.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/pfdin.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/Aristo/Aristo.css" media="screen" />
        <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/tema1/jquery-ui-1.8.16.custom.css" media="screen" /> -->

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/demo_table.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/stylesaaa.css" media="screen" /> 
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css" media="screen" /> 




        <? /*        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.wysiwyg.css" media="screen" /> 
          <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/tablesorter.css" media="screen" />
          <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/theme-blue.css" media="screen" />
         */ ?>

        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.7.1.min.js"></script> 
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.16.custom.min.js"></script>  
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.dataTables.js"></script> 
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.dataTables.fnReloadAjax.js"></script> 
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.ajaxTemplate.js"></script> 


        <script type="text/javascript"> 
            base_url = "<?= base_url(); ?>";

            $(document).ready(function() { 
                $(".buton").button();
                $("input.tarih").datepicker({ dayNames: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'], 
                    monthNames : ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                    monthNamesShort : ['Ock', 'Şbt', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Agu', 'Eyl', 'Ekm', 'Kas', 'Ara'],
                    dayNamesMin : ['Pz', 'Pt', 'Sl', 'Çr', 'Pr', 'Cm', 'Ct'],
                    dateFormat : "dd MM yy",
                    firstDay : 1
                });

                $("tr").hover(
                    function () {
                        $(this).addClass("hover");
                        $(this).children("")
                    },
                    function () {
                        $(this).removeClass("hover");
                    }
                );
                
                $("#menu ul").sortable({
                    update: function(event, ui) {
                        // This will trigger after a sort is completed
                        var ordering = "";
                        var $columns = $("#menu ul li");
                        $columns.each(function() {
                          ordering += this.id + "=" + $columns.index(this) + ";";
                        });
                        $.cookie("ordering", ordering);
                    }

                });

                $("#musteri_ara").autocomplete({
                    source: base_url + "customer_management/basic_search/",
                    minLength: 1,
                    select: function(event, ui) {
                        location.href = base_url + "customer_management/detail/" + ui.item.id;
                    }
                });

                $("#musteri_ara").live('focus', function(){
                    if($(this).val() == "Müşteri ara..."){
                        $(this).val("");
                    }
                });

                $("#musteri_ara").live('focusout', function(){
                    if($(this).val() == ""){
                        $(this).val("Müşteri ara...");
                    }
                });

                /*
                $("#musteri_ara").live('keyup', function(){
                    $("#musteri_ara_sonuclar ul").html("");
                    if($(this).val() == "Müşteri ara..." || $(this).val() == ""){
                        $("#musteri_ara_sonuclar").slideUp();
                        return false;
                    }else{
                        $("#musteri_ara_sonuclar").slideDown();
                    }

                    $("#musteri_ara_sonuclar ul").html("");
                    $("#musteri_ara_sonuclar ul").ajaxTemplate({
                        source : base_url + "customer_management/basic_search/" + $(this).val(), 
                        template : "#musteri_ara_li_template"
                    });
                });

                $("#musteri_ara").live('focus', function(){
                    if($(this).val() == "Müşteri ara..."){
                        $(this).val("");
                    }
                });

                $("#musteri_ara").live('focusout', function(){
                    if($(this).val() == ""){
                        $(this).val("Müşteri ara...");
                    }
                });

                $("#musteri_ara_sonuclar ul li").live('click', function(){
                    location.href = base_url + "customer_management/detail/" + $(this).attr("customer_id");
                });

                */
            }); 
        </script> 



    </head>
    <body>


<div id="top-bar">
    <div id="top-info">
        <img src="<?=base_url()?>images/user-icon.png" /><span><?= $this->session->userdata('user_name') ?></span>
    </div>
</div>



<div id="menu">
    <div id="logo">
        <img src="<?=base_url()?>images/logo.png" onclick="location.href = '<?= base_url() ?>home'" style=" cursor:pointer;">
    </div>
    <ul>
    <? $url = uri_string();?>
        <li class="first <?if(strrpos($url, "customer_management") === 0){echo " active ";}?>" onclick="location.href='<?= base_url() ?>customer_management/'">Müşteriler</li>
        <li <?if(strrpos($url, "personel_management") === 0){echo " class='active' ";}?> onclick="location.href='<?= base_url() ?>personel_management/'">Personeller</li>
        <li <?if(strrpos($url, "project_management") === 0){echo " class='active' ";}?> >Projeler</li>
        <li <?if(strrpos($url, "contacts") === 0){echo " class='active' ";}?> onclick="location.href='<?= base_url() ?>contacts/'">Rehber</li>
        <li <?if(strrpos($url, "customer_service") === 0){echo " class='active' ";}?> onclick="location.href='<?= base_url() ?>lister/customer_service/'">Sözleşmeler</li>
        <li <?if(strrpos($url, "offer_management") === 0){echo " class='active' ";}?> onclick="location.href='<?= base_url() ?>offer_management/'">Teklifler</li>
        <li>Servisler</li>
        <li>Fiyat Listesi</li>
        <li class="last">Hizmetler</li>
    </ul>
    <input type="text" style="height:34px;" value="Müşteri ara..." id="musteri_ara">
</div>

<?/*
        <div id="header" style="float:left;"> 
            <img src="<?= base_url(); ?>images/themes/blue/logo.gif" id="logo" onclick="location.href = '<?= base_url() ?>home'" style="float:left; cursor:pointer;">

                <div style="float:left; margin-top:6px;">
                    <a href="<?= base_url() ?>customer_management/" class="buton">Müşteriler</a>
                    <a href="<?= base_url() ?>personel_management/" class="buton">Personeller</a>
                    <a href="<?= base_url() ?>" class="buton">Projeler</a>
                    <a href="<?= base_url() ?>" class="buton">Rehber</a>
                    <a href="<?= base_url() ?>" class="buton">Sözleşmeler</a>
                    <a href="<?= base_url() ?>" class="buton">Teklifler</a>
                    <a href="<?= base_url() ?>" class="buton">Servisler</a>
                    <a href="<?= base_url() ?>" class="buton">Fiyat Listesi</a>
                    <a href="<?= base_url() ?>" class="buton">Hizmetler</a>
                    <a href="<?= base_url() ?>account/logout" class="buton">Çıkış yap (<?= $this->session->userdata('user_name') ?>)</a>
                </div>		
        </div>

