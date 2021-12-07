<?php if( !defined("SABIT") ){ exit; } 
$aranan = stripslashes(addslashes(urldecode(trim($_GET["s"]))));
$urunler  = $conn -> query("SELECT * FROM urun WHERE baslik LIKE '%".$aranan."%'");
seoyaz("".ucwords($_GET["s"])."","","","");
$toplam = $urunler -> rowCount();
$kapak = glob("uploads/onkapak/arama/arama.*");
if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
}
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/kategori.css" />
</head>
<body>
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo $lang['yardimci']['ara']; ?> / <?php echo ucwords($aranan); ?></li>
			</ul>
		</div>
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-12 col-xs-12">
					<div class="cihaniriboy-inner-left list-page">
						<div class="cihaniriboy-page-title" style="margin-bottom:20px; padding:0 25px;">
							<h1><?php echo ucwords($aranan); ?> için <?php echo $toplam; ?> sonuç bulundu</h1>
						</div>
						<div class="cihaniriboy-arama-content kat-list list">
							<div class="products">
								<div class="row">
									<?php 
									if($urunler -> rowCount() > 0){	
										$i= -0.1;
										$iPlus = 0.2;
										foreach($urunler as $row){
											$name      = unserialize($row['baslik']);
											$sef       = unserialize($row['sef']);	
											$images    = unserialize($row['resimler']);	
											 if(empty($images)){
												$anaresim = "default.jpg"; 	
											 }else{
												if(empty($row['vitrinresim'])){
													$anaresim = $images[0]; 	
												}else{
													$anaresim = $row['vitrinresim'];
												}
											 }
											  if(isset($_SESSION["m_oturum"])){
												$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
												if($uyebayi['fiyat'] != 0){
													$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
													$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
													$urunfiyat =  number_format($degisim,2);
													$ilkfiyat  = number_format($row['yenifiyat'],2);
												}else{
													$urunfiyat = number_format($row['yenifiyat'],2);
													$ilkfiyat  = number_format($row['fiyat'],2);
												}
											}else{
												$urunfiyat = number_format($row['yenifiyat'],2);
												$ilkfiyat  = number_format($row['fiyat'],2);
											}
										$i += $iPlus;
										?>
										<div class="col-md-3 col-xs-6 col-sm-4 change-grid col-sm-4 wow fadeIn" data-wow-delay="<?php echo $i; ?>s">
											<div class="product-item">
												<div class="product-image">
													<a title="<?php echo $name[$set['lang']['active']]; ?> " href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">
														<?php 
														if($row['indirim'] == 1){
															if($ilkfiyat != 0.00 ){ ?>
															<div class="indirim">
																<span>% <?php echo indirim($urunfiyat,$ilkfiyat); ?> İndirim</span>
															</div>
															<?php } ?>
														<!---/indirim-->
														<?php } ?>
														
														<?php if($row['kargobedava'] == 1){ ?>
														<div class="kargo-bedava">
															Kargo Bedava
														</div>
														<!--/kargo bedava -->
														<?php  } ?>
														<?php if($row['stok'] == 0){ ?>
														<div class="no-stok">
															Tükenmiştir
														</div>
														<?php } ?>
														<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" />
													</a>
												</div>
												<div class="product-detail">
													<div class="product-title">
														<a class="pr-detail" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><span><?php echo $name[$set['lang']['active']]; ?></span></a>
														
														<?php if(isset($_SESSION["m_oturum"])) { ?>
														<a href="#" class="favori favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
														<?php  } ?>
													</div>	
													<div class="product-prices">
														<div class="new-price"><?php echo number_format($urunfiyat,2);?> TL</div>
														<?php if($ilkfiyat != 0.00 ){ ?>
														<div class="old-price"><?php echo number_format($ilkfiyat,2);?> TL</div>
														<?php  } ?>
													</div>
												</div>
											</div>
										</div>	
									<?php	} }  ?>
								</div>
							</div>
						</div>
						<!--/arama-->
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
<script type="text/javascript">
	$(function(){
	$('.cihaniriboy-collapse .panel-heading').on('click', function(e) {
			e.preventDefault();
			var index = $(this).index('.panel-heading');
			$(".panel-heading").not(index).removeClass('cihaniriboy-panel-opened');
			$(".panel-heading").eq(index).addClass('cihaniriboy-panel-opened');
			$('.panel-collapse').not(index).stop().slideUp(500);
			$('.panel-collapse').eq(index).stop().slideToggle(500);
		});	
	})
</script>
 </body>
</html>