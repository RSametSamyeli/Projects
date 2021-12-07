<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM hizmet  WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}
	
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
$hizmetler		 = $conn -> query("SELECT * FROM hizmet ORDER BY sira ASC")->fetchAll();
if(empty($title)) {
$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
seoyaz("".$title."","".$descripton ."","".$keywords."",""); 
$kapak = glob("uploads/onkapak/kurumsal/kurumsal.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 

$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
$secilenler2       = $conn -> query("select * from urun where gununfirsati = 1 order by sira asc limit 4"); 
$secilenler        = $conn -> query("select * from urun order by sira asc limit 4");
?>

</head>
<body class="preload" style="background:#fafafa">
<div class="wrap">

<?php include('include/sabit/header.php'); ?>
<div class="main-container container">
		<ul class="breadcrumb">
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_hizmetler_link[$set['lang']['active']]; ?>"><?php echo ucfirsttr($sef_hizmetler_baslik [$set['lang']['active']]); ?></a></li>
					<li><?php echo $baslik; ?></li>
				
		</ul>
		
		<div class="row">
			<!--Left Part Start -->
			<aside class="col-sm-4 col-md-3" id="column-left">
				<div class="module blog-category titleLine">
	<h3 class="modtitle">Hizmetler</h3>
	<div class="modcontent">
		<ul class="list-group ">
			<?php foreach($hizmetler as $row){ 
											$name = unserialize($row['baslik']);
											$sef  = unserialize($row['sef']);									
											?>	
											<li class="list-group-item"><a <?php echo $row[0] == $id ? ' class="ci-side-active"' : null; ?> href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_hizmetler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row[0]?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
											
											<?php } ?>
		</ul>
		
	</div>
</div>		

	</aside>
			<!--Left Part End -->
			
			<!--Middle Part Start-->
			<div id="content" class="col-md-9 col-sm-8">
				<div class="article-info">
					<div class="blog-header">
						<h3><?php echo $baslik; ?></h3>
					</div>
					<div class="form-group">
						<a href="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $unx_resimler[0]; ?>" class="image-popup"><img src="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $unx_resimler[0]; ?>" alt="<?php echo $baslik; ?>" /></a>
					</div>
					
					<div class="article-description">
						<?php echo html_entity_decode($aciklama); ?>
						</div>

				</div>
<?php if( count($unx_resimler) > 0 ) { ?>
						
							<div class="row">
								<?php foreach($unx_resimler as $row){ ?>
								<div class="col-md-3 col-sm-3 col-xs-6">
									<a href="<?php echo $set['siteurl']; ?>/uploads/hizmet/large/<?php echo $row; ?>" class="erkaofisimo-u-zoom">
										<img src="<?php echo $set['siteurl']; ?>/uploads/hizmet/thumb/<?php echo $row; ?>"  />
									   
									</a>
								</div>
								<?php } ?>
							</div>
						
						<?php } ?>
			</div>
			
			
		</div>
		<!--Middle Part End-->
	</div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
		
<?php _footer(); ?>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('#erkaofisimo_font_buyut').click(function(){	   
			curSize= parseInt($('.erkaofisimo_fontsize').css('font-size')) + 2;
			if(curSize<=20)
				$('.erkaofisimo_fontsize').css('font-size', curSize);
			return false;
		});  
		$('#erkaofisimo_font_kucult').click(function(){	   
			curSize= parseInt($('.erkaofisimo_fontsize').css('font-size')) - 2;
			if(curSize>=12)
				$('.erkaofisimo_fontsize').css('font-size', curSize);
			return false;	
		}); 
	});
</script>
<script type="text/javascript">
	function PrintContent() {
		var DocumentContainer = document.getElementById('erkaofisimo-yazdir-content');
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