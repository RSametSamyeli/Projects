<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}
$bul = $conn -> query("SELECT * FROM sayfa WHERE sef LIKE '%".$get2."%'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit; }
	
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_aciklama 	 = unserialize($bul['aciklama']);
$unx_resimler 	 = unserialize($bul['resimler']);
$sayfabaslik 		 = $unx_baslik[$set['lang']['active']];
$maske 			 = $bul['maske'];
$aciklama 		 = $unx_aciklama[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
$pages			 = $conn -> query("SELECT * FROM sayfa ORDER BY sira ASC")->fetchAll();
if(empty($title)) {
$title = $sayfabaslik ;
}

$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
seoyaz("".$title."","".$keywords."","".$descripton ."",""); 
/* Sayfalar */
$link = $set['siteurl'].$_SERVER['REQUEST_URI'];

?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/sayfa.css" />
</head>
<body>
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
<div class="outer-page">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li class="active"><?php echo ucfirsttr($sayfabaslik); ?></li>
			</ul>
		</div>
		<div class="inner-page">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-xs-12">
						<div class="kurumsal-sidebar">
							<div class="title"><h1>KURUMSAL</h1></div>
							<ul>
								<?php foreach($pages as $row) { 
								$name = unserialize($row['baslik']);
								$sef  = unserialize($row['sef']);	
								echo '<li '; 
								echo $row['id'] == $bul['id'] ? ' class="active"' : null;
								echo '><a href="'.$set['langurl'].'/'.$detaysef_kurumsal_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'">'.$name[$set['lang']['active']].'</a></li>';
								 } ?>
							</ul>
						</div>
					</div>
					<!--/sol-->
					<div class="col-md-9 col-xs-12">
						<div class="sayfa-content">
							<div class="title"><h2><?php echo $sayfabaslik ; ?></h2></div>
							<div class="text"><?php echo html_entity_decode($aciklama); ?></div>
						</div>
					</div>
					<!--/sag-->
				</div>
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