<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM haber WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}

## cookie

  if (!isset($_COOKIE["oku_{$bul['id']}"])) {
	setcookie("oku_{$bul['id']}","Counted!",time()+604800);
	$conn -> exec("UPDATE haber SET okunma = okunma +1 WHERE id  = '".intval($bul['id'])."'");
   }
   
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_aciklama 	 = unserialize($bul['aciklama']);
$unx_resimler 	 = unserialize($bul['resimler']);
$baslik 		 = $unx_baslik[$set['lang']['active']];
$aciklama 		 = $unx_aciklama[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
$haberler		 = $conn -> query("SELECT * FROM haber ORDER BY sira ASC")->fetchAll();
if(empty($title)) {
$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
@$sresim =  $set['siteurl']."/uploads/haberler/thumb/".$unx_resimler[0]."";
seoyaz("".$title."","".$descripton ."","".$keywords."","".@$sresim.""); 
$kapak = glob("uploads/onkapak/haberler/haberler.*");
$arkakapak = glob("uploads/arkakapak/haberler/haberler.*"); 

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
			<h2><?php echo $baslik; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_haber_link[$set['lang']['active']]; ?>"><?php echo ucfirsttr($sef_haber_baslik [$set['lang']['active']]); ?></a></li>
					<li><?php echo $baslik; ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-inner-left" id="cihaniriboy-yazdir-content">
						<div class="cihaniriboy-page-title no-margin">
							<h1><?php echo $baslik; ?></h1>
							<div class="cihaniriboy_page_helpers">
								<div class="cihaniriboy_yazdir">
									<a href="javascript:void(0)" onclick="PrintContent()" class="print"> 
									<i class="fa fa-print"></i></a>
								</div>
								<div class="cihaniriboy_buyutkucut">
									<a href="#" id="cihaniriboy_font_buyut">A+</a>
									<a href="#" id="cihaniriboy_font_kucult">A-</a>
								</div>
							</div>
						</div>
						<div class="cihaniriboy-post-helper">
							<span><i class="fa fa-calendar"></i>
							<?php echo tarih($bul['tarih'],$set['lang']['active']); ?>
							</span>
							<span><i class="fa fa-eye"></i><?php echo $bul['okunma']; ?></span>
						</div>
						<div class="cihan-iriboy-page-maske">
							<img class="img-responsive" src="<?php echo $set['siteurl']; ?>/uploads/haberler/large/<?php echo $unx_resimler[0]; ?>" alt="<?php echo $baslik; ?>" />
						</div>
						<div class="cihaniriboy_page-text cihaniriboy_fontsize">
							<?php echo html_entity_decode($aciklama); ?>
						</div>
						<div class="cihaniriboy_social_media">
							<div class="cihaniriboy-social-facebook">
								<div class="fb-share-button" data-href="<?php echo $link; ?>" data-layout="button"></div>
							</div>
							<div class="cihaniriboy-social-twitter">
								<a class="twitter-share-button"
									   href="https://twitter.com/share"
									  data-url="<?php echo $link;?>"
									  data-text="<?php echo $title; ?>"
									  data-count="vertical">
									Tweet
									</a>
								<script type="text/javascript">
									window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
								</script>
							</div>
							<div class="cihaniriboy-social-google">
								<div class="g-plus" data-action="share" data-annotation="none" data-height="23" data-href="<?php echo $link; ?>"></div>
							
							</div>
						</div>
						<?php if( count($unx_resimler) > 0 ) { ?>
						<div class="cihaniriboy-inner-galeri cihaniriboy-img-list">
							<div class="row">
								<?php foreach($unx_resimler as $row){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6">
									<a href="<?php echo $set['siteurl']; ?>/uploads/haberler/large/<?php echo $row; ?>" class="cihaniriboy-u-zoom">
										<img src="<?php echo $set['siteurl']; ?>/uploads/haberler/thumb/<?php echo $row; ?>"  />
									   <i class="fa fa-search"></i>
									</a>
								</div>
								<?php } ?>
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
									<li class="li-open"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_haber_link[$set['lang']['active']]; ?>"><?php echo $lang['genel']['haberler']; ?></a>
										<ul class="cihaniriboy-sideul cihaniriboy-sideul-open">
											<?php foreach($haberler as $row){ 
											$name = unserialize($row['baslik']);
											$sef  = unserialize($row['sef']);									
											?>	
											<li><a <?php echo $row[0] == $id ? ' class="ci-side-active"' : null; ?> href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_haber_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row[0]?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
											
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
<script type="text/javascript">
	$(function(){
		$('#cihaniriboy_font_buyut').click(function(){	   
			curSize= parseInt($('.cihaniriboy_fontsize').css('font-size')) + 2;
			if(curSize<=20)
				$('.cihaniriboy_fontsize').css('font-size', curSize);
			return false;
		});  
		$('#cihaniriboy_font_kucult').click(function(){	   
			curSize= parseInt($('.cihaniriboy_fontsize').css('font-size')) - 2;
			if(curSize>=12)
				$('.cihaniriboy_fontsize').css('font-size', curSize);
			return false;	
		}); 
	});
</script>
<script type="text/javascript">
	function PrintContent() {
		var DocumentContainer = document.getElementById('cihaniriboy-yazdir-content');
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