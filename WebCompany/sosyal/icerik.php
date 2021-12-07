<?php session_start(); if(isset($_SESSION['yonetim'])){ require_once '../ayar.php'; require_once 'header.php'; ?>
    <body><?php require_once'left.php';?>
    <div class="orta">

        <span id="ekle">Yeni Ekle</span>
        <div class="icerikler">
            <div class="icerikduzenle">
                <h2>Düzenle</h2>
                <label for="baslik">Başlık</label>
                <input type="text" name="baslik" >

                <label for="icerik">İçerik</label>
                <div class="edit">
                    <textarea id="icduztext" rows="25" ></textarea>
                </div>

                <label for="aciklama">Açıklama</label>
                <input type="text" name="aciklama" >


                <label for="etiket">Etiket</label>
                <input type="text" name="etiket" >


                <label for="link">Link</label>
                <input type="text" name="link" >

                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" >

                <label for="resim">Resim</label>
                <input type="text" name="resim" >
                <a href="#" id="icerikkaydet" >Kaydet</a>
            </div>




            <div class="icerikekle">
                <h2>Ekle</h2>
                <label for="baslik">Başlık</label>
                <input type="text" name="baslik" >

                <label for="icerik">İçerik</label>
                <textarea name="icerik" id="icektext" rows="25"></textarea>


                <label for="aciklama">Açıklama</label>
                <input type="text" name="aciklama">


                <label for="etiket">Etiket</label>
                <input type="text" name="etiket" >


                <label for="link">Link</label>
                <input type="text" name="link">

                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" >

                <label for="resim">Resim</label>
                <input type="text" name="resim" >

                <a href="#" id="icerikekle" ">Kaydet</a>
            </div>

        </div>


        <h1>İçerikler</h1>
        <div class="icerik">
        <ul>
            <?php
            $cek=$db->query("select * from icerik order by id desc");
            if($cek->rowCount()){
                foreach($cek as $a){
                    ?>
                    <li><a name="<?php echo $a['id']?>" href="#"><?php echo $a['baslik']; ?></a></li>
                    <?php
                }
            }
            ?>

        </ul>
        </div>

    </div>
    </body>
    <?php require_once 'footer.php'; }else {header("location:giris.php");}?>