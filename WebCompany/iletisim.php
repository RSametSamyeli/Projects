    <?php 
    $title="İletişim Sayfası"; 
    $ozet="Izbarco Web Tasarım Ajansı iletişim bilgileri. Telefon: 505 156 30 83 - Adres: Yeni Mahalle Yaşam Sokak No:12/A Eğirdir/ISPARTA";
    $anahtar="ısparta web tasarım nerede, ısparta web tasarım firması bul, web tasarım firması telefon numarası, web tasarım firması adres";
    require_once 'header.php'; 
    $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
    $kullanicisor->execute(array(
    	'mail' => $_SESSION['userkullanici_mail']
    ));
    $say=$kullanicisor->rowCount();
    $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
    ?>

    <!-- Start Page Hero -->
    <section class="page-hero">
    	<div class="page-hero-parallax">

    		<div class="hero-image bg-img-16">

    			<div class="hero-container container pt50">  
    				<div class="hero-content text-left scroll-opacity"> 
    					<div class="section-heading">
    						<h1 class="white mb10 animated slideInDown">Bize Ulaşın</h1>
    						<h5 class="white pl5 animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?> İletişim Bilgileri</h5>  
    					</div>  
    					<ol class="breadcrumb animated slideInRight">
    						<li><a href="index.php">Anasayfa</a></li>
    						<li style="color: #0CB4CE" class="active">İletişim</li>
    					</ol>
    				</div> 
    			</div> 

    		</div> 

    	</div>
    </section>
    <!-- End Page Hero -->

    <div class="site-wrapper">  

    	<!-- Start Contact Form Section -->    
    	<section id="contact">
    		<div class="container">
    			<div class="row">   

    				<div class="col-sm-8"> 
    					<div id="message"><?php
    					if ($_GET['durum']=='ok') {?> 
    					<div class="alert alert-success mt-lg" id="contactSuccess">
    						<strong>Başarılı!</strong> Mesajınız Başarıyla Gönderildi.
    					</div>
    					<?php } elseif ($_GET['durum']=='no')  {?>
    					<div class="alert alert-danger mt-lg" id="contactError">
    						<strong>Hata!</strong> Mesaj Gönderilirken Bir Hata İle Karşılaşıldı.
    						<span class="font-size-xs mt-sm display-block" id="mailErrorMessage"></span>
    					</div>
    					<?php } ?>
    				</div>



    				<form  action="panel/netting/islem.php" method="POST">
    					<fieldset>
    						<?php if (isset($_SESSION['userkullanici_mail'])) {?>

    						<input name="adsoyad" type="text" readonly="" id="name" placeholder="<?php echo $kullanicicek['kullanici_adsoyad']; ?>" value="<?php echo $kullanicicek['kullanici_adsoyad']; ?>"/> 
    						<input name="email" type="text" readonly="" id="email" placeholder="<?php echo $kullanicicek['kullanici_mail']; ?>" value="<?php echo $kullanicicek['kullanici_mail']; ?>"/> 
                            <input name="gsm" type="text" readonly="" id="name" placeholder="<?php echo $kullanicicek['kullanici_gsm']; ?>" value="<?php echo $kullanicicek['kullanici_gsm']; ?>"/> 

                            <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>">

                            <?php } else {?>
                            <input name="adsoyad" maxlength="120" type="text"  id="name" placeholder="Adınız ve Soyadınız"/> 
                            <input type="email" name="email" type="text" id="email" placeholder="E-Posta Adresiniz"/> 
                            <input type="hidden" name="kullanici_id" value="sıfır">
                            <input name="gsm" type="tel" id="subject" placeholder="Telefon Numarası"/>
                            <?php } ?>
                            <input name="konu" type="text" id="subject" placeholder="Konu"/>

                        </fieldset>
                        <fieldset> 
                          <textarea name="yorum_detay" cols="40" rows="3" id="comments" placeholder="Mesajınız"></textarea>
                      </fieldset>
                      <input type="submit" name="yorumkaydet" value="Mesajı Gönder" class="submit" id="submit" />
                  </form>
              </div>  

              <div class="col-md-4 pt15">
                <h4>İletişim</h4>
                <p class="contact-info">Ajansımıza 7/24 form'dan ulaşabilirsiniz. <br> Yazdığınız mesajlar en geç 1 gün içinde garantili dönüş yapılmaktadır.</p>
                <h4>Adresimiz</h4>

                <ul class="contact-address">
                 <li><strong>Telefon:</strong> <?php echo $ayarcek['ayar_gsm'] ?></li>
                 <address>
                  <li><strong>Adres:</strong> <?php echo $ayarcek['ayar_adres'] ?> </li> 
                  <li><?php echo $ayarcek['ayar_ilce']." / ".$ayarcek['ayar_il'] ?></li>
              </address>
          </ul> 

          <h4><?php echo $ayarcek['ayar_isim']; ?> Sosyal Ağ</h4> 
          <ul class="contact-details-social">
             <li><a href="<?php echo $ayarcek['ayar_twitter']; ?>"><i class="ion-social-twitter"></i></a></li>
             <li><a href="<?php echo $ayarcek['ayar_facebook']; ?>"><i class="ion-social-facebook"></i></a></li>
             <li><a href="<?php echo $ayarcek['ayar_google']; ?>"><i class="ion-social-google"></i></a></li>
             <li><a href="<?php echo $ayarcek['ayar_instagram']; ?>"><i class="ion-social-instagram"></i></a></li>
         </ul> 
     </div>

 </div>
</div>
</section>
<!-- End Contact Form Section -->
<?php if (strlen($ayarcek['ayar_goooglemap'])>0) {?>
<section class="google-map map3 height450"></section>
<?php } ;?>
<?php 
require_once 'footer.php'; ?>