<?php  if( !defined("SABIT") ){ exit; } 
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM kategori WHERE id = '".intval($id)."'")->fetch();
$sayfa = intval($get4);

if(!$bul) { include("include/modules/404/404.php");  exit;}
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_resimler 	 = $bul['resimler'];
$baslik 		 = $unx_baslik[$set['lang']['active']];

$title 			 = $unx_title[$set['lang']['active']];
if(empty($title)) {
$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$description = $unx_description[$set['lang']['active']];

$kapak = glob("uploads/onkapak/haberler/haberler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 




if(empty($sayfa) || !is_numeric($sayfa)){ $sayfa = 1;}
$kactane = $conn -> query("SELECT * FROM hizmet WHERE katid = '".intval($bul['id'])."'");
$num = $kactane-> rowCount();
$kacar = 12;
$sayfasayisi = ceil($num/$kacar);
$nerden = ($sayfa*$kacar)-$kacar;
$haberler = $conn -> query("SELECT * FROM hizmet WHERE katid = '".intval($bul['id'])."' ORDER BY sira ASC LIMIT ".$nerden.",".$kacar."");
$yanhaberler  = $conn ->  query("SELECT * FROM hizmet WHERE katid = '".intval($bul['id'])."'");
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
			<h2><?php echo $baslik; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><a href="javascript:void;"><?php echo $lang['genel']['hizmetler']; ?></a></li>
					<li><?php echo $baslik; ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-hizmetler-content">
						<?php 
						$x = 0;
						foreach($haberler  as $row) { 
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
						<div class="cihaniriboy-hizmet-item">
							<div class="col-sm-5 col-xs-12 <?php echo $x == 2 ? ' pull-right' : null; ?>">
								<div class="hizmet-image">
									<img src="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $anaresim; ?>" alt="" />
								</div>
							</div>
							<div class="col-sm-7 col-xs-12">
								<div class="hizmet-baslik"><h4><?php echo $name[$set['lang']['active']]; ?></h4></div>
								<div class="hizmet-icerik">
									<?php
									$c = html_entity_decode($aciklama[$set['lang']['active']]); 
									echo substr($c,0,280);
									?>..
								</div>
								<div class="hizmet-link">
									<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $lang['yardimci']['devami']; ?> > </a>
								</div>
							</div>
							<h1></h1>
						</div>
						<?php  if($x >= 2) { $x = 0;} }  ?>
					</div>
				</div>
				<div class="col-md-4 col-xs-12">
					<div class="cihaniriboy-inner-right">
						<div class="cihaniriboy-inner-sidebar-blue">
							<div class="cihaniriboy-right-kivrim"></div>
							<div class="cihaniriboy-left-kivrim"></div>
							<div class="cihaniriboy-sidebar">
								<ul class="cihaniriboy-sidefirstul">
									<li class="li-open"><a href="javascript:;"><?php echo $unx_baslik[$set['lang']['active']]; ?></a>
										<ul class="cihaniriboy-sideul cihaniriboy-sideul-open">
											<?php foreach($yanhaberler as $row){ 
											$name = unserialize($row['baslik']);
											$sef  = unserialize($row['sef']);									
											?>	
											<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row[0]?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
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