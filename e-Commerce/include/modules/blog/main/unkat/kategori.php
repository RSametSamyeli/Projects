<?php  if( !defined("SABIT") ){ exit; } 
$unx_seo 	 = unserialize($sef_blog['seo']);
$sayfa = intval($get3);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak       = glob("uploads/onkapak/haberler/haberler.*");
seoyaz("".$title."","".$description."","".$keywords."",""); 


?>
 <link href="assets/cekirdek/css/layout.css" rel="stylesheet">
    <!-- flowerx -  CSS3 Image Hover Effects -->
    <link href="assets/cekirdek/css/style-flowerx.css" rel="stylesheet">
</head>
<body class="product-page">
<div id="page"> 
<?php include('include/sabit/header.php'); ?>
<div class="main-container top-space col2-right-layout">
    <div class="main container col-main">
  <?php $blog = $conn -> query("select * from blog order by sira asc");?>       
<section class="content-section" id="style-sixteen-hover">
      
 <?php 
					$i= -0.1;
					$iPlus = 0.2;
					foreach($blog as $haber){
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
          <div class="col-sm-4">
            <!-- style sixteen -->
            <figure class="style-sixteen-hover">
              <img src="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>" alt="<?php echo $baslik[$set['lang']['active']]; ?>" />
              <figcaption>
                <div>
                  <h3>Tarih : <?php echo tarih($haber['tarih'],$set['lang']['active']); ?></h3>
                  <h3>Okuma Sayısı : <?php echo $haber['okunma']; ?></h3>
                </div>
                <div>
                  <h2><?php echo $baslik[$set['lang']['active']]; ?></h2>
                </div>
              </figcaption>
              <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"></a>
            </figure>
          </div>
        <?php  } ?>
    </section>
		 </div> </div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>
<?php _footer(); ?>
 <script src="assets/cekirdek/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="assets/cekirdek/js/jquery.easing.min.js"></script>
    <!-- Custom scripts for this template -->
    <script src="assets/cekirdek/js/stylish-portfolio.min.js"></script>
<?php _footer_last(); ?>
 </body>
</html>