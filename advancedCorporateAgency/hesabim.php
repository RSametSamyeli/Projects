<?php
ob_start();
session_start();
require_once 'header.php'; ?>

<!-- Start Coming Soon Section -->
<section id="login" class="bg-img-11"> 
    <div class="login-container"> 
        <div class="container text-center">

        <?php require_once 'hesabim-sidebar.php'; ?>


            <div class="col-md-6">

                <form action="panel/netting/islem.php" method="POST">
                    <span class="white">Ad Soyad</span>
                    <input class="form-email bg-transparent white" type="text" name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad'] ?>">
                    <span class="white">Telefon Numaranız</span>
                    <input class="form-email bg-transparent white" type="text" name="kullanici_gsm" value="<?php echo $kullanicicek['kullanici_gsm'] ?>">
                    <span class="white">Mail Adresiniz</span>
                    <input class="form-password bg-transparent white" type="text" name="kullanici_mail"    value="<?php echo $kullanicicek['kullanici_mail'] ?>"> 
                    <span class="white">Şifreniz</span>
                    <input class="form-password bg-transparent white" type="password" name="kullanici_password" value="<?php echo $kullanicicek['kullanici_password'] ?>"> 

                </div>
                <div class="col-md-6">
                    <span class="white">İl</span>
                    <input class="form-password bg-transparent white" type="text" name="kullanici_il"    value="<?php echo $kullanicicek['kullanici_il'] ?>"> 
                    <span class="white">İlçe</span>
                    <input class="form-password bg-transparent white" type="text" name="kullanici_ilce"    value="<?php echo $kullanicicek['kullanici_ilce'] ?>"> 
                    <span class="white">Adresiniz</span>
                    <textarea class="bg-transparent white" style="height: 120px" name="kullanici_adres" value="<?php echo $kullanicicek['kullanici_adres'] ?>"><?php echo $kullanicicek['kullanici_adres'] ?></textarea>


                </div>
                <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                <input class="btn btn-primary btn-login" name="kullanicibilgiguncelle" type="submit" value="Kaydet">
            </form> 


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