<?php  if( !defined("SABIT") ){ exit; } 
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_hesap['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];


seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kapak = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 
/*
## Uyelik Puan 
if($parapuan['puansistemi'] == 1){
	if($parapuan['yeniuyelik'] == 1){
		## Update
		$sql = $conn -> prepare("INSERT INTO puangecmisi SET 
			uye_id      = :uye_id,
			puan_tur    = :puan_tur,	
			puan_toplam = :puan_toplam,
			puan_tarih	= :puan_tarih,
			durum 		= :durum,
			kullanma    = :kullanma			
		");
		$ekle = $sql-> execute(array(
			"uye_id" 		 => $_SESSION["m_id"],
			"puan_tur"		 => 0,
			"puan_toplam" 	 => $parapuan['yeniuyelikdeger'],
			"puan_tarih"	 => time(),
			"durum"			 => 0,
			"kullanma" 		 => 0	
		)); 
		$puanesitle   = $uyebul['uye_puan']  + $parapuan['yeniuyelikdeger'];	
		$puanupdate   = $conn -> exec("UPDATE users SET uye_puan = $puanesitle where id = $uyebul['id'] ");		
	}
}*/
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/hesap.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-inner">
					<ul class="list-inline list-unstyled">
						<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
						<li><?php echo ucfirsttr($lang['yardimci']['uyelik_guncelle']); ?></li>
					</ul>
				</div><!-- /.breadcrumb-inner -->
			</div><!-- /.container -->
		</div><!-- /.breadcrumb -->
<div class="cihaniriboy-outer-page">

		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-9 col-xs-12">
					<div class="inner-page">
						<div class="title">
							<h2>MERHABA <?php echo $uyebul['ad']. " " .$uyebul['soyad']; ?></h2>
							<span>HO??GELD??N??Z</span>
							<p>"Hesab??m" sayfas??ndan sipari??lerinizi ve ar??za/iade/de??i??im i??lemlerinizi takip edebilir, kazand??????n??z hediye ??eki ve puanlar?? g??r??nt??leyebilir, ??yelik bilgisi g??ncelleme, ??ifre ve adres de??i??ikli??i gibi hesap ayarlar??n??z?? kolayca yapabilirsiniz.</p>
						</div>
						<div class="menuler">
							<div class="row">
								<ul>	
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">
											<i class="fa fa-bell" aria-hidden="true"></i>
											<span>Sipari??lerim</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>">
											<i class="fa fa-user" aria-hidden="true"></i>
											<span>??yelik Bilgilerim</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
											<span>Adres Defterim</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sifre_link[$set['lang']['active']]; ?>">
											<i class="fa fa-key" aria-hidden="true"></i>
											<span>??ifremi De??i??tir</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<span>Al????veri?? Sepetim</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>">
											<i class="fa fa-life-ring" aria-hidden="true"></i>
											<span>Destek Taleplerim</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_kuponlarim_link[$set['lang']['active']]; ?>">
											<i class="fa fa-money" aria-hidden="true"></i>
											<span>Hediye ??eklerim & Puanlar??m</span>
										</a>
									</li>
									<li>
										<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_havalebildirimi_link[$set['lang']['active']]; ?>">
											<i class="fa fa-university" aria-hidden="true"></i>
											<span>Havale / Eft Bildirim</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-3 col-xs-12">
					<div class="custom-inner-right">
						<div class="sidebar">
							<?php include('include/sabit/shop-sidebar.php');?>
						</div>
					
					</div>
				</div>
				<!--/right-->
			</div>
		</div>
	</div>
	

<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<?php _footer_last(); ?>

 </body>
</html>