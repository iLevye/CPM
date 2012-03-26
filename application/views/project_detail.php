<? include('header.php'); ?>
<script type="text/javascript">     
    project_id = "<?= $project_id; ?>";
</script>

<style>
    table#proje_bilgileri tr td .editer {display:none;}
</style>

<? $this->load->javascript('project_detail'); ?>

    <div class="blok" style="width:47%; margin-left: 2%; margin-right:1%;">
        <h1>Proje Bilgileri</h1>
        <a class="buton" style="float:right; margin-top:-6px;" id="proje_duzenle_buton">Düzenle</a>
        <a class="buton" style="display:none; float:right;margin-top:-6px;" id="proje_vazgec_buton">Vazgeç</a>
        <a class="buton" style="display:none; float:right;margin-top:-6px;margin-right:6px;" id="proje_kaydet_buton">Kaydet</a>
        <span class="border"></span>
        <table id="proje_bilgileri" class="satir1 editable_data" style="margin-bottom:10px;float:left; width:100%;border: 1px solid #D9D9D9;">
            <tr class="odd"><td style="width:40%">Proje ID :</td><td style="width:60%;"><p id="project_id"></p><input id="d_project_id" readonly="readonly" class="editer" /></td></tr>
            <tr class="even"><td>Proje Adı :</td><td><p id="project_name"></p><input id="d_project_name" class="editer" /></td></tr>
            <tr class="odd"><td>Proje Durumu :</td>
                <td><p id="project_status_t"></p>
                    <select id="d_project_status" class="editer"></select>
                </td>
            </tr>
            <tr class="even"><td>Proje Baş. Tarihi :</td><td><p id="project_date1"></p><input id="d_project_date1" class="editer tarih" /></td></tr>
            <tr class="odd"><td>Proje Bit. Tarihi :</td><td><p id="project_date2"></p><input id="d_project_date2" class="editer tarih" /></td></tr>
            <tr class="even">
                <td>Proje Yöneticisi :</td>
                <td><p id="user_name"></p>
                    <select id="d_project_user_id" class="editer"></select>
                </td>
            </tr>
            <tr class="odd"><td>Müşteri Ünvanı:</td><td><p id="customer_title"></p><input id="d_customer_title" class="editer" readonly="readonly" /></td></tr>
        </table>
    </div>


    <div class="blok" style="width:47%; margin-left:1%; margin-right:2%;">
        <h1>Proje Günlüğü</h1>
        <a class="buton" id="yeni_not_buton" style="margin-top:-6px; float:right;">Yeni Not Ekle</a>
        <span class="border"></span>

        <div class="alert first">
            <div class="etiket">GÖRÜŞME</div><div class="ozet">Donec adipiscing nunc tellus a sapien a erosest congue...</div>
        </div>

        <?for($i=0; $i < 10; $i++){?>
            <div class="alert">
                <div class="etiket">GÖRÜŞME</div><div class="ozet">Donec adipiscing nunc tellus a sapien a erosest congue...</div>
            </div>

            <div class="alert-detail">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
            </div>
        <?}?>
    </div>

  
    <div class="blok" style="width:96%; margin-left:2%; margin-right:2%; margin-top:40px;">
        <h1>Proje Görevleri</h1>
        <a id="y_gorev_buton" class="buton" style="float:right; margin-top:-6px;">Yeni Görev</a>
        <span class="border"></span>
        <table id="gorevler_tablo" class="display" cellspacing="0" cellpadding="0" border="0" style="float:left; ">
            <thead>
                <tr>
                    <th style="max-width:200px;">Görev</th>
                    <th style="width:150px;">Sorumlu</th>
                    <th style="width:150px;">Durum</th>
                    <th style="max-width:100px;">Geçen Süre / Toplam Süre</th>
                    <th style="width: 100px;">Başlangıç Tarihi</th>
                    <th style="width:100px;">Bitiş Tarihi</th>
                    <th style="">Not</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

        <div id="yeni_gorev" title="Yeni Görev <span class='border'></span>" style="width:474px; display:none;">
            <div class="info-box"><p style="font-size:12px; text-align:justify;"><span style="font-weight:bold;">Bildirim gönder;</span> kullanıcı görevi tamamladığında size yada başka bir kullanıcıya bilgi verir</p></div>
            <div class="info-box"><span>Onay görevi oluştur;</span> kullanıcı görevi tamamlamak istediğinde, sizden ya da başka bir kullanıcıdan onay ister</div>

            <table class="input_table display" style="width:474px;">
                <tr>
                    <td>*Görev adı:</td>
                    <td><input type="text" id="y_task_name" />
                </tr>

                <tr>
                    <td><span style="float:left; margin-bottom:20px;">Görev Notu:</span></td>
                    <td><textarea id="y_task_not"></textarea>
                </tr>

                <tr>
                    <td>*Sorumlu:</td>
                    <td><select id="y_task_user_id">
                    </select></td>
                </tr>

                <tr>
                    <td>Geri bildirim</td>
                    <td><select id="y_task_feedback">
                        <option value="0">Yok</option>
                        <option value="1">Bildirim gönder</option>
                        <option value="2">Onay görevi oluştur</option>
                    </select></td>
                </tr>

                <tr class="feedback_user" style="display:none">
                    <td>Geri bildirim kullanıcısı</td>
                    <td><select id="y_task_feedback_user_id"></select></td>
                </tr>

                <tr>
                    <td>Tahmini süre (Saat): </td>
                    <td><input type="text" id="y_task_plannedTime" /></td>
                </tr>
                
                <tr>
                    <td>Başlangıç tarihi:</td>
                    <td><input type="text" class="tarih" id="y_task_plannedStart" value="<?=$bugun?>"/></td>
                </tr>

                    <tr>
                    <td>Bitiş tarihi:</td>
                    <td><input type="text" class="tarih" id="y_task_plannedFinish" value="<?=$bugun?>"/></td>
                </tr>


            </table>
        </div>


<? include('footer.php'); ?>