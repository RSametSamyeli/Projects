<?php  if( !defined("SABIT") ){ exit; } 
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_siparisitamamla['seo']);
include('ajax/sozlesme/sozlesme.php');
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
if(!isset($_SESSION["sepet"])){
	 header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}
## uye kontrol 
if(isset($_SESSION["m_oturum"])){
	 header("Location: /");
	 exit;
}


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


seoyaz("Ödeme Sayfası","","",""); 
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/siparis-tamamla.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/keypad.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-sepet-content custom-sepet-content">
			<div class="container">
				<div class="siparis-tamam-header">
					<div class="col-sm-12 col-md-8">
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-location-arrow"></i>TESLİMAT BİLGİLERİ</h2>
								<p>Teslimat ve Ödeme Bilgilerinizi Giriniz </p>
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
				
				
				<!--form basla-->
			<?php if($odemesanalpos['durum'] == 1) {?>
				<?php  if($iyziDurum == 1 ){ ?>
				<form action="<?php echo $set['siteurl']; ?>/ajax/odeme/uyeliksizodeme.php"  id="odemeform" method="POST">
				<?php }elseif($payuDurum  == 1) { ?>
					<form action="<?php echo $set['siteurl']; ?>/ajax/odeme/uyeliksizodeme.php"  id="odemeform" method="POST">
				<?php }else{ ?>
					<?php  if($anapos['mode'] == "T"){
					   echo '<form method="post" id="odemeform" action="/3dpostuyeliksiz.php">';
					}else{
						echo '<form method="post" id="odemeform" action="/3dpostuyeliksiz.php">';
					}
					?>
				<?php } ?>
				<?php  } else {   ?>
						<form action="<?php echo $set['siteurl']; ?>/ajax/odeme/uyeliksizodeme.php" id="odemeform" method="POST">
				<?php } ?>
				
				
				<div class="col-md-8 col-xs-12">
					<div class="tamamla-sol">
						<div class="adres-secimi">
							<div class="title">
								<i class="fa fa-map-signs" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Teslimat Bilgileri</h3>
									<span>Lütfen Formu Doldurun</span>
								</div>
							</div>
							<div class="secim-content">
								<div class="odeme-adres">
								
										<div class="white-card">
											<div class="adres-form-content" style="display:block">
														<p class="required">Zorunlu Alanlar  * </p>
														<div class="form-group">
															<label>Ad *</label>
															<input type="text" class="form-control" placeholder="Adınız" name="adres_ad">
															
														</div>
														<div class="form-group">
															<label>Soyad *</label>
															<input type="text" name="adres_soyad" class="form-control" placeholder="Soyadınız" autocomplete="off">
														
														</div>
														<div class="form-group">
															<label>Doğum Tarihi *</label>
															<input id="tarih" name="adres_dogumt"  type="text" placeholder="22/01/1999" autocomplete="off"  class="form-control input-lg ll-skin-lugo tarih">
														</div>
														<div class="form-group">
															<label>Telefon *</label>
															<input type="text" id="telefon" name="adres_telefon" class="form-control input-lg">
														</div>
														
														<div class="form-group">
															<label>E-Posta *</label>
															<input type="text" name="adres_mail" placeholder="E-Posta Adresiniz" class="form-control input-lg">
														</div>
														
														<div class="form-group">
															<label>Açık Adresiniz *</label>
															<textarea name="adres_mesaj" class="form-control" cols="2"  placeholder="Adresiniz"></textarea>
														</div>
														
														<div class="form-group">
															<label>Şehir Seç *</label>
															<input type="text" name="sehir" class="form-control"  placeholder="Şehirinizi Yazın" autocomplete="off">
																
														</div>
														
														<div class="form-group">
															<label>Semt / Mahalle *</label>
															<input type="text" name="semt_mahalle" class="form-control" placeholder="Semt / Mahalle" autocomplete="off">	
														</div>
														
														<div class="form-group">
															<label>Adres Tarifi *</label>
															<textarea name="acikadres"  class="form-control" cols="2"  placeholder="Adresiniz"></textarea>
														</div>
														
														
											</div>
											<!--/adres content -->
											
										</div>
									
								
								</div>
								<!--//adresss-->
								
							</div>
						</div>
						<!--/adres-->
						<?php if($kargolarCount > 0 ) { 
						
									$genelToplam = 0;
									$indirimler  = 0;
									$kargodurum = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef	  = unserialize($urunCek['sef']);
									if($urunCek['skargo'] == 1){
										$kargodurum = 1;
									}
			
									$varyant  = $row['varyant'];
									/* varyant hesapla */
										if(count($varyant) > 0) {	 
											$varAra  = 0 ;
											$defvarPlus   = 0;
											$defvarMinus  = 0;
											for($i = 0; $i < count($varyant['varBaslik']); $i++) {
												$varTutar = $varyant['varTutar'][$i];
												$varTur   = $varyant['varTur'][$i];
												if($varTur == 1){
													$defvarPlus  += $varTutar;
													$varAra      = number_format($row['arafiyat'],2) + $defvarPlus;
												}
												if($varTur == 0){
													$defvarMinus  += $varTutar;
													$varAra  = number_format($row['arafiyat'],2) - $defvarMinus;
												}
											}
											$birimfiyat = number_format($varAra,2);
										} else {
											$birimfiyat = number_format($row['arafiyat'],2);
										}
										
										$genelToplam += $row['adet'] * $birimfiyat;
									
									}
									
									?>
							
						<div class="kargo-secimi <?php 
							if($kargodurum ==1){	 
								echo ' hide';
							}
						?>">
							<div class="title">
								<i class="fa fa-truck" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Kargo Seçenekleri</h3>
									<span>Tercih Ettiğiniz Kargoyu Seçiniz</span>
								</div>
							</div>
							<div class="kargo-list">
								<ul>
									
									
									<?php 
									
									$i = 0;
									
										foreach($kargolarFetch as $row) { 
										$i++;
										$kampanya_durum = $row['kampanya_durum'];
										$kampanya_toplam = $row['kampanya_toplam'];
										if($kampanya_durum == 1){
											if( number_format($genelToplam,2) >= number_format($kampanya_toplam,2)) {
												$kargoucret = $row['kampanya_ucret'];
											}else{
												$kargoucret = $row['kargoucret'];
											}
										}else{
											$kargoucret = $row['kargoucret'];
										}
									
										if($kargodurum == 1){
											$kargoucret = 0;
										}
										
									?>
										<input type="hidden" name="sepettoplam" value="<?php echo number_format($genelToplam,2); ?>" />
									<li>
										<label>
											<div class="kargoinput">
												<input data-price="<?php  echo number_format($kargoucret,2); ?>" type="radio" <?php echo $i == 1 ? ' checked ' : null; ?> id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" name="kargosecenek" />
											</div>
											<div class="kargoimg">
												<img src="<?php echo $set['siteurl']; ?>/uploads/kargo/<?php echo $row['image']; ?>" alt="<?php echo $row['firmaadi']; ?>" />
											</div>
											<div class="kargoname">
												<?php echo $row['firmaadi']; ?> - <div class="kargo-price"><?php  echo number_format($kargoucret,2); ?></div> TL
											</div>
										</label>
									</li>
									 <?php } ?>
								</ul>
								
							</div>
						</div>
						<?php  } ?>
						<!--/kargo-->
						
				<div class="col-md-12 col-xs-12 no-padding">
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
				
						<div class="siparis-notu">
							<div class="title">
								<i class="fa fa-pencil" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Sipariş Notu</h3>
									<span>Sipariş ile belirtmek istediğiniz notlar.</span>
								</div>
							</div>
							<textarea name="siparisnot" class="form-control" id="" cols="0" rows="0"></textarea>
						</div>
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
									$kdv = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant 	 = $row['varyant'];
									$secenekler   = $row['secenekler'];
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
												var_dump(implode('|x|',$secenekler));	
											}else{
												$secenekArr[] = '';		 			
											}
											
											if(count($varyant) > 0) {	
												$varyantidler    = array();
												$varyantturler   = array();
												$varyantFiyatlar = array();
												$varyantAciklama = array();
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
												$varyantFiyatlar[] = '';
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
								<?php if(count($row['secenekler']) > 0 ) {
									foreach($row['secenekler'] as $spkey => $val){ ?>
										<input type="text" name="secenekler[<?php echo $row['sepetid']; ?>][<?php echo $spkey; ?>]" value="<?php echo $val; ?>" />
									<?php }
								} ?>
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
								$anaTutar = number_format($genelToplam,2) + $kdv;
								$anaTutar =    number_format($genelToplam,2);
								$anaTutar =  $anaTutar - $indirimler;
								?>
								<li><span>Sipariş Tutarı</span> <p> TL</p><span class="tutar tutar-hesap"><?php echo number_format($genelToplam,2); ?> </span></li>
								<li><span>Kdv</span> <p>TL</p><span class="tutar"><?php echo $kdv; ?>  </span></li>
								<li class="li-kapida-odeme"><span>Kapıda Ödeme Tutarı</span> <p>TL</p><span class="kapida-odeme tutar-hesap">0.00 </span> </li>
								<li><span>Kargo</span><p>TL</p><span class="kargo-tutar tutar-hesap">0.00 </span></li>
								
								<li class="genel-toplam"><span>Sepet Toplamı</span><p>TL</p><span class="tutar"><?php echo number_format($anaTutar,2); ?> </span></li>	
								<?php ?>
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
					<input type="hidden" name="teslimatadresi" value="" />
					<input type="hidden" name="faturaadresi" value="" />
			
			
					<input type="hidden" name="kdv" value="<?php echo $kdv; ?>" />
					<input type="hidden" name="kapidaodemefiyat" value="" />
					<input type="hidden" name="kapidaodemeturu" value="" />

					<input type="hidden" name="kargotutar" value="" />
					<input type="hidden" name="kdvsiztutar" value="<?php echo $genelToplam; ?>"  />
			
					<input type="hidden" class="amount" name="toplamtutar" id="i-amount" value="<?php echo $anaTutar; ?>" />	
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
	

	
	<?php include('include/sabit/sozlesmeler.php'); ?>	
	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.plugin.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.keypad.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.keypad-tr.js"></script>
<?php _footer_last(); ?>


<script type="text/javascript">

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
				var kapidevam = $('input[name=kapiodemedevam]').val();
				$('#odemeform').attr("action","<?php echo $set['siteurl']; ?>/ajax/odeme/uyeliksizodeme.php");
				if(kapidevam == 0){
					$('.sip-done button').hide();
				}else{
					$('.li-kapida-odeme').show();
					var kapidaodemeturu = $('.kapi-item input:checked').val();
					split = kapidaodemeturu.split('|x|');
					$('span.kapida-odeme').html(split[1]);
					$('input[name=kapidaodemefiyat]').val(split[1]);
					$('input[name=kapidaodemeturu]').val(split[0]);
					$('input[name=havaleindirimtutar]').val("0.00");
					$('span.spanhavaleindirim').html("0.00");
					hesapla();
					$('.kapi-item input').change(function(){
						kapideger = $(this).val();
						kapideger = kapideger.split('|x|');
						$('span.kapida-odeme').html(kapideger[1]);
						$('input[name=kapidaodemefiyat]').val(kapideger[1]);
						$('input[name=kapidaodemeturu]').val(kapideger[0]);
						hesapla();
					});
				}
			}else if(odtur == "havale"){
				$('#odemeform').attr("action","<?php echo $set['siteurl']; ?>/ajax/odeme/uyeliksizodeme.php");
				$('.li-havaleindirim').show();
				$('input[name=havaleindirimtutar]').val(havaleindirim);
				$('span.spanhavaleindirim').html(havaleindirim);
				$('.sip-done button').show();
				$('.li-kapida-odeme').hide();
				$('span.kapida-odeme').html('0.00');
				$('input[name=kapidaodemefiyat]').val("");
				$('input[name=kapidaodemeturu]').val("");
				hesapla();
				$('form#odemeform').formValidation('destroy');
			}else {
				$('#odemeform').attr("action","<?php echo $set['siteurl']; ?>/3dpostuyeliksiz.php");
				$('.sip-done button').show();
				$('.li-kapida-odeme').hide();
				$('span.kapida-odeme').html('0.00');
				$('input[name=havaleindirimtutar]').val("0.00");
				$('span.spanhavaleindirim').html("0.00");
				
				//$('.havaleindirim').val("");
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
						
							adres_ad: {

							validators: {

								notEmpty: {

									message: 'Adınızı Giriniz'

								}

							}

						},

						adres_soyad: {

							validators: {

								notEmpty: {

									message: 'Soyadınızı Giriniz'

								}

							}

						},

						adres_mail: {

							validators: {

								notEmpty: {

									message: 'E-Mail Adresinizi Giriniz'

								}

							}

						},

						adres_telefon: {

							validators: {

								notEmpty: {

									message: 'Telefon Numaranızı Giriniz'

								}

							}

						},

						adres_dogumt: {

							validators: {

								notEmpty: {

									message: 'Doğum Tarihinizi Giriniz'

								}

							}

						},

						sehir: {

							validators: {

								notEmpty: {

									message: 'Şehir Alanını Boş Bırakmayın'

								}

							}

						},

						semt_mahalle: {

							validators: {

								notEmpty: {

									message: 'Semt Mahalle Alanını Boş Bırakmayın'

								}

							}

						},

						acikadres: {

							validators: {

								notEmpty: {

									message: 'Açık Adres Alanını Boş Bırakmayın'

								}

							}

						},
					  adres_mesaj: {

							validators: {

								notEmpty: {

									message: 'Adresinizi Yazmadınız'

								}

							}

						},
						
						adres_mail: {

							validators: {

								notEmpty: {

									message: 'E-Mail Adresinizi Giriniz'

								}

							}

						},

						adres_telefon: {

							validators: {

								notEmpty: {

									message: 'Telefon Numaranızı Giriniz'

								}

							}

						},

						adres_dogumt: {

							validators: {

								notEmpty: {

									message: 'Doğum Tarihinizi Giriniz'

								}

							}

						},
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
						
							adres_ad: {

							validators: {

								notEmpty: {

									message: 'Adınızı Giriniz'

								}

							}

						},

						adres_soyad: {

							validators: {

								notEmpty: {

									message: 'Soyadınızı Giriniz'

								}

							}

						},

						adres_mail: {

							validators: {

								notEmpty: {

									message: 'E-Mail Adresinizi Giriniz'

								}

							}

						},

						adres_telefon: {

							validators: {

								notEmpty: {

									message: 'Telefon Numaranızı Giriniz'

								}

							}

						},

						adres_dogumt: {

							validators: {

								notEmpty: {

									message: 'Doğum Tarihinizi Giriniz'

								}

							}

						},

						sehir: {

							validators: {

								notEmpty: {

									message: 'Şehir Alanını Boş Bırakmayın'

								}

							}

						},

						semt_mahalle: {

							validators: {

								notEmpty: {

									message: 'Semt Mahalle Alanını Boş Bırakmayın'

								}

							}

						},

						acikadres: {

							validators: {

								notEmpty: {

									message: 'Açık Adres Alanını Boş Bırakmayın'

								}

							}

						},
					  adres_mesaj: {

							validators: {

								notEmpty: {

									message: 'Adresinizi Yazmadınız'

								}

							}

						},
						
						adres_mail: {

							validators: {

								notEmpty: {

									message: 'E-Mail Adresinizi Giriniz'

								}

							}

						},

						adres_telefon: {

							validators: {

								notEmpty: {

									message: 'Telefon Numaranızı Giriniz'

								}

							}

						},

						adres_dogumt: {

							validators: {

								notEmpty: {

									message: 'Doğum Tarihinizi Giriniz'

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


<script type="text/javascript">
	$(function(){
		  $('.adres-disable input').change(function(){
			  if (this.checked) {
				$('.fatura-adresi').attr('disabled', true);
			  } else {
				$('.fatura-adresi').attr('disabled', false);
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
		 	
		 /***** Kargo  *****/
		$.kargom = function(id){
			//$('.overlay-sepet').show();
			$('span.kargo-tutar').html(id);
			$('input[name=kargotutar]').val(id);
			hesapla();
		}	
			
		var fkargoid = $('input[name=kargosecenek]:checked').attr('data-price');
		$.kargom(fkargoid);
		$('input[name=kargosecenek]').change(function(){  
			   var id = $(this).attr('data-price');
				$.kargom(id);
		});
		
		$('.sip-done a').click(function(){
			  $('#teslimatform').submit();
			  return false;
		  });
		
	});
</script>
 </body>
</html>