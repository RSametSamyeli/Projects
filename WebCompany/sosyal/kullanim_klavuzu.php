<?php session_start();
if (isset($_SESSION["mail"])) {
    include 'header.php';
    include 'left.php'; ?>
    <div class="orta">
        <div class="ic">
            <h1>Satın Alma Klavuzu</h1>
            <div class="kk">
                <img src="resimler/kk.jpg" width="100%">
                <p>1-) <b>Hizmet Listesi:</b> Bu kısımda hizmet listesi yer almakta olup, satın alacağınız hizmeti (Youtube İzlenme, İnstagram Takipçi vb..) buradan seçebilirsiniz.</p>
                <p>2-) <b>Servis Listesi:</b> Hizmet seçimi gerçekleştirdikten sonra hizmete dair servisi buradan seçebilirsiniz.</p>
                <p>3-) <b>Fiyat:</b> Servisin 1000 adet için belirlenmiş fiyatıdır.</p>
                <p>4-) <b>Açıklama:</b> Bu kısımda servis hakkında açıklamalar, maksimum yada minimum ne kadar satın alabileceğiniz gibi bilgiler yer alır.</p>
                <p>5-) <b>Link:</b> İşlem satın alacağınız fotoğrafınız, videonuz yada profiliniz için istenen bağlantıdır. Açıklamada aksi belirtilmediği taktirde tam link girmeniz gerekmektedir.</p>
                <p>6-) <b>Adet:</b> Satın almak istediğiniz miktarı bu kısma giriniz.</p>
                <p>7-) <b>Ücret:</b> Miktar girdikten sonra otomatik olarak hesaplama yapılarak bakiyenizden eksilecek tutar burada gösterilmektedir.</p>







            </div>
        </div>
    </div>
    <?php
    include_once 'footer.php';
} else {
    header("location:/");
}
?>