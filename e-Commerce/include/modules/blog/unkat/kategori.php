<?php  if( !defined("SABIT") ){ exit; } 
$unx_seo 	 = unserialize($sef_blog['seo']);
$sayfa = intval($get3);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak       = glob("uploads/onkapak/haberler/haberler.*");
if(empty($sayfa) || !is_numeric($sayfa)){ $sayfa = 1;}
$kactane = $conn -> query("SELECT * FROM blog");
$num = $kactane-> rowCount();
$kacar = $def['habersayfalama'];
$sayfasayisi = ceil($num/$kacar);
$nerden 	  = ($sayfa*$kacar)-$kacar;	
$haberler     = $conn -> query("SELECT * FROM blog ORDER BY sira ASC LIMIT ".$nerden.", ".$kacar."");
$yanhaberler  = $conn -> query("SELECT * FROM blog ORDER BY sira ASC");
seoyaz("".$title."","".$description."","".$keywords."",""); 
?>
<style type="text/css">
	.erkaofisimo-on-resim{
		background-image:url("/<?php echo $kapak[0]; ?>");
	}
</style>
</head>
<body>
<div id="erkaofisimo_main" class="erkaofisimo_main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="erkaofisimo-outer-page">
		<div class="erkaofisimo-on-resim">
			<h2><?php echo $lang['genel']['blog']; ?></h2>
		</div>
		<div class="erkaofisimo_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo ucfirsttr($lang['genel']['blog']); ?></li>
				</ul>
			</div>
		</div>
		<div class="erkaofisimo-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="erkaofisimo-inner-left">
						<div class="erkaofisimo-page-title">
							<h1><?php echo $lang['genel']['blog']; ?></h1>
						</div>
						<div class="erkaofisimo-haberler-content erkaofisimo-img-list">
							<div class="row">
								<?php 
								$i= -0.1;
								$iPlus = 0.2;
								foreach($haberler as $haber){
								 $resimler   =   unserialize($haber['resimler']);
								 $sef 	     =   unserialize($haber['sef']);
								 $giris 	 =   unserialize($haber['giris']);
								 $baslik 	 =   unserialize($haber['baslik']);
								 $aciklama   =   unserialize($haber['aciklama']);
								 $aciklama   =  html_entity_decode($aciklama[$set['lang']['active']]);	
									$i += $iPlus;
									if(empty($resimler)){
											$anaresim = "default.jpg"; 	
								   }else{
										if(empty($haber['vitrinresim'])){
											$anaresim = $resimler[0]; 	
										}else{
											$anaresim = $haber['vitrinresim'];
										}
								 }
							?>
								<div class="erkaofisimo-haber-item wow fadeIn" data-wow-delay="<?php echo $i; ?>s">
									<div class="col-sm-12">
										<div class="erkaofisimo-haber-image">
											<img src="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>" alt="<?php echo $baslik[$set['lang']['active']]; ?>" />
											<div class="ci-haber-hover">
												<div class="ci-buttons">
													 <a href="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>" alt="<?php echo $baslik[$set['lang']['active']]; ?>" class="erkaofisimo-u-zoom"><i class="fa fa-search"></i></a>
													 <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><i class="fa fa-link"></i></a>
												</div>
											</div>
										</div>
									</div>
									<!--/habersol-->
									<div class="col-sm-12">
										<div class="erkaofisimo-haber-sag margin-top-25">
											<div class="erkaofisimo-haber-sag-title">
												<h4><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><?php echo $baslik[$set['lang']['active']]; ?></a></h4>
											</div>
											<div class="erkaofisimo-haber-sag-helper">
												<span><i class="fa fa-calendar"></i>
												<?php echo tarih($haber['tarih'],$set['lang']['active']); ?>
												</span>
												<span><i class="fa fa-eye"></i><?php echo $haber['okunma']; ?></span>
											</div>
											<div class="erkaofisimo-haber-sag-giris">
												<?php echo html_entity_decode($giris[$set['lang']['active']]); ?>
											</div>
											<div class="erkaofisimo-haber-link">
												<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><i class="fa fa-angle-right"></i> <?php echo $lang['yardimci']['devami']; ?> </a>
											</div> 
										</div>
									</div>
									<!--/habersag-->
								</div>
								
								<?php 
								} ?>
							</div>
						</div>
						<!--/haberler-->
						<?php if($sayfasayisi > 1){?> 
					<div class="erkaofisimo-sayfalama">
						<div class="erkaofisimo_sayfalama_orta">
							<?php
								if($sayfa > 1){
								$onceki = $sayfa-1;
								echo '<a href="'.$set['langurl'].'/'.$sef_blog_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$onceki.'"><i class="fa fa-chevron-left"></i></a>';
								}
								for($i=1; $i<=$sayfasayisi; $i++){
									if($i == $sayfa) {
									echo '<span class="erkaofisimo-spanaktif">'.$i.'</span>';
									}else{
									echo '<a href="'.$set['langurl'].'/'.$sef_blog_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$i.'">'.$i.'</a>';
								}
							
							}
							if($sayfa != $sayfasayisi){
								$sonraki = $sayfa+1;
								echo '<a href="'.$set['langurl'].'/'.$sef_blog_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$sonraki.'"><i class="fa fa-chevron-right"></i></a>';
							}
							?>
						</div>
					</div>
					<?php } ?>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12">
					<div class="erkaofisimo-inner-right">
						<div class="erkaofisimo-inner-sidebar-blue">
							<div class="erkaofisimo-right-kivrim"></div>
							<div class="erkaofisimo-left-kivrim"></div>
							<div class="erkaofisimo-sidebar">
								<ul class="erkaofisimo-sidefirstul">
									<li class="li-open"><a href="javascript:;"><?php echo $lang['genel']['blog']; ?></a>
										<ul class="erkaofisimo-sideul erkaofisimo-sideul-open">
											<?php foreach($yanhaberler as $row){ 
											$name = unserialize($row['baslik']);
											$sef  = unserialize($row['sef']);									
											?>	
											<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row[0]?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
											<?php } ?>
										</ul>
									</li>
									
								</ul>
							</div>
						</div>
						<!--/sidebar-->
						<?php if($def['widgettext'] =="aktif") { 
							include('ajax/yazi/widget.php');
							?>
						<div class="erkaofisimo-sag-widget">
							<div class="erkaofisimo-sag-widget-text">
								<h4><?php echo $widgetbaslik[$set['lang']['active']]; ?></h4>
								<p><?php echo $widgetaciklama[$set['lang']['active']]; ?></p>
							</div>
						</div>
						<?php } ?>
						<?php if($def["onlinekatalog"] == "aktif") { 
						$online_link = glob("uploads/onlinekatalog/pdf/katalog.*");
						?>
						<div class="erkaofisimo-sag-widget">
							<div class="erkaofisimo-sag-widget-katalog">
								<a href="/<?php echo $online_link[0]; ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i><?php echo $lang['yardimci']['katalog_indir']; ?></a>
							</div>
						</div>
						<?php } ?>
						<?php if($def['widgetresim'] =="aktif") {
							$online_link = glob("uploads/widget/widget.*");
						?>
						<div class="erkaofisimo-sag-widget">
							<div class="erkaofisimo-sag-widget-katalog-image">
								<img src="<?php echo $set['siteurl']; ?>/<?php echo $online_link[0]; ?>" alt="widget" />
							</div>
						</div>
						<?php } ?>
						<!--/widgets-->
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
 </body>
</html>