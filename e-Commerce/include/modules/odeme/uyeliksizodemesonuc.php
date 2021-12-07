<?php 
if( !defined("SABIT") ){ exit; }
@include('phpmailer/PHPMailerAutoload.php');



if(!isset($_SESSION["misafir_id"])){
	include('include/modules/404/404.php');
	exit;
}


$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["misafir_id"])."")->fetch();
if(!$uyebul){
	include('include/modules/404/404.php');
	exit;
}



if(!isset($_SESSION["sonuc"])){
	header('location:/');
}


if($_SESSION["sonuc"]["durum"] == "success"){ 

	## Coksatan
	$sipCek = $conn -> query("select * from siparis where oid =  '".$_SESSION["fs"]["oid"]."' ")->fetch();
	$cokSatan = 0;
	if($sipCek){
		$urunidler  = unserialize($sipCek['urunid']);
		$adetler    = unserialize($sipCek['adet']);
	}
	
	
	/**** Kupon Geçmişi Güncelle ****/

	
	$indirimler  = 0;
	if(isset($_SESSION["misafir_id"])){
		$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["misafir_id"])."  AND siparisid = ".$_SESSION["fs"]["oid"]."  AND durum = 0");
		$kuponlarFetch = $kuponlar->fetchAll();
		if($kuponlar -> rowCount() >0 ) {
		foreach($kuponlarFetch as $row8){ 
				$indirimler  = $indirimler + $row8['tutar'];
			}
		}
	}


	/////*************** Mesaj Yolla ************************//////	

	if($smsAyar['durum'] == 1){
		## netgsm	
		if($smsAyar['firmaid'] == 0){
			$mesaj = html_entity_decode($smsAyar['ilksiparis']);
			$arr1  = array('{%ad%}','{%soyad%}','{%tarih%}','{%sipno%}');
			$arr2  = array($uyebul['ad'],$uyebul['soyad'],date("d.m.Y H:i"),$_SESSION["fs"]["oid"]);
			$mesaj = str_replace($arr1,$arr2,$mesaj);
			netgsm($mesaj,$uyebul['telefon']);
		}
	}
	
			
		
	/////*************** E-Mail ************************//////	
		 @include('include/modules/mailtaslak/uyeliksizsiparismail.php');
	//*************** E-Mail end ************************//	

	
	//*** Sip Sayısına At****///
	$stutar = 0 ;
	
	$stutar = 0 ;
	foreach(@$_SESSION["sepet"] as $row) { 
	$varyant 	 = $row['varyant'];
		if(count($varyant) > 0) {	 
			$varAra  = 0 ;
			for($i = 0; $i < count($varyant['varBaslik']); $i++) {
				$varTutar = $varyant['varTutar'][$i];
				$varTur   = $varyant['varTur'][$i];
				if($varTur == 1){
					$varAra  = number_format($row['arafiyat'],2) + $varTutar;
				}
				if($varTur == 0){
					$varAra  = $varAra - $varTutar;
				}
			}
			$birimfiyat = number_format($varAra,2);
		} else {
			$birimfiyat = number_format($row['arafiyat'],2);
		}
										
		$stutar = $row['adet'] * $birimfiyat;
		$sipsql = $conn -> prepare("INSERT INTO siparissayi SET 
			urunid       = :urun_id,
			adet	     = :adet,
			toplamtutar	 = :toplamtutar,
			tarih	 	 = :tarih,
			siparisid    = :siparisid,
			userid		 = :userid
			");
			
		 $sipsql-> execute(array(
			"urun_id" 		=> $row['sepetid'],
			"adet"			=> $row['adet'],
			"toplamtutar"	=> number_format($stutar,2),
			"tarih"			=> time(),
			"siparisid"	 	=> $_SESSION["fs"]["sipid"],
			"userid"		=> $_SESSION["fs"]["user_id"]
		)); 		
	}

	//***** Sip Sayısına At Bitti ****///
	
	
	/**** Kredi Güncelle ****/
	if($main_settings['kredisistemi'] == 1){
		if(!empty($_SESSION["fs"]["kredipuan"])){ 
				## Transfer 
				$bakiyem 	  = $uyebul['uye_kredi'];
				$bakiyem 	 = str_replace(",","",$bakiyem);

				$toplamTutar  =  $_SESSION["fs"]["kdvsiztutar"] + $_SESSION["fs"]["kdv"] + $_SESSION["fs"]["kargotutar"] ;
				$toplamTutar  = $toplamTutar - $indirimler;
				$toplamTutar  = number_format($toplamTutar,2);
				$toplamTutar  = str_replace(",","",$toplamTutar);
				if($bakiyem >= $toplamTutar){
					$kalanbakiye     = ($bakiyem - $toplamTutar);
					$kullanilankredi = $toplamTutar;
				}elseif($bakiyem <= $toplamTutar){	
					$kalanbakiye = 0.00;
					$kullanilankredi =  $bakiyem; 
				}
				/*echo $_SESSION["fs"]["kdvsiztutar"] + $_SESSION["fs"]["kdv"] + $_SESSION["fs"]["kargotutar"]."<br/>";
				echo $indirimler."<br/>";
				echo $kullanilankredi;
				exit;*/
				
				$sql = $conn -> prepare("INSERT INTO kredigecmisi SET 
				uye_id      = :uye_id,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma,
				sid			= :sid
				");
				
				 $sql-> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_toplam" 	 => number_format($kullanilankredi,2),
					"puan_tarih"	 => time(),
					"durum"			 => 1,
					"kullanma" 		 => 1,
					"sid"			 => $_SESSION["fs"]["oid"],
				)); 
				
				$kredisifirla   = $conn -> exec("UPDATE users SET uye_kredi = ".$kalanbakiye." where id = ".$uyebul['id']." ");
				$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();	
		}
	}
	/**** Kredi Güncelle Bitti ****/
		
		
		
	/**** Puan Güncelle ****/
	if($parapuan['puansistemi'] == 1){

		## Kazanmadan Önce Toplam Puandan Düş 
			if($parapuan['yenisiparis'] == 1){
				## Transfer 
				if(!empty($_SESSION["fs"]["parapuan"])){ 
					$bakiyem 	 = puanconvert($uyebul['uye_puan']);
					$bakiyem 	 = str_replace(",","",$bakiyem);
					
					$toplamTutar  = $_SESSION["fs"]["kdvsiztutar"] + $_SESSION["fs"]["kdv"] + $_SESSION["fs"]["kargotutar"] ;
					$toplamTutar  = $toplamTutar - $indirimler;
					$toplamTutar  = number_format($toplamTutar,2);
					$toplamTutar  = str_replace(",","",$toplamTutar);
					
					if($bakiyem >= $toplamTutar){
						$kalanbakiye = $bakiyem - $toplamTutar;
						$kalanbakiye = paraconvert($kalanbakiye);
						$kullanilanpuan =  paraconvert($toplamTutar); 
					
					}elseif($bakiyem < $toplamTutar){
						$kalanbakiye = 0;	
						$kullanilanpuan =  paraconvert($bakiyem); 
					}
					
					$sql = $conn -> prepare("INSERT INTO puangecmisi SET 
					uye_id      = :uye_id,
					puan_tur    = :puan_tur,	
					puan_toplam = :puan_toplam,
					puan_tarih	= :puan_tarih,
					durum 		= :durum,
					kullanma    = :kullanma,
					sid			= :sid						
					");
					
					 $sql-> execute(array(
						"uye_id" 		 => $uyebul['id'],
						"puan_tur"		 => 1,
						"puan_toplam" 	 => $kullanilanpuan,
						"puan_tarih"	 => time(),
						"durum"			 => 1,
						"kullanma" 		 => 1,
						"sid"			 => $_SESSION["fs"]["oid"]						
					)); 
					
					$puansifirla   = $conn -> exec("UPDATE users SET uye_puan = ".$kalanbakiye." where id = ".$uyebul['id']." ");
				}
				 
				 ## session puan bitti
				
				$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["misafir_id"]))->fetch();
				## Normal Siparişten Puan Kazan ##
				$sql2 = $conn -> prepare("INSERT INTO puangecmisi SET 
				uye_id      = :uye_id,
				puan_tur    = :puan_tur,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma,
				sid			= :sid	
				");
				$ekle2 = $sql2 -> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_tur"		 => 1,
					"puan_toplam" 	 => $parapuan['yenisiparisdeger'],
					"puan_tarih"	 => time(),
					"durum"			 => 0,
					"kullanma" 		 => 0,
					"sid"			 => $_SESSION["fs"]["oid"]
				)); 
				/*if($ekle2){
					$puanesitle   = $uyebul['uye_puan']  + $parapuan['yenisiparisdeger'];	
					$puanupdate   = $conn -> exec("UPDATE users SET uye_puan = $puanesitle where id = ".$uyebul['id']." ");	
				}*/

			
			}

	}
	

	/// **************** sipariş başarılıyla ************************//////	
}
seoyaz("Ödeme Durumu","","","");
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
<!--link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" /-->
</head>
<body class="boxed">
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
				
				<div class="col-md-8 col-xs-12">
					<div class="odeme-sonuc">
					<?php if($_SESSION["fs"]["odemeturu"] == "kredikarti"){ ?>
						<?php if($_SESSION["sonuc"]["durum"] == "success"){  
									foreach(@$_SESSION["sepet"] as $row) { 
										$adet       = $row['adet'];
										$varyant  = $row['varyant'];
										//echo $varyantid;
										$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
										$sef      = unserialize($urunCek['sef']);
										$urunStok = $urunCek["stok"];
										$stokdus  =  $urunCek["stok"] - $adet;
										/* Ürün Stokdan Düş */
										$stoksql = $conn -> prepare("UPDATE urun SET stok = :stok WHERE id = :id ");
										$stoksql -> execute(array(
												"stok" => $stokdus,
												"id"      => intval($urunCek['id'])
											));
										/* Varyantları Güncelle */
										if(count($varyant) > 0) { 
											for($i = 0; $i < count($varyant['varid']); $i++) { 
												$urunvaryantlar = $conn -> query("select * from urunvaryants where  varyantdeger = ".intval($varyant['varid'][$i])." && urunid = " .intval($urunCek['id']));
												if($urunvaryantlar -> rowCount() > 0 ){
														foreach($urunvaryantlar->fetchAll() as $row6){ 
															if($row6['varyantdeger'] == intval($varyant['varid'][$i])){ 
																	$varyantstok      = $row6['varyantstok'];
																	$varyantstokdus   =  $varyantstok - $adet;
																	$varyantsql = $conn -> prepare("UPDATE urunvaryants SET varyantstok = :varyantstok WHERE varyantdeger = :varyantdeger && urunid = :urunid ");
																	$guncelle   = $varyantsql -> execute(array(
																			"varyantstok"  => $varyantstokdus,
																			"varyantdeger" => intval($varyant['varid'][$i]),
																			"urunid"	   => intval($urunCek['id'])
																		));
															}
														}
												}
											}
										}	
									
								}
						?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Siparişinizi Hazırlamaya Başladık..</span>
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
							<a class="s" href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
							<a class="b" href="<?php echo $set['langurl']; ?>">Alışverişe Devam Et</a>
						</div>
						<?php  }else { 
						
							
							foreach($_SESSION["sepet"] as $row) { 
										$adet       = $row['adet'];
										$varyant  = $row['varyant'];
										$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									
										$sef      = unserialize($urunCek['sef']);
										$urunStok = $urunCek["stok"];
										$stokdus  = $urunCek["stok"] - $adet;
										
								
										$stoksql = $conn -> prepare("UPDATE urun SET stok = :stok WHERE id = :id ");
										$stoksql -> execute(array(
												"stok" => $stokdus,
												"id"      => intval($urunCek['id'])
											));
											
										/*  Varyant Stok Düş */
										if(count($varyant) > 0) { 
											for($i = 0; $i < count($varyant['varid']); $i++) { 
												$urunvaryantlar = $conn -> query("select * from urunvaryants where  varyantdeger = ".intval($varyant['varid'][$i])." && urunid = " .intval($urunCek['id']));
												if($urunvaryantlar -> rowCount() > 0 ){
														foreach($urunvaryantlar->fetchAll() as $row6){ 
															if($row6['varyantdeger'] == intval($varyant['varid'][$i])){ 
																	$varyantstok      = $row6['varyantstok'];
																	$varyantstokdus   =  $varyantstok - $adet;
																	$varyantsql = $conn -> prepare("UPDATE urunvaryants SET varyantstok = :varyantstok WHERE varyantdeger = :varyantdeger && urunid = :urunid ");
																	$guncelle   = $varyantsql -> execute(array(
																			"varyantstok"  => $varyantstokdus,
																			"varyantdeger" => intval($varyant['varid'][$i]),
																			"urunid"	   => intval($urunCek['id'])
																		));
															}
														}
												}
											}
										}	
									
								}
								

						?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Siparişinizi Hazırlamaya Başladık..</span>
							</div>
							<div class="siparis-no">
								<h3>SİPARİŞ NUMARANIZ</h3>
								<span>#<?php echo $_SESSION["fs"]["oid"]; ?></span>
							</div>
							<div class="odeme-text">
								<span>Sipariş detaylarınızı içeren bilgilendirme mail <?php echo $uyebul['email']; ?> adresine gönderildi.</span>
								
							</div>
							
							<div class="odeme-links">
								<a class="s" href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
								<a class="b" href="<?php echo $set['langurl']; ?>">Alışverişe Devam Et</a>
							</div>
							
						<?php } ?>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12">
					<div class="sepet-page-right">
						<div class="mini-sepet">
							<div class="title">
								<span>Sipariş Özeti</span>
								<a href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</div>
							
							<div class="urun-list">
								<?php 
									$genelToplam = 0;
									$indirimler  = 0;
									$puan  = 0;
									$kdv = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant  = $row['varyant'];
									/* varyant hesapla */
										if(count($varyant) > 0) {	 
											$defvarPlus   = 0;
											$defvarMinus  = 0;
											$varAra 	  = $row['arafiyat'];
											$varAra       = str_replace(",","",$varAra);
											for($i = 0; $i < count($varyant['varBaslik']); $i++) {
												$varTutar = $varyant['varTutar'][$i];
												$varTur   = $varyant['varTur'][$i];
													if($varTur == 1){
														$defvarPlus  += $varTutar;
													}
													if($varTur == 0){
														$defvarMinus  += $varTutar;
													}	
											}
											$varAra = $varAra + $defvarPlus;
											$varAra = $varAra - $defvarMinus;
											
											$birimfiyat = $varAra;
										} else {
											$birimfiyat = $row['arafiyat'];
										}
										$kdv		 =  $kdv +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
										
										$genelToplam += $row['adet'] * $birimfiyat;
		
									?>
								<div class="urun-item">
									<div class="urun-img">
										<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
									</div>
									<div class="urun-infos">
										<div class="name">
											<span><?php echo $row['baslik']; ?></span>
											<?php 
											if(count($varyant) > 0) {	
												echo '<div class="right-varyants">';
												for($i = 0; $i < count($varyant['varBaslik']); $i++) {
													echo '
													<span class="var-desc">'.$varyant['varKat'][$i].' - '.$varyant['varBaslik'][$i].'</span>';
													if($varyant['varTutar'][$i] != 0.00 ){
														if($varyant['varTur'][$i] == 0){
															$varDurum  = '(-)';
															$varClass = 'varyant-eksi';
														}else{
															$varDurum  = '(+)';
															$varClass = 'varyant-arti';
														}
														echo '<span class="varyant-deger"> '.$varDurum.' <p class="'.$varClass.'">'.$varyant['varTutar'][$i].'</p></span>';
													}
													echo '<br/>';
												} 
												echo '</div>';
											}
											?>
											<span><?php echo $row['adet']; ?> Adet -  <?php echo number_format($row['adet'] * $birimfiyat , 2 ); ?> TL</span>
										</div>
									</div>
								</div>
								<?php  } ?>
							</div>
							
						</div>
						<div class="basket-right">
							<ul>
								<?php 
									if(isset($_SESSION["m_oturum"])){ 
								$kuponlar = $conn->query("select * from kupongecmisi where siparisid = ".intval($_SESSION["fs"]["oid"])." && userid = ".intval($_SESSION["m_id"])." AND durum = 0");
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlar -> rowCount() >0 ) {
										foreach($kuponlarFetch as $row4){ 
											$indirimler  = $indirimler + $row4['tutar'];
										}
									}
									
								}
								$anaTutar   =   $genelToplam  + $_SESSION["fs"]['kargotutar'] ;
								if($_SESSION["fs"]["kapidaodemefiyat"] != 0.00){
									$anaTutar   =  $anaTutar  + $_SESSION["fs"]["kapidaodemefiyat"];
								}
							
								
								?>
								
								<li><span>Sipariş Tutarı</span> <span class="tutar"><?php echo number_format($genelToplam,2); ?> TL</span></li>
								<li><span>Kdv</span> <span class="tutar"><?php echo $kdv; ?>  TL</span></li>
								<?php  if($_SESSION["fs"]["kapidaodemefiyat"] != 0.00){  ?>
								
								<li><span>Kapıda Ödeme Fiyatı </span> <span class="tutar"><?php echo $_SESSION["fs"]["kapidaodemefiyat"]; ?>  TL</span></li>
								
								<?php  } ?>
								
							
								<?php if($kuponlar -> rowCount() >0 ) {  
										foreach($kuponlarFetch as $row5){ ?>
											<li>
												<span>Kupon Tutarı (-)</span>
												<span><?php echo number_format($row5['tutar'],2); ?> TL</span>
											</li>
										<?php } ?>
									<?php  } ?>
								<li><span>Kargo</span><span class="kargo-tutar"><?php echo $_SESSION["fs"]['kargotutar']; ?> TL</span></li>
									<?php if($_SESSION["fs"]["kredipuan"] >=  number_format($_SESSION["fs"]["toplamtutar"],2) ) {
										$toplamTutar = $_SESSION["fs"]["toplamtutar"] + $_SESSION["fs"]['kargotutar'];
									}else {
										$toplamTutar = $_SESSION["fs"]["toplamtutar"];
									}
									
								
									
									$toplamTutar = $kdv  + $toplamTutar;

									?>
								<li class="genel-toplam"><span>Sepet Toplamı</span>
									<span class="tutar"><?php echo number_format($toplamTutar ,2); ?> TL
								</span></li>
								<?php ?>
							</ul>
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
						
					</div>
				</div>
					
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
	unset($_SESSION["misafir_id"]);
}
 ?>
 </body>
</html>
