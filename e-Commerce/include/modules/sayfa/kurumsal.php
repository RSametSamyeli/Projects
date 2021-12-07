<?php  if( !defined("SABIT") ){ exit; } 
echo $get1;
echo 'xxx';
exit;
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}
$last =  explode("-",$get2);
$id = end($last);
$bul = $conn -> query("SELECT * FROM sayfa WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}
	
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_aciklama 	 = unserialize($bul['aciklama']);
$baslik 		 = $unx_baslik[$set['lang']['active']];
$aciklama 		 = $unx_aciklama[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
$pages			 = $conn -> query("SELECT * FROM sayfa ORDER BY sira ASC");
if(empty($title)) {
$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
seoyaz("".$title."","".$keywords."","".$descripton .""); ?>
</head>
<body>
<!-- Header -->
<?php include('include/sabit/header.php'); ?>
<div class="zr-page">	
	<div class="container">
		<div class="urun-detay">
			<div class="detay-ribbon"><h2><?php echo $baslik; ?></h2></div>
			<!-- Sol -->
				<div class="col-md-3">
					<div class="detay-sol">
						<div class="zr-sidebar">
							<ul>
								<?php foreach($pages as $row)  {
									$row_ad = unserialize($row['baslik']);
									$row_sef = unserialize($row['sef']);
									echo '<li><a '; 
									echo $row['id'] == $id ? 'class="side-active"': null;
									echo 'href="/kurumsal/'.$row_sef['tr'].'-'.$row['id'].'">'.$row_ad['tr'].'</a></li>';
							 } ?>
							</ul>
							<div class="side-adv clearfix">
								<img src="/assets/images/adv-1.png" alt="eskayem" />
							</div>
						</div>
					</div>
				</div>
			<!-- Sol ** -->
			<!-- Sag -->
				<div class="col-md-9">
					<div class="detay-sag">
						<div class="detay-text" style="text-align:justify">
								<?php echo html_entity_decode($aciklama); ?>
						</div>
					</div>
				</div>
			<!-- Sag -->
		</div>
	</div>
</div>	
<!-- Zr Footer -->
<?php include('include/sabit/footer.php'); ?>		
<?php _footer(); ?>
 </body>
</html>