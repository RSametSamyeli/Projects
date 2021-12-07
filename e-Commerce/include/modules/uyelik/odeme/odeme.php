<?php  if( !defined("SABIT") ){ exit; } 
if(!empty($get2)) exit;
include('ajax/sozlesme/sozlesme.php');
if(count(@$_SESSION["sepet"]) < 1){
	header('location:'.$sef_sepet_link[$set['lang']['active']]);
	exit;
}

## Seo 
$unx_seo 	 = unserialize($sef_odeme['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];


## F-T Adres
if(isset($_POST["teslimatadresi"])){
	if(isset($_POST["adres_disable"])){
		$_SESSION['fposts']["faturaadresi"] = $_POST["teslimatadresi"];
	}else{
		$_SESSION['fposts']["faturaadresi"] = $_POST["faturaadresi"];
	}
	$_SESSION['fposts']["teslimatadresi"] = $_POST["teslimatadresi"];
	$_SESSION['fposts']["kargosecenek"]   = $_POST["kargosecenek"];
	$_SESSION['fposts']["siparisnot"]     = $_POST["siparisnot"];
}

## Kargo Ücret 
if(isset($_POST['kargosecenek'])){
	$kar 		 = clean($_POST['kargosecenek']);
	$sepettoplam = clean($_POST['sepettoplam']);
	$kargobul    = $conn -> query("select * from kargo where  id = ".intval($kar))->fetch();
	$kampanya_durum   =  $kargobul['kampanya_durum'];
	$kampanya_toplam  =  $kargobul['kampanya_toplam'];
	if($kampanya_durum == 1){
		if(number_format($kampanya_toplam,2) < number_format($sepettoplam)){
			$kargofiyat = $kargobul['kampanya_ucret'];
		}else{
			$kargofiyat = $kargobul['kargoucret'];
		}
	}else{
		$kargofiyat = $kargobul['kargoucret'];
	}	
}else{
	$kargofiyat = 0.00;
}


## Uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	 header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}

$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }


## Adresler
$adresler      = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 
$adreslerCount =  $adresler -> rowCount();
$adreslerFetch =  $adresler -> fetchAll();

## Kargolar 
$kargolar = $conn -> query("select * from kargo where durum = 1 order by sira asc");
$kargolarCount = $kargolar-> rowCount();
$kargolarFetch = $kargolar -> fetchAll(); 

## Bankalar - Eft
$bankalar = $conn -> query("select * from banka order by sira asc");

## Ödeme Durumlar ##
$odemehavale   = $conn->query("select id,ad,durum from payments where id = 1")->fetch();
$odemesanalpos = $conn->query("select id,ad,durum from payments where id = 2")->fetch();
$odemekapida   = $conn->query("select id,ad,durum from payments where id = 3")->fetch();
$odemepaytr    = $conn->query("select id,ad,durum from payments where id = 4")->fetch();

$oid        = "".rand(23,999999)."";   
$_SESSION['fposts']["oid"]	  = $oid;

seoyaz("".$title."","".$description."","".$keywords ."",""); 

?>
</head>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/keypad.css" />
<body class="cnt-home">
 
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
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-credit-card-alt"></i>ÖDEME SEÇENEKLERİ</h2>
								<p>Ödeme Bilgilerinizi Giriniz</p>
							</div>
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-check" aria-hidden="true"></i>SİPARİŞ ONAYI</h2>
								<p>Siparişiniz Özeti </p>
							</div>
						</div>
					</div>
				</div>
				<?php  if($iyziDurum == 1 ){ ?>
					<form action="<?php echo $set['siteurl']; ?>/ajax/odeme/odeme.php" class="form-horizontal"  id="odemeform" method="POST">
				<?php }elseif($payuDurum  == 1) { ?>
					<form action="<?php echo $set['siteurl']; ?>/ajax/odeme/odeme.php" class="form-horizontal"  id="odemeform" method="POST">
				<?php }else{ ?>
					<?php if($anapos['mode'] == "T"){
					   echo '<form method="post" class="form-horizontal" id="odemeform" action="https://entegrasyon.asseco-see.com.tr/fim/est3Dgate">';
					}else{
						echo '<form method="post" class="form-horizontal" id="odemeform" action="https://sanalpos.halkbank.com.tr/fim/est3Dgate">';
					}
					?>
					
				<?php } ?>
				<div class="col-md-8 col-xs-12">
					<div class="tamamla-sol">
						<div class="odemeler">
								
								<?php 
								if(isset($_SESSION["hata"])) { ?>
								<div class="card-errors">
									<span><?php echo $_SESSION["hata"]; ?></span>
								</div> <?php  } ?>
								<div class="card-errors">
									
								</div>
								<ul class="nav nav-tabs">
									
									<?php if($odemesanalpos['durum'] == 1) { ?>
									<li><a data-toggle="tab" rel="kredikarti" data-tur="kredikarti"  class="enable" href="#kredikarti"> <i class="fa fa-credit-card-alt"></i>Kredi Kartı</a></li>
									<?php  } ?>
									
									<?php if($odemehavale['durum'] == 1) {?>
									<li><a data-toggle="tab" rel="Havale / Eft" data-tur="havale" class="enable" href="#havale"><i class="fa fa-money" aria-hidden="true"></i> Havale / Eft </a></li>
									<?php  } ?>
									<?php if($odemekapida['durum'] == 1) { ?>
									<li><a data-toggle="tab" rel="Kapıda Ödeme"  data-tur="kapidaodeme" class="enable" href="#kapi"><i  class="fa fa-briefcase" aria-hidden="true"></i>Kapıda Ödeme</a></li>
									<?php  } ?>
									<?php if($odemepaytr['durum'] == 1) { ?>
									<li><a  rel="Kapıda Ödeme"  class="enable" href="<?php echo $set['langurl']; ?>/paytrodeme"><i  class="fa fa-briefcase" aria-hidden="true"></i>Paytr Ödeme Sayfası</a></li>
									<?php  } ?>
								</ul>
							  <div class="tab-content">
								
								<!--/kredikartı-->
								<?php if($odemesanalpos['durum'] == 1) { ?>
								<div id="kredikarti" class="tab-pane fade in">
									<?php if($iyziDurum == 1 ){
										include('include/modules/sanalpos/iyzico.php');
									  }elseif($payuDurum  == 1){
										  include('include/modules/sanalpos/payu.php');
									  }else { ?>
										 	<div class="kredi-karti">
												<div class="kredikarti-left">
													<div class="kart-bilgileri">
														<div class="form">
															<div class="form-group">
																<div class="col-sm-12 no-padding">
																	<label>Kart Sahibinin Adı Soyadı</label>
																</div>
																<div class="col-sm-12 no-padding">
																	<input type="text" class="form-control" id="cardadsoyad"  autocomplete="off"  name="cardadsoyad" />
																</div>
															</div>
															<div class="form-group">
																<div class="col-sm-12 no-padding">
																	<label>Kredi Kartı Numarası</label>
																</div>
																<div class="col-sm-12 no-padding">
																	<input type="text" class="form-control"  maxlength="19" autocomplete="off" id="cardNumber" name="pan" />
																</div>
															</div>
															
																<div class="row">
																	<div class="col-sm-4">
																		<div class="form-group">
																		<label>Ay</label>
																			<select class="form-control" id="ccAy" name="Ecom_Payment_Card_ExpDate_Month">
																				<?php for($i = 1; $i <= 12; $i++){
																					if($i < 10){
																						echo '<option value="0'.$i.'">0'.$i.'</option>';
																					}else{
																						echo '<option value="'.$i.'">'.$i.'</option>';
																					}
																				}?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Yıl</label>
																			<select class="form-control" id="ccYil"  name="Ecom_Payment_Card_ExpDate_Year">
																				<?php for($i = 17; $i < 36; $i++){
																					echo '<option value="'.$i.'">'.$i.'</option>';
																				}?>
																					
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Cvc</label>
																			<input type="text" autocomplete="off" onkeypress="return numbersonly(this, event)" maxlength="4" class="form-control" id="cvcNumber" autocomplete="off"   name="cv2" />
																		
																		</div>
																	</div>
																	<div class="col-sm-12">
																		<div class="form-group">
																			<label>Kart Tipi</label>
																			<select class="form-control"  name="cardType">
																				<option value="1" selected>Visa</option>
																				<option value="2">MasterCard</option>
																			</select>
																		</div>
																	</div>
																</div>
															
																<input type="hidden" name="force3ds" id="force3ds" />
																<input type="hidden" name="binNumber" id="binNumber" value="" />		
																<input type="hidden" name="cardAssociation" id="cardAssociation"  value="" />
																<input type="hidden" name="cardFamily" id="cardFamily" />
																<input type="hidden" name="bankName" id="bankName" />
																<input type="hidden" name="cardType" id="cardType" />
														</div>
													</div>
													<?php 
													$genelToplam = 0;
													foreach(@$_SESSION["sepet"] as $row) { 
														$genelToplam += $row['adet'] * $row['arafiyat'];
													} 
													$kdv 	 	=    kdv_ekle($genelToplam,18);
													$anaTutar   =   $genelToplam  + $kargofiyat; 
													$taksitler  =     unserialize($anapos['taksitler']); 
													?>
													<div class="taksit-tablosu">
														
														<div class="title"><h3>TAKSİT SEÇENEKLERİ </h3></div>
														<div class="taksitler">
															<?php 
															
															if($anapos){  
																if($anaTutar >= $anapos['mintaksit'] ) {	?>
																	<div class="installmentOptionsRow">
																		<div id="installment-container" class="installment-container">
																			<ul class="installments">
																					<li class="installment full selected">
																						<input type="radio" checked name="installment-option"   class="installment-option" value="">
																						<span class="iyzi-inst-label" style="min-width: 47px;"> Peşin</span>
																						<span class="iyzi-inst-amount"><?php echo $anaTutar; ?>  TL </span>
																					</li>
																					<?php 
																					 
																					 foreach($taksitler as $key => $value) { 
																						if(!empty($value)){ 
																						 $oran    = $anaTutar * ($value / 100);
																						 $toplam   = $anaTutar + $oran;
																						 $bolum    = $toplam/$key;
																						?>
																							<li class="installment full">
																								<input type="radio" name="installment-option" class="installment-option" value="<?php echo $key; ?>">
																								<span class="iyzi-inst-label" style="min-width: 47px;"> <?php echo $key; ?> Taksit</span>
																								<span class="iyzi-inst-amount"><?php echo number_format($toplam,2); ?>  TL /  <?php echo number_format($bolum,2); ?>  X <?php echo $key; ?></span>
																							</li>
																						<?php }
																						}
																					?>
																				</ul>
																		</div>
																	</div>
																<?php } 
																} else { ?>
																		Taksit seçenekleri, kredi kartı bilgilerinizi girdikten sonra gelecektir.
															<?php } ?>
														
															
														</div>
														
													</div>
												</div>
												<div class="kredi-karti-right hidden-xs hidden-sm">
													<div class="kredi-karti-content" id="kredi-karti-content">
														<div class="front" id="front">
															<span class="cartLogo"></span>
															<span class="cartNo"></span>
															<span class="cartDate">
																<em class="ay">05</em>/<em class="yil">20</em>
															</span>
															<span class="cartName">Ad Soyad</span>
															<span class="cartType"></span>
														</div>
														<div class="back" id="back">
															<span class="cardCvc"></span>
														</div>
													</div>
												</div>
											</div>
									 <?php  } ?>
								</div>
								<!--/kredi kartı-->
								<?php  } ?>
								<?php if($odemehavale['durum'] == 1) { ?>
								<div id="havale" class="tab-pane fade in">
									  <div class="havale">
											<?php if($bankalar -> rowCount() > 0 )
											$i = 0;
											foreach($bankalar as $row)	{  
											$i++;
											?>
											<div class="h-item">
												<label>
													<input type="radio" <?php echo $i== 1 ? ' checked' : null ;  ?> name="havaletipi" value="<?php echo $row['id']; ?>" />
													<div class="h-image">
														<img src="<?php echo $set['siteurl']; ?>/uploads/banka/<?php echo $row['image']; ?>" alt="" />
													</div>
													<div class="h-info">
														<?php echo $row['hesap_adi']; ?> <br/>	
														<?php echo $row['banka_adi']." ".$row['sube_adi'];  ?>
														Şube Kodu : <?php echo $row['sube_kodu']; ?>  
														Hesap No : <?php echo $row['hesap_no']; ?>  
														IBAN : <?php echo $row['iban']; ?>  
													</div>
												</label>
											</div>
											<?php  } ?>
									  </div>
								</div>
								
								<!--/havale-->
								<?php  } ?>
								<?php if($odemekapida['durum'] == 1) { ?>
								<div id="kapi" class="tab-pane fade in">
									<div class="kapida-odeme">
										<div class="kapi-item">
											<label>
												<input type="radio" checked name="kapiodemetur" value="Kapıda Nakit Ödeme|x|<?php echo $kapidaNakit; ?>" />
												<div class="k-info"> Kapıda Nakit Ödeme <span><?php echo $kapidaNakit; ?></span> TL </div>
											</label>
										</div>
									</div>
									<div class="kapida-odeme">
										<div class="kapi-item">
											<label>
												<input type="radio" name="kapiodemetur" value="Kapıda Kartla Ödeme|x|<?php echo $kapidaKart; ?>" />
												<div class="k-info">Kapıda Kredi Kartıyla Ödeme <span><?php echo $kapidaKart; ?></span> TL</div>
											</label>
										</div>
									</div>
								</div>
								<!--/kapıda odeme-->
								<?php  } ?>
								
							  </div>
						</div>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12">
					<div class="sepet-page-right">
						<div class="sip-done">
							<button type="submit">SİPARİŞİ TAMAMLA <i class="fa fa-chevron-right"></i></button>
						</div>
						<div class="mini-sepet">
							<div class="title">
								<span>Sipariş Özeti</span>
								<a href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</div>
							
							<div class="urun-list">
								<?php 
									$genelToplam = 0;
									$indirimler  = 0;
									$kdv = 0;
									$kargodurum = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
								
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant 	 = $row['varyant'];
									$secenekler   = $row['secenekler'];
									if($urunCek['skargo'] == 1){
										$kargodurum = 1;
									}
									//echo '<pre>';
									//var_dump($row['secenekler']);
									//echo '</pre>';
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
										$kdv	 =  $kdv +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
										$genelToplam += $row['adet'] * $birimfiyat;
									?>
								<div class="urun-item">
									<div class="urun-img">
										<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
									</div>
									<div class="urun-infos">
										<div class="name">
											<span><?php echo $row['baslik']; ?> - <?php echo $urunCek['kod']; ?></span>
											<?php 
											if(count($secenekler) > 0){
												$secenekArr[] = '';		
												//var_dump(implode('|x|',$secenekler));	
											}else{
												$secenekArr[] = '';		 			
											}
											
												$varyantidler    = array();
												$varyantturler   = array();
												$varyantFiyatlar = array();
												$varyantAciklama = array();
												
											if(count($varyant) > 0) {	
												
												
												
												echo '<div class="right-varyants">';
												for($i = 0; $i < count($varyant['varBaslik']); $i++) {
													//echo "cccccccc".$varyant['varid'][$i]."ccccccccc";
													$varyantidler[]  = $varyant['varid'][$i];	
												
													echo '<span class="var-desc">'.$varyant['varKat'][$i].' - '.$varyant['varBaslik'][$i].'</span>';
													if($varyant['varTutar'][$i] != 0.00 ){
														$varyantFiyatlar[]   = $varyant['varTutar'][$i];
												
														$varyantturler[]     = $varyant['varTur'][$i];	
													
														if($varyant['varTur'][$i] == 0){
															$varDurum  = '(-)';
														}else{
															$varDurum  = '(+)';
														}
														$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i].' - '.$varDurum.' '.$varyant['varTutar'][$i];	
														echo '<span class="varyant-deger"> '.$varDurum.' <p>'.$varyant['varTutar'][$i].'</p></span>';
													}else{
														
														$varyantFiyatlar[] = '';
														$varyantturler[]   = '';
														$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i];	
														
													}
													
													echo '<br/>';
												} 
												echo '</div>';
											
											}else{
										
												$varyantidler[]    = '';
												$varyantturler[]   = '';
												$varyantFiyatlar[] = '0';
												$varyantturler[]   = '';
												$varyantAciklama[] = '';		 											
											}
										
											
											$varyantidBirlestir        = implode(",",$varyantidler);
											$varyantfiyatBirlestir 	   = implode(",",$varyantFiyatlar);
											$varyantturBirlestir   	    = implode(",",$varyantturler);
											$varyantAciklamaBirlestir   = implode(",",$varyantAciklama);
											
											?>
											<span><?php echo $row['adet']; ?> Adet -  <?php echo number_format($row['adet'] * $birimfiyat , 2 ); ?> TL</span>
										</div>
									</div>
								</div>
									
									<?php 
										
									?>
								<?php if(count($row['secenekler']) > 0 ) {
									foreach($row['secenekler'] as $spkey => $val){ ?>
										<input type="hidden" name="secenekler[<?php echo $row['sepetid']; ?>][<?php echo $spkey; ?>]" value="<?php echo $val; ?>" />
									<?php } } ?>
								<input type="hidden" name="xx" value="<?php echo implode('|x|',$secenekler); ?>" />
								<input type="hidden" name="urunid[]" value="<?php echo $row['sepetid']; ?>" />
								<input type="hidden" name="uvaryant[]" value="<?php echo $varyantAciklamaBirlestir; ?>" />
								<input type="hidden" name="varyantid[]" value="<?php echo $varyantidBirlestir; ?>" />
								<input type="hidden" name="varyanttutarlar[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantfiyatBirlestir; ?>" />
								<input type="hidden" name="varyantturler[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantturBirlestir; ?>" />
								<input type="hidden" name="baslik[]" value="<?php echo $row['baslik']; ?>" />
								<input type="hidden" name="adet[]" value="<?php echo $row['adet']; ?>" />
								<input type="hidden" name="siparistarih[]" value="<?php echo $row['siparistarih']; ?>" />
								<input type="hidden" name="siparissaat[]" value="<?php echo $row['siparissaat']; ?>" />
								<input type="hidden" name="bitistarihi[]" value="<?php echo $urunCek['bitistarihi']; ?>" />
								<input type="hidden" name="bastarih[]" value="<?php echo $row['bastarih']; ?>" />
								<input type="hidden" name="bittarih[]" value="<?php echo $row['bittarih']; ?>" />
								<?php  } ?>
							</div>
						</div>
					
						<div class="basket-right">
							<ul>
								<?php 
								
								if(isset($_SESSION["m_oturum"])){ 
									$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1");
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlar -> rowCount() >0 ) {
										foreach($kuponlarFetch as $row){ 
											$indirimler  = $indirimler + $row['tutar'];
										}
									}
								}
								$anaTutar = $genelToplam + $kdv;
								$anaTutar   =    $genelToplam   + $kargofiyat; 
								$anaTutar   =  $anaTutar - $indirimler	;
								?>
								<li><span>Sipariş Tutarı</span> <p>TL</p> <span class="tutar tutar-hesap">  <?php echo number_format($genelToplam,2); ?> </span></li>
								<li><span>Kdv</span> <p>TL</p><span class="tutar"><?php echo $kdv; ?>  </span></li>
								<li class="li-kapida-odeme"><span>Kapıda Ödeme Tutarı</span> <p>TL</p><span class="kapida-odeme tutar-hesap">0.00 </span> </li>
								<?php  if($kargodurum != 1){  ?>
									<li><span>Kargo</span> <p>TL</p><span class="kargo-tutar tutar-hesap"><?php echo number_format($kargofiyat,2); ?> </span></li>
								 <?php } else { ?>
									<li class="hide"><span>Kargo</span> <p>TL</p><span class="kargo-tutar tutar-hesap">0</span></li>
								 <?php } ?>
 								<?php 
								## indirimler
								if(isset($_SESSION["fs"]["puan"])){
									echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["puan"].'</span></li>';
								}
								if(isset($_SESSION["fs"]["kredi"])){
									echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["kredi"].'</span></li>';
								}
								if(isset($_SESSION["m_oturum"])){
									
									if($kuponlar -> rowCount() >0 ) {
										
										foreach($kuponlarFetch as $row){
											echo '<li><input type="hidden" name="indirimkupon[]" value="'.$row['id'].'"  /><span>Kupon Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
										}
									}
								}
								?>
								<li class="genel-toplam"><span>Sepet Toplamı</span><p>TL</p><span class="tutar"><?php echo number_format($anaTutar,2); ?> </span></li>	
							</ul>
						
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
						<div class="sozlesmeler">
								<div class="form-group" style="margin:0;!important">
									<div class="sozlesme-1">
										<label>
											<input type="checkbox" name="sozlesme1" class="n-sozlesme" value="sozlesme1"/>
											<a href="javascript:void(0)"  data-toggle="modal" data-target="#myModal">Ön Bilgilendirme Formu </a> 'nu okudum kabul ediyorum.
										</label>
									</div>
								</div>
								<div class="form-group" style="margin:0;!important">
									<div class="sozlesme-2">
										<label>
											<input type="checkbox" name="sozlesme2" class="n-sozlesme" value="sozlesme2"/>
											<a href="javascript:void(0)"  data-toggle="modal" data-target="#myModal2">Mesafeli Satış Sözleşmesini </a> 'nu okudum kabul ediyorum.
										</label>
									</div>
								</div>
						</div>
						<div class="sip-done" style="margin-bottom:25px;">
							<button type="submit">SİPARİŞİ TAMAMLA <i class="fa fa-chevron-right"></i></button>
						</div>
					</div>
				</div>
				   	<input type="hidden" name="odemeturu" class="odemeturu"/>
					<input type="hidden" name="teslimatadresi" value="<?php echo $_SESSION['fposts']["teslimatadresi"]; ?>" />
					<input type="hidden" name="faturaadresi" value="<?php echo $_SESSION['fposts']["faturaadresi"]; ?>" />
					<input type="hidden" name="kargosecenek" value="<?php echo $_SESSION['fposts']["kargosecenek"]; ?>" />
					<input type="hidden" name="siparisnot" value="<?php echo $_SESSION['fposts']["siparisnot"]; ?>" />
					<input type="hidden" name="kdv" value="<?php echo $kdv; ?>" />
					<input type="hidden" name="kapidaodemefiyat" value="" />
					<input type="hidden" name="kapidaodemeturu" value="" />

					<input type="hidden" name="kargotutar" value="<?php  echo $kargofiyat; ?>" />
					<input type="hidden" name="kdvsiztutar" value="<?php echo number_format($genelToplam,2); ?>"  />
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $uyebul['id']; ?>" />
					<input type="hidden" class="amount" name="toplamtutar" id="i-amount" value="<?php echo number_format($anaTutar,2); ?>" />	
					<?php 
						// Halk Bank Gerekli Alanlar
						$clientId   = $anapos['magazano'];            
						$okUrl      = $set['siteurl']."/ajax/odeme/odeme.php";
						$failUrl    = $set['siteurl']."/ajax/odeme/odeme.php";     
						$rnd        =  microtime();   
						$storekey   = "".$anapos['storekey']."";        
						$storetype  = "3d"; 
						$amount     = number_format($anaTutar,2);	
						$hashstr    = $clientId . $oid . $amount . $okUrl . $failUrl . $rnd  . $storekey;
						$hash 	    = base64_encode(pack('H*',sha1($hashstr)));
						
						// Halk Bank Gerekli Alanlar
						?>
						<input type="hidden" name="clientid" value="<?php  echo $clientId ?>">
						<input type="hidden" name="okUrl" value="<?php  echo $okUrl ?>">
						<input type="hidden" name="failUrl" value="<?php  echo $failUrl ?>">
						<input type="hidden" name="rnd" value="<?php  echo $rnd ?>" >
						<input type="hidden" name="hash" value="<?php  echo $hash ?>" >
						<input type="hidden" name="storetype" value="3d" >		
						<input type="hidden" name="lang" value="tr">
						<input type="hidden" name="currency" value="949">
					    <input type="hidden" name="amount" value="<?php echo number_format($anaTutar,2); ?>">
					    <input type="hidden" name="oid" value="<?php  echo $oid; ?>">	
						<input type="hidden" name="siparisturu" value="0" />
				</form>
					
			</div>
		</div>
		
	</div>
	

	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
	<?php include('include/sabit/sozlesmeler.php'); ?>	

<!--/modals-->	
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.plugin.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.keypad.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.keypad-tr.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	function numbersonly(myfield, e, dec) {
			var key;
			var keychar;
 
			if (window.event)
				key = window.event.keyCode;
			else if (e)
				key = e.which;
			else
				return true;
			keychar = String.fromCharCode(key);
 
			// control keys
			if ((key == null) || (key == 0) || (key == 8) ||
			(key == 9) || (key == 13) || (key == 27))
				return true;
 
			// numbers
			else if ((("0123456789").indexOf(keychar) > -1))
				return true;
 
			// decimal point jump
			else if (dec && (keychar == ".")) {
				myfield.form.elements[dec].focus();
				return false;
			}
			else
				return false;
	}
	 function clearBanks() {
		$(".cartLogo").html("");
		$(".cartType").html("");
		$(".cartName").html("");
		 <?php if(!$anapos){ ?>
		$('.taksitler').html("");	
		 <?php } ?>
		$('#bankName').val('');
		$('#binNumber').val('');
		$('#cardFamily').val('');
		$('#cardType').val('');
		$('#cardAssociation').val('');
		$('#force3ds').val('');
	}

	/* Bin */
	function binSorgula(bin,amount){
		$.ajax({
			type : 'POST',
			data : 'veri=bin&bin='+bin,
			dataType: "json",
			url  : '<?php echo $set['siteurl']; ?>/ajax/odeme.php',
			success : function(result){
				if(result.status == "success"){
					$('#bankName').val(result.bankName);
					$('#binNumber').val(result.binNumber);
					$('#cardFamily').val(result.cardFamily);
					$('#cardAssociation').val(result.cardAssociation);
					$('#cardType').val(result.cardType);
					if(result.cardAssociation == 'AMERICANEXPRESS'){
						$('.cartType').html('<div class="card-american"></div>');
					}else if(result.cardAssociation == "VISA"){
						$('.cartType').html('<div class="card-visa"></div>');
					}else if (result.cardAssociation == "MASTER_CARD"){
						$('.cartType').html('<div class="card-master"></div>');
					}
					$('.cartLogo').html('<img src="<?php echo $set['siteurl']; ?>/assets/images/cards/'+result.bankImg+'" alt="" />');
					<?php if(!$anapos){ ?>
					taksit(bin,amount);
					<?php  } ?>
				}else if(result.status == "failure"){
					 <?php if(!$anapos){ ?>
					 clearBanks();
					 <?php  } ?>
				}
				
			},
			  error: function(xhr, textStatus, errorThrown) {
				console.log(xhr);
			  }
		});
	}
	
	function selected(){
		$('.installments li').click(function(){
			$('.installments li').removeClass('selected');			
			$(this).addClass("selected");
			$('.installments li input').prop('checked',false);
			$(this).find('input').prop('checked',true);
		 });
	}
	
	
	function taksit(bin,amount){
		$.ajax({
			type  : 'POST',
			data  : 'veri=taksit&amount='+amount+'&bin='+bin,
			url   : 'ajax/odeme.php',
			cache : false,
			success : function(result){	
				var dizi = result.split('|x|');	
				if(dizi[1] == "success") {
					$('.taksitler').html(dizi[0]);	
					$('#force3ds').val(dizi[2]);
					selected();
				}
			}, error: function (xhr, desc, err) {
				console.log("Details: " + desc + "\nError:" + err);
			}
		});
		
	}

	
	function number_format(number, decimals, dec_point, thousands_point) {

		if (number == null || !isFinite(number)) {
			throw new TypeError("number is not valid");
		}

		if (!decimals) {
			var len = number.toString().split('.').length;
			decimals = len > 1 ? len : 0;
		}

		if (!dec_point) {
			dec_point = '.';
		}

		if (!thousands_point) {
			thousands_point = ',';
		}

		number = parseFloat(number).toFixed(decimals);
		number = number.replace(",", dec_point);
		var splitNum = number.split(dec_point);
		splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
		number = splitNum.join(dec_point);
		return number;
		
	}
	
	function hesapla(){
		var hesap = 0.00;
		var indirim = 0.00;
		
		var aratutar,araindirim;
		$('.basket-right ul li').each(function(){
			var tutar = $(this).find('span.tutar-hesap').html();
			var indirimtutar = $(this).find('span.indirim-hesap').html();
			if(tutar != undefined && tutar != "" ){
				tutar = tutar.replace(",","");
				tutar = tutar.replace(".",",");
				tutar = parseFloat(tutar);
				hesap = hesap + tutar;
			}
			if(indirimtutar != undefined && indirimtutar != "" ){
				 indirimtutar = indirimtutar.replace(",","");
				 indirimtutar = indirimtutar.replace(".",",");
				 indirim = indirim + parseFloat(indirimtutar);	
			}
		});
		
		aratutar     =  hesap - indirim;
		aratutar     = number_format(aratutar,2,'.',',');
		$('.basket-right ul li.genel-toplam span.tutar').html(aratutar);
		$('input[name=toplamtutar]').val(aratutar);
	}
	$(function(){

		 selected();				 
		$('[data-toggle="popover2"]').popover({
			placement : 'top',
			trigger : 'hover',
			html : true,
			content : '3D Secure nedir? <br/> 3D Secure, internetten güvenle alışveriş yapılabilmesi için Visa ve MasterCardın geliştirdiği ek bir kimlik doğrulama sistemidir. Bu sistemle hem kart sahipleri hem de üye iş yerleri internet dolandırıcılıklarına karşı güvence altına alınır.'
		}); 
		
	
		hesapla();

		$('.nav-tabs li:first').addClass('active');
		$('.tab-content div:first').addClass('active');
		$('input.odemeturu').val($(".odemeler ul li a:first").attr('rel'));

		
		$('.li-kapida-odeme').hide();
		$(".odemeler ul li a.enable").click(function(e){
			if($(this).hasClass('disable')){
				return false;
			}
			var kon = $(this).attr('rel');
			var odtur = $(this).attr('data-tur');

			$('input.odemeturu').val(kon);
			if(odtur == "kapidaodeme"){
				$('.li-kapida-odeme').show();
				var kapidaodemeturu = $('.kapi-item input:checked').val();
					split = kapidaodemeturu.split('|x|');
					$('span.kapida-odeme').html(split[1]);
					$('input[name=kapidaodemefiyat]').val(split[1]);
					$('input[name=kapidaodemeturu]').val(split[0]);
					hesapla();
					$('.kapi-item input').change(function(){
							kapideger = $(this).val();
							kapideger = kapideger.split('|x|');
							$('span.kapida-odeme').html(kapideger[1]);
							$('input[name=kapidaodemefiyat]').val(kapideger[1]);
							$('input[name=kapidaodemeturu]').val(kapideger[0]);
							hesapla();
					});
		
			}else {
				$('.li-kapida-odeme').hide();
				$('span.kapida-odeme').html('0.00');
				$('input[name=kapidaodemefiyat]').val("");
				$('input[name=kapidaodemeturu]').val("");
				hesapla();
				$('form#odemeform').formValidation('destroy');
			}
			
			
		});
	
		$('.sip-done button').on('click',function(){
			var od = $('input.odemeturu').val();
			if(od == "kredikarti"){
				$('form#odemeform').formValidation('destroy').formValidation({
					framework: 'bootstrap',
					icon: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
				   },
					fields: {
						cardadsoyad: {
							validators: {
								notEmpty: {
									message: 'Kart Sahibinin Adı Soyadı Boş Olamaz'
								}
							}
						},
						pan: {
							validators: {
								notEmpty: {
									message: 'Kart Numarası Boş Olamaz'
								},
								
							}
						},
						cv2: {
							validators: {
								notEmpty: {
									message: 'Kart Güvenlik Şifresi Boş Olamaz'
								},
								stringLength: {
									min:3,
									message: 'Güvenlik Kodu 3 Karekterden Küçük Olamaz'
								}
							}
						},
						sozlesme1: {
							validators: {
								notEmpty: {
									message: 'Ön Bilgilendirme Formunu Kabul Ediniz'
								},
							}
						},
						sozlesme2: {
							validators: {
								notEmpty: {
									message: 'Mesafeli Satış Sözleşmesini Kabul Ediniz'
								},
							}
						},
					
					}
				}).on('success.form.fv', function(e) {
					e.preventDefault();
					 $('.cihaniriboy-loading').show();		
					var $form = $(e.target),
					 fv    = $(e.target).data('formValidation');
					 fv.defaultSubmit();
					 
				});
				
			}else {
				$('form#odemeform').formValidation('destroy').formValidation({
					framework: 'bootstrap',
					icon: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
				   },
					fields: {
						sozlesme1: {
							validators: {
								notEmpty: {
									message: 'Ön Bilgilendirme Formunu Kabul Ediniz'
								},
							}
						},
						sozlesme2: {
							validators: {
								notEmpty: {
									message: 'Mesafeli Satış Sözleşmesini Kabul Ediniz'
								},
							}
						},
						
					
					}
				}).on('success.form.fv', function(e) {
					e.preventDefault();
					 $('.cihaniriboy-loading').show();
					 var $form = $(e.target),
					 fv    = $(e.target).data('formValidation');
					 fv.defaultSubmit();
				});
				
			}
			
		});

		$('.mini-sepet .title').click(function(){
			  if(!$(this).hasClass('active')){
				  $(this).addClass('active');
				  $('.urun-list').hide();
			  }else{
				   $(this).removeClass('active');
				   $('.urun-list').show();
			  }
		  });
		  
		 
		 $('#mesafeli-satis-sozlesmesi-checkbox').change(function() {
			if( this.checked ) {
				$('input[name=mesafeli-satis-sozlesmesi]').attr("value", "1");
			}else{
				$('input[name=mesafeli-satis-sozlesmesi]').attr("value", "2");
			}
		});
		
		$('#cardNumber').keypad({
            keypadOnly: false,
            onKeypress: function (key, value, inst) {
                $('#cardNumber').keyup();
                $('#cardNumber').keypress();
            }
        });
		
		  $('#cvcNumber').keypad({
            keypadOnly: false,
            onKeypress: function (key, value, inst) {
                $('#cvcNumber').keyup();
            }
        });
		
		 $('#cardNumber').bind("cut copy paste", function (e) {
            e.preventDefault();
        });

		
		 $('#cardNumber').keyup(function (e) {
			if (e.charCode == 0 && e.keyCode == 0) {
                return false;
            }
			var val = $(this).val().split(" ").join("");
			if (val.length < 6) {
			   clearBanks();
            } else if (val.length == 6 ) {
			   var amount = $('#i-amount').val();	
			   binSorgula(val.substr(0, 6),amount);
			   

            } else if (val.length > 16) {
                return false;
            }
			
			 if (val.length > 0) {
                val = val.match(new RegExp('.{1,4}', 'g')).join(" ");
            }
			$(this).val(val);
            $(".cartNo").text(val);


		 });
		 
		 $('#cardNumber').keypress(function (e) {
			var keyNum;
            if (window.event) {
                keyNum = e.keyCode;
            }else if (e.which) {
                keyNum = e.which;
            }
			var val = $(this).val().split(" ").join("");
			return ((keyNum >= 48 && keyNum <= 57) || keyNum == 8) && val.length <= 15;

		});
		
		 $('#cardadsoyad').keyup(function () {
			 
            if ($(this).val() != '') {
                $(".cartName").text($(this).val());
            } else {
                $(".cartName").text('Ad Soyad');
            }
	
        });

		$("em.ay").text(("0" + $('#ccAy').val()).slice(-2));
		$('#ccAy').change(function () {
			$("em.ay").text(("0" + $(this).val()).slice(-2));
		});
		$("em.yil").text($('#ccYil').val());
		$('#ccYil').change(function () {
			$("em.yil").text($(this).val());
		});
		
		 $('#cvcNumber').focus(function () {
            $("#kredi-karti-content").addClass("creditCardBack");
            $("#kredi-karti-content").removeClass("creditCardFront");
        }).blur(function () {
            $("#kredi-karti-content").addClass("creditCardFront");
            $("#kredi-karti-content").removeClass("creditCardBack");
        });
		
		$('#cvcNumber').keyup(function () {
            
			var val = $(this).val();
            var cvvLen = $("#cardAssociation").val() == "AMERICAN_EXPRESS" ? 4 : 3; 
			 if (val.length > 0) {
                val = val.match(new RegExp('.{1,4}', 'g')).join(" ");
            }
			if ($(this).val().length == cvvLen ) {
				 $(".keypad-close").click();
			}
			$(".cardCvc").text(val);
        });

		/*if($('.card-errors').is(':visible')){
			var h = $('.card-errors').offset().top;	
			$("html,body").stop().animate({ scrollTop: h+"px" }, 1000);
		}*/
		
	});
</script>
<?php unset($_SESSION["hata"]); ?>
 </body>
</html>