<? include('header.php'); ?>

<style>
    #projeler_tablo tr td {cursor:pointer;}
    #projeler_tablo tr:hover {border-bottom:1px solid gray;}
    table#musteri_bilgileri tr td .editer {display:none;}
    #customer_title input {font-size:22px; width:100%;}
    #customer_title {width:100%;}
    #action_uncheck, #action_check{position:absolute; top:0px; right:0px; cursor: pointer; float:right; width:30px;top: -39px;right: -23px;}
    #y_sozlesme_hizmetler td input[type=text] {width:80px;}
    #y_sozlesme_hizmetler td input.tarih{width:116px;}
</style>

<script type="text/javascript">
    customer_id = "<?= $customer_id; ?>";
    session_user_id = <?=$this->session->userdata('user_id');?>;
</script>
<? $this->load->javascript("jquery.ajaxTemplate"); ?>
<? $this->load->javascript('customer_detail'); ?>

<div id="notice"></div>
    
    <div class="blok" style="width:47%; margin-left: 2%; margin-right:1%;">
        <h1 id="customer_title" class="editable">
            <p><?= $customer_title ?></p>
        </h1>

        <span class="border" style="position:relative;">
            <?if($customer_checked == 1){?>
                <img id="action_uncheck" src="<?=base_url();?>images/checked.png">
            <?}else{?>
                <img id="action_check" src="<?=base_url();?>images/unchecked.png">
            <?}?>
        </span>
            <table id="musteri_bilgileri" class="satir1 editable_data" style="margin-bottom:10px;float:left; width:100%;border: 1px solid #D9D9D9;">
                <tr>
                    <td class="data1" style="width:80px;">Firma No</td>
                    <td style="font-weight:bold;font-size:16px; width:110px;"><?=$customer_mno ?></td>
                    <td style="width:110px;" class="editable" id="customer_status" ><p><? echo $customer_status == 0 ? "Pasif" : "Aktif"; ?></p><select style="display:none"><option <?selected($customer_status, 0)?> value="0">Pasif</option><option <?selected($customer_status, 1)?> value="1">Aktif</option></select></td>
                    <td style="color:red; font-size:16px;"><?=$borc?></td>
                </tr>
                <tr>
                    <td class="data1">Firma Sahibi Bilgileri</td><td agent_id="<?=$agent['agent_id']?>" id="agent_name" class="editable"><p><?= $agent['agent_name']?></p></td>
                    <td id="<?echo $agent['agent_gsm'] == "" ? "agent_phone" : "agent_gsm"; ?>" class="editable">
                        <p><? echo $agent['agent_gsm'] == "" ? $agent['agent_phone'] : $agent['agent_gsm'];?></p>
                    </td><td class="editable" id="agent_email"><p><?=$agent['agent_email']?></p></td>
                </tr>
                <tr>
                    <td class="data1">Telefon / Fax / Cep</td><td id="customer_phone" class="editable"><p><?= $customer_phone ?></p></td><td id="customer_fax" class="editable"><p><?= $customer_fax ?></p></td><td id="" class=""><p>test cep</p></td>
                </tr>
                <tr>
                    <td class="data1">Firma Adresi:</td><td colspan="3" id="customer_address" class="editable"><p><?= $customer_address ?></p></td>
                </tr>
                <tr>
                    <td class="data1">Vergi Dairesi</td><td id="customer_taxOffice" class="editable"><p><?= $customer_taxOffice ?></p></td><td class="data1">Vergi Numarası</td><td class="editable" id="customer_taxNumber"><p><?= $customer_taxNumber ?></p></td>
                </tr>
                <tr>
                    <td class="data1">Web adresi</td><td class="editable" id="customer_www"><p><?= $customer_www ?></p></td><td class="data1">E-posta</td><td class="editable" id="customer_email"><p><?= $customer_email ?></p></td>
                </tr>
                <tr>
                    <td class="data1">Sektör</td>
                    <td class="editable" id="customer_sector" function="sektorler('#customer_sector select', <?echo $customer_sector == "" ? 0 : $customer_sector?>)">
                        <p><?= $sector_name ?></p>
                        <select style="display:none"></select>
                    </td>
                    <td class="data1">Müşteri Temsilcisi</td><td class="editable" id="customer_user_id" function="temsilciler('#customer_user_id select', <?echo $customer_user_id == "" ? 0 : $customer_user_id?>)"><p><?=$user_name?></p><select style="display:none"></select></td>
                </tr>
            </table>
            <a href="#" class="buton" style="margin-top:-6px;float:right;" id="firma_bagla_buton">Firma Bağla</a>
            <a href="#" class="buton" style="float:right; margin-top:-6px; margin-right:6px;" id="musteri_duzenle_buton">Düzenle</a>
            <a href="#" class="buton" style="margin-top:-6px; margin-right:6px; display:none; float:right;" id="musteri_vazgec_buton">Vazgeç</a>
            <a href="#" class="buton" style="margin-top:-6px; margin-right:6px; display:none; float:right; margin-right:6px;" id="musteri_kaydet_buton">Kaydet</a>

    </div>


<div id="not_template" style="display:none;">
    <div class="alert first" note_id="{$customerNote_id}" style="{if $customerNote_important == 1}background:#F9EFC5{/if}">
        {$tags} <div class="ozet"><span style="width:130px; float:left;">{$user_name}</span> {$customerNote_date} </div>
    </div>
    
    <div class="alert-detail" note_id="{$customerNote_id}">
        <p></p>
    </div>
</div>

<div class="blok" style="width:47%; margin-left:1%; margin-right:2%;">
    <h1>Firma Notları</h1>
    <a class="buton" id="yeni_not_buton" style="margin-top:-6px; float:right;">Yeni Not Ekle</a>
    <a href="#" class="link" id="not_filtre_buton" style="float:right; margin-right:10px;">Filtrele</a>
    <div id="not_filtre">
        <select id="filtre_select" multiple style="width:110px;height:150px;">
            <option>test</option><option>asdf</option>
        </select>
        <a href="#" class="buton" id="get_filtre" />Filtrele</a>
    </div>
    <span class="border"></span>
    
    <div id="not_listesi" style="overflow-y: auto; height: 500px; width:100%; overflow-x:hidden;"></div>
</div>

                <div id="yeni_not" style="display:none;float:left;" title="Yeni Müşteri Notu<span class='border'></span>">
                    <table class="input_table display" style="width:474px;">
                        <tr>
                            <td style="width:150px;">
                                Etiketler<br>
                                <a href="#" id="yeni_etiket" class='link'>Yeni Etiket</a>
                            </td>
                            <td style="width:350px;">
                                <select id="y_not_tipi" multiple style="height:100px; width:200px;"></select>
                            </td>
                        </tr>

                        <tr>
                            <td>Yetkili</td><td><select>
                                    <option>Seçebilirsiniz</option>
                                    <?
                                    $this->Agent->agent_customer_id = $customer_id;
                                    $agents = $this->Agent->get_agents();
                                    foreach ($agents as $yetkili) {
                                        ?>
                                        <option value="<?= $yetkili['agent_id'] ?>"><?= $yetkili['agent_name'] ?></option>
                                    <? } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Notunuz</td><td><textarea id="y_not_text" style="width:100%; height:90px;"></textarea></td>
                        </tr>

                        <tr>
                            <td></td><td><input id="important" value="1" type="checkbox" ><label for="important" style="cursor:pointer">Önemli</label></td>
                        </tr>
                    </table>
                </div>

                <div style="display:none" id="yeni_not_tipi" title="Yeni not grubu ekleyin. <span class='border'></span>">
                    <table class="input_table display" style="width:300px;">
                        <tr>
                            <td>Başlık</td><td><input id="y_not_tipi_baslik" /></td>
                        </tr>
                    </table>
                </div>


<div class="blok" style="width:96%; margin-left:2%; margin-right:2%;">
    <h1>Diğer Bilgiler</h1>
    <span class="border"></span>
                <div id="tabs" style="float:left; width:100%; margin-top:20px;">
                    <ul>
                        <li><a href="#hizmetler" id="hizmetler_tab">Hizmetler</a></li>
                        <li><a href="#odemeler" id="odemeler_tab">Tahsilatlar</a></li>
                        <li><a href="#projeler" id="projeler_tab">Projeler</a></li>
                        <li><a href="#yetkililer" id="yetkililer_tab">Yetkililer</a></li>
                        <li><a href="#sozlesmeler" id="sozlesmeler_tab">Sözleşmeler</a></li>
                    </ul>

                    <div id="hizmetler" style="padding:0px; float:left; width:100%;">
                        <a style="float:right;" id="yeni_hizmet_buton" class="buton">Yeni Hizmet Ekle</a>

                        <div id="yeni_hizmet" title="Yeni Hizmet <span class='border'></span>" style="display:none;">
                            <table class="input_table display" style="width:474px;">
                                <tr>
                                    <td style="width:250px;">
                                        Hizmet
                                    </td>
                                    <td style="width:250px;">
                                        <select id="y_hizmet">
                                            <?
                                            $hizmetler = $this->Service->get_services();
                                            unset($hizmetler[0]);
                                            foreach ($hizmetler as $hizmet) {
                                                ?>
                                                <option value="<?= $hizmet['service_id'] ?>"><?= $hizmet['service_name'] ?></option>
<? } ?>
                                            <option value="0">Diğer</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="user_tr">
                                    
                                    <tr class="option hosting_tr">
                                        <td>Hosting</td>
                                        <td>
                                            <select id="y_hosting">
                                            </select>
                                        </td>
                                    </tr>

                                    <tr class="option domain_tr">
                                        <td>Domain</td>
                                        <td><input type="text" id="y_domain" /></td>
                                    </tr>

                                    <tr class="option proje_tr">
                                        <td>
                                            Proje
                                        </td>
                                        <td>
                                            <select id="y_proje">		
                                                <option value="yeni_proje">Yeni Proje</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr class="option yeni_proje_tr">
                                        <td>Proje Adı <span style="font-size:11px;"></span></td>
                                        <td><input type="text" id="y_proje_adi" /></td>
                                    </tr>

                                    <tr class="option proje_tarihi">
                                        <td>Proje Başlangıç Tarihi</td>
                                        <td><input type="text" class="tarih" id="y_date1"></td>
                                    </tr>

                                    <tr class="option proje_tarihi">
                                        <td>Proje Bitiş Tarihi</td>
                                        <td><input type="text" class="tarih" id="y_date2"></td>
                                    </tr>

                                    <tr class="option proje_ozeti_tr">
                                        <td><p style="float:left;">Proje Özeti <span style="font-size:11px;"></span></p></td>
                                        <td><textarea id="y_proje_ozeti" style="float:left; height:66px"></textarea></td>
                                    </tr>

                                    <tr class="option host_data_tr">
                                        <td>FTP Kullanıcı Adı</td>
                                        <td><input type="text" id="y_ftp_username" /></td>
                                    </tr>

                                    <tr class="option host_data_tr">
                                        <td>FTP Password</td>
                                        <td><input type="text" id="y_ftp_password" /></td>
                                    </tr>

                                    <tr class="option host_data_tr">
                                        <td>FTP Kota (MB) </td>
                                        <td><input type="text" id="y_kota" /></td>
                                    </tr>

                                    <tr class="option atacfs_kota_tr">
                                        <td>Kullanıcı Kotası</td>
                                        <td><input type="text" id="y_atacfs_kota" /></td>
                                    </tr>

                                    <tr class="option eticaret_tr">
                                        <td>Yönetici İsim Soyisim</td>
                                        <td><input type="text" id="y_isim_soyisim" /></td>
                                    </tr>

                                    <tr class="option eticaret_tr">
                                        <td>Yönetici E-posta</td>
                                        <td><input type="text" id="y_eposta"/></td>
                                    </tr>

                                    <tr class="option eticaret_tr">
                                        <td>Yönetici Şifre</td>
                                        <td><input type="text" id="y_sifre" /></td>
                                    </tr>

                                    <tr class="option eticaret_tr">
                                        <td>Site Grubu</td>
                                        <td><input type="text" value="0" id="y_site_grubu"/></td>
                                    </tr>

                                    <tr style="border-top:2px solid gray; border-bottom: 2px solid gray;"class="option mysql_olustur_tr">
                                        <td>MySql Veritabanı</td>
                                        <td>
                                            <a href="#" class="buton olustur">Oluştur</a>
                                            <a href="#" class="buton vazgec" style="display:none;">Vazgeç</a>
                                        </td>
                                    </tr>

                                    <tr class="option mysql_data_tr">
                                        <td>MySql Veritabanı Adı:</td>
                                        <td><input type="text" id="y_mysql_dbname" /> </td>
                                    </tr>

                                    <tr class="option mysql_data_tr">
                                        <td>MySql Kullanıcı Adı:</td>
                                        <td><input type="text" id="y_mysql_username" /> </td>
                                    </tr>
                                    <tr class="option mysql_data_tr">
                                        <td>MySql Şifresi:</td>
                                        <td><input type="text" id="y_mysql_pass" /> </td>
                                    </tr>

                                    <tr style="" class="ekle_tr">
                                        <td></td>
                                        <td><a href="#" class="buton" id="hizmet_ekle_buton" style="float:right;">Hizmet Ekle</a></td>
                                    </tr>
                            </table>
                        </div>


                        <table id="hizmetler_tablo" class="display clickable grouptable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
                            <thead>
                                <tr>
                                    <th style="width:auto;">Hizmet</th>

                                    <th	style="width:140px;">Hizmet Tutarı (TL)</th>
                                    <th style="">KDV (TL)</th>
                                    <th style="">Toplam (TL)</th>
                                    <th style="width:150px;">Başlangıç</th>
                                    <th style="width:150px;">Bitiş</th>
                                    <th >Sunucu</th>
                                    <th >Yayın</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div id="odemeler" style="padding:0px;">
                        <a style="float:right;" href="#" id="yeni_odeme_buton" class="buton">Yeni Ödeme</a>


                        <table id="odemeler_tablo" class="display" cellspacing="0" cellpadding="0" border="0" style="float:left;">
                            <thead>
                                <tr>
                                    <th>Hizmet</th>
                                    <th>Ödeme Tarihi</th>
                                    <th>Ödenen Tutar (TL)</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                        <div id="yeni_odeme" title="Yeni Ödeme <span class='border'></span>" style="display:none;">
                            <table class="input_table display" style="width:400px;">
                                <tr>
                                    <td>
                                        Sözleşme
                                    </td>
                                    <td>
                                        <select id="y_odeme_sozlesmeler"></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tutar (TL)</td>
                                    <td><input type="text" id="y_odeme_tutar" /></td>
                                </tr>
                                <tr>
                                    <td>Ödeme Tarihi</td>
                                    <td><input type="text" class="tarih" id="y_odeme_tarih"/></td>
                                </tr>
                                <tr>
                                    <td>Ödeme Kanalı</td>
                                    <td><select id="y_odeme_odeme_kanali"><option value="1">Havale/EFT</option><option value="2">Kredi Kartı</option><option value="3">Çek</option><option value="0">Diğer</option></select></td>
                                </tr>
                                <tr id="cek_vaade_tr" style="display:none;">
                                    <td>Çekin Vadesi</td>
                                    <td><input type="text" class="tarih" id="y_odeme_cek_vade" /></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    
                    
                    <div id="projeler" style="padding:0px; ">
                        <a style="float:right;" id="yeni_proje_buton" class="buton">Yeni Proje</a>
                        
                        <table id="projeler_tablo" class="display" cellspacing="0" cellpadding="0" border="0" style="float:left; ">
                            <thead>
                                <tr>
                                    <th style="min-width:170px;">Proje Adı</th>
                                    <th style="min-width:160px;">Son Durum</th>
                                    <th style="">Bekleyen Görevler</th>
                                    <th>Tamamlanan Görevler</th>
                                    <th style="width: none; min-width: 110px;">Proje Başlangıç Tarihi</th>
                                    <th style="width: none; min-width:94px;">Proje Teslim Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <div id="yeni_proje" title="Yeni Proje <span class='border'></span>" style="display:none;">
                            <table class="input_table display" style="width:400px;">
                                <tr>
                                    <td>Proje Adı</td>
                                    <td><input type="text" id="proje_adi"/></td>
                                </tr>
                                <tr>
                                    <td>Başlangıç Tarihi</td>
                                    <td><input type="text" class="tarih" id="proje_baslangic" /></td>
                                </tr>
                                <tr>
                                    <td>Bitiş Tarihi</td>
                                    <td><input type="text" class="tarih" id="proje_bitis" /></td>
                                </tr>
                                <tr>
                                    <td>Proje Yöneticisi</td>
                                    <td><select id="proje_yoneticisi"></select></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="yetkililer" style="padding:0px; ">
                        <a style="float:right;" class="buton" id="yetkili_ekle_buton">Yeni Yetkili</a>
                        <table id="yetkililer_tablo" class="display" cellspacing="0" cellpadding="0" border="0" style="float:left;">
                            <thead>
                                <tr>
                                    <th>Yetkili Adı</th>
                                    <th>Yetkili Telefonu</th>
                                    <th>Yetkili Cep Telefonu</th>
                                    <th>Yetkili E-posta</th>
                                    <th>Yetkili Ünvanı </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        
                        <div id="yetkili_edit" title="Yetkili Düzenle <span class='border'></span>" style="display:none;">
                            <table class="input_table display" style="width:400px;">
                                <tr>
                                    <td>Yetkili Adı</td>
                                    <td><input type="text" id="d_agent_name"/></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Telefonu</td>
                                    <td><input type="text" id="d_agent_phone" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Cep Telefonu</td>
                                    <td><input type="text" id="d_agent_gsm" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili E-posta</td>
                                    <td><input type="text" id="d_agent_email" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Ünvanı</td>
                                    <td><input type="text" id="d_agent_title" /></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div id="yetkili_sil_confirm" title="Emin misiniz ? <span class='border'></span>" style="display:none;">
                            <p>Bu yetkiliyi silmek istediğinize emin misiniz ? </p>
                        </div>
                        
                        <div id="yetkili_ekle" title="Yeni Yetkili <span class='border'></span>" style="display:none;">
                            <table class="input_table display" style="width:400px;">
                                <tr>
                                    <td>Yetkili Adı</td>
                                    <td><input type="text" id="y_agent_name"/></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Telefonu</td>
                                    <td><input type="text" id="y_agent_phone" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Cep Telefonu</td>
                                    <td><input type="text" id="y_agent_gsm" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili E-posta</td>
                                    <td><input type="text" id="y_agent_email" /></td>
                                </tr>
                                <tr>
                                    <td>Yetkili Ünvanı</td>
                                    <td><input type="text" id="y_agent_title" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div id="sozlesmeler" style="padding:0px;">
                        <a style="float:right;" class="buton" id="yeni_sozlesme_buton">Yeni Sözleşme</a>

                        <table id="contracts_table" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
                            <thead>
                                <tr>
                                    <th>Sözleşme Adı</th>
                                    <th style="">Müşteri</th>
                                    <th style="">Sözleşme Tarihi</th>
                                    <th style="">Satış Temsilcisi</th>
                                    <th style="">Hizmet Sayısı</th>
                                    <th style="">Ödenen</th>
                                    <th style="">Borç</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>


                        <div id="yeni_sozlesme" title="Yeni Sözleşme <span class='border'></span>" style="display:none;">

                            <table class="input_table display" style="width:1000px;">
                                <tr>
                                    <td>Sözleşme Tarihi</td>
                                    <td><input type="text"  id="y_sozlesme_tarihi" /></td>

                                    <td>Satış Temsilcisi</td>
                                    <td><select id="y_sozlesme_user_id"></select></td>

                                    <td>Sözleşme Adı</td>
                                    <td><input type="text" id="y_sozlesme_adi" /></td>
                                </tr>

                                <tr collspan="6">
                                    <table id="y_sozlesme_hizmetler" class="input_table display">
                                        <thead>
                                        <tr style="background:lightgray">
                                            <td></td>
                                            <td style="width:120px;">Hizmet</td>
                                            <td>Başlangıç Tarihi</td>
                                            <td>Bitiş Tarihi</td>
                                            <td>Tutar (TL)</td>
                                            <td>KDV (%)</td>
                                            <td>Toplam (TL)</td>
                                            <td>Alınan Tutar</td>
                                            <td>Kalan Tutar</td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                        
                                    </table>
                                </tr>
                                <!--
                                <tr class="sozlesme_tutari_tr">
                                    <td>Sözleşme Tutarı (TL)</td>
                                    <td><input id="y_ucret" type="text" /></td>
                                </tr>

                                <tr>
                                    <td>KDV (%)</td>
                                    <td><input id="y_kdv" type="text" value="18" /></td>
                                </tr>
                                
                                <tr>
                                    <td>Toplam Tutar (TL)</td>
                                    <td><input id="y_toplam_tutar"type="text" value="" /></td>
                                </tr>

                                <tr>
                                    <td>Alınan Tutar (TL)</td>
                                    <td><input id="y_alinan_tutar"type="text" value="" /></td>
                                </tr>

                                <tr>
                                    <td>Kalan Tutar (TL)</td>
                                    <td><input id="y_kalan_tutar"type="text" value="" readonly="readonly" /></td>
                                </tr>

                                <tr class="date1_tr">
                                    <td><span class="date1">Hizmet Başlangıç Tarihi</span></td>
                                    <td><input type="text" class="tarih" id="y_date1" value="<?= datepicker_en(date('Y-m-d')) ?>" /></td>
                                </tr>
                                
                                <tr class="date2_tr">
                                    <td><span class="date2">Hizmet Bitiş Tarihi :</span></td>
                                    <td><input type="text" class="tarih" id="y_date2" /></td>
                                </tr>
                                -->

                            </table>
                        </div>

                    </div>
                </div>
    </div>

<? include('footer.php'); ?>