<?php 
ob_start();
session_start();
require_once 'panel/netting/baglan.php';
require_once 'panel/app/ponki.php';

if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

	exit("Bu sayfaya erişim yasak");

}

$iceriksor=$db->prepare("SELECT * from icerik where icerik_id=:icerik_id");
$iceriksor->execute(array(
	'icerik_id' => $_GET['icerik_id']
));

$a=$icerikcek['icerik_ad'];

$icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC);


$ayarsor=$db->prepare("select * from ayar where ayar_id=?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
	'mail' => $_SESSION['userkullanici_mail']
));
$say=$kullanicisor->rowCount();
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="tr">
<head>
	<!-- Klasik Metalar -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--Mobilde Üst Kısmı Renkli-->
	<meta name="theme-color" content="#2ECD71">

	<!--Anahtar Kelimeler-->
	<meta name="keywords" content="<?php if (empty($anahtar)) {
		echo $ayarcek['ayar_keywords'];
	} else {
		echo $anahtar;
	} 
	?>">

	<!--Açıklama-->
	<meta name="description" content="<?php if (empty($ozet)) {
		echo $ayarcek['ayar_description'];
	} else {
		echo $ozet;
	} 
	?>">

	<!--Yazar-->
	<meta name="author" content="<?php echo $ayarcek['ayar_author']; ?>">
	<!-- Twitter Kart Görüntüleme -->  
	<meta name="twitter:card" content="summary_large_image">  
	<meta name="twitter:site" content="@sametsamyeli2">  
	<meta name="twitter:creator" content="SametSamyeli2">  
	<meta name="twitter:title" content="<?php if (empty($title)) {
		echo $ayarcek['ayar_title'];
	} else {
		echo $title." - ".$ayarcek['ayar_title'];
	} 
	?>">  
	<meta name="twitter:description" content="<?php if (empty($ozet)) {
		echo $ayarcek['ayar_description'];
	} else {
		echo $ozet;
	} 

	?>">  
	<meta name="twitter:image:src" content="<?php if (empty($resim)) {
		echo $ayarcek['ayar_resim'];
	} else {
		echo $ayarcek['ayar_siteurl'].$resim;
	} 
	?>"> 

	<!-- Facebook Kart Görüntüleme  -->  
	<meta property="og:url" content="<?php if (empty($link)) {
		echo $ayarcek['ayar_siteurl'];
	} else {
		echo "http://www.".$link;
	} 
	?>">  
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php if (empty($title)) {
		echo $ayarcek['ayar_title'];
	} else {
		echo $title." - ".$ayarcek['ayar_title'];
	} 
	?>">  
	<meta property="og:image" content="<?php if (empty($resim)) {
		echo $ayarcek['ayar_resim'];
	} else {
		echo $ayarcek['ayar_siteurl'].$resim;
	} 
	?>">  
	<meta property="og:description" content="<?php if (empty($ozet)) {
		echo $ayarcek['ayar_description'];
	} else {
		echo $ozet;
	} 
	?>">  

	<!-- Firma Adı-->
	<meta property="og:site_name" content="<?php echo $ayarcek['ayar_isim']; ?>">  

	<!-- Resim Alt Özelliği-->
	<meta property="og:image:alt" content="<?php if (empty($ozet)) {
		echo $ayarcek['ayar_description'];
	} else {
		echo substr($ozet, 0,100);
	} 
	?>">  

	<!-- Skype Paylaşım Göstergesi-->
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>

	<!-- Google+ Kart Görüntüleme  -->  
	<meta itemprop="name" content="<?php if (empty($title)) {
		echo $ayarcek['ayar_title'];
	} else {
		echo $title." - ".$ayarcek['ayar_title'];
	} 
	?>">  
	<meta itemprop="description" content="<?php if (empty($ozet)) {
		echo $ayarcek['ayar_description'];
	} else {
		echo $ozet;
	} 
	?>">  
	<meta itemprop="image" content="<?php if (empty($resim)) {
		echo $ayarcek['ayar_resim'];
	} else {
		echo $ayarcek['ayar_siteurl'].$resim;
	} 
	?>">   

	<!-- Google Robotlar-->
	<meta name="robots" content="index, follow, noodp, noydir"/>

	<!-- Yerel Gösterge Ayarları -->
	<meta name="dc.language" content="TR">

	<meta name="dcterms.subject" content="Web Tasarım Ajansı">

	<meta name="dcterms.rights" content="<?php echo $ayarcek['ayar_isim']; ?>">

	<meta name="dcterms.audience" content="Global">

	<meta name="geo.a3" content="<?php echo $ayarcek['ayar_ilce'].' '.$ayarcek['ayar_il']; ?>">

	<meta name="geo.country" content="tr">

	<meta name="geo.placename" content="<?php echo $ayarcek['ayar_il']; ?>">

	<meta name="revisit-after" content="1 days"/>


	<!-- Cep Telefonu TaskBar Renk Göstergeleri-->
	<meta name="theme-color" content="#0EAAC2">

	<meta name="msapplication-navbutton-color" content="#0EAAC2">

	<meta name="apple-mobile-web-app-status-bar-style" content="#0EAAC2">


	<title><?php if (empty($title)) {

		echo $ayarcek['ayar_title'];

	} else {

		echo $title." - ".$ayarcek['ayar_title'];
	} 

	?></title> 

	<!-- Mobile Meta Kodları -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Font  -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400" rel="stylesheet">


	<!-- Vendor CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/font-awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="vendor/animate/animate.min.css">
	<link rel="stylesheet" href="vendor/linear-icons/css/linear-icons.min.css">
	<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

	<!-- Tema CSS -->
	<link rel="stylesheet" href="css/theme.css">
	<link rel="stylesheet" href="css/theme-elements.css">

	<!-- Slider CSS Dosyaları -->
	<link rel="stylesheet" href="vendor/rs-plugin/css/settings.css">
	<link rel="stylesheet" href="vendor/rs-plugin/css/layers.css">
	<link rel="stylesheet" href="vendor/rs-plugin/css/navigation.css">

	<!-- Skin CSS -->
	<link rel="stylesheet" href="css/skins/default.css">		
	<script src="master/style-switcher/style.switcher.localstorage.js"></script> 

	<!-- Tema Ayar CSS -->
	<link rel="stylesheet" href="css/custom.css">

	<!-- Sıfırlama CSS -->
	<script src="vendor/modernizr/modernizr.min.js"></script>

	
</head>
<body>
	<div class="body">

		<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 120, 'stickySetTop': 0}">
			<div class="header-body">
				<div class="header-top header-top-dark">
					<div class="header-top-container container">
						<div class="header-row">
							<div class="header-column justify-content-start">
								<span class="d-none d-sm-flex align-items-center">
									<i class="fas fa-map-marker-alt mr-1"></i>
									<?php echo $ayarcek['ayar_adres'] ?> <?php echo $ayarcek['ayar_ilce']." / ".$ayarcek['ayar_il'] ?>
								</span>
								<span class="d-none d-sm-flex align-items-center ml-4">
									<i class="fas fa-phone mr-1"></i>
									<a href="tel:<?php echo $ayarcek['ayar_gsm'] ?>"><?php echo $ayarcek['ayar_gsm'] ?></a>
								</span>
							</div>
							<div class="header-column justify-content-end">
								<ul class="header-top-social-icons social-icons social-icons-transparent d-none d-md-block">
									<li class="social-icons-facebook">
										<a href="<?php echo $ayarcek['ayar_facebook'];?>" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
									</li>
									<li class="social-icons-twitter">
										<a href="<?php echo $ayarcek['ayar_twitter'];?>" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
									</li>
									<li class="social-icons-instagram">
										<a href="<?php echo $ayarcek['ayar_instagram'];?>" target="_blank" title="Instragram"><i class="fab fa-instagram"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="header-container container">
					<div class="header-row">
						<div class="header-column justify-content-start">
							<div class="header-logo">
								<a href="index.php">

									<!-- LOGO -->

									<img alt="<?php echo $ayarcek['ayar_isim']; ?> Logosu" src="<?php echo $ayarcek['ayar_logo']; ?>" width="197" height="100">

									<!-- LOGO -->

								</a>
							</div>
						</div>

						<!-- MENU BASLANGIC -->
						<div class="header-column justify-content-end">
							<div class="header-nav">
								<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav flex-column flex-lg-row" id="mainNav">


											<!-- Menu PHP -->
											<li><a href="index.php">ANASAYFA</a></li>
											<?php 

											$menusor=$db->prepare("select * from menu where menu_ust=:menu_ust and menu_durum=1 order by menu_sira");
											$menusor->execute(array(
												'menu_ust' => 0
											));
											while($menucek=$menusor->fetch(PDO::FETCH_ASSOC)) {
												$menu_id=$menucek['menu_id'];
												$altmenusor=$db->prepare("select * from menu where menu_ust=:menu_id and menu_durum=1 order by menu_sira");
												$altmenusor->execute(array(
													'menu_id' => $menu_id
												));
												$say=$altmenusor->rowCount();

												?>


												<li <?php if ($say>0) {?>

												class="dropdown"

												<?php } else {?>

												<?php } ?>

												>

												<a <?php if ($say>0) {?> class="dropdown-item dropdown-toggle" <?php } ?> href="<?php

												if (strlen($menucek['menu_url'])>0) {

													echo $menucek['menu_url'];

												} elseif (strlen($menucek['menu_url'])==0) {?>

												sayfa-<?=seo($menucek["menu_ad"]).'-'.$menucek["menu_id"]?>

												<?php }

												?>"><?php echo $menucek['menu_ad']; ?></a>

<?php if ($say>0) {?>
												<ul class="dropdown-menu">
													<?php 

													while($altmenucek=$altmenusor->fetch(PDO::FETCH_ASSOC)) {
														?>
														<li><a class="dropdown-item" href="<?php

														if (strlen($altmenucek['menu_url'])>0) {

															echo $altmenucek['menu_url'];

														} elseif (strlen($altmenucek['menu_url'])==0) {?>

														sayfa-<?=seo($altmenucek["menu_ad"]).'-'.$altmenucek["menu_id"]?>

														<?php }

														?>"><?php echo $altmenucek['menu_ad']; ?></a></li>
														<?php  } ?>
													</ul>
													<?php } ?>
												</li>
												<?php  } ?>
											</ul>






										</nav>
									</div>
									<button class="header-btn-collapse-nav ml-3" data-toggle="collapse" data-target=".header-nav-main nav">
										<span class="hamburguer">
											<span></span>
											<span></span>
											<span></span>
										</span>
										<span class="close">
											<span></span>
											<span></span>
										</span>
									</button>
								</div>
							</div>

							<!--MENU HTML SON -->

						</div>
					</div>
				</div>
			</header>
			<?php $menusor=$db->prepare("SELECT * from menu where menu_id=:menu_id");
			$menusor->execute(array(
				'menu_id' => $_GET['menu_id']
			));

			$a=$menucek['menu_ad'];

			$menucek=$menusor->fetch(PDO::FETCH_ASSOC);

			$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
			$hakkimizdasor->execute(array(0));
			$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

			?>