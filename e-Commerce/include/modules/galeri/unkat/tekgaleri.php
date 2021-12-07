<?php  if( !defined("SABIT") ){ exit; } 
$unx_seo 	 = unserialize($sef_galeri['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
 
$sayfa = intval($get3); 
if(empty($sayfa) || !is_numeric($sayfa)){ $sayfa = 1;}
$kactane 	 = $conn -> query("select * from resim");
$num 		 = $kactane -> rowCount();
$kacar		 = 12;
$sayfasayisi = ceil($num/$kacar);
$nerden      = ($sayfa*$kacar)-$kacar;	
$bul		 = $conn -> query("SELECT * FROM resim ORDER BY sira ASC limit ".$nerden.",".$kacar."");
$kapak 		 = glob("uploads/onkapak/galeri/galeri.*");
$arkakapak   = glob("uploads/arkakapak/galeri/galeri.*");

if($sayfa > 1){
	$seobaslik = $title." - ".ucfirsttr($lang['yardimci']['sayfa'])." ".$sayfa."";
}else{
	$seobaslik = $title ;
}


$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
## Meta 
seoyaz("".$title."","".$description."","".$keywords."","");
?>

<link rel="stylesheet" href="http://eticaret.ergunkaplan.com.tr/assets/css/erkaofisimo.css" />
</head>
<body class="common-home res layout-home4">

<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="main-container container">
		<ul class="breadcrumb">
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo ucfirsttr($lang['genel']['galeri']); ?></li>
				
		</ul>
		</div>
	<div id="erkaofisimo_main" class="erkaofisimo_main">
		<div class="erkaofisimo-inner-page">
			<div class="container">
				<div class="col-md-12 col-xs-12">
					<div class="erkaofisimo-main-page erkaofisimo-img-list">
						<?php if($bul -> rowCount() > 0) { 
							$i= -0.1;
							$iPlus = 0.2;
							foreach($bul as $row){ 
								$sef = unserialize($row['sef']);
								$name  = unserialize($row['baslik']);
								$images    = unserialize($row['resimler']);	
								$i += $iPlus;
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
							<div class="col-lg-3 col-sm-6 col-xs-12 col-md-3 wow fadeIn"  data-wow-delay="<?php echo $i; ?>s">
								<div class="urun-content-outer margin-bottom-30">
									<div class="urun-content">
										<div class="urun-image">
											<img src="<?php echo $set['siteurl']; ?>/uploads/resim/thumb/<?php echo $anaresim; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"/>
											<div class="corner"></div>
											<div class="corner-plus"></div>
											<div class="urun-navigasyon">
												<a href="<?php echo $set['siteurl']; ?>/uploads/resim/large/<?php echo $anaresim; ?>" class="erkaofisimo-u-zoom"><i class="fa fa-search"></i></a>
											</div>
										</div>
										<?php if($def['resimgorunum'] != 'pasif'){?>
										<div class="urun-link">
											<a>
												<span><?php echo $name[$set['lang']['active']]; ?></span>
											</a>
										</div>
										<?php }else{ ?>
										<div class="urun-link">	
											<a href="javascript:void(0)">
												<span><?php echo $name[$set['lang']['active']]; ?></span>
											</a>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php  } ?>
						<!--/item-->
					<?php } ?>
					</div>
					<?php if($sayfasayisi > 1){?> 
					<div class="erkaofisimo-sayfalama">
						<div class="erkaofisimo_sayfalama_orta">
							<?php
								if($sayfa > 1){
								$onceki = $sayfa-1;
								echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$onceki.'"><i class="fa fa-chevron-left"></i></a>';
								}
								for($i=1; $i<=$sayfasayisi; $i++){
									if($i == $sayfa) {
									echo '<span class="erkaofisimo-spanaktif">'.$i.'</span>';
									}else{
									echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$i.'">'.$i.'</a>';
								}
							
							}
							if($sayfa != $sayfasayisi){
								$sonraki = $sayfa+1;
								echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$sonraki.'"><i class="fa fa-chevron-right"></i></a>';
							}
							?>
						</div>
					</div>
					<?php } ?>
				</div>
				<!--/left-->
			</div>
		</div>
	</div>
	</div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
		
<?php _footer(); ?>
<?php _footer_last(); ?>
 </body>
</html>