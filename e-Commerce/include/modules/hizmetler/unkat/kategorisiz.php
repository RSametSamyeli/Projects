<?php  if( !defined("SABIT") ){ exit; } 
$unx_seo 	 = unserialize($sef_hizmetler['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak       = glob("uploads/onkapak/kurumsal/kurumsal.*");
$hizmetler   = $conn -> query("SELECT * FROM hizmet order by sira asc");
seoyaz("".$title."","".$description."","".$keywords."",""); 
$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
?>
<style type="text/css">
	.erkaofisimo-on-resim{
		background-image:url("/<?php echo $kapak[0]; ?>");
	}
</style>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/erkaofisimo.css" />
</head>
<body class="preload" style="background:#fafafa">
<div class="wrap">
<?php include('include/sabit/header.php'); ?>
<div id="content">
		<div class="content-page">
			<div class="container">
				<div class="bread-crumb bg-white border radius6">
					<a href="/">Ana Sayfa</a> <span class="color"><?php echo $lang['genel']['hizmetler']; ?></span>
				</div>
				
				<div class="main-content-page">
					<div class="content-blog-page">
						<div class="blog-grid-post">
							<div class="row">
							<?php 
					$x = 0;
					foreach($hizmetler  as $row) { 
					$name      = unserialize($row['baslik']);
					$sef       = unserialize($row['sef']);	
					$aciklama   = unserialize($row['aciklama']);
					$images    = unserialize($row['resimler']);	
					$x++;
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
							
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="item-latest-news radius6 drop-shadow bg-white">
										<div class="post-thumb">
											<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" class="post-thumb-link">
												<img src="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $anaresim; ?>" alt="">
											</a>
											<a class="quick-view-thumb" href="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $anaresim; ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
										</div>
										<div class="post-info">
											<h3 class="title18"><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $name[$set['lang']['active']]; ?></a></h3>
											<p class="desc"><?php
								$c = html_entity_decode($aciklama[$set['lang']['active']]); 
								echo substr($c,0,160);
								?>.</p>
											<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" class="readmore shop-button">Devamı</a>
										</div>
									</div>
								</div>
							<?php  } ?>	
							</div>
						</div>
					</div>
				</div>
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