<?php  if( !defined("SABIT") ){ exit; } 
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_sepet['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
	## adresler
	$adresler      = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 
	$adreslerCount =  $adresler -> rowCount();
	$adreslerFetch =  $adresler -> fetchAll();
}


## kargolar 
$kargolar = $conn -> query("select * from kargo where durum = 1 order by sira asc");
$kargolarCount = $kargolar-> rowCount();
$kargolarFetch = $kargolar -> fetchAll(); 
$oid        = "".rand(23,999999)."";   

seoyaz("".$title."","".$description."","".$keywords ."",""); ?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/sepetim.css" />
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
					<li><?php echo $sef_sepet_baslik[$set['lang']['active']]; ?></li>
				</ul>
			</div><!-- /.breadcrumb-inner -->
		</div><!-- /.container -->
	</div><!-- /.breadcrumb -->
	<div class="cihaniriboy-outer-page">
		<div class="custom-sepet-content">
			<div class="container">
				<div class="row">
				<?php if(count(@$_SESSION["sepet"]) > 0) {?>
					<div class="col-md-8 col-xs-12">
						<div class="sepet-page">	
							<div class="sepet-table">
								<form action="" method="post" id="sepetform">
									<div class="table-responsive">
										<table class="table" id="sepetim">
												<thead>
													<tr>
														<th><?php echo $lang['yardimci']['urun_bilgileri']; ?></th>
														<th class="text-center"><?php echo $lang['yardimci']['adet']; ?></th>
														<th class="text-center"><?php echo $lang['yardimci']['birim_fiyat']; ?></th>
														<th class="text-center"><?php echo $lang['yardimci']['toplam_fiyat']; ?></th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$genelToplam = 0;
													$indirimler  = 0;
													$kdv = 0;
													foreach(@$_SESSION["sepet"] as $row) { 
													
													$urunCek    =  $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
													$sef = unserialize($urunCek['sef']);
													$varyant = $row['varyant'];
													$siparistarih = $row['siparistarih'];
													$siparissaat  = $row['siparissaat'];
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
													<tr class="trsepet<?php echo $row['sepetid']; ?> <?php echo $puandiv; ?>">
														<td class="urun-bilgi" width="50%">
															<div class="sepet-img">
																<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['sepetid']; ?>">
																	<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
																</a>
															</div>
															<div class="sepet-desc">
																<span><?php echo $row['baslik']; ?> </span><br/>
																<span><?php echo $urunCek['kod']; ?></span><br/>
																<?php 
																if(count($varyant) > 0) {	
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
																}
																?>
															</div>
															<?php if($parapuan['puansistemi'] == 1){ ?>
																<?php  if($urunCek['parapuan'] == 1 ){ ?>
																<div class="puan">Bu Ürün Puanla Satın Alınabilir</div>
																<?php  } else { ?>
																<div class="puan">Bu Ürün Puanla Satın <span>Alınamaz</span></div>
																<?php } ?>
															<?php }  // puan acıksa ?>
															
															<?php if(!empty($siparistarih)){ 
																echo ' 
																	<div class="sepet-sip-tarih">
																		<span>Sipariş Tarihi</span>
																		'.$siparistarih.' '.$siparissaat.'
																	</div>
																'; 
															  } ?>
														</td>
														<td class="text-center">
															<?php echo $row['adet']; ?>
														</td>
														<td class="text-center">
															<?php 
															if(count($varyant) > 0) {	 
																$varAra  = 0 ;
																$defvarPlus   = 0;
																$defvarMinus  = 0;
																$varyantidler    = array();
																$varyantturler   = array();
																$varyantFiyatlar = array();
																$varyantAciklama = array();
																for($i = 0; $i < count($varyant['varBaslik']); $i++) {
																	$varTutar = $varyant['varTutar'][$i];
																	$varTur   = $varyant['varTur'][$i];
																	$varyantidler[]  = $varyant['varid'][$i];	
																	if(!empty($varTur)){
																		if($varTur == 1){
																			$defvarPlus  += $varTutar;
																			$varAra      = $row['arafiyat'] + $defvarPlus;
																		}
																		if($varTur == 0){
																			$defvarMinus  += $varTutar;
																			$varAra  = $row['arafiyat'] - $defvarMinus;
																		}
																	}
																	// varyantlar
																		if($varyant['varTutar'][$i] != 0.00 ){
																		$varyantFiyatlar[]   = $varyant['varTutar'][$i];
																		$varyantturler[]     = $varyant['varTur'][$i];	
																		
																		if($varyant['varTur'][$i] == 0){
																			$varDurum  = '(-)';
																		}else{
																			$varDurum  = '(+)';
																		}
																		$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i].' - '.$varDurum.' '.$varyant['varTutar'][$i];	
																		
																	}else{
																		$varyantFiyatlar[] = '';
																		$varyantturler[]   = '';
																		$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i];	
																	}
																}
																
															} else {
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
															
															<?php if(count($varyant) > 0) {  
																if($varyant['varTutar'][0] != 0.00) {
															?>
															<span class="varli-fiyat"><?php  echo $row['arafiyat']; ?> <?php echo $lang['yardimci']['tl']; ?>  <br/></span>
																<?php } } ?>
															<?php echo number_format($birimfiyat,2); ?> <?php echo $lang['yardimci']['tl']; ?>
														</td>
														<td class="sepet-fiyat text-center"><span><?php echo number_format($row['adet'] * $birimfiyat , 2 ); ?> <?php echo $lang['yardimci']['tl']; ?></span></td>
														<td class="text-center remove-sepet"><a href="#" id="<?php echo $row['sepetid']; ?>"  class="remove"><i class="fa fa-remove"></i></a></td>
														<input type="hidden" name="urunid[]" class="urunids" value="<?php echo $row['sepetid']; ?>" />
														<input type="hidden" name="baslik[]" value="<?php echo $row['baslik']; ?>" />
														<input type="hidden" name="adet[]" value="<?php echo $row['adet']; ?>" />
														<input type="hidden" class="katsid" name="katsid[]" value="<?php echo $urunCek['katid']; ?>" />
														<input type="hidden"   name="varyanttutarlar[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantfiyatBirlestir; ?>" />
														<input type="hidden"   name="varyantturler[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantturBirlestir; ?>" />
														<input type="hidden"   name="uvaryant[]" value="<?php echo $varyantAciklamaBirlestir; ?>" />
														<input type="hidden"   name="varyantid[]" value="<?php echo $varyantidBirlestir; ?>" />
														
													</tr>
													
													<?php } ?>
												</tbody>
										</table>
									</div>
									<input type="hidden" name="veri" value="siparis" />
									<input type="hidden" name="userid" value="<?php echo $_SESSION["m_id"]?>" />
									<input type="hidden" name="toplamtutar" value="<?php echo number_format($genelToplam,2); ?>" />
									<div class="sepet-buttons">
										
									</div>
							</div>
							
							<div class="back-btn">
								<a href="/"><i class="fa fa-chevron-left"></i>Alışverişe Devam Et</a>
								
							</div>
						</div>
						
					</div>
					<!--/left-->
					<div class="col-md-4 col-xs-12">
						<div class="sepet-page-right">
							<div class="sip-done">
								<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparisitamamla_link[$set['lang']['active']]; ?>">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></a>
								<button type="submit" class="puan-button">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></button>
							</div>
							<div class="basket-right">
								<ul>
									<?php 
									
									if(isset($_SESSION["m_oturum"])){ 
										$kuponlar = $conn -> query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1 limit 1");
										$kuponlarFetch = $kuponlar->fetchAll();
										if($kuponlar -> rowCount() >0 ) {
											foreach($kuponlarFetch as $row){ 
												$indirimler  = $indirimler + $row['tutar'];
											}
										}
									}
									
									$anaTutar = $genelToplam;
									$anaTutar =  $anaTutar - $indirimler; ?>
									<li><span>Sipariş Tutarı</span> <p>TL</p><span class="tutar tutar-hesap"><?php echo number_format($genelToplam,2); ?> </span></li>
									<li class="kdv-li"><span>Kdv </span> <p>TL</p> <span class="tutar"><?php echo $kdv; ?> </span></li>
									<?php 
									## indirimler
									if(isset($_SESSION["m_oturum"])){
										if($kuponlar -> rowCount() >0 ) {
											foreach($kuponlarFetch as $row){
												echo '<li class="li-kupon'.$row['id'].'"><span>Kupon Tutarı <a href="#" id="'.$row['id'].'" class="kupon-sil">[Sil]</a> </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
											}
										}
									} ?>
									<li class="genel-toplam"><span>Sepet Toplamı</span>  <p>TL</p>  <span class="tutar"><?php echo number_format($anaTutar,2); ?> </span></li>
									<?php ?>
								</ul>
								<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
							</div>
							<?php if(isset($_SESSION["m_oturum"])){ ?>
							<?php if($parapuan['puansistemi'] == 1){ ?>
								<?php if( puanconvert($uyebul['uye_puan']) >=  number_format($anaTutar,2)  ) {?>
								<div class="puan-inner puan-kullan-box">
									<div class="title">Puan</div>
									<div class="text">
										Kazanmış olduğunuz puanları kullanabilirsiniz.
									</div>
									<label>
										<input type="checkbox" name="puan" value="<?php echo $uyebul['uye_puan']; ?>" />
										<span>Puanlarımı Kullan <em> ( <?php echo $uyebul['uye_puan']; ?> Puan )</em> </span>
									</label>
								</div>	
							<?php  }?>
							<?php  } // puan açıksa ?>
							<?php  }  // oturum varsa ?>
							<?php if(isset($_SESSION["m_oturum"])){ ?>
							<?php if($main_settings['kredisistemi'] == 1){ ?>
							<div class="puan-inner kredi-kullan-box">
								<div class="title">Kredi</div>
								<div class="text">
									Kredi bakiyesiyle al
								</div>
								<label>
									<input type="checkbox" name="kredi" value="<?php echo $uyebul['uye_kredi']; ?>" />
									<span>Kredi Kullan <em> ( <?php echo $uyebul['uye_kredi']; ?> Kredi )</em> </span>
								</label>
							</div>	
							<?php  } // kredi açıksa ?>
							<?php  }  // oturum varsa ?>
							
							<?php 
								if(isset($_SESSION["m_oturum"])){ 
									$kuponlar = $conn -> query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1 limit 1");
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlar -> rowCount() >0 ) {
										foreach($kuponlarFetch as $row){ 
											$indirimler  = $indirimler + $row['tutar'];
										}
									}
								} 
							?>
							
							<?php  if(isset($_SESSION["m_oturum"])){ 
							$kuponlar 	   = $conn -> query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1 limit 1");
						
							?>
								<?php if($kuponlar -> rowCount() < 1 ){ ?>
								<div class="hediye-cek-content">
									<div class="title">Kupon Kodu</div>
									<div class="text">
										Bir kupon kodunuz varsa aşağıdaki alana girdikten sonra uygula butonuna basınız
									</div>
									<div class="form">
										<div class="input-group">
										  <input type="text" class="form-control" name="kuponkod"  placeholder="Kupon Kodu..." aria-label="Search for...">
										  <span class="input-group-btn">
											<button class="btn btn-secondary kupon-btn" type="button">Kullan <i class="fa fa-check"></i></button>
										  </span>
										</div>
									</div>
								</div>
								<?php  } ?>
							<?php  } ?>
							
							
							<div class="sip-done">
							
								<?php if(!isset($_SESSION["m_oturum"])){ ?> 
									<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparisitamamla_link[$set['lang']['active']]; ?>">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></a>
									<a href="<?php echo $set['langurl']; ?>/uyeliksiz-siparis">ÜYELİKSİZ DEVAM ET<i class="fa fa-chevron-right"></i></a>
								<?php } else { ?>
									<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparisitamamla_link[$set['lang']['active']]; ?>">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></a>
									<button type="submit" class="puan-button">SİPARİŞİ TAMAMLA<i class="fa fa-chevron-right"></i></button>
								<?php }?>
							</div>
						</div>
						
					</div>
				</div>
				<?php  } else { ?>
					<div class="empty-box">
						<div class="title">Sepetinizde Ürün Bulunmuyor</div>
						<div class="devam-et"><a href="/"><i class="fa fa-chevron-left"></i>Alışverişe Devam Et</a></div>
					</div>
				<?php } ?>
			</div>
			<?php if(isset($_SESSION["m_oturum"])){ include('include/sabit/adrespopup.php'); }?>
			</form>
		</div>
	</div>
	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<?php _footer_last(); ?>
<script type="text/javascript">

	function hesapla(){
		var hesap   = 0.00;
		var indirim = 0.00;
		var aratutar;
		$('.basket-right ul li').each(function(){
			var tutar       = $(this).find('span.tutar-hesap').html();
			var indirimtutar = $(this).find('span.indirim-hesap').html();
				
			if(indirimtutar != undefined && indirimtutar != "" ){
				 indirim =+ indirim + parseFloat(indirimtutar);	
			}
			
			if(tutar != undefined && tutar != "" ){
				hesap =+ hesap + parseFloat(tutar);	
			}
		});
		
		aratutar     =  hesap.toFixed(2) - indirim.toFixed(2);
		if(aratutar < 0.00){
			aratutar = 0.00;
		}
		$('.basket-right ul li.genel-toplam span.tutar').html(aratutar.toFixed(2));
		//$('input[name=toplamtutar]').val(yenihesap.toFixed(2));
	}
	
	function puan(puan,durum){
	var lipuansay = $('li.li-puan').length;
		$.ajax({
			type  : 'POST',
			data  : 'veri=puan&puan='+puan+'&durum='+durum,
			url   : 'ajax/uyelik.php',
			cache : false,
			success : function(result){	
				result = result.split('|x|');
				if(result[0] == 'done'){
					if(result[1] == 1){
						$('.kdv-li').after('<li class="li-puan li-puan'+result[3]+'"><span>Puan Tutarı  (-) </span><p>TL</p><span class="indirim-hesap">'+result[2]+'</span></li>');	
						hesapla();
					}else {
						$('.basket-right:first ul:first li.li-puan'+result[3]+'').remove();
						hesapla();
					}
				}else if (result[0] == 'yonlendir'){
					if(result[1] == 1){
						$('.kdv-li').after('<li class="li-puan li-puan'+result[3]+'"><span>Puan Tutarı  (-) </span><p>TL</p><span class="indirim-hesap">'+result[2]+'</span></li>');	
						hesapla();
						$('form#sepetform').attr('action','<?php echo $set['siteurl']; ?>/ajax/odeme/puanlaodeme.php');
						$('.sip-done').find('a').hide();
						$('.sip-done').find('button').show();
						$('.hediye-cek-content').hide();
						$("#adrespop").modal('show');
					}else {
						$('.basket-right:first ul:first li.li-puan'+result[3]+'').remove();
						hesapla();
						$('form#sepetform').attr('action','');
						$('.sip-done').find('a').show();
						$('.sip-done').find('button').hide();
						$('.hediye-cek-content').show();
						$("#adrespop").modal('hide');
					}
					
				}else{
					swal({
					  type: 'error',
					  title: ''+result[0]+'',
					  confirmButtonColor: '#333',
					});
				}
				
			}, error: function (xhr, desc, err) {
				console.log("Details: " + desc + "\nError:" + err);
			}
		});
	}
	
	function kredi(puan,durum){
		var lipuansay = $('li.li-puan').length;
				$.ajax({
					type  : 'POST',
					data  : 'veri=kredi&kredi='+puan+'&durum='+durum,
					url   : 'ajax/uyelik.php',
					cache : false,
					success : function(result){	
						result = result.split('|x|');
						if(result[0] == 'done'){
							if(result[1] == 1){
								$('.kdv-li').after('<li class="li-kredi li-kredi'+result[3]+'"><span>Kredi Tutarı  (-) </span><p>TL</p><span class="indirim-hesap">'+result[2]+'</span></li>');	
								hesapla();
							}else {
								$('.basket-right:first ul:first li.li-kredi'+result[3]+'').remove();
								hesapla();
							}
						}else if (result[0] == 'yonlendir'){
							if(result[1] == 1){
								$('.kdv-li').after('<li class="li-kredi li-kredi'+result[3]+'"><span>Kredi Tutarı  (-) </span><p>TL</p><span class="indirim-hesap">'+result[2]+'</span></li>');	
								hesapla();
								$('form#sepetform').attr('action','<?php echo $set['siteurl']; ?>/ajax/odeme/krediyleodeme.php');
								$('.sip-done').find('a').hide();
								$('.sip-done').find('button').show();
								$('.hediye-cek-content').hide();
								$("#adrespop").modal('show');
							}else {
								$('.basket-right:first ul:first li.li-kredi'+result[3]+'').remove();
								hesapla();
								$('form#sepetform').attr('action','');
								$('.sip-done').find('a').show();
								$('.sip-done').find('button').hide();
								$('.hediye-cek-content').show();
								$("#adrespop").modal('hide');
							}
						}else{
							swal({
							  type: 'error',
							  title: ''+result[0]+'',
							  confirmButtonColor: '#333',
							});
						}
						
					}, error: function (xhr, desc, err) {
						console.log("Details: " + desc + "\nError:" + err);
					}
				});
	}
	
	$(document).on("click", "a.kupon-sil", function(ev) {
		var id = $(this).attr('id');
		$.ajax({
				type:'POST', 						
				data:'veri=kuponsil&id='+id,											
				url:'ajax/uyelik.php', 					
					success:function(gelen){ 		 	
						if(gelen == "done"){
							$('.li-kupon'+id).remove();
							hesapla();
						}
				}
			});
		return false;
	});
	
	$(function(){
		
		 $('.adres-disable input').change(function(){
			  if (this.checked) {
				$('.fatura-adresi').attr('disabled', true);
			  } else {
				$('.fatura-adresi').attr('disabled', false);
			  }   
		  });
		
		$('input[name=kredi]').change(function(){
			var p_active;
			var p_deger   = $(this).val();
			if(!$(this).hasClass('puan-active')){
				$(this).addClass('puan-active');
				p_active = 1;
				kredi(p_deger,p_active);
				$('.puan-kullan-box').hide();
			}else{
				p_active = 0;
				kredi(p_deger,p_active);
				$(this).removeClass('puan-active');
				$('.puan-kullan-box').show();
			}
		});
		
		
		$('input[name=puan]').change(function(){
			var p_active;
			var p_deger   = $(this).val();
			if(!$(this).hasClass('puan-active')){
				$(this).addClass('puan-active');
				p_active = 1;
				puan(p_deger,p_active);
				$('.kredi-kullan-box').hide();
			}else{
				p_active = 0;
				puan(p_deger,p_active);
				$(this).removeClass('puan-active');
				$('.kredi-kullan-box').show();
			}
		});
		
		
		var yenidizi = new Array();
		var diziurun = new Array();
		var i = 0;
		var x = 0;
		
		$('.kupon-btn').click(function(){
			
			$('.katsid').each(function(){
				yenidizi[i] = $(this).val(); i++;
			});
			$('.urunids').each(function(){
				diziurun[x] = $(this).val(); x++;
			});
			
			var secilikat     =  yenidizi.join();
			var seciliurunler =  diziurun.join();
			var sepettoplam   = $('li.genel-toplam span.tutar').html();
			var kod           = $('input[name=kuponkod]').val();
			var data          = 'veri=kupon&kuponkod='+kod+'&kats='+secilikat+'&urunids='+seciliurunler+'&sepettoplam='+sepettoplam;
			$.ajax({
				type:'POST', 						
				data:data,											
				url:'ajax/uyelik.php', 					
				success:function(gelen){ 		 	
				parcala = gelen.split('|x|');
					if(parcala[0] == "done"){
						$('.kdv-li').after('<li class="li-kupon'+parcala[3]+'"><span>Kupon Tutarı  <a href="#" id="'+parcala[3]+'" class="kupon-sil">[Sil]</a></span><p>TL</p><span class="indirim-hesap">'+parcala[2]+' </span></li>');
						swal({
						  type: 'success',
						  title: ''+parcala[1]+'',
						  confirmButtonColor: '#333',
						});
						$('input[name=kuponkod]').val('')
						hesapla();
						$('.hediye-cek-content').hide();
						
					}else{
						if(parcala[1] == "refresh" ){
							swal({
							  type: 'error',
							  title: ''+parcala[0]+'',
							  confirmButtonColor: '#333',
							}).then(
						   function () { location.reload(); },
						   function () { return false; });
						}else{
							swal({
							  type: 'error',
							  title: ''+parcala[0]+'',
							  confirmButtonColor: '#333',
							});
						}
					}
				}
			});
		});	
	});
</script>
 </body>
</html>