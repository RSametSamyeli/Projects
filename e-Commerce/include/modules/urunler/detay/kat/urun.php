<?php  if( !defined("SABIT") ){ exit; } 
$last = explode("-",$get2);
$id	  = end($last);

$bul  = $conn -> query("SELECT * FROM urun WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}
$katbul = $conn -> query("SELECT * FROM kategori WHERE id = '".intval($bul['katid'])."'")->fetch();
include('iyzipay-php-develop/IyzipayBootstrap.php');
$katunx_baslik	 = unserialize($katbul['baslik']);
$katunx_sef 	 = unserialize($katbul['sef']);	
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_resimler 	 = unserialize($bul['resimler']);
$unx_aciklama 	 = unserialize($bul['aciklama']);
$unx_kisayazi    = unserialize($bul['kisayazi']);
$unx_tabextra  	 = unserialize($bul['tabextra']);
$unx_pdf 		 = unserialize($bul['pdfname']);
$urunbaslik 	 = $unx_baslik[$set['lang']['active']];
$yorumCek 		 = $conn -> query("SELECT * FROM yorumlar where tur = 3 && durum = 1 && icerik =  ".intval($bul['id']));
$markaCek  		 = $conn -> query("SELECT * FROM marka where id =  ".intval($bul['marka_id']))->fetch();

##Seo 
$title 			 = $unx_title[$set['lang']['active']];
if(empty($title)) {
	$title = $urunbaslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
$kapak	   = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 



if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
}


## Varyants 
$varyantkats  = $conn -> query("select * from kategori where modul = 'varyant' ORDER by sira ASC");								
											
	$benzerurunler 	  = $conn -> query("SELECT * FROM kategori_set
				INNER JOIN 
				urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['katid'])." LIMIT 5");
$link    = $set['langurl']."/".$detaysef_urunler_link[$set['lang']['active']]."/".$unx_sef[$set['lang']['active']]."-".$bul['id']."";
@$sresim =  $set['siteurl']."/uploads/urun/large/".$unx_resimler[0]."";
seoyaz("".$title."","".$keywords."","".$descripton ."",@$sresim); 
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/jquery.raty.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/urun-detay.css" />
</head>
<body class="product-page">
<div id="page"> 
<?php include('include/sabit/header.php'); ?>
 <!-- Breadcrumbs -->
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a href="/" title="Ana Sayfa">Ana Sayfa</a> <span>/</span> </li>
            <li class="category1599"> <a href="<?php echo $set['langurl']; ?>/<?php echo $sef_urunler_link[$set['lang']['active']]; ?>/<?php echo $katunx_sef[$set['lang']['active']]."-".$katbul['id']; ?>" title=""><?php echo ucfirsttr($katunx_baslik[$set['lang']['active']]); ?></a> <span>/ </span> </li>
            <li class="category1601"> <strong><?php echo $urunbaslik; ?></strong> </li>
				
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
    <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main">
      <div class="container">
        <div class="row">
          <div class="col-main">
            <div class="product-view">
              <div class="product-essential">
                <form action="#" method="post" id="product_addtocart_form">
                  <input name="form_key" value="6UbXroakyQlbfQzK" type="hidden">
                  <div class="product-img-box col-lg-4 col-sm-5 col-xs-12">
                    <div class="product-image">
                         <div class="product-full"> <img id="product-zoom" src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $unx_resimler[0]; ?>" data-zoom-image="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $unx_resimler[0]; ?>" alt="<?php echo $urunbaslik;?>"/> </div>
                      
                      <div class="more-views">
                        <div class="slider-items-products">
                          <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                            <div class="slider-items slider-width-col4 block-content">
							<?php foreach($unx_resimler as $row) { ?>
                              <div class="more-views-items"> <a href="#" data-image="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $row; ?>" data-zoom-image="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $row; ?>"> <img id="product-zoom"  src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $row; ?>" alt="<?php echo $urunbaslik;?>"/> </a></div>
							<?php  } ?>	
                             </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end: more-images --> 
                  </div>
                  <div class="product-shop col-lg-8 col-sm-7 col-xs-12">
				  <div class="product-shop col-lg-8 col-sm-7 col-xs-12" id="yazdir-content">
									<div class="erkaofisimo-urundetay-sag urun-container" id="var-selects">
										
										<div class="erkaofisimo-urun-detay-title"> <h1><?php echo $urunbaslik; ?></h1></div>
										<div class="erkaofisimo-helper-header">
											<?php if(!empty($bul['kod'])){?>
											<div class="erkaofisimo-urun-kod">
												<?php echo $lang['yardimci']['urun_kodu']; ?> <span><?php echo $bul['kod']; ?></span>
											</div>
											<?php } ?>
											<div class="erkaofisimo-urun-rate hidden-xs">
												<div class="zr-view">
													<div class="z1"></div>
													<div class="zr-field"></div>
												</div>
											</div>
										</div>
									    
									    <div class="detay-kat hidden">
											<span><?php echo $katunx_baslik[$set['lang']['active']];  ?></span>
										</div>
										
									
										<div class="erkaofisimo-urun-fiyatlar">
											<?php 
											if(isset($_SESSION["m_oturum"])){
												$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
												if($uyebayi['fiyat'] != 0){
													$degisim   = ($bul['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
													$degisim   =  $bul['yenifiyat'] - $degisim;
													$urunfiyat =  $degisim;
													$ilkfiyat  = $bul['yenifiyat'];
												}else{
													$urunfiyat = $bul['yenifiyat'];
													$ilkfiyat  = $bul['fiyat'];
												}
											}else{
												$urunfiyat = $bul['yenifiyat'];
												$ilkfiyat  = $bul['fiyat'];
											}
											 ?>
											<?php if($bul['fiyatgizle'] != 1){ ?>		 
											<?php if($ilkfiyat != 0.00){ ?>
											<div class="eski-fiyat">
												<p><?php echo number_format($ilkfiyat,2); ?> TL</p> <span>( KDV Dahil) </span>
											</div>
											<?php  } ?>
												
											<div class="yeni-fiyat">
												<p><?php echo $urunfiyat; ?> TL </p> <span>( KDV Dahil) </span>
											</div>
											
												<?php if($ilkfiyat != 0.00){ ?>
											<div class="urun-indirim hidden-xs">
												<span>%<?php echo indirim($urunfiyat,$ilkfiyat);?> İNDİRİM</span>
											</div>
												<?php  } ?>
											<?php  } else{ ?>
												<div class="fiyat-sorunuz text-left"><strong>Fiyat Sorunuz <strong></div>
											<?php } ?>
											<input type="hidden" class="urun-fiyat" value="<?php echo $urunfiyat; ?>" />
										</div>
										 <?php  if($bul['siparistarihdurum'] == 1){ ?>
										 
											<div class="sip-teslim">
												<div class="title">
													Sipariş Teslim Tarihi
												</div>
												<div class="tarih">
													<div class="date-and-time">
														<input type="text" class="form-control datepicker siparistarih" value="<?php echo date('Y'); ?>-<?php echo date('m'); ?>-<?php echo date('d'); ?>" name="sipariszaman" data-format="yyyy MM dd">
														<input type="text" class="form-control timepicker siparissaat" name="siparissaat" data-template="dropdown" data-show-seconds="false" data-default-time="11:25" data-show-meridian="false" data-minute-step="5" data-second-step="5" />
													</div>
												</div>
											</div>
											
											<?php } ?>
											
											
											
										 <?php  if($bul['baslangicbitisdurum'] == 1){ ?>
												
												<div class="baslangicbitis">
												
													<div class="tarihler">
														<div class="title">Baslangıç Tarihi</div>
														<div class="tarih">
															
															<input type="text" class="form-control datepicker bastarih" value="<?php echo date('Y'); ?>-<?php echo date('m'); ?>-<?php echo date('d'); ?>" name="bastarih" data-format="yyyy MM dd">
														</div>
														<div class="title">Bitiş Tarihi</div>
														<div class="tarih">
															<input type="text" class="form-control datepicker bittarih" value="<?php echo date('Y'); ?>-<?php echo date('m'); ?>-<?php echo date('d'); ?>" name="bittarih" data-format="yyyy MM dd">
														</div>
													</div>
												</div>	
												
												
												
										 
										 <?php  } ?>
										 
										<?php if($varyantkats -> rowCount() > 0 ) { ?>
												<div class="varyant-tablosu erkaofisimo-img-list2">
												<?php foreach($varyantkats as $row) {
												$name = unserialize($row['baslik']);
												$varyants = $conn -> query("select * from urunvaryants where urunid = ".intval($bul['id'])." && varyantgrupid  = ".intval($row['id'])." ");
												if($varyants -> rowCount()  > 0) { ?>
													<div class="varyant-box">
														<div class="title">
															<span><?php echo $name[$set['lang']['active']]; ?></span>
														</div>
														<div class="buttons">
															<select name="varyants[]" class="select-varyants" id=""  rel="<?php echo $name[$set['lang']['active']]; ?>">
																	<option value=""><?php echo $name[$set['lang']['active']]; ?> Seçiniz</option>
																	<?php foreach($varyants as $row2) {
																	
																	$varStok  = $row2['varyantstok']; 
																	$varCek   = $conn -> query("select * from varyant where id = ".intval($row2['varyantdeger']))->fetch();
																	$name2    = unserialize($varCek['baslik']); 
																	$varyanttur   = $row2['varyanttur'];
																	$varyanttutar = $row2['varyanttutar'];
																	$varyantdeger  = $row2['varyantdeger'];
																	?>
																 <option <?php echo $row2['varyantstok'] ==  0 ? ' disabled' : null ; ?>  value="<?php echo $name2[$set['lang']['active']]."|x|".$varyanttur."|x|".$varyanttutar."|x|".$varyantdeger; ?>">
																	<?php echo $name2[$set['lang']['active']]; ?>
																	<?php if($varyanttutar != 0.00){
																		echo $varyanttur == 0 ? '(-) ' : ('(+) '); 
																		echo $varyanttutar;
																	}?>
																	<?php echo $row2['varyantstok'] ==  0 ? ' <span style="font-size:10px!important;">Stokda Bulunmuyor</span>' : null ; ?>
																</option>
																<?php  } ?>
															</select>
														</div>
													</div>
													<?php  } ?>
												<?php } ?>
												</div>
											<?php } // endif ?>
											
											
										<?php 
										$secenekler = $conn -> query('select * from urunsecenekler where urunid = '.intval($bul['id']).' ');
										?>
										<?php if($secenekler->rowCount() > 0 ){ ?>
										<div class="extra-modul">
											<?php foreach($secenekler as $row) { ?>
												<div class="modul-baslik">
													<?php echo $row['secenekdeger']; ?> (<?php echo $row['zorunluluk'] == 1 ? 'Zorunlu' : 'Zorunlu Değil';  ?>)
												</div>
												<div class="modul-input">
													<input type="text" data-id="<?php echo $row['id']; ?>" data-baslik="<?php echo $row['secenekdeger']; ?>" class="normalseceneksay modulinput <?php echo $row['zorunluluk'] == 1 ? 'secenekzorunlu' : null;  ?>" name="secenekler" />
												</div>
											<?php } ?>
										</div>	
										<?php  } ?>
										<!---/modul-->	
											
											
										<input type="hidden" name="varyant" class="input-varyant" />
										<div class="erkaofisimo-sepetekle">
											<?php if($bul['stok'] == 0 ) { ?>
											<div class="stok-yok">
												Ürün Stokda Bulunmuyor
											</div>
											<?php }else {?>
											
											<div class="sepet-adet">
												<div class="input-spinner">
													<button type="button" class="btn btn-default arrow" id="minus">-</button>
													<input type="text" name="adet" class="size-1 adet" value="1">
													<button type="button" class="btn btn-default" id="plus">+</button>
												</div>
											</div>
											<div class="stok-asimi">
												
											</div>
											
											<?php if($bul['fiyatgizle'] != 1){ ?> 
												
													<?php if(@$main_settings['fiyatgizle'] == 1 ){ ?>
													
														<?php if(isset($_SESSION["m_oturum"])) { ?>
															<div class="sepet-ekle">
																<a href="#" class="custom-sepete-ekle" id="<?php echo $bul['id']; ?>">SEPETE EKLE</a>
																<a href="#" data-urun-id="<?php echo $bul['id']; ?>" class="favorite" id="favorite">
																				<i class="fa fa-heart" aria-hidden="true"></i> <span>FAVORİLERE EKLE</span>
																			</a>
																<div class="urun-buttons">
																	<ul>
																		<?php if($bul['stok'] != 0 ) { ?>
																		
																		<?php  } else { ?>
																		
																		<?php }?>
																	</ul>
																</div>
															</div>
														
														<?php  } else { ?>
														
															<span>Fiyat Sorunuz</span>
														
														<?php } ?>
														
													<?php  } else { ?>
														
														<div class="sepet-ekle">
															<a href="#" class="custom-sepete-ekle" id="<?php echo $bul['id']; ?>">SEPETE EKLE</a>
															<a href="#" data-urun-id="<?php echo $bul['id']; ?>" class="favorite" id="favorite">
																			<i class="fa fa-heart" aria-hidden="true"></i> <span>FAVORİLERE EKLE</span>
																		</a>
															<div class="urun-buttons">
																<ul>
																	<?php if($bul['stok'] != 0 ) { ?>
																	
																	<?php  } else { ?>
																	
																	<?php }?>
																</ul>
															</div>
														</div>
														
													<?php } ?>
														
												
												
												
												<?php  } ?>
											<?php  } ?>
										</div>
										
										
										
										

									</div>
								</div>
								<div class="product-shop col-lg-4 col-sm-5 hidden-xs">
								<div class="hot-banner"><img src="assets/images/kresim9.jpg"></div>
								<div class="hot-banner"><center><a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&text=Sipari%C5%9F%C2%A0vermek%C2%A0istiyorum<?php echo $urunbaslik; ?>" target="_blank"><img src="assets/images/whatsapp.gif"></a></center></div>
								</div>
                  </div>
				  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="product-collateral">
            <div class="add_info">
              <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Ürün Açıklaması </a> </li>
                <li> <a href="#product_tabs_custom" data-toggle="tab">İade Değişim</a> </li>
                <li> <a href="#product_tabs_custom1" data-toggle="tab">Kargo Bilgileri</a> </li>
              </ul>
              <div id="productTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="product_tabs_description">
                  <div class="std">
                   <?php echo html_entity_decode($unx_aciklama[$set['lang']['active']]); ?>
				   </div>
                </div>
               
                <div class="tab-pane fade" id="product_tabs_custom">
                  <div class="product-tabs-content-inner clearfix">
                   <?php echo html_entity_decode($unx_tabextra[$set['lang']['active']]); ?>
                  </div>
                </div>
								
									
                <div class="tab-pane fade" id="product_tabs_custom1">
                  <div class="product-tabs-content-inner clearfix">
                   <?php echo html_entity_decode($unx_kisayazi[$set['lang']['active']]); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main Container End --> 
  
  <!-- Related Products Slider -->
  <?php if($benzerurunler -> rowCount() > 0){?>
  <div class="container">
  
   <!-- Related Slider -->
  <div class="related-pro">

      <div class="slider-items-products">
        <div class="related-block">
          <div id="related-products-slider" class="product-flexslider hidden-buttons">
            <div class="home-block-inner">
              <div class="block-title">
                <h2>Benzer Ürünler</h2>
              </div>
              <div class="pretext"><img alt="Benzer Ürünler" src="assets/images/kresim10.jpg">
              <div class="offer-text"><?php echo $anabaslik6[$set['lang']['active']]; ?></div>
              </div>
            </div>
            <div class="slider-items slider-width-col4 products-grid block-content">
			
			<?php foreach($benzerurunler as $row) { 
								$name      = unserialize($row['baslik']);
								$sef       = unserialize($row['sef']);	
								$images  	   = unserialize($row['resimler']);	
								 if(empty($images)){
									$anaresim = "default.jpg"; 	
								 }else{
									if(empty($row['vitrinresim'])){
										$anaresim = $images[0]; 	
									}else{
										$anaresim = $row['vitrinresim'];
									}
								 }
								?>
                <div class="item">
                  <div class="item-inner">
                     <div class="item-img">
                  <div class="item-img-info"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="Retis lapen casen" class="product-image"> <img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>" alt="Retis lapen casen"> </a>
                    
                    <div class="box-hover">
                      <ul class="add-to-links">
                        <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
						
														<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
													
						
					  </ul>
                    </div>
                  </div>
                </div>
                    <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <div class="rating-box">
                            <div class="rating" style="width:100%"></div>
                          </div>
                        </div>
                      </div>
								
					 <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
						<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo number_format($row['fiyat'],2);?> TL </del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo number_format($row['yenifiyat'],2);?> TL</span></ins> </span>

						</div>
                      </div>
					  <?php } ?>

								
									
									<div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
								
                      
                    </div>
                  </div>
                </div>
                  </div>
                </div>
				<?php  } ?>

					

              </div>
          </div>
        </div>
      </div>

  </div>
  <!-- End related products Slider --> 
  
 
  
    
  </div>
<?php  } ?>

	<input type="hidden" name="urunid" value="<?php echo $bul['id']; ?>" />
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>	

<div class="modal fade in" id="fiyatpop">
	  <div class="modal-dialog modal-sm">
		  <div class="modal-content">
			  <form action="" method="post" id="fiyatForm">
				  <div class="modal-header">
					<a class="close" data-dismiss="modal">×</a>
					<h3>Fiyat Düşünce Haber Ver</h3>
				  </div>
				  <div class="modal-body  clearfix">
						<div class="fiyathaber">
							<div class="form-group">
								<label>* Güncel Fiyat  (TL)</label>
								<input type="text" class="form-control" disabled value="<?php echo number_format($bul['yenifiyat'],2); ?>"  name="" />
							</div>
							<div class="form-group">
								<label>* Bildirim Fiyatı  (TL)</label>
								<input type="text" class="form-control" name="ffiyat" />
							</div>
							<div class="form-group">
								<label>* Süre (Gün) </label>
								<input type="text" class="form-control" name="fsure" />
							</div>
							 <input type="hidden" name="furunid" value="<?php  echo $bul['id']; ?>">	
						</div>
				  </div>
				  <div class="modal-footer">
						<a class="btn btn-success btn-icon fiyat-form-send">Gönder <i class="fa fa-check"></i></a>
				  </div>
			 </form>
		  </div>
	  </div>
</div>


<?php _footer(); ?>
<script type="text/javascript" src="assets/tema/js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="assets/tema/js/jquery.mobile-menu.min.js"></script> 
<script type="text/javascript" src="assets/tema/js/cloud-zoom.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.elevateZoom-3.0.8.min.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.raty.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrap-timepicker.min.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
		
		$(function(){ 
			
			
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd',
				startDate: '-3d'
			});
			
			
			var basdeger;
			var bitdeger;
			var urunFiyat = $('.urun-fiyat').val();
	
			basdeger = $('.bastarih').val();
			bitdeger = $('.bittarih').val();
			
			function tarihgonder(bastarih,bittarih){
					$.ajax({
						type  : 'POST',
						data  : 'veri=fiyatver&bastarih='+bastarih+'&bittarih='+bittarih+'&urunfiyat='+urunFiyat,
						url   : 'ajax/uyelik.php',
						cache : false,
						success : function(result){	
							$('.yeni-fiyat > p').html(result);
							$('.urun-fiyat').val(result);
						}, error: function (xhr, desc, err) {
							console.log("Details: " + desc + "\nError:" + err);
						}
					});
			}	
			
			$('input.bastarih').datepicker().on('changeDate', function (ev) {
				basdeger = $(this).val();
				tarihgonder(basdeger,bitdeger);
			});

			/*$('input.bastarih').change(function(){ 
				basdeger = $(this).val();
				tarihgonder(basdeger,bitdeger);
			});*/
			
			$('input.bittarih').datepicker().on('changeDate', function (ev) {
				bitdeger = $(this).val();
				tarihgonder(basdeger,bitdeger);
			});
			
			
		});
	function elevalate(){
		var zoomConfig = {
			cursor: 'crosshair',
			gallery:'img_galery',
			galleryActiveClass: 'active'
		}; 
		var image = $('#img_galery > a');
		var zoomImage = $('img#u-zoom');	
		var $winen = $(window).width();
		if($winen < 740){
		$('.zoomContainer').remove();
			zoomImage.removeData('elevateZoom');
		}else{
			zoomImage.elevateZoom(zoomConfig);
		}
	}
	function stok(id,adet){
		$.ajax({
			type  : 'POST',
			data  : 'veri=stok&id='+id+'&adet='+adet,
			url   : 'ajax/uyelik.php',
			cache : false,
			success : function(result){	
			
				if(result == 0){
					$('.sepet-ekle').hide();
					$('.erkaofisimo-sepetekle').prepend('<div class="stok-yok" style="margin-bottom:10px">Stok Limiti Aşıldı.</div>');
		
				} else if(result >= 0) {
					$('.sepet-ekle').show();
					$('.erkaofisimo-sepetekle').find('.stok-yok').remove();
				}
			}, error: function (xhr, desc, err) {
				console.log("Details: " + desc + "\nError:" + err);
			}
		});
		
	}
	function varyantstok(id,adet,varyant){
		$.ajax({
			type  : 'POST',
			data  : 'veri=varyantstok&id='+id+'&adet='+adet+"&varyant="+varyant,
			url   : 'ajax/uyelik.php',
			cache : false,
			success : function(result){	
				var sonuc = result.split('|x|');
				if(sonuc[0] == "false"){
					$('.sepet-ekle').hide();
					$('.stok-asimi').html('<div class="stok-yok" style="margin-bottom:10px">Stok Limiti Aşıldı.</div>');
				}else{
					$('.sepet-ekle').show();
					$('.stok-asimi').html('');
				}
				
			}, error: function (xhr, desc, err) {
				console.log("Details: " + desc + "\nError:" + err);
			}
		});
	}
	
	$(function(){
	elevalate();
		$('.stokhaberver').click(function(){ 
			var id = $(this).attr('data-urun-id');
				$.ajax({
					type  : 'POST',
					data  : 'veri=stokhaber&urunid='+id,
					url   : 'ajax/uyelik.php',
					cache : false,
					success : function(result){	
						if(result != 'done'){
							swal({
							  type: 'error',
							  title: ''+result+'',
							  confirmButtonColor: '#333',
							});
						}else{
							swal({
							  type: 'success',
							  title: 'Ürün Listenize Eklenmiştir.',
							  confirmButtonColor: '#333',
							});
						}
						
					}, error: function (xhr, desc, err) {
						console.log("Details: " + desc + "\nError:" + err);
					}
				});
			return false;
		});
		
		$('.fiyathaberver').click(function(){
			$("#fiyatpop").modal('show');
			return false;
		});
		
		$('.fiyat-form-send').click(function(){
			var form = $('form#fiyatForm').serialize();
				$.ajax({
					type  : 'POST',
					data  : form+'&veri=fiyathaber',
					url   : 'ajax/uyelik.php',
					cache : false,
					success : function(result){	
						if(result != 'done'){
							swal({
							  type: 'error',
							  title: ''+result+'',
							  confirmButtonColor: '#333',
							});
						}else{
							swal({
							  type: 'success',
							  title: 'Ürün Listenize Eklenmiştir.',
							  confirmButtonColor: '#333',
							});
						}
						
					}, error: function (xhr, desc, err) {
						console.log("Details: " + desc + "\nError:" + err);
					}
				});
			return false;
		});
		
		$('.urun-alt-buttons a#yorumyaz').click(function(){
			$('.urun-tabs-ul li').removeClass('active');
			$('.urun-tabs-ul li:last').addClass('active');
			$('.tab-pane').removeClass('active');
			$('.tab-pane:last').addClass('active');
			$('html, body').animate({scrollTop: $('.urun-segments').position().top },500);
			return false;
		});
		
		$('#erkaofisimo-yorum-form').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				adsoyad: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_ad']; ?>'
						}
					}
				},
				email: {
						validators: {
							notEmpty: {
								message: '<?php echo $lang['mesaj']['bos_email']; ?>'
							},
							emailAddress: {
								message: '<?php echo $lang['mesaj']['gecersiz_email']; ?>'
							}
						}
				  },
				yorum: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_yorum']; ?>'
						},
						 stringLength: {
                            min: 10,
                            message: '<?php echo $lang['mesaj']['min_mesaj']; ?>'
                        }
					}
				}
				
			}
		}).on('success.form.bv', function(e) {
				e.preventDefault();
				var data = $("#erkaofisimo-yorum-form").serialize();
				$(".ci-yorum-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
				$.ajax({
					type:'POST',
					url:'ajax/yorum.php',
					data: data,
					cache:false
				}).done(function(e){
					if( e != "done"){
						$(".ci-yorum-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
						$('.erkaofisimo-errors').html('<span>'+e+'</span>');
					}else{
						$('.erkaofisimo-yorum-yap').slideUp();
						$('.erkaofisimo-success-msg-content').show();
					}
				}).fail(function(){
					alert("Hata-2");
				});
			});
			
			
		/*$('.erkaofisimo-urun-tab li:first,.erkaofisimo-urun-tab-content div:first').addClass('active');
		if( $('.varyant-tablosu').length  > 0){		
			$('input.input-varyant').val($('.varyant-tablosu .buttons span').not('.disable').first().attr('rel'));
			$('.varyant-tablosu .buttons span').not('.disable').first().addClass('selected');
			$('.varyant-tablosu .buttons span').click(function(){
				if( !$(this).hasClass('disable') ){
					var id = $(this).attr('rel');
					$('input.input-varyant').val(id);
					$('.varyant-tablosu .buttons span').removeClass('selected');
					$(this).addClass('selected');
				}
			});
		}*/
		
		var id 	= $("input[name=urunid]").val();
			$(".zr-field").html("");
			var star = <?php echo number_format($bul['puan'],2); ?>;
			$('.z1').raty({
				  score: star,
				  click: function(score, evt) {
					$.ajax({
						url: 'ajax/rate.php',
						type:'POST',
						data: { score: score,id: id }
					}).done(function(data){
						$(".zr-field").html(data);
						$('.z1').raty({  
						   score: star,
						  readOnly: true
						});
					});
				}
			});
			
	

	/* Spinner */
	var $input = $(".input-spinner").find('input');
		$(".input-spinner button").on('click', function(ev){
			$def   = $(this).attr("id");
			 min  = 1;
			 max  = <?php echo $bul['stok']; ?>;
			 var durum  = true;
			 val = $input.val();
			 
				 if($def == "plus"){  
					val++;
				 }
				 if ($def == "minus"){
					val--;
				 }
				if( ! val.toString().match(/^[0-9-\.]+$/))
				{
					val = 0;
				}
				$input.val( parseFloat(val)).trigger('keyup');
			
		});
		$input.keyup(function()
		{
			if(min != null && parseFloat($input.val()) < min)
			{
				$input.val(min);
			}
			else
			
			if(max != null && parseFloat($input.val()) > max)
			{
				$input.val(max);
			}
		});
		
	});
	$(window).resize(function() {
		elevalate();
	});
</script>

<script type="text/javascript">
	function PrintContent() {
		var DocumentContainer = document.getElementById('yazdir-content');
		var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
</script>
 </body>
</html>