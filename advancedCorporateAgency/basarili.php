<?php include "header.php" ?>
<!-- Start Confirmation --> 
<section class="hero-fullscreen confirmation-page">
    <div class="hero-static-fullscreen">

        <div class="hero-image bg-img-9">

            <div class="hero-container container">  
                <div class="hero-content"> 

                    <?php
                    if ($_GET['durum']=='ok') {?> 
                    <i class="ion-ios-checkmark-outline size-8x highlight"></i>
                    <h2 class="white">Başarıyla Giriş Yapıldı!</h2>
                    <p class="mb60 white">Giriş yapma isteğiniz başarı ile gerçekleşti, anasayfaya yönlendiriliyorsunuz!</p> 
                    <meta http-equiv="refresh" content="3;URL=index.php">

                    <?php } elseif ($_GET['durum']=='basarisizgiris')  {?>

                    <i class="ion-ios-close-outline size-8x highlight"></i>
                    <h2 class="white">Bir problem oldu!</h2>
                    <p class="mb60 white">Giriş yapma isteğiniz gerçekleşmedi, lütfen tekrar deneyin. Giriş sayfasına yönlendiriliyorsunuz.</p>
                    <meta http-equiv="refresh" content="3;URL=musteri-panel.php"> 

                    <?php } elseif ($_GET['durum']=='loginbasarili')  {?>
                    <i class="ion-ios-checkmark-outline size-8x highlight"></i>
                    <h2 class="white">Başarıyla Kayıt Olundu!</h2>
                    <p class="mb60 white">Başarıyla kayıt oldunuz. Giriş sayfasına yönlendiriliyorsunuz..</p>
                    <meta http-equiv="refresh" content="3;URL=musteri-panel.php"> 

                    <?php } elseif ($_GET['durum']=='basarisiz')  {?>
                    <i class="ion-ios-checkmark-outline size-8x highlight"></i>
                    <h2 class="white">Bir sorunumuz var!</h2>
                    <p class="mb60 white">Üye kaydı olurken bir problem gerçekleşti, yeniden kayıt sayfasına yönlendiriliyorsunuz.</p>
                    <meta http-equiv="refresh" content="3;URL=register.php"> 
                    <?php } ?>


                    <a href="index.php" class="btn btn-primary btn-xs"><i class="ion-arrow-left-c"></i> Anasayfaya Dönün</a> 

                    <ul class="list-inline mt20">
                        <li><a href="<?php echo $ayarcek['ayar_twitter'];?>"><i class="icon ion-social-twitter"></i></a></li>
                        <li><a href="<?php echo $ayarcek['ayar_facebook'];?>"><i class="icon ion-social-facebook"></i></a></li>
                        <li><a href="<?php echo $ayarcek['ayar_google'];?>"><i class="icon ion-social-google"></i></a></li>
                    </ul> 

                </div> 
            </div> 

        </div>  

    </div>
</section> 
<!-- End Confirmation --> 

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script src="js/plugins.js"></script>             
<script src="js/scripts.js"></script>  

</body>
</html>