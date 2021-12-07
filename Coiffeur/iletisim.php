    <?php 
    $title="İletişim Sayfası"; 
    $ozet="Graptik Web Tasarım Ajansı iletişim bilgileri";
    require_once 'header.php'; 
    $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
    $kullanicisor->execute(array(
    	'mail' => $_SESSION['userkullanici_mail']
    ));
    $say=$kullanicisor->rowCount();
    $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
    ?>
    <div role="main" class="main">
    	<section class="page-header mb-0">
    		<div class="container">
    			<div class="row align-items-center">
    				<div class="col-md-6 text-md-left">
    					<h1 class="font-weight-bold">Bize Ulaşın</h1>
    				</div>
    				<div class="col-md-6">
    					<ul class="breadcrumb justify-content-md-end">
    						<li><a href="index.php">Anasayfa</a></li>
    						<li class="active">İletişim</li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</section>


    	<section class="section">

    		<div class="container">
    			<div class="row text-center">
    			</div>
    			<div class="row pt-5">
    				<div class="col-lg-4">
    					<div class="row">
    						<div class="col-12 col-md-4 col-lg-12 mb-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter">
    							<div class="icon-box icon-box-style-1">
    								<div class="icon-box-icon">
    									<i class="lnr lnr-apartment text-color-primary"></i>
    								</div>
    								<div class="icon-box-info mt-1">
    									<div class="icon-box-info-title">
    										<h3 class="font-weight-bold text-4 mb-0">Adres</h3>
    									</div>
    									<p><?php echo $ayarcek['ayar_adres'] ?><br> 
    										<?php echo $ayarcek['ayar_ilce']." / ".$ayarcek['ayar_il'] ?></p>
    									</div>
    								</div>
    							</div>
    							<div class="col-12 col-md-4 col-lg-12 mb-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
    								<div class="icon-box icon-box-style-1">
    									<div class="icon-box-icon icon-box-icon-no-top">
    										<i class="lnr lnr-envelope text-color-primary"></i>
    									</div>
    									<div class="icon-box-info mt-1">
    										<div class="icon-box-info-title">
    											<h3 class="font-weight-bold text-4 mb-0">E-Posta Adresi</h3>
    										</div>
    										<p><a href="mailto:<?php echo $ayarcek['ayar_mail'] ?>"><?php echo $ayarcek['ayar_mail'] ?></a></p>
    									</div>
    								</div>
    							</div>
    							<div class="col-12 col-md-4 col-lg-12 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="400">
    								<div class="icon-box icon-box-style-1">
    									<div class="icon-box-icon">
    										<i class="lnr lnr-phone-handset text-color-primary"></i>
    									</div>
    									<div class="icon-box-info mt-1">
    										<div class="icon-box-info-title">
    											<h3 class="font-weight-bold text-4 mb-0">Telefon Numarası</h3>
    										</div>
    										<p><a href="tel:<?php echo $ayarcek['ayar_gsm'] ?>"><?php echo $ayarcek['ayar_gsm'] ?></a></p>
    									</div>
    								</div>
    							</div>
    						</div>
    					</div>
    					<div class="col-lg-8 appear-animation mb-4" data-appear-animation="fadeInRightShorter">


    						<form  action="panel/netting/islem.php" method="POST">
    							<div class="contact-form-success alert alert-success d-none">
    								<strong>Başarılı!</strong> Mesajınız Başarıyla Gönderildi.
    							</div>
    							<div class="contact-form-error alert alert-danger d-none">
    								<strong>Hata!</strong> Mesaj Gönderilirken Bir Hata İle Karşılaşıldı.
    								<span class="mail-error-message d-block"></span>
    							</div>
    							<div class="form-row">
    								<div class="form-group col-md-4">
    									<input type="text" value="" data-msg-required="Adınız ve Soyadınız" maxlength="100" class="form-control" name="adsoyad" id="adsoyad" placeholder="Adınız ve Soyadınız" required>
    								</div>
    								<div class="form-group col-md-4">
    									<input type="email" value="" data-msg-required="E-Posta Adresiniz" data-msg-email="E-Posta Adresiniz" maxlength="100" class="form-control" name="email" id="email" placeholder="E-Posta Adresiniz" required>
    								</div>
    								<div class="form-group col-md-4">
    									<input type="gsm" value="" data-msg-required="Telefon Numarası" data-msg-email="Telefon Numarası" maxlength="100" class="form-control" name="gsm" id="gsm" placeholder="Telefon Numarası" required>
    								</div>
    							</div>
    							<div class="form-row">
    								<div class="form-group col">
    									<input type="text" value="" data-msg-required="Konu" maxlength="100" class="form-control" name="konu" id="konu" placeholder="Konu" required>
    								</div>
    							</div>
    							<div class="form-row">
    								<div class="form-group col">
    									<textarea maxlength="5000" data-msg-required="Mesajınız" rows="5" class="form-control" name="yorum_detay" id="yorum_detay" placeholder="Mesajınız" required></textarea>
    								</div>
    							</div>
    							<div class="form-row mt-2">
    								<div class="col">
    									<input type="submit" name="yorumkaydet" value="Mesajı Gönder" class="btn btn-primary btn-rounded btn-4 font-weight-semibold text-0" data-loading-text="Bekleyiniz..">
    								</div>
    							</div>
    						</form>
    					</div>


                                                <div class="row mx-0 appear-animation mt-2" data-appear-animation="fadeInUpShorter">

                            <!-- En Aşağıdan Gerekli Yerler Girilerek Google Maps Ayarı Yapılabilir -->

                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3124.053022635122!2d27.211031315665927!3d38.463337180016595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b97d244a09b747%3A0x3e1f3a1a8e015ee9!2sKaz%C4%B1mdirik+Mahallesi%2C+159.+Sk.+No%3A34+D%3Aa%2C+35100+Bornova%2F%C4%B0zmir!5e0!3m2!1str!2str!4v1549974165534" height="500" width="800" frameborder="0" style="border:0;" allowfullscreen></iframe>
                        </div>

    				</div>
    			</div>

    		</section>

    	</div>

    	
    	<?php require_once 'footer.php'; ?>