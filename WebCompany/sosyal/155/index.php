<?php session_start();
if (isset($_SESSION['yonetim'])) {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="box">
            <a href="paket">
                <i class="fa fa-star" aria-hidden="true"></i>
                <p>Keşfet Paketleri</p>
            </a>
        </div>
        <div class="box">
            <a href="islem">
                <i class="fas fa-user-plus"></i>
                <p>Otomatik İşlemler</p>
            </a>
        </div>
        <div class="grup">
            <div class="bakiye">
                <h1>Bakiye Ekle</h1>
                <input type="text" name="kid" placeholder="Kullanici İD / Ad Soyad / Telefon / Mail">
                <div class="inputs">
                </div>
                <a href="#" name="bakiyeekle" id="#bakiyeekle">Bakiye Ekle</a>
                <a href="#" name="bakiyecikar" id="#bakiyecikar">Bakiye Çıkar</a>
            </div>
            <div class="sms">
                <h1>Toplu SMS Gönder</h1>
                <textarea rows="5" placeholder="SMS İÇERİĞİ"></textarea>
                <a href="#" id="smsgonder">Gönder</a>
            </div>
        </div>
        <div class="duyuru">
            <div class="duyuruekle">
                <a href="#" name="yeniduyuru">Duyuru Ekle</a>
            </div>
            <script>
                $("a[name=yeniduyuru]").click(function (a) {
                    a.preventDefault();
                    $(".duyek").slideDown();
                })
            </script>

            <h1>Duyurular</h1>
            <?php
            $cek=$db->query("select * from duyuru order by id desc limit 10");
            if($cek->rowCount()){
                foreach($cek as $geldi){
                    $tar=strtotime($geldi['tarih']);
                    $tar=date("d-m-Y",$tar);
                    ?>
                    <span>
                        <div class="gur">
                        <h2><?php echo $geldi['baslik']; ?></h2>
                        <p><?php echo $geldi['icerik']; ?></p>
                        <span id="tarih"><?php echo $tar; ?></span>
                            </div>
                        <a href="#" name="duysil" id="<?php echo $geldi['id']; ?>">Sil</a>
                    </span>
                    <?php
                }
            }
            ?>

            <div class="duyek">
                <h1>Yeni Duyuru Ekle</h1>
                <input type="text" name="duybas" placeholder="Duyuru Başlığı">
                <textarea name="duyic" placeholder="Duyuru Metni" rows="10"></textarea>
                <a href="#" name="duyay">Duyuru Yayınla</a>
            </div>
        </div>
        <script>
            $("a[name=duyay]").click(function (a) {
                a.preventDefault();
               var baslik=$("input[name=duybas]").val();
               var icerik=$("textarea[name=duyic]").val();
               $.ajax({
                   type:"post",
                   url:"ajax.php",
                   data:{
                       "duyek":1,
                       "duybas":baslik,
                       "duyic":icerik
                   },success:function (cevap) {
                       cevap=cevap.trim();
                       if(cevap){
                           alert("Duyuru Yayınlandı...");
                           window.location.reload();
                       }
                   }
               })
            });
            $("a[name=duysil]").click(function () {
                var id=$(this).attr('id');
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{
                        "duysil":1,
                        "id":id
                    },success:function (cevap) {
                        cevap=cevap.trim();
                        if(cevap){
                            alert("Duyuru silindi...");
                            window.location.reload();
                        }
                    }
                })
            });
            $("#smsgonder").click(function (aaa) {
				aaa.preventDefault();
				if (confirm('Sms gönderilecek, onaylıyor musunuz?')) {
                var mesaj = $(".sms textarea").val();
                if ($(".sms textarea").val() != "") {
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "toplusms": 1,
                            "mesaj": mesaj
                        }, success: function (cevap) {
                          
                        }
                    })
                }
				} else {

}
            })
        </script>
    </div>
    </body>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>