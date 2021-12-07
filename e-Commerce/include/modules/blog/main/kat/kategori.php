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
	.cihaniriboy-on-resim{
		background-image:url("/<?php echo $kapak[0]; ?>");
	}
</style>
</head>
<body>
<div id="cihaniriboy_main" class="cihaniriboy_main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-on-resim">
			<h2><?php echo $lang['genel']['blog']; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo ucfirsttr($lang['genel']['blog']); ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-inner-left">
						<div class="cihaniriboy-page-title">
							<h1><?php echo $lang['genel']['blog']; ?></h1>
						</div>
						<div class="cihaniriboy-haberler-content cihaniriboy-img-list">
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
								<div class="cihaniriboy-haber-item wow fadeIn" data-wow-delay="<?php echo $i; ?>s">
									<div class="col-sm-12">
										<div class="cihaniriboy-haber-image">
											<img src="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>" alt="<?php echo $baslik[$set['lang']['active']]; ?>" />
											<div class="ci-haber-hover">
												<div class="ci-buttons">
													 <a href="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>" alt="<?php echo $baslik[$set['lang']['active']]; ?>" class="cihaniriboy-u-zoom"><i class="fa fa-search"></i></a>
													 <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><i class="fa fa-link"></i></a>
												</div>
											</div>
										</div>
									</div>
									<!--/habersol-->
									<div class="col-sm-12">
										<div class="cihaniriboy-haber-sag margin-top-25">
											<div class="cihaniriboy-haber-sag-title">
												<h4><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><?php echo $baslik[$set['lang']['active']]; ?></a></h4>
											</div>
											<div class="cihaniriboy-haber-sag-helper">
												<span><i class="fa fa-calendar"></i>
												<?php echo tarih($haber['tarih'],$set['lang']['active']); ?>
												</span>
												<span><i class="fa fa-eye"></i><?php echo $haber['okunma']; ?></span>
											</div>
											<div class="cihaniriboy-haber-sag-giris">
												<?php echo html_entity_decode($giris[$set['lang']['active']]); ?>
											</div>
											<div class="cihaniriboy-haber-link">
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
					<div class="cihaniriboy-sayfalama">
						<div class="cihaniriboy_sayfalama_orta">
							<?php
								if($sayfa > 1){
								$onceki = $sayfa-1;
								echo '<a href="'.$set['langurl'].'/'.$sef_blog_link[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$onceki.'"><i class="fa fa-chevron-left"></i></a>';
								}
								for($i=1; $i<=$sayfasayisi; $i++){
									if($i == $sayfa) {
									echo '<span class="cihaniriboy-spanaktif">'.$i.'</span>';
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
					<div class="cihaniriboy-inner-right">
						<div class="cihaniriboy-inner-sidebar-blue">
							<div class="cihaniriboy-right-kivrim"></div>
							<div class="cihaniriboy-left-kivrim"></div>
							<div class="cihaniriboy-sidebar">
								<ul class="cihaniriboy-sidefirstul">
									<li class="li-open"><a href="javascript:;"><?php echo $lang['genel']['blog']; ?></a>
										<ul class="cihaniriboy-sideul cihaniriboy-sideul-open">
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
						<div class="cihaniriboy-sag-widget">
							<div class="cihaniriboy-sag-widget-text">
								<h4><?php echo $widgetbaslik[$set['lang']['active']]; ?></h4>
								<p><?php echo $widgetaciklama[$set['lang']['active']]; ?></p>
							</div>
						</div>
						<?php } ?>
						<?php if($def["onlinekatalog"] == "aktif") { 
						$online_link = glob("uploads/onlinekatalog/pdf/katalog.*");
						?>
						<div class="cihaniriboy-sag-widget">
							<div class="cihaniriboy-sag-widget-katalog">
								<a href="/<?php echo $online_link[0]; ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i><?php echo $lang['yardimci']['katalog_indir']; ?></a>
							</div>
						</div>
						<?php } ?>
						<?php if($def['widgetresim'] =="aktif") {
							$online_link = glob("uploads/widget/widget.*");
						?>
						<div class="cihaniriboy-sag-widget">
							<div class="cihaniriboy-sag-widget-katalog-image">
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