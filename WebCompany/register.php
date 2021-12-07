<?php 
$title="Kayıt Ol";
$ozet="İnternet üzerinden hazırlanmış hazır yazılımları satın alabilmek ve ticket sistemi için lütfen kayıt olun.";


include "header.php"; ?>
<!-- Start Coming Soon Section -->
<section id="sign-up" class="bg-img-10"> 
    <div class="sign-up-container"> 

        <div class="container text-center">

            <div class="col-md-12 dark"> 
                <h3 class="mb5 white">Kayıt Oluşturma Paneli</h3> 
                <p class="subheading white"><?php echo $ayarcek['ayar_isim']; ?> 'a Hoşgeldiniz</p>
                <div class="login-form pt30 pb30">
                   <form action="panel/netting/islem.php" method="POST">
                       <?php 

                       if ($_GET['durum']=="farklisifre") {?>

                       <div class="alert alert-danger">
                        <strong>Hata!</strong> Girdiğiniz şifreler eşleşmiyor.
                    </div>
                    
                    <?php } elseif ($_GET['durum']=="eksiksifre") {?>

                    <div class="alert alert-danger">
                        <strong>Hata!</strong> Şifreniz minimum 6 karakter uzunluğunda olmalıdır.
                    </div>
                    
                    <?php } elseif ($_GET['durum']=="mukerrerkayit") {?>

                    <div class="alert alert-danger">
                        <strong>Hata!</strong> Bu kullanıcı daha önce kayıt edilmiş.
                    </div>
                    
                    <?php } elseif ($_GET['durum']=="basarisiz") {?>

                    <div class="alert alert-danger">
                        <strong>Hata!</strong> Kayıt Yapılamadı Sistem Yöneticisine Danışınız.
                    </div>
                    
                    <?php }
                    ?>
                    <input class="sign-up-first-name bg-transparent" type="text" name="kullanici_adsoyad" placeholder="Adınız ve Soyadınız">
                    <input class="sign-up-first-name bg-transparent" type="tel" name="kullanici_gsm" placeholder="Telefon Numaranız">
                    <input class="sign-up-email bg-transparent" type="text"  name="kullanici_mail" placeholder="E-Posta Adresiniz">
                    <input class="sign-up-password bg-transparent" type="password" name="kullanici_passwordone" placeholder="Şifre">
                    <input class="sign-up-password bg-transparent" type="password" name="kullanici_passwordtwo" placeholder="Şifre Tekrar">
<!--
                    <div class="actions">
                        <p class="terms">Üye olduğunuzda <a href="#">Kullanıcı Sözleşmesini</a> onaylamış olursunuz.</p> 
                    </div>-->

                    <input class="btn btn-sm btn-primary btn-sign-up" name="kullanicikaydet" type="submit" value="Kayıt Ol">
                </form>  
            </div> 
            <p>Zaten üye misiniz? O zaman şimdi <a style="color: #0CB4CE" href="musteri-panel.php">giriş yapın</a>!</p> 

        </div>   

    </div>

</div> 
</section>
<!-- End Coming Soon Section -->   

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script src="js/plugins.js"></script>             
<script src="js/scripts.js"></script>  

</body>
</html>