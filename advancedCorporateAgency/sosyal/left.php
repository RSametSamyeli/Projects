<?php if(isset($_SESSION["mail"])) { ?>
    <div class="sol">
        <a id="logo" href="/"><img src="resimler/logo_3.png"></a>
        <div class="para">

        </div>
        <div class="menu">
            <ul>
                <li>  <a><b>₺</b> <?php
                        $bakiye = $db->query("select * from uye where id='{$_SESSION['uye_id']}'")->fetch(PDO::FETCH_ASSOC);
                        echo round($bakiye['bakiye'], 2);
                        ?></a></li>
                <li><a href="<?php echo $sitelink ?>"><i class="fas fa-home"></i> Anasayfa</a></li>
                <li><a href="islemler"><i class="fas fa-bars"></i> İşlemler</a></li>
                <li><a href="oto"><i class="fas fa-tachometer-alt"></i> Oto Beğeni/İzlenme</a></li>
                <li><a href="hesap"><i class="fas fa-user"></i> Hesabım</a></li>


                <li><a href="bakiye"><i class="fas fa-plus"></i> Bakiye Ekle</a></li>
                <li><a href="cikis"><i class="fas fa-sign-out-alt"></i> Çıkış</a></li>
            </ul>
        </div>
    </div>
    <?php
}else {header("location:/");}
?>