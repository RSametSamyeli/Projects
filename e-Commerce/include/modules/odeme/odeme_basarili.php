<?php 
include('phpmailer/PHPMailerAutoload.php');
include("../../../lab/function.php");
$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
/*if(!isset($_SESSION["sonuc"])){
	header('location:/');
}*/
seoyaz("Ödeme Durumu","","","");
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
</head>
<body>
<div id="main" class="main">

	<?php include('../../../include/sabit/header.php') ?>
	
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
						<?php 
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
							<?php  foreach($_SESSION["sepet"] as $row) {  
								$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
								if($urunCek['kurun']){  
								## superfırsat urununu bul
								$spUrun = $conn -> query("select * from urun where aurun = ".intval($urunCek['id'])." ")->fetch(); 	?>
								<?php if($spUrun){ 
										$sef = unserialize($spUrun['sef']);
								?>
								<div class="sp-urune-git"><a target="_blank" href="<?php echo $set['siteurl']; ?>/<?php echo $detaysef_urunler_link['tr']; ?>/<?php echo $sef['tr']; ?>-<?php echo $spUrun['id']; ?>">Süper Fırsat Ürününe Gitmek İçin Tıklayınız</a></div>
									<?php  } ?>
								<?php } ?>
							<?php  } ?>
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
									$kdvler      = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant  = $row['varyant'];
									
									/* varyant hesapla */
										if(count($varyant) > 0) {	 
												$defvarPlus   = 0;
												$defvarMinus  = 0;
												$varAra  = $row['arafiyat'];
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
										
										$birimfiyat = str_replace(",","",$birimfiyat);
										$genelToplam += $row['adet'] * $birimfiyat;
										$kdvler		 =   $kdvler +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
		
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
									$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND siparisid = ".$_SESSION["fs"]["oid"]."  &&  durum = 0");
									$kuponlarCount = $kuponlar->rowCount();
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlarCount > 0 ) {
										foreach($kuponlarFetch as $row){ 
											$indirimler  = $indirimler + $row['tutar'];
										}
									}
								}
								$anaTutar  		 =  $genelToplam;
								if($_SESSION["fs"]["kapidaodemefiyat"] != 0.00){
									$anaTutar   =  $anaTutar  + $_SESSION["fs"]["kapidaodemefiyat"];
								}
								$anaTutar   =  ($anaTutar - $indirimler )  - ( $_SESSION["fs"]["parapuan"] );
								$anaTutar   =  $anaTutar  -  $_SESSION["fs"]["kredipuan"] ;
								?>
								
								<li><span>Sipariş Tutarı</span> <span class="tutar"><?php echo $genelToplam; ?> TL</span></li>
								<li><span>Kdv</span> <span class="tutar"><?php echo $kdvler; ?>  TL</span></li>
								<?php 
								 if(!empty($_SESSION["fs"]["parapuan"])){ 
									echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["parapuan"].'</span></li>';
								 }
								 if(!empty($_SESSION["fs"]["kredipuan"])){ 
									echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["kredipuan"].'</span></li>';
								 }
								?>
								<?php if($kuponlar -> rowCount() >0 ) {  
										foreach($kuponlarFetch as $row5){ ?>
											<li>
												<span>Kupon Tutarı (-)</span>
												<span><?php echo number_format($row5['tutar'],2); ?> TL</span>
											</li>
										<?php } ?>
									<?php  } ?>
								<li><span>Kargo</span><span class="kargo-tutar"><?php echo $_SESSION["fs"]['kargotutar']; ?> TL</span></li>
								<li class="genel-toplam"><span>Sepet Toplamı</span><span class="tutar"><?php echo number_format($_SESSION["fs"]["toplamtutar"],2); ?> TL</span></li>
								<?php ?>
							</ul>
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
											
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
<?php include('../../../include/sabit/footer.php') ?>

	
<?php _footer(); ?>
<?php _footer_last(); ?>
<?php
	
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
	
 ?>
 
 </body>
</html>
