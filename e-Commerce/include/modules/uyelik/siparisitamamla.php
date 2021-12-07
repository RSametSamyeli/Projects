<?php  if( !defined("SABIT") ){ exit; } 
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_siparisitamamla['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
if(!isset($_SESSION["sepet"])){
	 header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	 header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}
$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }



## adresler
$adresler      = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 
$adreslerCount =  $adresler -> rowCount();
$adreslerFetch =  $adresler -> fetchAll();
## kargolar 
$kargolar = $conn -> query("select * from kargo where durum = 1 order by sira asc");
$kargolarCount = $kargolar-> rowCount();
$kargolarFetch = $kargolar -> fetchAll(); 

seoyaz("".$title."","".$description."","".$keywords ."",""); 
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/siparis-tamamla.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-sepet-content">
			<div class="container">
				<div class="siparis-tamam-header">
					<div class="col-sm-12 col-md-4">
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-location-arrow"></i>TESLİMAT BİLGİLERİ</h2>
								<p>Teslimat Bilgilerinizi Giriniz </p>
							</div>
							<i class="fa fa-angle-right"></i>
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
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-check" aria-hidden="true"></i>SİPARİŞ ONAYI</h2>
								<p>Siparişiniz Özeti </p>
							</div>
						</div>
					</div>
				</div>
				<form action="<?php echo $set['langurl']; ?>/odeme" id="teslimatform" method="POST">
				<div class="col-md-8 col-xs-12">
					<div class="tamamla-sol">
						<div class="adres-secimi">
							<div class="title">
								<i class="fa fa-map-signs" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Adres Bilgileri</h3>
									<span>Tercih Ettiğiniz Adresleri Seçin</span>
								</div>
							</div>
							<div class="secim-content">
								<?php if($adreslerCount > 0) { ?>
								<div class="col-sm-6 col-xs-12">
									<div class="adres-select">
										<h5>Teslimat Adresi</h5>
										<select name="teslimatadresi" class="form-control teslimat-adresi" id="">
											<?php foreach($adreslerFetch as $row){?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>  - <?php echo $row['adres']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="adres-select">
										<h5>Fatura Adresi</h5>
										<select name="faturaadresi" class="form-control fatura-adresi" id="">
											<?php foreach($adreslerFetch as $row){?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> - <?php echo $row['adres']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="adres-disable">
									<label>
										<input type="checkbox" name="adres_disable" value="adresdisable">
										  Fatura bilgilerim teslimat bilgilerim ile aynı olsun
									</label>
								</div>
								<?php  } else { ?>
									<div class="adres-tanimla">
										Kayıtlı Adres Bulunmuyor. <a href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>/ekle">Adres Eklemek İçin Tıklayın.</a>
									</div>
								<?php } ?>
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
													$varAra      = $row['arafiyat'] + $defvarPlus;
												}
												if($varTur == 0){
													$defvarMinus  += $varTutar;
													$varAra  = $row['arafiyat'] - $defvarMinus;
												}
											}
											$birimfiyat = $varAra;
										} else {
											$birimfiyat = $row['arafiyat'];
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
												<input type="radio" <?php echo $i == 1 ? ' checked ' : null; ?> id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" name="kargosecenek" />
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
						<?php if($adreslerCount > 0 ){ ?>
						<div class="sip-done">
							<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparisitamamla_link[$set['lang']['active']]; ?>">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></a>
						</div>
						<?php  } ?>
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
									$sef	  = unserialize($urunCek['sef']);
									$varyant  = $row['varyant'];
									if($urunCek['skargo'] == 1){
										$kargodurum = 1;
									}
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
									$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1");
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlar -> rowCount() >0 ) {
										foreach($kuponlarFetch as $row){ 
											$indirimler  = $indirimler + $row['tutar'];
										}
									}
								}
								$anaTutar = $genelToplam + $kdv;
								$anaTutar = $genelToplam;
								$anaTutar = $anaTutar - $indirimler;
								?>
								<li><span>Sipariş Tutarı</span> <p> TL</p><span class="tutar"><?php echo number_format($genelToplam,2); ?> </span></li>
								<li><span>Kdv</span> <p>TL</p><span class="tutar"><?php echo $kdv; ?>  </span></li>
								<?php  if($kargodurum != 1){ ?>
								<li><span>Kargo</span><p>TL</p><span class="kargo-tutar">0.00 </span></li>
								<?php  } ?>
								<?php 
								## puan 
								if(isset($_SESSION["fs"]["puan"])){
									echo '<li class="li-puan li-puan'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["puan"].'</span></li>';
								}
								?>
								<?php 
								## puan 
								if(isset($_SESSION["fs"]["kredi"])){
									echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["kredi"].'</span></li>';
								}
								?>
								<?php 
								## indirimler
								if(isset($_SESSION["m_oturum"])){
									
									if($kuponlar -> rowCount() >0 ) {
										
										foreach($kuponlarFetch as $row){
											echo '<li><span>Kupon Tutarı </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
										}
									}
								}
								?>
								
								<li class="genel-toplam"><span>Sepet Toplamı</span> <p>TL</p><span class="tutar"><?php echo number_format($anaTutar,2); ?> </span></li>
								<?php ?>
							</ul>
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
						<?php if($adreslerCount > 0 ){?>
						<div class="sip-done">
							<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparisitamamla_link[$set['lang']['active']]; ?>">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></a>
						</div>
						<?php  } ?>
					</div>
				</div>
				</form>
					
			</div>
		</div>
		
	</div>
	

	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<?php _footer_last(); ?>
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
		 	
		if($('.kargo-list').length > 0){	
			$.kargom = function(id){
				$('.overlay-sepet').show();
				$.ajax({
					type:'POST',
					url:'ajax/odeme.php',
					data: 'id='+id+'&veri=kargo',
					cache:false
				}).done(function(e){
					$('.overlay-sepet').hide();	
					var split = e.split('|x|');
					$('.sepet-page-right .basket-right ul:first').html(split[3]);
					$('#first-sepet-ul ul:first').html(split[1]);
				}).fail(function(){
					alert("Hata-2");
				});
			}		

			 var fkargoid = $('input[name=kargosecenek]:checked').attr('id');
			$.kargom(fkargoid);
			$('input[name=kargosecenek]').change(function(){  
				   var id = $(this).attr('id');
					$.kargom(id);
			});
			
	
		}
		$('.sip-done a').click(function(){
			  $('#teslimatform').submit();
			  return false;
		  });
		
	});
</script>
 </body>
</html>