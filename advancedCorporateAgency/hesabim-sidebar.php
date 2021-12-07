 <?php

 if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

 	exit("Bu sayfaya erişim yasak");

 }
 require_once 'header.php'; ?>



 <h3 class="white mb5 mt60">Merhaba, <?php echo $kullanicicek['kullanici_adsoyad'] ?></h3> 
 <p class="white">Bu sayfadan kullanıcı bilgilerini ekleyebilir veya düzeltebilirsin</p>

 <div id="message"><?php
 	if ($_GET['durum']=='ok') {?> 
 	<br><div class="alert alert-success mt-lg" id="contactSuccess">
 		Bilgileriniz Başarıyla Kayıt Edildi.
 	</div>
 	<?php } elseif ($_GET['durum']=='no')  {?>
 	<br><div class="alert alert-danger mt-lg" id="contactError">
 		Bilgileriniz Kayıt Edilirken Bir Hata İle Karşılaşıldı.
 		<span class="font-size-xs mt-sm display-block" id="mailErrorMessage"></span>
 	</div>
 	<?php } ?>
 </div>

 <br><br>

 <div class="col-md-12">
 	<span><a href="hesabim.php" style="color: #0CB4CE">Kullanıcı Bilgileri</a></span> -
 	<span><a href="#" style="color: #FFFFFF;">Siparişlerim</a></span> -
 	<span><a href="#" style="color: #FFFFFF">Ticket ( <u style="color: #0CB4CE">0</u> ) </a></span> -
 	<span><a href="#" style="color: #FFFFFF">Kredi Sistemi</a></span>
 	<hr>