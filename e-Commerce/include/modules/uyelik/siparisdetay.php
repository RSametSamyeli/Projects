<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}

$id = $get2;
$bul = $conn -> query("select * from siparis where id = ".intval($id))->fetch();
if(!$bul) exit;

$sipdurum   	  = $conn -> query("select * from siptanimla where id = ".$bul['durum']."")->fetch();
$sipdurumbaslik   = unserialize($sipdurum['baslik']);
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_siparislerim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kapak = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 

$urunidler  = unserialize($bul['urunid']);
$adetler    = unserialize($bul['adet']);
$basliklar  = unserialize($bul['baslik']);
$uvaryant   = unserialize($bul['uvaryant']);
$secenekler = unserialize($bul['secenekler']);
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo ucfirsttr($lang['yardimci']["siparislerim"]); ?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
	<!--/header-->
	<div class="cihaniriboy-outer-page">
			<div class="cihaniriboy-inner-page">
				<div class="container">
					<div class="col-md-9 col-xs-12">
						<div class="inner-page">
							<div class="profilim">
								<div class="title hidden-print">
									<h2 class="hidden-print"><?php echo ucfirsttr($lang['yardimci']["siparislerim"]); ?></h2>
								</div>
								<div class="siparislerim">
									<div class="siparis-detay">
										
											<div class="siparis-ust">
												<div class="d-title">
													<div class="d-left">
														<h3 style="font-size:22px;"><?php echo strtouppertr($lang['yardimci']['siparisno']); ?>. #<?php echo $bul['oid']?></h3>
														<span><?php echo date("d-m-Y H:i",$bul['tarih']); ?></span>
													</div>
													<div class="d-right">
														<?php  if(!empty($bul['kargono'])) { ?>
														<div class="d-kargo">
															Kargo Takip No : <span> <?php echo $bul['kargono']; ?></span>
														</div>
														<?php } ?>
														<div class="d-siparis-durum">
															Sipariş Durumu : <span><?php echo $sipdurumbaslik[$set['lang']['active']]; ?></span>
														</div>
													</div>
												</div>
												
											</div>
											
											<div class="siparis-orta">
												<div class="row">
													<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
														<div class="siparis-box">
															<h4 style="margin-bottom:3px;">SİPARİŞİ VEREN</h4>
															<div class="ince-list" style="padding-left:3px;">
																<?php echo $uyebul['ad']." ".$uyebul['soyad']; ?>
																<br />
																<?php echo $uyebul['telefon']; ?>
																<br />
																<?php echo date("d-m-Y : H: i", $bul['tarih']); ?>
																<br />
																<?php echo $uyebul['email']; ?>
																<br />
																<?php echo $bul['ip']; ?>
																
															</div>
														</div>
														
													</div>
													<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
														<div class="siparis-box">
															<h4 style="margin-bottom:3px;">ÖDEME ŞEKLİ</h4>
														
															<?php echo $bul['odemeturu']; ?>
															<h4 style="margin-bottom:3px; margin-top:15px;">KARGO SEÇENEK</h4>
														
																<?php 
																$kargo = $conn -> query("select * from kargo where id = ".intval($bul['kargo']))->fetch();
																echo $kargo['firmaadi']; ?>
															<br />
															<?php if(!empty($bul['siparisnot'])) {?>
															<h4 style="margin-bottom:3px; margin-top:15px;">MÜŞTERİ NOTU</h4>
															<?php echo $bul['siparisnot']; ?>
															<br/>
															<?php } ?>
														</div>
													</div>
													<?php if($bul['odemeturu'] == "Havale / Eft") { ?>
													<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
														<div class="siparis-box">
															<h4 style="margin-bottom:3px;">HAVALE / EFT </h4>
															<?php 
															$bankabilgi  = $conn -> query("select * from banka where id = ".intval($bul['havaletipi']))->fetch();
															?>
																<?php echo $bankabilgi['hesap_adi']; ?> <br/>	
																<?php echo $bankabilgi['banka_adi']." ".$bankabilgi['sube_adi'];  ?>
																Şube Kodu : <?php echo $bankabilgi['sube_kodu']; ?>  
																Hesap No : <?php echo $bankabilgi['hesap_no']; ?>  
																IBAN : <?php echo $bankabilgi['iban']; ?>  
															<br />
														</div>
													</div>
													<?php  }elseif($bul['odemeturu'] == "Puanla Ödeme") { ?>
														<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
															<div class="siparis-box">
																<h4 style="margin-bottom:6px;">Puanla Ödeme</h4>
																	Harcanan Puan Tutarı : <?php echo number_format($bul['puantutar'],2); ?>
																<br />
																<?php  if(!empty($bul['adminnot'])) { ?>
																	<h4 style="margin-bottom:2px; width:100%; float:left;  margin-top:12px;">Yönetici Notu</h4>
																	
																<?php echo $bul['adminnot']; ?>
															<?php }?>
															</div>
															
														</div>
														<?php }elseif($bul['odemeturu'] == "Krediyle Ödeme") { ?>
															<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
																<div class="siparis-box">
																	<h4 style="margin-bottom:6px;">Krediyle Ödeme</h4>
																		Kredi Tutarı : <?php echo number_format($bul['kreditutar'],2); ?>
																	<br />
																	<?php  if(!empty($bul['adminnot'])) { ?>
																		<h4 style="margin-bottom:2px; width:100%; float:left;  margin-top:12px;">Yönetici Notu</h4>
																		
																	<?php echo $bul['adminnot']; ?>
																<?php }?>
																</div>
																
															</div>
														<?php } else { ?> 
														<div class="col-sm-4 col-lg-4 col-md-4 invoice-left">
															<div class="siparis-box">
																<h4 style="margin-bottom:3px;">KAPIDA ÖDEME </h4>
																	<?php echo $bul['kapidaodemeturu']; ?>
																<br />
															</div>
														</div>
													<?php } ?>
													<div class="col-sm-6 col-lg-6 col-md-6 invoice-left">
														<div class="siparis-box">
															<h4 style="margin-bottom:3px;">TESLİMAT ADRESİ</h4>
																<?php 
																$teslimatadresi = $conn -> query("select * from useraddress where id = ".intval($bul['teslimatadresi']))->fetch();
																
																$tSehir 		= $conn -> query("select * from il where ID = ".intval($teslimatadresi['sehir']))->fetch();;
																$tilce			= $conn -> query("select * from ilce where ID = ".intval($teslimatadresi['ilce']))->fetch();												
																?>
																<?php echo $teslimatadresi['name']; ?>
																- <?php echo $teslimatadresi['adres']; ?> 
																- <?php echo $tSehir['ADI']; ?> 
																- <?php echo $tilce['ADI']; ?>
																- <?php echo $teslimatadresi['ulke']; ?>
																- <?php echo $teslimatadresi['postakodu']; ?>
																<br/> <?php echo $teslimatadresi['adsoyad']; ?>
																- <?php echo $teslimatadresi['telefon']; ?>
																<br />
																<br />
														</div>
													</div>
													<div class="col-sm-6 col-lg-6 col-md-6 invoice-left">
														<div class="siparis-box">
															<h4 style="margin-bottom:3px;">FATURA  ADRESİ</h4>
															<?php 
															
															$faturaadresi   = $conn -> query("select * from useraddress where id = ".intval($bul['faturaadresi']))->fetch();
															$tSehir 		= $conn -> query("select * from il where ID = ".intval($faturaadresi['sehir']))->fetch();;
															$tilce			= $conn -> query("select * from ilce where ID = ".intval($faturaadresi['ilce']))->fetch();												
															?>
															<?php echo  $faturaadresi['name']; ?>
															- <?php echo $faturaadresi['adres']; ?> 
															- <?php echo $tSehir['ADI']; ?> 
															- <?php echo $tilce['ADI']; ?>
															- <?php echo $faturaadresi['ulke']; ?>
															- <?php echo $faturaadresi['postakodu']; ?>
															<br/> <?php echo $faturaadresi['adsoyad']; ?>
															- <?php echo $faturaadresi['telefon']; ?>
															<br />
														</div>
													</div>
												</div>
												
											</div>

											<div class="detay-table">
												<div class="table-responsive"> 
													<table class="table table-bordered">
														<thead>
															<tr>
																<th class="text-center">#ID</th>
																<th><?php echo $lang['yardimci']['urun_ismi']; ?></th>
																<th class="text-center"><?php echo $lang['yardimci']['adet']; ?></th>
																<th class="text-center"><?php echo $lang['yardimci']['birim_fiyat']; ?></th>
																<th class="text-center">TOPLAM TUTAR</th>
															</tr>
														</thead>
														
														<tbody>
															<?php
															$genelToplam = 0;
															$indirimler  = 0;
															$varyantsid      = unserialize($bul['varyantid']);
															$varyantturler   = unserialize($bul['varyantturler']);
															$varyanttutarlar = unserialize($bul['varyanttutarlar']);
															$teslimattarih   = unserialize($bul['teslimattarih']);
															$teslimatsaat    = unserialize($bul['teslimatsaat']);
															$bitistarihi    = unserialize($bul['bitistarihi']);
															$bastarih    = unserialize($bul['bastarih']);
															$bittarih    = unserialize($bul['bittarih']);
															$varAra  = 0 ;
															$defvarPlus   = 0;
															$defvarMinus  = 0;
															
															for($i = 0 ; $i < count($urunidler); $i++){ 
															$uruncek = $conn -> query("SELECT * FROM urun where id = ".intval($urunidler[$i]))->fetch();
															
															/* varyant hesapla */
															if(!empty($varyanttutarlar[$urunidler[$i]][0])){
													
																for($c = 0; $c < count($varyanttutarlar[$urunidler[$i]][0]); $c++) { 
																	$varyanttutarlar2 = explode(",",$varyanttutarlar[$urunidler[$i]][$c]);
																	$varyantturler2   = explode(",",$varyantturler[$urunidler[$i]][$c]);
																	
																	for($x = 0; $x < count($varyanttutarlar2); $x++){
																		$varTutar = $varyanttutarlar2[$x];
																		
																		$varTur   = $varyantturler2[$x];	
																	
																		if(!empty($varTur)){
																			if($varTur == 1){
																				$defvarPlus  += $varTutar;
																				$varAra      = $uruncek['yenifiyat'] + $defvarPlus;
															
																			}
																			if($varTur == 0){
																				$defvarMinus  += $varTutar;
																				$varAra  = $uruncek['yenifiyat'] - $defvarMinus;
																		
																			}
																		}
																	}
																
																}
																$birimfiyat = number_format($varAra,2);
															}else{
																$birimfiyat = $uruncek['yenifiyat'];
															}
														
															$kuponlar = $conn->query("select * from kupongecmisi where siparisid = ".intval($bul['oid'])." && userid = ".intval($uyebul['id'])." ");
															$kuponlarFetch = $kuponlar->fetchAll();
															$genelToplam += $adetler[$i] * $birimfiyat;
															$aratutar   =  $adetler[$i] * $birimfiyat;
															$urunimg    = unserialize($uruncek['resimler']);
															$sef        = unserialize($uruncek['sef']);
															?>
															<tr>
																<td class="text-center"><?php echo $urunidler[$i]; ?></td>
																<td><a href="<?php echo $set['langurl'];  ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']];  ?>/<?php echo  $sef[$set['lang']['active']]."-".$uruncek['id']; ?>">
																	<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $urunimg[0]; ?>" alt="" />
																	<span><?php echo $basliklar[$i]; ?> 
																	<?php echo $uvaryant[$i]."<br/>"; ?>
																	
																<?php if(count($secenekler) > 0){
																		 foreach($secenekler as $row => $val){
																			if($row == $urunidler[$i]) {
																				 foreach($val as $key => $val2){
																					 $sbul = $conn -> query('select * from urunsecenekler where urunid  = '.intval($urunidler[$i]).'  ')->fetch();
																					  echo '<span style="font-weight:bold;">'.$sbul['secenekdeger'].'</span><br/>';
																					 echo $val2.'<br/>';
																				 }
																			}
																		 }
																	 } ?>
																	
																	
														 
																	</span>
																		<?php  
																		if($uruncek['siparistarihdurum'] == 1){ 
																			if(count($teslimattarih) > 0){ 
																			echo '<br/><strong>Sipariş Teslim Tarihi</strong><br/>';
																			echo $teslimattarih[$i].' -'.$teslimatsaat[$i];
																			/*for($i = 0; count($teslimattarih) > 0; $i++ ){ 
																				echo 'Sipariş Tarihi';
																				echo $teslimattarih[$i];
																			}*/
																			 
																		} }
																		 ?>
																		 
																		 <?php  
																		 #### Sipariş başlangıç bitiş tarihi
																		if($uruncek['baslangicbitisdurum'] == 1){
																			echo '<div style="display:block; width:100%; float:left; ">';
																			echo '<br/><strong>Başlangıç Tarihi</strong><br/>';
																			echo $bastarih[$i];
																			echo '<br/><strong>Bitiş Tarihi</strong><br/>';
																			echo $bittarih[$i];
																			echo '</div>';
																		}
																		?>
																		
																		<?php  
																		
																		if(count($bitistarihi) > 0){ 
																			if($bitistarihi[$i] != 0){
																			echo '<br/><strong>Sipariş Bitiş Tarihi</strong><br/>';
																			$suan = date( "Y-m-d", $bul['tarih']);
																			$yenitarih = strtotime(' '.$bitistarihi[$i].' day',strtotime($suan));
																			$yenitarih = date('Y-m-d H-i' ,$yenitarih );
																			echo $yenitarih;
																			}
																		} ?>
														
														
																</a>
																
																</td>
																<td class="text-center"><?php echo $adetler[$i]; ?></td>
																<td class="text-center "><?php echo number_format($uruncek['yenifiyat'],2); ?> <?php echo $lang['yardimci']['tl']; ?> </td>
																<?php
																if($bul['kreditutar'] >=  number_format($bul['toplamtutar'],2) ) {
																	$toplamTutar = $bul['toplamtutar'] + $bul['kargotutar'];
																}else {
																	$toplamTutar = $bul['toplamtutar'];
																} ?>
																<td class="text-center "><?php echo number_format($toplamTutar,2); ?> <?php echo $lang['yardimci']['tl']; ?></td>
															</tr>
															<?php } ?>
														</tbody>
														
													</table>
												</div>
											</div>	
											<?php if(!empty($bul['adminnot'])){?>
											<div class="yonetici-notu">
												<strong>Yönetici Notu :</strong>
												<?php echo $bul['adminnot']; ?>
											</div>
											<?php } ?>
											<div class="detay-footer">
												
														<div class="invoice-right">
															<ul class="list-unstyled">
																<li>
																	Ara Tutar
																	<strong><?php echo number_format($bul['kdvsiztutar'],2); ?> TL</strong>
																</li>
																<li>
																	Kdv:
																	<strong><?php echo number_format($bul['kdv'],2); ?> TL</strong>
																</li>
																<li>
																	Kargo Tutar;
																	<strong><?php echo number_format($bul['kargotutar'],2); ?> TL</strong>
																</li>
																<?php if($bul['odemeturu'] == "Kapıda Ödeme"){ ?>
																<li>
																	Kapıda Ödeme Tutarı;
																	<strong><?php echo number_format($bul['kapidaodemefiyat'],2); ?> TL</strong>
																</li>
																<?php  } ?>
																<?php if($bul['puantutar'] != 0.00 ) { ?>
																<li>
																	Puan Tutarı : 
																	<strong>- <?php echo number_format($bul['puantutar'],2); ?> TL</strong>
																</li>
																<?php  } ?>
																<?php if($bul['kreditutar'] != 0.00 ) { ?>
																<li>
																	Kredi Tutarı : 
																	<strong>- <?php echo number_format($bul['kreditutar'],2); ?> TL</strong>
																</li>
																<?php  } ?>
																<?php if($kuponlar -> rowCount() >0 ) {  
																	foreach($kuponlarFetch as $row){ ?>
																		<li>
																			Kupon Tutarı;
																			<strong><?php echo number_format($row['tutar'],2); ?> TL</strong>
																		</li>
																	<?php } ?>
																	<?php  } ?>
																<?php
																if($bul['kreditutar'] >=  number_format($bul['toplamtutar'],2) ) {
																	$toplamTutar = $bul['toplamtutar'] + $bul['kargotutar'];
																}else {
																	$toplamTutar = $bul['toplamtutar'];
																} ?>
																<li>
																	Toplam Tutar:
																	<strong><?php echo number_format($toplamTutar,2); ?> TL</strong>
																</li>
																
															</ul>
															<br />
															<br />
															<div class="col-sm-12 col-xs-12 hidden-print">
																<div class="iade-durum">
																	<?php if($bul['iade'] == 0){?>
																	<a href="#" class="btn btn-red btn-icon btn-sm icon-left siparis-iade hidden-print">
																		<i class="fa fa-times" aria-hidden="true"></i>
																		İade
																	</a>
																	<?php } elseif($bul['iade'] == 1) { ?>
																		<div class="iade-sonuc">
																			<div class="box"><span>İade Durumu : <strong>Onay Bekliyor</strong> </span></div>
																			<div class="box"><span>İade Nedeni : <?php echo $bul['iadesebep']; ?></span></div>
																		</div>
																		
																	<?php } elseif($bul['iade'] == 2){ ?>
																		<div class="iade-sonuc">
																			<div class="box"><span>İade Durumu : <strong>Onaylandı</strong> </span></div>
																			<div class="box"><span>İade Nedeni : <?php echo $bul['iadesebep']; ?></span></div>
																		</div>
																	<?php } ?>
																</div>
																<a href="javascript:window.print();" class="btn btn-primary btn-icon btn-sm icon-left siparis-yazdir hidden-print">
																	<?php echo $lang['yardimci']['yazdir']; ?>
																	<i class="fa fa-print" aria-hidden="true"></i>
																</a>
																<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>" class="btn btn-primary btn-icon btn-sm icon-left hidden-print siparis-list">
																	<?php echo $lang['yardimci']['siparislerim']; ?>
																	<i class="fa fa-list" aria-hidden="true"></i>
																</a>
															</div>
														</div>
														
													
											</div>
									</div>
										
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
<div class="modal fade" id="iadepop">
	  <div class="modal-dialog modal-md">
		  <div class="modal-content">
			  <div class="modal-header">
				<a class="close" data-dismiss="modal">×</a>
				<h3>Sipariş İade</h3>
			  </div>
			  <div class="modal-body clearfix">
					<div class="siparis-iade">
						<form action="" method="post" id="iadeform">
							<div class="form-group">
								<label class="col-sm-12">Neden İade Etmek İstiyorsunuz ? </label>
								<div class="col-sm-12">
									<textarea name="sebep" class="form-control" id="" cols="0" rows="0"></textarea>
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $bul['id']; ?>" />
						</form>
					</div>
			  </div>
			  <div class="modal-footer">
					<a class="btn btn-success iade-et" href="#">İade Et</a>
					<a class="btn btn-primary" data-dismiss="modal">İptal Et</a>
			  </div>
		  </div>
	  </div>
</div>
<script type="text/javascript">
	$(function(){
		$('.siparis-iade').click(function(){
			$("#iadepop").modal('show');
				$('.iade-et').click(function(){
						var form = $('form#iadeform').serialize();
						$.ajax({
							type  : 'POST',
							data  : form+'&veri=iade',
							url   : 'ajax/uyelik.php',
							cache : false,
							success : function(result){	
								if(result == 'done'){
									swal({
									  type: 'success',
									  title: 'Sipariş İade Edilmek Üzere Onaya Gönderildi',
									  confirmButtonColor: '#333',
									}).then(
								   function () { location.reload(); },
								   function () { return false; });
								}else{
									swal({
									  type: 'error',
									  title: ''+result+'',
									  confirmButtonColor: '#333',
									});
								}
							}, error: function (xhr, desc, err) {
								console.log("Details: " + desc + "\nError:" + err);
							}
						});
					return false;
				});
			return false;
		});
	});
</script>
 </body>
</html>