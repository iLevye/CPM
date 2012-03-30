<? include('header.php'); ?>

<?
$this->load->javascript('personel');
$this->load->javascript('jquery.tree');
$this->load->javascript('jquery.treecheckbox');
$this->load->javascript('jquery.treecollapse');
$this->load->javascript('jquery.treecontextmenu');
$this->load->javascript('jquery.treednd');
$this->load->javascript('jquery.treeselect');
?>

<style>
    table#personel_bilgileri tr td .editer {display:none;}
</style>
</head>
<body>


<div id="kayit_bilgi_penceresi" class="info_popup" title="Personel Bilgileri <span class='border'></span>" style="display:none; ">

    <div id="tabs" style="width:970px; border:none;">
        <ul>
            <li><a href="#tabs-1" class="genel_bilgiler">Genel Bilgiler</a></li>
            <li id="yetki_tab_buton"><a href="#yetkiler">Yetkiler</a>
                <li><a href="#gorevler">Görevler</a></li>
                <li><a href="#maas_dokumu">Maaş Dökümü</a></li>
                <li><a href="#izin_cizelgesi">İzin Çizelgesi</a></li>
                <li><a href="#evraklar">Evraklar</a></li>
        </ul>

        <div id="tabs-1" class="module" style="width:940px;">
            <table id="personel_bilgileri" class="satir1 editable_data" style="border: 1px solid #D9D9D9;">
                <tr class="odd"><td style="width:240px">Personel ID :</td><td style="width:60%;"><p id="user_id"></p><input id="d_user_id" readonly="readonly" class="editer" /></td></tr>
                <tr class="even"><td>E-posta :</td><td><p id="user_email"></p><input id="d_user_email" class="editer line_input" /></td></tr>
                <tr class="odd"><td>İsim :</td><td><p id="user_name"></p><input id="d_user_name" class="editer line_input" /></td></tr>
                <tr class="even"><td>Adres :</td><td><p id="user_address"></p><input id="d_user_address" class="editer line_input" /></td></tr>
                <tr class="odd"><td>Telefon :</td><td><p id="user_phone"></p><input id="d_user_phone" class="editer line_input" /></td></tr>
                <tr class="even"><td>GSM :</td><td><p id="user_gsm"></p><input id="d_user_gsm" class="editer line_input" /></td></tr>
                <tr class="odd"><td>Title :</td><td><p id="user_title"></p><input id="d_user_title" class="editer line_input" /></td></tr>
                <tr class="even"><td>Departman :</td><td><p id="department_name"></p>
                        <select id="d_user_department_id" class="editer"></select>
                        </td></tr>
                <tr class="odd"><td></td><td>
                    <a class="buton" style="float:right;" id="personel_duzenle_buton">Düzenle</a>
                    <a class="buton" style="display:none; float:right;" id="personel_vazgec_buton">Vazgeç</a>
                    <a class="buton" style="display:none; float:right;" id="personel_kaydet_buton">Kaydet</a>
                </td></tr>
            </table>
            
                

        </div>

        <div id="yetkiler">
            <div id="yetki_agaci" style="float:left; padding-right:60px;">
                <ul>
                    <li class="t_musteriler"><input type="checkbox"><span>Müşteriler</span>
                            <ul>
                                <li class="in"><input type="checkbox"><span>Kendi Müşterileri</span>
                                        <ul>
                                            <li class="read collapsed"><input type="checkbox" id="gorme"><span>Görme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bigiler</span></li>
                                                        <li><input type="checkbox"><span>Hizmetler</span></li>
                                                        <li><input type="checkbox"><span>Ödemeler</span></li>
                                                        <li><input type="checkbox"><span>Projeler</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve Notlar</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                            <li class="edit collapsed"><input type="checkbox"><span>Düzenleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bigiler</span></li>
                                                        <li><input type="checkbox"><span>Hizmetler</span></li>
                                                        <li><input type="checkbox"><span>Ödemeler</span></li>
                                                        <li><input type="checkbox"><span>Projeler</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve Notlar</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                            <li class="write collapsed"><input type="checkbox"><span>Ekleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Ödeme</span></li>
                                                        <li><input type="checkbox"><span>Hizmet</span></li>
                                                        <li><input type="checkbox"><span>Proje</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve not</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                        </ul>
                                </li>
                                <li class="out"><input type="checkbox"><span>Diğer Müşteriler</span>
                                        <ul>
                                            <li class="read collapsed"><input type="checkbox"><span>Görme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bigiler</span></li>
                                                        <li><input type="checkbox"><span>Hizmetler</span></li>
                                                        <li><input type="checkbox"><span>Ödemeler</span></li>
                                                        <li><input type="checkbox"><span>Projeler</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve Notlar</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                            <li class="edit collapsed"><input type="checkbox"><span>Düzenleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bigiler</span></li>
                                                        <li><input type="checkbox"><span>Hizmetler</span></li>
                                                        <li><input type="checkbox"><span>Ödemeler</span></li>
                                                        <li><input type="checkbox"><span>Projeler</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve Notlar</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                            <li class="write collapsed"><input type="checkbox"><span>Ekleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Ödeme</span></li>
                                                        <li><input type="checkbox"><span>Hizmet</span></li>
                                                        <li><input type="checkbox"><span>Proje</span></li>
                                                        <li><input type="checkbox"><span>Görüşme ve not</span></li>
                                                        <li><input type="checkbox"><span>Yetkili bilgileri</span></li>
                                                    </ul>
                                            </li>
                                        </ul>
                                </li>
                            </ul>
                    </li>

                    <li class="t_personel"><input type="checkbox"><span>Personel</span>
                            <ul>
                                <li class="in"><input type="checkbox"><span>Departman İçi</span>
                                        <ul>
                                            <li class="read collapsed"><input type="checkbox"><span>Görme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel bilgiler</span></li>
                                                        <li><input type="checkbox"><span>Yetkiler</span></li>
                                                        <li><input type="checkbox"><span>Görevler</span></li>
                                                        <li><input type="checkbox"><span>Maaş dökümü</span></li>
                                                        <li><input type="checkbox"><span>İzin Çizelgesi</span></li>
                                                    </ul>
                                            </li>
                                            <li class="edit collapsed"><input type="checkbox"><span>Düzenleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bilgiler</span></li>
                                                        <li><input type="checkbox"><span>Yetkiler (Yetki ekleme - alma)</span></li>
                                                        <li><input type="checkbox"><span>Görevler</span></li>
                                                        <li><input type="checkbox"><span>İzin Çizelgesi</span></li>
                                                    </ul>
                                            </li>
                                            <li class="write collapsed"><input type="checkbox"><span>Ekleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Yeni Personel</span></li>
                                                        <li><input type="checkbox"><span>Maaş Bilgisi</span></li>
                                                        <li><input type="checkbox"><span>İzin Bilgisi</span></li>
                                                    </ul>
                                            </li>
                                        </ul>
                                </li>
                                <li class="out"><input type="checkbox"><span>Departman Dışı</span>
                                        <ul>
                                            <li class="read collapsed"><input type="checkbox"><span>Görme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel bilgiler</span></li>
                                                        <li><input type="checkbox"><span>Yetkiler</span></li>
                                                        <li><input type="checkbox"><span>Görevler</span></li>
                                                        <li><input type="checkbox"><span>Maaş dökümü</span></li>
                                                        <li><input type="checkbox"><span>İzin Çizelgesi</span></li>
                                                    </ul>
                                            </li>
                                            <li class="edit collapsed"><input type="checkbox"><span>Düzenleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Genel Bilgiler</span></li>
                                                        <li><input type="checkbox"><span>Yetkiler (Yetki ekleme - alma)</span></li>
                                                        <li><input type="checkbox"><span>Görevler</span></li>
                                                        <li><input type="checkbox"><span>İzin Çizelgesi</span></li>
                                                    </ul>
                                            </li>
                                            <li class="write collapsed"><input type="checkbox"><span>Ekleme</span>
                                                    <ul>
                                                        <li><input type="checkbox"><span>Yeni Personel</span></li>
                                                        <li><input type="checkbox"><span>Maaş Bilgisi</span></li>
                                                        <li><input type="checkbox"><span>İzin Bilgisi</span></li>
                                                    </ul>
                                            </li>
                                        </ul>
                                </li>
                            </ul>
                    </li>

                    <li class="t_rehber"><input type="checkbox"><span>Rehber</span>
                            <ul>
                                <li class="read collapsed"><input type="checkbox"><span>Görme</span>
                                        <ul>
                                            <li><input type="checkbox"><span>Müşteriler</span></li>
                                            <li><input type="checkbox"><span>Personeller</span></li>
                                        </ul>
                                </li>
                                <li class="edit collapsed"><input type="checkbox"><span>Düzenleme</span>
                                        <ul>
                                            <li><input type="checkbox"><span>Müşteriler</span></li>
                                            <li><input type="checkbox"><span>Personeller</span></li>
                                        </ul>
                                </li>
                            </ul>
                    </li>


                </ul>
            </div>
            
            <p style="float: left; font-size: 13px; margin-left: 16px; color: #424041; font-style: italic; width:470px;">* Yetki şablonlarını kullanarak daha önce oluşturulmuş kullanıcı yetkilerini verebilirsiniz. </p>
            
            <div style="float:left; margin-left: 20px; width:338px;">
                
                <table class="satir1">
                    <tr>
                        <td style="width: 150px;">Yetki şablonu :</td><td>
                            <select id="sablon_select">
                                <option value="0">Seçebilirsiniz</option>
                                <option value="1">Standart Yetki</option>
                                <option value="2">Müşteri Yönetimi Yetkisi</option>
                            </select>
                        </td>
                    </tr>
                </table>
                   
                <a  class="buton" style="float:right;" id="yetki_kaydet">Kaydet</a>
                
            </div>
            
            
        </div>

        <div id="gorevler">

            <div id="yeni_gorev" title="Yeni Proje Ekle <span class='border'></span>" style="display:none;">
                <form class="column">
                    <span>Proje: <select><option>Örnek Proje 1</option><option>Örnek Proje 2</option><option>Örnek Proje 3</option></select></span>
                    <span>Görev Notu: <textarea></textarea></span>
                </form>
                <a style="float:right;" href="#" class="buton">Ekle</a>
            </div>

            <table id="personel_task" class="display">
                <thead>
                    <tr>
                        <th>Durum</th>
                        <th>Süre</th>
                        <th>Proje (Müşteri)</th>
                        <th>Başlama Tarihi</th>
                        <th>Bitiş Tarihi</th>
                    </tr>
                </thead>
            </table>

        </div>

        <div id="maas_dokumu">
            <a href="#" class="buton" id="yeni_odeme_buton">Yeni Ödeme</a>
            <div id="yeni_odeme" title="Yeni Ödeme <span class='border'></span>" style="display:none;">
                <p style="font-size:11px; font-style: italic; margin-bottom:0px;">* Tüm tutarları tl cinsinden giriniz.</p>
                <table id="yeni_maas_odeme" class="input_table display" style="margin-top: 0px;">
                    <tr>
                        <td>Ödeme Tarihi</td><td><input type="text" class="tarih" id="odeme_tarihi" /></td>                        
                    </tr>
                    <tr>
                        <td>Ödenen Maaş</td><td><input type="text" id="odenen_maas" /></td>
                    </tr>
                    <tr>
                        <td>Net Maaş</td><td><input type="text" id="net_maas" /></td>                        
                    </tr>
                    <tr>
                        <td>A.G.İ.</td><td><input type="text" id="agi" value="60" /></td>
                    </tr>
                    <tr>
                        <td>Yol, Yemek</td><td><input type="text" id="yol_yemek" /></td>                        
                    </tr>
                    <tr>
                        <td>Prim</td><td><input type="text" id="prim" /></td>
                    </tr>
                    <tr>
                        <td>Avans Kesintisi
                            <span style="font-size:11px;">
                                <br>
                                (Personele ön ödeme yapılmışsa.)
                            </span>
                        </td><td><input type="text" id="avans" /></td>                        
                    </tr>
                    <tr>
                        <td>Diğer Kesintiler</td><td><input type="text" id="kesinti" /></td>
                    </tr>
                    <tr>
                        <td>Sigorta</td><td><input type="text" id="sigorta" /></td>
                    </tr>
                    <tr>
                        <td>Personel Maliyeti</td><td><input type="text" id="maliyet" /></td>
                    </tr>
                    
                </table>
                <a style="float:right;" id="maas_ekle_buton" class="buton">Ekle</a>
            </div>
            <table class="display" id="maas_table">
                <thead>
                    <tr>
                        <th style="width:90px;">Ödeme Tarihi</th>
                        <th>Ödenen Maaş</th>
                        <th>Net Maaş</th>
                        <th>A.G.İ</th>
                        <th>Yol + Yemek</th>
                        <th>Prim</th>
                        <th>Avans Kesintisi</th>
                        <th>Kesinti</th>
                        <th>Sigorta</th>
                        <th>Personel Maliyeti</th>
                        <th>Sil</th>
                    </tr>
                </thead>

            </table>
        </div>




        <div id="izin_cizelgesi">
            <a href="#" class="buton" id="yeni_izin_buton">Yeni İzin Kaydı</a>

            <div id="yeni_izin" title="Yeni İzin Kaydı <span class='border'></span>" style="display:none;">
                <table id="yeni_izin" class="display input_table" style="width:500px;">
                    <tr>
                        <td>İzin Başlangıç Tarihi </td><td><input id="y_dayoff_start" type="text" class="tarih"></td></tr>
                        <td>İzin Bitiş Tarihi*: </td><td><input id="y_dayoff_finish" type="text" class="tarih"></td></tr>
                </table>
                <p style="font-size:10px;">İzin Bitiş Tarihi, personelin işbaşı yaptığı günün tarihidir.</p>
            </div>

            <table id="dayoff_table" class="display">
                <thead>
                    <tr>
                        <th>İzin Başlangıç Tarihi</th>
                        <th>İzin Bitiş Tarihi</th>
                        <th>Sil</th>
                    </tr>
                </thead>
            </table>
        </div>




        <div id="evraklar">
            <a href="#" class="buton">Güncelle</a>
            <table class="display">
                <thead>
                    <tr>
                        <th>Belge</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tr class="odd">
                    <td style="width:200px;">Sağlık Raporu</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="even">
                    <td>İkametgah</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="odd">
                    <td>Nüfus Sureti</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="even">
                    <td>Adli Sicil Kaydı</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="odd">
                    <td>Nüfus Cüzdan Fotokopisi</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="even">
                    <td>Diploma Fotokopisi</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="odd">
                    <td>Kan Grubu Kartı</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="even">
                    <td>Evlilik Cüzdanı Fotokopisi</td>
                    <td style="color:#C2C4C4;">Mevcut Değil</td>
                </tr>
                <tr class="odd">
                    <td>Askerlik durumu ile ilgili belge</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="even">
                    <td>Ehliyet</td>
                    <td>Mevcut</td>
                </tr>
                <tr class="odd">
                    <td>Sertifikalar</td>
                    <td>Mevcut</td>
                </tr>

            </table>
        </div>
    </div>

</div>







<? ///////////////////////////////////   YENİ KAYIT /// ?>
<div id="yeni_kayit_penceresi" title="Yeni Personel <span class='border'></span>" style="display:none;">

    <table class="input_table display" style="width:474px;">
        <tr>
            <td style="width:150px;">Personel Adı</td>
            <td style="width:350px;"><input type="text" id="y_personel_isim"></td>
        </tr>

        <tr>
            <td>E-posta</td>
            <td><input type="text" id="y_personel_eposta"></td>
        </tr>

        <tr>
            <td>Şifre</td>
            <td><input type="text" id="y_personel_pass"></td>
        </tr>

        <tr>
            <td>Telefon</td>
            <td><input type="text" id="y_personel_telefon"></td>
        </tr>

        <tr>
            <td>GSM</td>
            <td><input type="text" id="y_personel_gsm"></td>
        </tr>

        <tr>
            <td>Title</td>
            <td><input type="text" id="y_personel_title"></td>
        </tr>

        <tr>
            <td>Adres</td>
            <td><textarea id="y_personel_adres"></textarea></td>
        </tr>

        <tr>
            <td>Departman</td>
            <td>
                <select id="y_personel_departman" style="min-width:200px;">
                <?php foreach ($departments as $permission) { ?>
                    <option value="<?= $permission['department_id'] ?>"><?= $permission['department_name'] ?></option>
                <?php } ?>
                </select>
            </td>
        </tr>
        
    </table>

</div>




<? ///////////////////////////////////   LİSTELEME TABLOSU   ?>
<div class="blok" style="width:96%; margin-left: 2%; margin-right:2%;">
    <h1>Personel Listesi</h1>
    <a href="#" class="buton" id="yeni_kayit_buton" style="margin-top:-6px; float:right;">Yeni Personel</a>
    <span class="border"></span>

        <table id="myTable" class="display clickable" cellspacing="0" cellpadding="0" border="0" style="float:left;">
            <thead>

                <tr>
            <div class="headtr">
                <th style="width: 5%">ID</th>
                <th style="width: 20%;">İsim</th>
                <th style="">Title</th>
                <th style="">GSM</th>
                <th style="">E-posta</th>
            </div>
            </tr>

            </thead>
            <tbody>

            </tbody>
        </table>
</div>

<? include('footer.php'); ?>