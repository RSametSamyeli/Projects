<?php  if( !defined("SABIT") ){ exit; } 
@include("ajax/yazi/markayazi.php");
$unx_seo 	 = unserialize($sef_galeri['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak = glob("uploads/onkapak/galeri/galeri.*");
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
	<?php 
		$altkategori = $conn -> query('SELECT * FROM album')->fetchAll(); 
		function loopProje(){	
		global $conn,$set,$def;
		global $altkategori;
		global $sef_galeri_link;
		foreach($altkategori as $altkat){
			$projeler = $conn -> prepare('SELECT * FROM resim WHERE ustkat = ? ');
			$projeler -> execute(array(intval($altkat['id'])));
			$projeler = $projeler -> fetchAll();
			foreach($projeler as $proje) { 
				$name    = unserialize($proje['baslik']);
				$sef     = unserialize($proje['sef']);
				$images  = unserialize($proje['resimler']);
				$albumcek = $conn -> query("SELECT * FROM album where id = ".$proje['ustkat']) -> fetch();
				$albumSef = unserialize($albumcek['sef']);
				if(empty($images)){
					$anaresim = "default.jpg"; 	
				}else{
					if(empty($proje['vitrinresim'])){
						$anaresim = $images[0]; 	
					}else{
						$anaresim = $row['vitrinresim'];
					}
				}
				echo '<div class="cihaniriboy_galeribox col-sm-4 col-xs-12 col-md-3 isotope-item z'.$proje['ustkat'].'">
							<div class="cihaniriboy_galeribox_image">
								<img src="'.$set['siteurl'].'/uploads/resim/thumb/'.$anaresim.'" alt="'.$name[$set['lang']['active']].'">
								<div class="cihaniriboy_galeri_overlay">
									<div class="cihaniriboy_galeri_desc">
										<h4><a href="'.$set["langurl"].'/'.$sef_galeri_link[$set['lang']['active']].'-'.$albumSef[$set['lang']['active']].'/'.$albumcek['id'].'/'.$sef[$set['lang']['active']].'-'.$proje['id'].'">'.$name[$set['lang']['active']].'</a></h4>
									</div>
									<div class="cihaniriboy_helper_icons">
										<a href="'.$set['siteurl'].'/uploads/resim/large/'.$anaresim.'" class="cihaniriboy-u-zoom"><i class="fa fa-search"></i></a>
										'; 
										if($def['resimgorunum'] != 'pasif') {
											echo '<a href="'.$set["langurl"].'/'.$sef_galeri_link[$set['lang']['active']].'/'.$albumSef[$set['lang']['active']].'-'.$albumcek['id'].'/'.$sef[$set['lang']['active']].'-'.$proje['id'].'" class=""><i class="fa fa-share"></i></a>';
										}
										echo '
									</div>
								</div>
							</div>
								
					</div>';
			}
		
		}
	}
		?>		
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-on-resim">
			<h2><?php echo $lang['genel']['galeri']; ?></h2>
		</div>
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo $lang['genel']['galeri']; ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-12 col-xs-12">
					<div class="cihaniriboy-inner-left">
						<div class="cihaniriboy-galeri-isotope">
							<div class="cihaniriboy_galeri-header">
								<div class="portfolioFilter">
									<a href="#" data-filter="*" class="current"><span><?php echo $lang['yardimci']['tumu']; ?></span></a>
										<?php foreach($altkategori as $row) { 
												$name = unserialize($row['baslik']);
											?>
										<a href="#" data-filter=".z<?php echo $row['id']; ?>"><span><?php echo $name[$set['lang']['active']]; ?></span></a>
										<?php }  ?>
								</div>
							</div>
							<div class="cihaniriboy_galeri isotope cihaniriboy-img-list" id="isotope-cont">
								<?php loopProje(); ?>		
							</div>
						</div>
						<!--/galeri-->
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
	<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/jquery.isotope.js"></script>
	<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/imagesloaded.pkgd.min.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		
		var $container = $('#isotope-cont');
		$container.isotope({
			filter: '*',
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		});
		$('.portfolioFilter a').click(function(){
			$('.portfolioFilter .current').removeClass('current');
			$(this).addClass('current');
	 
			var selector = $(this).attr('data-filter');
			$container.isotope({
				filter: selector,
				animationOptions: {
					duration: 750,
					easing: 'linear',
					queue: false
				}
			 });
			 return false;
		});
	});
</script>
 </body>
</html>