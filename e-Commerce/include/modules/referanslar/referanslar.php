<?php  if( !defined("SABIT") ){ exit; } 
@include("ajax/yazi/referansyazi.php");
$unx_seo 	 = unserialize($sef_referanslar['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak = glob("uploads/onkapak/kurumsal/kurumsal.*");
seoyaz("".$title."","".$description."","".$keywords."",""); 
$markalar = $conn -> query("SELECT * FROM referans ORDER BY sira ASC");
$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
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
			<h2><?php echo $lang['genel']['referanslar']; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo $lang['genel']['referanslar']; ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-inner-left">
						<div class="cihaniriboy-page-title">
							<h1><?php echo $lang['genel']['referanslar']; ?></h1>
						</div>
						<div class="cihaniriboy-marka-content">
							<div class="marka-giris-yazi">
								<?php if(!empty($girisyazi[$set['lang']['active']])){ ?> 
								<div class="cihaniriboy-marka-text">
									<?php echo html_entity_decode($girisyazi[$set['lang']['active']]); ?>
								</div>
								 <?php } ?> 
							</div>
							<div class="cihaniriboy-marka-list cihaniriboy-img-list">
								<div class="row">
									<?php if($markalar -> rowCount() > 0){	
									$i= -0.1;
									$iPlus = 0.2;
									foreach($markalar as $row){ 
									 $marka_baslik = unserialize($row['baslik']);	
								    	$i += $iPlus; 
									?>
									<div class="col-md-4 col-lg-3 col-sm-6 col-xs-12 clearfix wow fadeIn"  data-wow-delay="<?php echo $i; ?>s">
										<div class="cihaniriboy-marka-item">
											<div class="marka-item-relative">
												<img src="<?php echo $set['siteurl']; ?>/uploads/referans/large/<?php echo $row['resimler']; ?>" alt="<?php echo $marka_baslik[$set['lang']['active']]; ?>">
												<div class="corner"></div>
								
												<div class="urun-navigasyon">
													<a href="<?php echo $set['siteurl']; ?>/uploads/referans/large/<?php echo $row['resimler']; ?>" class="cihaniriboy-u-zoom"><i class="fa fa-search"></i></a>
												</div>
											</div>
										</div>
									</div>
									<?php } }?>
								</div>
							</div>
						</div>
						<!--/marka-->
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
									<?php foreach($sideMenuler as $row){ 
										$name = unserialize($row['baslik']);
										$sef  = unserialize($row['sef']);
										echo '<li '; 
										echo $sef[$set['lang']['active']] == $get1 ? ' class="cihaniriboy-sidebar-acıkmavi"' : null;
										echo '><a href="'.$set['langurl'].'/'.$sef[$set['lang']['active']].'">'.$name[$set['lang']['active']].'</a></li>';
									} ?>
									
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