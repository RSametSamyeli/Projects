<?php 
if( !defined("SABIT") ){ exit; }

if(!isset($_SESSION["m_oturum"])){
	include('include/modules/404/404.php');
	exit;
}

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"])."")->fetch();
if(!$uyebul){
	include('include/modules/404/404.php');
	exit;
}


if(!isset($_SESSION["sonuc"])){
	header('location:/');
}
if($_SESSION["sonuc"]["durum"] == "success"){ 

	$sql = $conn -> prepare("INSERT INTO kredigecmisi SET 
		uye_id      = :uye_id,
		puan_toplam = :puan_toplam,
		puan_tarih	= :puan_tarih,
		durum 		= :durum,
		kullanma    = :kullanma			
	");
	 $sql-> execute(array(
		"uye_id" 		 => $uyebul['id'],
		"puan_toplam" 	 => $_SESSION["fs"]["toplamtutar"],
		"puan_tarih"	 => time(),
		"durum"			 => 0,
		"kullanma" 		 => 0	
	)); 
			
	/// **************** Puan End ************************//////	
}
seoyaz("Ödeme Durumu","","","");
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
</head>
<body>
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		
		<div class="custom-sepet-content">
			<div class="container">
				<div class="siparis-tamam-header">
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-location-arrow"></i>TESLİMAT BİLGİLERİ</h2>
								<p>Teslimat Bilgilerinizi Giriniz </p>
							</div>
							
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-credit-card-alt"></i>ÖDEME SEÇENEKLERİ</h2>
								<p>Ödeme Bilgilerinizi Giriniz</p>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-check" aria-hidden="true"></i>SİPARİŞ ONAYI</h2>
								<p>Siparişiniz Özeti </p>
							</div>
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="odeme-sonuc">
					<?php if($_SESSION["fs"]["odemeturu"] == "kredikarti"){ ?>
						<?php if($_SESSION["sonuc"]["durum"] == "success"){  ?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Kredi Siparişiniz Alındı..</span>
							</div>
							<div class="siparis-no">
								<h3>SİPARİŞ NUMARANIZ</h3>
								<span>#<?php echo $_SESSION["fs"]["oid"]; ?></span>
							</div>
							<div class="odeme-text">
								<span>Sipariş detaylarınızı içeren bilgilendirme mail <?php echo $uyebul['email']; ?> adresine gönderildi.</span>
								<span><?php echo date("d.m.Y H:i",$_SESSION["sonuc"]['date']); ?> tarihinde yapmış olduğunuz işlem sırasında kartınızdan <strong><?php echo number_format($_SESSION["sonuc"]["amount"],2); ?></strong> tutar çekilmiştir.</span>
							</div>
						<?php 
						 # SESSIONLARI SİL
						
						} else { ?>
							<div class="odeme-false">
								<div class="icon">
									<i class="fa fa-times" aria-hidden="true"></i>
								</div>
								<h4>İŞLEMİNİZ GERÇEKLEŞEMEDİ</h4>
								<span><?php echo date("d.m.Y H:i",$_SESSION["sonuc"]['date']);  ?> tarihinde yapmış olduğunuz işlem başarısız oldu. Hata kodu : <?php echo $_SESSION["sonuc"]["hata"]; ?></span>
							
							</div>
						<?php } ?>
						<div class="odeme-links">
							<a class="s" href="<?php echo $set['siteurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
							<a class="b" href="<?php echo $set['siteurl']; ?>">Alışverişe Devam Et</a>
						</div>
						<?php  }else { 
						
								

						?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Kredi Siparişiniz Alındı..</span>
							</div>
							<div class="siparis-no">
								<h3>SİPARİŞ NUMARANIZ</h3>
								<span>#<?php echo $_SESSION["fs"]["oid"]; ?></span>
							</div>
							<div class="odeme-text">
								<span>Kredi Siparişiniz Alındı..</span>
								
							</div>	
							<div class="odeme-links">
								<a class="s" href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
								<a class="b" href="<?php echo $set['langurl']; ?>">Alışverişe Devam Et</a>
							</div>
							
						<?php } ?>
					</div>
				</div>
				<!--/left-->

					
			</div>
		</div>
		
	</div>
	

	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<?php _footer_last(); ?>
<?php

if($_SESSION["sonuc"]["durum"] == "success"){ 
	if(isset($_SESSION["fs"])){
		unset($_SESSION["fs"]);
	}

	unset($_SESSION["siparisid"]);  
	unset($_SESSION['fposts']["faturaadresi"]);
	unset($_SESSION['fposts']["teslimatadresi"]);
	unset($_SESSION['fposts']["kargosecenek"]);
	unset($_SESSION['fposts']["siparisnot"]);
	unset($_SESSION["sepet"]);
	unset($_SESSION["sonuc"]);
}
 ?>
 </body>
</html>
