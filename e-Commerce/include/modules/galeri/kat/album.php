<?php  if( !defined("SABIT") ){ exit; } 
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM album WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}
 
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']); 
 $baslik 		 = $unx_baslik[$set['lang']['active']];
$sayfa = intval($get4);
if(empty($sayfa) || !is_numeric($sayfa)){ $sayfa = 1;}
$kactane = $conn -> query("SELECT * FROM resim WHERE ustkat = '".intval($bul['id'])."'");
$num = $kactane-> rowCount();
$kacar = 12;
$sayfasayisi = ceil($num/$kacar);
$nerden = ($sayfa*$kacar)-$kacar;	
$resimler = $conn -> query("SELECT * FROM resim WHERE ustkat = '".intval($bul['id'])."' ORDER BY sira ASC LIMIT ".$nerden.",".$kacar."");

$kapak 		 = glob("uploads/onkapak/galeri/galeri.*");
$arkakapak   = glob("uploads/arkakapak/galeri/galeri.*");

$title 			 = $unx_title[$set['lang']['active']];
if(empty($title)) {
	$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];

if($sayfa > 1){
	$seobaslik = $title." - ".ucfirsttr($lang['yardimci']['sayfa'])." ".$sayfa."";
}else{
	$seobaslik = $title ;
}

## Meta 
seoyaz("".$title."","".$descripton."","".$keywords."","");
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
			<h2><?php echo $lang['genel']['galeri']; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_galeri_link[$set['lang']['active']]; ?>"><?php echo ucfirsttr($lang['genel']['galeri']); ?></a></li>
					<li><?php echo ucfirsttr($baslik); ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 no-padding col-xs-12">
					<div class="cihaniriboy-main-page cihaniriboy-img-list">
						<?php if($resimler -> rowCount() > 0) { 
							$i= -0.1;
							$iPlus = 0.2;
							foreach($resimler as $row){ 
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
							<div class="col-lg-4 col-sm-6 col-xs-12 col-md-3 wow fadeIn" data-wow-delay="<?php echo $i; ?>s">
								<div class="urun-content-outer margin-bottom-30">
									<div class="urun-content">
										<div class="urun-image">
											<img src="<?php echo $set['siteurl']; ?>/uploads/resim/thumb/<?php echo $anaresim; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"/>
											<div class="corner"></div>
											<div class="corner-plus"></div>
											<div class="urun-navigasyon">
												<a href="<?php echo $set['siteurl']; ?>/uploads/resim/large/<?php echo $anaresim; ?>" class="cihaniriboy-u-zoom"><i class="fa fa-search"></i></a>
												<?php if($def['resimgorunum'] != 'pasif') {?>
												<a href="<?php echo $set["langurl"]; ?>/<?php echo $sef_galeri_link[$set['lang']['active']]; ?>/<?php echo $unx_sef[$set['lang']['active']]."-".$bul['id'] ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><i class="fa fa-link"></i></a>
												<?php } ?>
											</div>
										</div>
										<?php if($def['resimgorunum'] != 'pasif'){?>
										<div class="urun-link">
											<a href="<?php echo $set["langurl"]; ?>/<?php echo $sef_galeri_link[$set['lang']['active']]; ?>/<?php echo $unx_sef[$set['lang']['active']]."-".$bul['id'] ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">
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
					<div class="cihaniriboy-sayfalama">
						<div class="cihaniriboy_sayfalama_orta">
							<?php
								if($sayfa > 1){
								$onceki = $sayfa-1;
								echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$onceki.'"><i class="fa fa-chevron-left"></i></a>';
								}
								for($i=1; $i<=$sayfasayisi; $i++){
									if($i == $sayfa) {
									echo '<span class="cihaniriboy-spanaktif">'.$i.'</span>';
									}else{
									echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$i.'">'.$i.'</a>';
								}
							
							}
							if($sayfa != $sayfasayisi){
								$sonraki = $sayfa+1;
								echo '<a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'/'.$lang['yardimci']['sayfa'].'/'.$sonraki.'"><i class="fa fa-chevron-right"></i></a>';
							}
							?>
						</div>
					</div>
					<?php } ?>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12">
					<div class="cihaniriboy-inner-right">
						<div class="<?php echo $def['urunlersidebar'] == 1 ? 'cihaniriboy-inner-sidebar-blue' : 'cihaniriboy-inner-sidebar-klasik'; ?>">
							<div class="cihaniriboy-right-kivrim"></div>
							<div class="cihaniriboy-left-kivrim"></div>
							<div class="cihaniriboy-sidebar">
								<ul class="cihaniriboy-sidefirstul">
										<?php 
										function menucek($parent,$derinlik=0,$mod){	
											global $conn;
											global $set;
											global $id;
											global $sef_galeri_link;
											$altmenu2  = $conn -> query("SELECT * FROM resim WHERE ustkat = '".intval($parent)."' order by sira asc");
											if($altmenu2  -> rowCount() > 0){
								
													foreach($altmenu2 as $kat){
														$unx_sef 	 = unserialize($kat['sef']);
														$unx_baslik  = unserialize($kat['baslik']);
														echo '<li><a href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'-'.$kat['id'].'">'.$unx_baslik[$set['lang']['active']].'</a></li>';
														
													}
									
											}
										}
										## Urunler Func


										$katlar = $conn -> query("SELECT * FROM album ORDER BY sira ASC");
											foreach($katlar as $row) { 
												$name	  = unserialize($row['baslik']);
												$sef 	  = unserialize($row['sef']);
												$altmenu = $conn -> query("SELECT * FROM resim WHERE ustkat = '".intval($row['id'])."' order by sira asc");
												echo '<li class="'; 
												echo $row['id'] == $id ? 'li-open' :null;
												echo '">'; 
														echo '<a '; 
														
														echo ' href="'.$set['langurl'].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'" class="subacma';
														
														echo '"';
														echo '>'.$name[$set['lang']['active']].'</a>';
														if($def['resimgorunum'] != 'pasif') {
															if($altmenu -> rowCount() > 0){
																echo '<ul class="cihaniriboy-sideul" '; 
																echo $row['id'] == $id ? 'style="display:block"' :null;
																echo '>';
																		echo menucek($row['id'],0,"projeler");
																echo '</ul>';
															}
														}
													echo '</li>';	
											}
										?>
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