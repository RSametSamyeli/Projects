<?php if( !defined("SABIT") ){ exit; }
seoyaz("","","",""); 
$slider          = $conn -> query("select * from slider where dil = '".$set['lang']['active']."' order by sira asc");

$urunler           = $conn -> query("select * from urun order by sira asc limit 10");
$sliderSetting     =  unserialize($def['slider']);
$yorumlar 		   = $conn -> query("select * from yorumlar where tur = 3 and durum  = 1 limit 6");
$secilenler2       = $conn -> query("select * from urun order by sira asc limit 6"); 
$secilenler        = $conn -> query("select * from urun where gununfirsati = 1 order by sira asc limit 8");
$secilenler3       = $conn -> query("select * from urun where yeniurun = 1 order by sira asc limit 12");
$secilenler4       = $conn -> query("select * from urun where indirim = 1 order by sira asc limit 6");
$secilenler5       = $conn -> query("select * from urun order by sira asc limit 6");
$firsaturunler1    = $conn -> query("select * from urun where firsaturun = 1  order by sira asc limit 1");
$anasayfaReklamlar1 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 1 order by sira asc limit 1");
$anasayfaReklamlar2 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 1 order by sira asc limit 2 OFFSET 1");
$anasayfaReklamlar3 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 2 order by sira asc ");
$anasayfaReklamlar4 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 3 order by sira asc ");
$firsataktif    = $conn -> query("select * from siteayar where anatab1 = 1");
$kategoriaktif    = $conn -> query("select * from siteayar where anatab2 = 1");
$yeniaktif    = $conn -> query("select * from siteayar where anatab3 = 1");
$indirimnaktif    = $conn -> query("select * from siteayar where anatab4 = 1");
$ebultennaktif    = $conn -> query("select * from siteayar where anatab5 = 1");
$myorumnaktif    = $conn -> query("select * from siteayar where anatab6 = 1");
$slidernaktif    = $conn -> query("select * from siteayar where anatab7 = 1");
$yenikatnaktif    = $conn -> query("select * from siteayar where anatab8 = 1");
$sizinicinnaktif    = $conn -> query("select * from siteayar where anatab9 = 1");
$blognaktif    = $conn -> query("select * from siteayar where anatab10 = 1");

if(isset($_SESSION["fs"]["kredi"])){
	unset($_SESSION["fs"]["kredi"]);
}
if(isset($_SESSION["fs"]["puan"])){
	unset($_SESSION["fs"]["puan"]);
}
if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
}

?>
</head>
<body class="cms-index-index cms-home-page">
<div id="page"> 
<!-- ============================================== HEADER ============================================== -->
	<?php include('include/sabit/header.php'); ?>
	
 <!-- Slider -->
  <div id="thm-slideshow" class="thm-slideshow">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
<?php if($slidernaktif -> rowCount() > 0) { ?>
        <?php if($slider -> rowCount() > 0 ){ ?>
          <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container'>
            <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
              <ul>
		
			<?php foreach($slider as $row){ ?>
				<li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='<?php echo $set['siteurl']; ?>/uploads/slider/<?php echo $row['url'];  ?>'><img src='<?php echo $set['siteurl']; ?>/uploads/slider/<?php echo $row['url'];  ?>' alt="slide-img" data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' />
                  <div class="info">
                    <div class='tp-caption ExtraLargeTitle sft  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><span><?php echo $row['slogan1']; ?></span> </div>
                    <div class='tp-caption LargeTitle sfl  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><span><?php echo $row['slogan2']; ?></span> </div>
                    <div class='tp-caption sfb  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><a href='<?php echo $row['link']; ?>' class="buy-btn">Detaya Git</a> </div>
                  </div>
                </li>
				 <?php  } ?>
              </ul>
            </div>
          </div>
		  <?php  } ?>
		  <?php  } ?>
        </div>
		<?php if($firsataktif -> rowCount() > 0) { ?>
        <div class="col-md-3 hot-deal">
          <ul class="products-grid">
						
					
 <?php foreach($firsaturunler1 as $row){ 
				$name      = unserialize($row['baslik']);
				$sef       = unserialize($row['sef']);	
				$images    = unserialize($row['resimler']);	
				 if(empty($images)){
					$anaresim = "default.jpg"; 	
				 }else{
					if(empty($row['vitrinresim'])){
						$anaresim = $images[0]; 	
					}else{
						$anaresim = $row['vitrinresim'];
					}
				 }
				  		if(isset($_SESSION["m_oturum"])){
						$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
						if($uyebayi['fiyat'] != 0){
							$degisim   = ($row['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
							$degisim   =  $row['yenifiyat'] - $degisim;
							$urunfiyat =  $degisim;
							$ilkfiyat  = $row['yenifiyat'];
						}else{
							$urunfiyat = $row['yenifiyat'];
							$ilkfiyat  = $row['fiyat'];
						}
					}else{
						$urunfiyat = $row['yenifiyat'];
						$ilkfiyat  = $row['fiyat'];
					}
			?>						
            <li class="right-space two-height item">
              <div class="item-inner">
                <div class="item-img">
                  <div class="item-img-info"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="Retis lapen casen" class="product-image"> <img style="height:240px;" src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>" alt="Retis lapen casen"> </a>
                    
                    <div class="box-hover">
                      <ul class="add-to-links">
                        <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
						
														<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
													
						
					  </ul>
                    </div>
                  </div>
                </div>
                <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <div class="rating-box">
                            <div class="rating" style="width:100%"></div>
                          </div>
                        </div>
                      </div>
								
					 <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo $ilkfiyat; ?> TL</del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo $urunfiyat; ?> TL</span></ins> </span>
					
						</div>
                      </div>
					  <?php } ?>

								
									
									<div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
								
                      
                    </div>
                  </div>
                </div>
              </div>
            </li>
			<?php  } ?>
          </ul>
        </div>
		<?php  } ?>
		  
      </div>
    </div>
  </div>
  
			<?php echo html_entity_decode($footeryazi[$set['lang']['active']]); ?>
			

	
	<?php if($sizinicinnaktif -> rowCount() > 0){?>
	<div class="content-page">
    <div class="container"> 
      <!-- featured category fashion -->
      <div class="category-product">
        <div class="navbar nav-menu">
          <div class="navbar-collapse">
            <ul class="nav navbar-nav">
              <li>
                <div class="new_title">
                  <h2>Sizin İçin Seçtiklerimiz</h2>
                </div>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse --> 
          
        </div>
        <div class="product-bestseller">
          <div class="product-bestseller-content">
            <div class="product-bestseller-list">
              <div class="tab-container"> 
                <!-- tab product -->
                <div class="tab-panel active" id="tab-1">
                  <div class="category-products">
                    <ul class="products-grid">
                     
                      
                       
 <?php foreach($secilenler as $row){ 
				$name      = unserialize($row['baslik']);
				$sef       = unserialize($row['sef']);	
				$images    = unserialize($row['resimler']);	
				 if(empty($images)){
					$anaresim = "default.jpg"; 	
				 }else{
					if(empty($row['vitrinresim'])){
						$anaresim = $images[0]; 	
					}else{
						$anaresim = $row['vitrinresim'];
					}
				 }
				  		if(isset($_SESSION["m_oturum"])){
						$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
						if($uyebayi['fiyat'] != 0){
							$degisim   = ($row['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
							$degisim   =  $row['yenifiyat'] - $degisim;
							$urunfiyat =  $degisim;
							$ilkfiyat  = $row['yenifiyat'];
						}else{
							$urunfiyat = $row['yenifiyat'];
							$ilkfiyat  = $row['fiyat'];
						}
					}else{
						$urunfiyat = $row['yenifiyat'];
						$ilkfiyat  = $row['fiyat'];
					}
			?>						
           <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
              <div class="item-inner">
                <div class="item-img">
                  <div class="item-img-info"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="Retis lapen casen" class="product-image"> <img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>" alt="Retis lapen casen"> </a>
                    
                    <div class="box-hover">
                      <ul class="add-to-links">
                        <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
						
														<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
													
						
					  </ul>
                    </div>
                  </div>
                </div>
                <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <div class="rating-box">
                            <div class="rating" style="width:100%"></div>
                          </div>
                        </div>
                      </div>
								
					 <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo $ilkfiyat; ?> TL</del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo $urunfiyat; ?> TL</span></ins> </span>
					
						</div>
                      </div>
					  <?php } ?>

								
									
									<div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
								
                      
                    </div>
                  </div>
                </div>
              </div>
            </li>
          <?php  } ?>
		
					  
					  
                    </ul>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <?php  } ?>
		  
		  	<?php if($kategoriaktif -> rowCount() > 0){?>
  <!-- bestsell Slider -->
  <section class="bestsell-pro">
    <div class="container">
      <div class="slider-items-products">
        <div class="bestsell-block">
          <div id="bestsell-slider" class="product-flexslider hidden-buttons">
            <div class="home-block-inner">
              <div class="block-title">
                <h2>Yeni Ürünler </h2>
              </div>
              <div class="pretext"><a title="Retis lapen casen" href="#"> <img alt="Retis lapen casen" src="assets/images/kresim7.jpg"> </a>
              <div class="offer-text"><?php echo $anabaslik7[$set['lang']['active']]; ?></div>
              </div>
              </div>
            <div class="slider-items slider-width-col4 products-grid block-content">
			
			<?php foreach($secilenler2 as $row){ 
				$name      = unserialize($row['baslik']);
				$sef       = unserialize($row['sef']);	
				$images    = unserialize($row['resimler']);	
				 if(empty($images)){
					$anaresim = "default.jpg"; 	
				 }else{
					if(empty($row['vitrinresim'])){
						$anaresim = $images[0]; 	
					}else{
						$anaresim = $row['vitrinresim'];
					}
				 }
				  		if(isset($_SESSION["m_oturum"])){
						$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
						if($uyebayi['fiyat'] != 0){
							$degisim   = ($row['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
							$degisim   =  $row['yenifiyat'] - $degisim;
							$urunfiyat =  $degisim;
							$ilkfiyat  = $row['yenifiyat'];
						}else{
							$urunfiyat = $row['yenifiyat'];
							$ilkfiyat  = $row['fiyat'];
						}
					}else{
						$urunfiyat = $row['yenifiyat'];
						$ilkfiyat  = $row['fiyat'];
					}
			?>		
              <div class="item">
                  <div class="item-inner">
                     <div class="item-img">
                  <div class="item-img-info"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="Retis lapen casen" class="product-image"> <img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>" alt="Retis lapen casen"> </a>
                    <div class="new-label new-top-left">Yeni</div>
                    <div class="box-hover">
                      <ul class="add-to-links">
                        <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
						
														<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
													
						
					  </ul>
                    </div>
                  </div>
                </div>
                    <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <div class="rating-box">
                            <div class="rating" style="width:100%"></div>
                          </div>
                        </div>
                      </div>
								
					 <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo $ilkfiyat; ?> TL</del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo $urunfiyat; ?> TL</span></ins> </span>
					
						</div>
                      </div>
					  <?php } ?>

								
									
									<div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
								
                      
                    </div>
                  </div>
                </div>
                  </div>
                </div>
              <?php  } ?>
			  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Bestsell Slider --> 
    <?php  } ?>
	<?php if($myorumnaktif -> rowCount() > 0){?>
	 <div class="bottom-banner-section">
    <div class="container">
      <div class="row">
      <div class="col-md-4 col-sm-12">
      <div class="testi-slider">
              <div>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                 
                  <div class="carousel-inner">
				  
				  <?php foreach($anasayfaReklamlar1 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>
                    <div class="item active">
                    <div class="avatar"><img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"></div>
                      <div>
                      <p>"<?php echo $altname[$set['lang']['active']]; ?>"</p>
                      <div class="clients_author"><a href="<?php echo $url[$set['lang']['active']]; ?>" target="_blank">
              <?php echo $name[$set['lang']['active']]; ?></a></div>
                       </div>
                    </div>
                  <?php } ?>
<?php foreach($anasayfaReklamlar2 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>
                    <div class="item">
                    <div class="avatar"><img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"></div>
                      <div>
                      <p>"<?php echo $altname[$set['lang']['active']]; ?>"</p>
                      <div class="clients_author"><a href="<?php echo $url[$set['lang']['active']]; ?>" target="_blank">
              <?php echo $name[$set['lang']['active']]; ?></a></div>
                       </div>
                    </div>
                  <?php } ?>  				  
                  </div>
                   <ol class="carousel-indicators">
                    <li class="active" data-target="#carousel-example-generic" data-slide-to="0"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol>
                  <a class="left carousel-control" href="#" data-slide="prev"> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#" data-slide="next"> <span class="sr-only">Next</span> </a></div>
              </div>
            </div>
      </div>
         <div class="col-md-8 col-sm-12">
       <div class="row">
         <?php foreach($anasayfaReklamlar3 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>  
        <div class="col-md-6 col-sm-6">
          <div class="bottom-banner-img1"> <a href="<?php echo $url[$set['lang']['active']]; ?>"> <img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>">
            
            </a></div>
        </div>
 <?php } ?>
        <?php foreach($anasayfaReklamlar4 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?> 
        <div class="col-md-12 col-sm-12">
          <div class="bottom-banner-img1 last"> <a href="<?php echo $url[$set['lang']['active']]; ?>"><img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> <span class="banner-overly"></span>
            <div class="bottom-img-info last">
              <h3><?php echo $name[$set['lang']['active']]; ?></h3>
              <h6><?php echo $altname[$set['lang']['active']]; ?></h6>
            </div>
            </a></div>
        </div>
		 <?php } ?>
        </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($yeniaktif -> rowCount() > 0){?>
  <section class="featured-pro">
    <div class="container">
      <div class="slider-items-products">
        <div class="featured-block">
          <div id="featured-slider" class="product-flexslider hidden-buttons">
            <div class="home-block-inner">
              <div class="block-title">
                <h2>İNDİRİMDE</h2>
              </div>
              <div class="pretext"><a title="Retis lapen casen" href="#"> <img alt="Retis lapen casen" src="assets/images/kresim8.jpg"> </a>
              <div class="offer-text"><?php echo $anabaslik8[$set['lang']['active']]; ?></div>
              </div>
             </div>
            <div class="slider-items slider-width-col4 products-grid block-content">
			
			
             <?php foreach($secilenler4 as $row){ 
				$name      = unserialize($row['baslik']);
				$sef       = unserialize($row['sef']);	
				$images    = unserialize($row['resimler']);	
				 if(empty($images)){
					$anaresim = "default.jpg"; 	
				 }else{
					if(empty($row['vitrinresim'])){
						$anaresim = $images[0]; 	
					}else{
						$anaresim = $row['vitrinresim'];
					}
				 }
				  		if(isset($_SESSION["m_oturum"])){
						$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
						if($uyebayi['fiyat'] != 0){
							$degisim   = ($row['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
							$degisim   =  $row['yenifiyat'] - $degisim;
							$urunfiyat =  $degisim;
							$ilkfiyat  = $row['yenifiyat'];
						}else{
							$urunfiyat = $row['yenifiyat'];
							$ilkfiyat  = $row['fiyat'];
						}
					}else{
						$urunfiyat = $row['yenifiyat'];
						$ilkfiyat  = $row['fiyat'];
					}
			?>		
              <div class="item">
                  <div class="item-inner">
                     <div class="item-img">
                  <div class="item-img-info"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="Retis lapen casen" class="product-image"> <img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>" alt="Retis lapen casen"> </a>
                    <div class="new-label new-top-left">Yeni</div>
                    <div class="box-hover">
                      <ul class="add-to-links">
                        <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
						
														<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
													
						
					  </ul>
                    </div>
                  </div>
                </div>
                    <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                    <div class="item-content">
                      <div class="rating">
                        <div class="ratings">
                          <div class="rating-box">
                            <div class="rating" style="width:100%"></div>
                          </div>
                        </div>
                      </div>
								
					 <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo $ilkfiyat; ?> TL</del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo $urunfiyat; ?> TL</span></ins> </span>
					
						</div>
                      </div>
					  <?php } ?>

								
									
									<div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
								
                      
                    </div>
                  </div>
                </div>
                  </div>
                </div>
              <?php  } ?>
            
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php  } ?>
  
  <?php if($blognaktif -> rowCount() > 0){?>
  <?php $blog = $conn -> query("select * from blog order by sira asc limit 2");?>
   <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="blog-outer-container">
          <div class="new_title">
            <h2>Blogdan Son Yazılar</h2>
          </div>
          <div class="blog-inner">
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
            <div class="col-lg-6 col-md-6 col-sm-6 blog-preview_item">
              <div class="entry-thumb image-hover2"> <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"> <img alt="<?php echo $baslik[$set['lang']['active']]; ?>" src="<?php echo $set['siteurl']; ?>/uploads/blog/large/<?php echo $anaresim; ?>"> </a> </div>
              <div class="blog-preview_info">
                <ul class="post-meta">
                  <li><i class="fa fa-user"></i>Başlık: <?php echo $baslik[$set['lang']['active']]; ?> </li>
                  <li><i class="fa fa-comments"></i><?php echo $haber['okunma']; ?></li>
                  <li><i class="fa fa-calendar"></i><?php echo tarih($haber['tarih'],$set['lang']['active']); ?></li>
                </ul>
                <h4 class="blog-preview_title"><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><?php echo $baslik[$set['lang']['active']]; ?></a></h4>
                <div class="blog-preview_desc"><?php echo html_entity_decode($giris[$set['lang']['active']]); ?></div>
                <a class="blog-preview_btn" href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>">Devamı</a> </div>
            </div>
           <?php  } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
   <?php  } ?>
<!-- ============================================================= FOOTER ============================================================= -->
<?php include("include/sabit/footer.php"); ?>

<!-- ============================================================= FOOTER : END============================================================= --> 
 <?php _footer(); ?>
<script>
jQuery(document).ready(function() {
	jQuery('#rev_slider_4').show().revolution({
	dottedOverlay: 'none',
	delay: 5000,
	startwidth: 915,
	startheight: 440,
	hideThumbs: 200,
	thumbWidth: 200,
	thumbHeight: 50,
	thumbAmount: 2,
	navigationType: 'thumb',
	navigationArrows: 'solo',
	navigationStyle: 'round',
	touchenabled: 'on',
	onHoverStop: 'on',
	swipe_velocity: 0.7,
	swipe_min_touches: 1,
	swipe_max_touches: 1,
	drag_block_vertical: false,
	spinner: 'spinner0',
	keyboardNavigation: 'off',
	navigationHAlign: 'center',
	navigationVAlign: 'bottom',
	navigationHOffset: 0,
	navigationVOffset: 20,
	soloArrowLeftHalign: 'left',
	soloArrowLeftValign: 'center',
	soloArrowLeftHOffset: 20,
	soloArrowLeftVOffset: 0,
	soloArrowRightHalign: 'right',
	soloArrowRightValign: 'center',
	soloArrowRightHOffset: 20,
	soloArrowRightVOffset: 0,
	shadow: 0,
	fullWidth: 'on',
	fullScreen: 'off',
	stopLoop: 'off',
	stopAfterLoops: -1,
	stopAtSlide: -1,
	shuffle: 'off',
	autoHeight: 'off',
	forceFullWidth: 'on',
	fullScreenAlignForce: 'off',
	minFullScreenHeight: 0,
	hideNavDelayOnMobile: 1500,
	hideThumbsOnMobile: 'off',
	hideBulletsOnMobile: 'off',
	hideArrowsOnMobile: 'off',
	hideThumbsUnderResolution: 0,
	hideSliderAtLimit: 0,
	hideCaptionAtLimit: 0,
	hideAllCaptionAtLilmit: 0,
	startWithSlide: 0,
	fullScreenOffsetContainer: ''
});
});
</script> 
<!-- Hot Deals Timer 1--> 
<script>
var dthen1 = new Date("12/25/17 11:59:00 PM");
	start = "08/04/15 03:02:11 AM";
	start_date = Date.parse(start);
	var dnow1 = new Date(start_date);
	if (CountStepper > 0)
	ddiff = new Date((dnow1) - (dthen1));
	else
	ddiff = new Date((dthen1) - (dnow1));
	gsecs1 = Math.floor(ddiff.valueOf() / 1000);
	
	var iid1 = "countbox_1";
	CountBack_slider(gsecs1, "countbox_1", 1);
</script>
<?php _footer_last(); ?>
<!-- Placed at the end of the document so the pages load faster -->
	<!-- JavaScripts placed at the end of the document so the pages load faster --> 

</div>	
 </body>
</html>