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

	<meta charset="utf-8">
	<meta name="theme-color" content="#0EAAC2">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NLTS3R6');</script>
<!-- End Google Tag Manager -->

<meta name="keywords" content="<?php if (empty($anahtar)) {
	echo $ayarcek['ayar_keywords'];
} else {
	echo $anahtar;
} 
?>"" />
<meta name="description" content="<?php if (empty($ozet)) {
	echo $ayarcek['ayar_description'];
} else {
	echo $ozet;
} 
?>">
<meta name="author" content="<?php echo $ayarcek['ayar_author']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Social: Twitter / Open Graph -->  
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

<!-- Social: Facebook / Open Graph -->  
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
<meta property="og:site_name" content="<?php echo $ayarcek['ayar_isim']; ?>">  
<meta property="og:image:alt" content="<?php if (empty($ozet)) {
	echo $ayarcek['ayar_description'];
} else {
	echo substr($ozet, 0,100);
} 
?>">  
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>

<!-- Social: Google+ / Schema.org  -->  
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

<meta name="robots" content="index, follow, noodp, noydir"/>


<meta name="dc.language" content="TR">

<meta name="dcterms.subject" content="Web Tasarım Ajansı">

<meta name="dcterms.rights" content="<?php echo $ayarcek['ayar_isim']; ?>">

<meta name="dcterms.audience" content="Global">

<meta name="geo.a3" content="<?php echo $ayarcek['ayar_ilce'].' '.$ayarcek['ayar_il']; ?>">

<meta name="geo.country" content="tr">

<meta name="geo.placename" content="<?php echo $ayarcek['ayar_il']; ?>">

<meta name="revisit-after" content="1 days"/>

<meta name="theme-color" content="#0EAAC2">

<meta name="msapplication-navbutton-color" content="#0EAAC2">

<meta name="apple-mobile-web-app-status-bar-style" content="#0EAAC2">


<title><?php if (empty($title)) {

	echo $ayarcek['ayar_title'];

} else {

	echo $title." - ".$ayarcek['ayar_title'];
} 

?></title> 




<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/site.webmanifest">
<link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#00aba9">
<link href="css/plugins.css" rel="stylesheet" type="text/css" media="all">   
<link href="css/theme.css" rel="stylesheet" type="text/css" media="all">  
<link href="css/icon-fonts.css" rel="stylesheet" type="text/css" media="all">
<link href="css/custom.css" rel="stylesheet" type="text/css" media="all">  
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300%7CMontserrat:400,700%7CRaleway:400,200,300' rel='stylesheet' type='text/css'> 
<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
<link rel=”alternate” href=”http://izbarco.com/”  hreflang=”tr-tr” />
<link rel="stylesheet" href="css/animate/animate.min.css">

<meta name="yandex-verification" content="29c93e8b4d206f28" />

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37749924-4"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-37749924-4');
</script>

<script type="text/javascript">
	if(top != self) {
		window.open(self.location.href, '_top');
	}
</script>

</head>
<body> 
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NLTS3R6"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<!-- Start Header --><header>
		<nav class="navbar navbar-default transparent">
			<div class="container">

				<div class="navbar-header ">
					<div class="container">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Menu</span>
							<span class="icon-bar top-bar"></span>
							<span class="icon-bar middle-bar"></span>
							<span class="icon-bar bottom-bar"></span>
						</button>
						<a class="navbar-brand logo-light" href="index.php"><img src="<?php echo $ayarcek['ayar_logo']; ?>" alt="<?php echo $ayarcek['ayar_isim']; ?> Logosu"></a>
						<a class="navbar-brand logo-dark" href="index.php"><img src="<?php echo $ayarcek['ayar_logo2']; ?>" alt="<?php echo $ayarcek['ayar_isim']; ?> Logosu"></a>
					</div>
				</div>

				<div id="navbar" class="navbar-collapse collapse">
					<div class="container">
						<ul class="nav navbar-nav menu-right"> 


							<!-- Menu -->
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

								<li class="dropdown menu_ust"><a href="<?php

								if (strlen($menucek['menu_url'])>0) {

									echo $menucek['menu_url'];

								} elseif (strlen($menucek['menu_url'])==0) {?>

								sayfa-<?=seo($menucek["menu_ad"]).'-'.$menucek["menu_id"]?>

								<?php }

								?>" class="dropdown-toggle"><?php echo $menucek['menu_ad']; ?><i class="<?php if ($say>0) {
									echo "fa fa-chevron-down";
								} ?>"></i></a> 

								<ul class="dropdown-menu">  
									<?php 

									while($altmenucek=$altmenusor->fetch(PDO::FETCH_ASSOC)) {
										?>
										<li><a href="<?php

										if (strlen($altmenucek['menu_url'])>0) {

											echo $altmenucek['menu_url'];

										} elseif (strlen($altmenucek['menu_url'])==0) {?>

										sayfa-<?=seo($altmenucek["menu_ad"]).'-'.$altmenucek["menu_id"]?>

										<?php }

										?>"><?php echo $altmenucek['menu_ad']; ?></a></li>
										<?php  } ?>
									</ul>

								</li>

								<?php  } ?>

								<!-- Menu -->   

								<!-- Search Icon Button -->

								<li class="header-divider"><a><span></span></a></li> 
								<?php 

								if (!isset($_SESSION['userkullanici_mail'])) {?>
								<li class="menu_ust"><a style="color: #0CB4CE" href="musteri-panel.php">Giriş Yap</a></li>
								<li class="menu_ust"><a style="color: #0CB4CE" href="register.php">Kayıt Ol</a></li>
								<?php } else { ?>
								<ul style="float:right; text-align:right;list-style: none outside none;">
									<li style="    padding-top: 19px;
									line-height: 10px;">Hoşgeldin <strong style="color: #0CB4CE; "><?php echo $kullanicicek['kullanici_adsoyad'] ?></strong></li>
									<li style="position: relative; display: inline;"><strong><a href="hesabim-ana.php" style="font-size: 13px;">Hesap Bilgilerim</a> - </strong></li>
									<li style=" position: relative; display: inline;;"><strong><a href="logout.php" style="font-size: 13px;">Çıkış</a></strong></li>
								</ul>

								<?php } ?>


                                <!--
                                <li class="header-icon-btn">
                                    <a class="popup-with-zoom-anim search" href="#search-modal"><span class="fa fa-search"></span></a>
                                    <div id="search-modal" class="zoom-anim-dialog mfp-hide">
                                        <form>  
                                            <input type="text" id="search-modal-input" placeholder="Ne aramıştınız?" autocomplete="off">
                                        </form>
                                    </div>
                                </li> 

                                <li><a href="<?php echo $ayarcek['ayar_twitter'];?>"><span class="ion-social-twitter"></span></a></li> 
                                 <li><a href="<?php echo $ayarcek['ayar_twitter'];?>"><span class="ion-social-facebook"></span></a></li> 
                                 <li><a href="<?php echo $ayarcek['ayar_twitter'];?>"><span class="ion-social-instagram"></span></a></li> -->

                             </ul>   
                         </div>



                     </div>

                 </div>
             </nav> </header>

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
        <!-- End Header -->