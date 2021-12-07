<?php if($_SESSION['yonetim']!=""){?>
<div class="sol">
    <div class="logo">
        <a href="index.php"><img src="../resimler/logo_3.png"></a>
    </div>
    <ul class="res">
        <li><a href="index.php">Anasayfa</a></li>
        <li><a href="uyeler.php">Üyeler</a></li>
        <li><a href="uyeoto.php">Otomatik Beğeniler</a></li>
        <li><a href="kategoriler.php">Kategoriler</a></li>
        <li><a href="servisler.php">Servisler</a></li>
        <li><a href="servisekle.php">Servisler Ekle</a></li>
        <li><a href="islemakisi.php">İşlem Akışı</a></li>
        <li><a href="icerik.php">İçerik</a></li>
        <li><a href="tik.php">Mavi Tik</a></li>
        <li><a href="odemeakisi.php">Ödeme Akışı</a></li>
        <li><a href="cikis.php">Çıkış</a></li>
    </ul>
</div>
    <div class="respons">
        <span>&#9776;</span>
    </div>

    <script>
        var dur=0;
        $(".respons").click(function () {
            if(dur==0){
           $(".sol ul li a").show();
           dur=1;
            }else if(dur==1) {
                $(".sol ul li a").hide();
                dur=0;
            }
            $(document).scroll(function () {

                $(".sol ul li a").hide();
                dur=0;
            });
        });
    </script>

<?php }else {header("location:giris.php");}?>