<?php if( !defined("SABIT") ){ exit; }
seoyaz("","","",""); 
$slider          = $conn -> query("select * from slider where dil = '".$set['lang']['active']."' order by sira asc");

$urunler           = $conn -> query("select * from urun order by sira asc limit 10");
$sliderSetting     =  unserialize($def['slider']);
$yorumlar 		   = $conn -> query("select * from yorumlar where tur = 3 and durum  = 1 limit 6");
$secilenler2       = $conn -> query("select * from urun where gununfirsati = 1 order by sira asc limit 6"); 
$secilenler        = $conn -> query("select * from urun order by sira asc limit 6");
$secilenler3       = $conn -> query("select * from urun where yeniurun = 1 order by sira asc limit 6");
$secilenler4       = $conn -> query("select * from urun where indirim = 1 order by sira asc limit 6");
$secilenler5       = $conn -> query("select * from urun order by sira asc limit 6");
$firsaturunler1    = $conn -> query("select * from urun where firsaturun = 1  order by sira asc limit 6");
$anasayfaReklamlar1 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 1 order by sira asc ");
$anasayfaReklamlar2 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 2 order by sira asc ");
$anasayfaReklamlar3 = $conn -> query("select * from reklam where  gosterim = 0 && reklamturu = 0 && durum = 1 && pozisyon = 3 order by sira asc ");
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
<body class="cnt-home">
<!-- ============================================== HEADER ============================================== -->
	<?php include('include/sabit/header.php'); ?>
<!-- ============================================== HEADER : END ============================================== -->
<div class="body-content outer-top-xs" id="top-banner-and-menu">
  <div class="container">
    <div class="row"> 
      <!-- ============================================== SIDEBAR ============================================== -->
      <div class="col-xs-12 col-sm-12 col-md-3 sidebar"> 
        
        <!-- ================================== TOP NAVIGATION ================================== -->
		<?php if($kategoriaktif -> rowCount() > 0) { ?> 
        <div class="side-menu animate-dropdown outer-bottom-xs">
          <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> KATEGORİLER</div>
          <nav class="yamm megamenu-horizontal">
            <ul class="nav">
             <?php 
			
			 function getKatList($id = 0){
				  global $conn,$set;
				  $katArr = array();
				  $katal  = $conn -> query("select * from kategori where modul = 'urunler'  AND ustid = '".intval($id)."'");
				  if($katal -> rowCount() > 0){
					  foreach($katal as $row){
						$baslik = unserialize($row['baslik']);
						$katArr[] = $row;
						$katal  = $conn -> query("select * from kategori where modul = 'urunler'  AND ustid = '".intval($row['id'])."'");
						 if($katal -> rowCount() > 0){ 
							foreach($katal as $row){
								$baslik = unserialize($row['baslik']);
								$katArr[] = $row;
								 getKatList($row['id']);
							}
						 }
					  }
				  }
				    return $katArr;
			 }
			
			foreach($anakatsFetch as $row){ 
			 $name      = unserialize($row['baslik']);
			 $sef       = unserialize($row['sef']);
			 $altkats   = $conn -> query("select * from kategori where ustid = '".intval($row['id'])."'");
			 $allkats = array();	
			?>
			<?php if($altkats -> rowCount() > 0) { ?>
			<li class="dropdown menu-item"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon fa fa-shopping-bag" aria-hidden="true"></i><?php echo $name[$set['lang']['active']]; ?></a>
				<ul class="dropdown-menu mega-menu">
                  <li class="yamm-content">
                    <div class="row">
                      
					 
						<?php 
							$i = 1;
							$item_close = true;
							foreach(getKatList($row['id']) as $row2) { 
								if( $i === 1 ){ ?>
							<div class="col-xs-12 col-sm-12 col-md-4">
								<ul>
						 
							<?php $item_close = false;} ?> 
							
							<?php 
							$name      = unserialize($row2['baslik']);
							$sef       = unserialize($row2['sef']); ?>
                           <li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row2['id'];?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
						   <?php if( $i == 3 ){ ?>
								</ul></div><?php 
							}
							$i++;
							if( $i > 3){ $i = 1;  }
							} 
							if( !$item_close ){ 
								$item_close = false; 
							}
						  ?>
						  
                    
									
  
  
                    </div>
                    <!-- /.row --> 
                  </li>
                  <!-- /.yamm-content -->
                </ul>
                <!-- /.dropdown-menu --> 
			 <?php  } //endif ?>
				</li>
				<?php  } ?>
              <!-- /.menu-item -->
            </ul>
            <!-- /.nav --> 
          </nav>
          <!-- /.megamenu-horizontal --> 
        </div>
		<?php  } ?>
        <!-- /.side-menu --> 
        <!-- ================================== TOP NAVIGATION : END ================================== --> 


         <!-- ================================== promo-banner : END ================================== --> 
        <!-- ============================================== HOT DEALS ============================================== -->
		<?php if($firsataktif -> rowCount() > 0) { ?>
        <?php if($firsaturunler1 -> rowCount() > 0){?>
		<div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs">
          <h3 class="section-title">Fırsat Ürünleri</h3>
          <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">
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
							$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
							$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
							$urunfiyat =  number_format($degisim,2);
							$ilkfiyat  = number_format($row['yenifiyat'],2);
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
					}else{
						$urunfiyat = number_format($row['yenifiyat'],2);
						$ilkfiyat  = number_format($row['fiyat'],2);
					}
			?>
			<div class="item">
              <div class="products">
                <div class="hot-deal-wrapper">
					<div class="image">
					<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt=""> 
					</div>
						<?php 
					if($row['indirim'] == 1){
						if($ilkfiyat != 0.00 ){ ?>
					<div class="sale-offer-tag"><span><?php echo indirim(number_format($urunfiyat,2),number_format($ilkfiyat,2)); ?> %<br>
						İndirim</span>
					</div>
						<?php } ?>
					<!---/indirim-->
					<?php } ?>
                </div>
                <!-- /.hot-deal-wrapper -->
                
                <div class="product-info text-left m-t-20">
                  <h3 class="name"><a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $name[$set['lang']['active']]; ?></a></h3>
                  <div class="rating rateit-small"></div>
                  <div class="product-price"> 
					<span class="price"> <?php echo number_format($urunfiyat,2);?> TL </span>
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="price-before-discount"><?php echo $ilkfiyat; ?> TL </span>
					<?php  }?>
				  </div>
                  <!-- /.product-price --> 
                  
                </div>
                <!-- /.product-info -->
              </div>
            </div>
				<?php  } ?>
          </div>
          <!-- /.sidebar-widget --> 
        </div>
        <!-- ============================================== HOT DEALS: END ============================================== --> 
        <?php  } ?>
		<?php  } ?>
        <!-- ============================================== SPECIAL OFFER ============================================== -->
        <?php if($anasayfaReklamlar3 -> rowCount() > 0) { ?>
		<div class="home-banner">
			<div class="row">
            <?php foreach($anasayfaReklamlar3 as $row){ 
				$name = unserialize($row['baslik']);
				$url = unserialize($row['url']);
			?>
			<div class="col-md-<?php echo $row['grid']; ?> col-sm-<?php echo $row['grid']; ?>">
                <div class="image"> 
					<a href="<?php echo $url[$set['lang']['active']]; ?>"  target="<?php echo $row['pencere'] == 0 ? '_self' :  '_target';  ?>" id="">
						<img class="img-responsive" style="width:100%" src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> 
					</a>
				</div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col -->
			<?php  } ?>
          </div>
		</div>
		<?php  } ?>
		<?php if($yeniaktif -> rowCount() > 0) { ?>
		<?php if($secilenler3  -> rowCount() >= 6){?>
        <div class="sidebar-widget outer-bottom-small wow fadeInUp">
          <h3 class="section-title">Yeni Ürünler</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">
             
			<?php 
		
				$i = 1;
				$item_close = true;
				foreach($secilenler3 as $row){
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
							$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
							$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
							$urunfiyat =  number_format($degisim,2);
							$ilkfiyat  = number_format($row['yenifiyat'],2);
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
					}else{
						$urunfiyat = number_format($row['yenifiyat'],2);
						$ilkfiyat  = number_format($row['fiyat'],2);
					}
					if( $i === 1 ){ ?>
						  <div class="item"><div class="products special-product">
						 
							<?php $item_close = false;} ?>
							   <div class="product">
								<div class="product-micro">
								  <div class="row product-micro-row">
									<div class="col col-xs-5">
									  <div class="product-image">
										<div class="image"> 
											<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"> 
												<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> 
											</a> 
										</div>
										<!-- /.image --> 
									  </div>
									  <!-- /.product-image --> 
									</div>
									<!-- /.col -->
									<div class="col col-xs-7">
									  <div class="product-info">
										<h3 class="name"><a href="#"><?php echo $name[$set['lang']['active']]; ?></a></h3>
										<div class="rating rateit-small"></div>
										<div class="product-price"> 
											<span class="price">  <?php echo number_format($urunfiyat,2); ?> TL </span> 
											<?php if($ilkfiyat != 0.00 ){ ?>
												<span class="price-before-discount"><?php echo $ilkfiyat; ?> TL </span>
											<?php  }?>
										</div>
										
										<!-- /.product-price --> 
										
									  </div>
									</div>
									<!-- /.col --> 
								  </div>
								  <!-- /.product-micro-row --> 
								</div>
								<!-- /.product-micro --> 
								
							  </div>
						
					
					<?php if( $i == 3 ){ ?>
						</div></div><?php 
					}
					$i++;
					if( $i > 3){ $i = 1;  }
				}
				if( !$item_close ){ $item_close = false; ?><?php 	} ?>
			
           
           
            </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
		<?php  } ?>
		<?php  } ?>
        <!-- ============================================== SPECIAL OFFER : END ============================================== --> 
      <?php if($indirimnaktif -> rowCount() > 0) { ?>
       <?php if($secilenler4 -> rowCount() >= 6){ ?>
       <div class="sidebar-widget outer-bottom-small wow fadeInUp">
          <h3 class="section-title">İndirimli Ürünler</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">
              
					<?php 
		
				$i = 1;
				$item_close = true;
				foreach($secilenler4 as $row){
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
							$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
							$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
							$urunfiyat =  number_format($degisim,2);
							$ilkfiyat  = number_format($row['yenifiyat'],2);
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
					}else{
						$urunfiyat = number_format($row['yenifiyat'],2);
						$ilkfiyat  = number_format($row['fiyat'],2);
					}
					if( $i === 1 ){ ?>
						  <div class="item"><div class="products special-product">
						 
							<?php $item_close = false;} ?>
							   <div class="product">
								<div class="product-micro">
								  <div class="row product-micro-row">
									<div class="col col-xs-5">
									  <div class="product-image">
										<div class="image"> 
											<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"> 
												<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> 
											</a> 
										</div>
										<!-- /.image --> 
									  </div>
									  <!-- /.product-image --> 
									</div>
									<!-- /.col -->
									<div class="col col-xs-7">
									  <div class="product-info">
										<h3 class="name"><a href="#"><?php echo $name[$set['lang']['active']]; ?></a></h3>
										<div class="rating rateit-small"></div>
										<div class="product-price"> 
											<span class="price">  <?php echo number_format($urunfiyat,2); ?> TL </span> 
											<?php if($ilkfiyat != 0.00 ){ ?>
												<span class="price-before-discount"><?php echo $ilkfiyat; ?> TL </span>
											<?php  }?>
										</div>
										<!-- /.product-price --> 
										
									  </div>
									</div>
									<!-- /.col --> 
								  </div>
								  <!-- /.product-micro-row --> 
								</div>
								<!-- /.product-micro --> 
								
							  </div>
						
					
					<?php if( $i == 3 ){ ?>
						</div></div><?php 
					}
					$i++;
					if( $i > 3){ $i = 1;  }
				}
				if( !$item_close ){ $item_close = false; ?><?php 	} ?>
				<!--item-->
           
            </div>
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 
		<?php  } ?>
		<?php  } ?>
        <!-- ============================================== SPECIAL DEALS : END ============================================== --> 
        <!-- ============================================== NEWSLETTER ============================================== -->
		<?php if($ebultennaktif -> rowCount() > 0) { ?>
        <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small">
          <h3 class="section-title">E-Bülten Kayıt</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <p>Sitemizdeki Yeniliklerden Haberdar Ol!</p>
           
              <div class="form-group">
                <label class="sr-only" for="exampleInputEmail1">Email adres</label>
                <input type="email" name="maillist" class="form-control" id="exampleInputEmail1" placeholder="E-Mail Adresinizi Yazın">
              </div>
              <button class="btn btn-primary" id="mail-birak">Kayıt Ol</button>
            
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
		<?php  } ?>
        <!-- /.sidebar-widget --> 
        <!-- ============================================== NEWSLETTER: END ============================================== --> 
        
        <!-- ============================================== Testimonials============================================== -->
		<?php if($myorumnaktif -> rowCount() > 0) { ?>
        <?php if($yorumlar -> rowCount() > 0 ) {?>
		<div class="sidebar-widget  wow fadeInUp outer-top-vs ">
          <div id="advertisement" class="advertisement">
            <?php foreach($yorumlar as $row){ 
			
			?>
			<div class="item">
              <div class="testimonials"><em>"</em> <?php echo $row['mesaj']; ?><em>"</em></div>
              <div class="clients_author"><?php echo $row['adsoyad']; ?> </div>
              <!-- /.container-fluid --> 
            </div>
            <!-- /.item -->
            <?php  } ?>
          </div>
          <!-- /.owl-carousel --> 
        </div>
        
        <!-- ============================================== Testimonials: END ============================================== -->
        <?php  } ?>
		<?php  } ?>
 
      </div>
      <!-- /.sidemenu-holder --> 
      <!-- ============================================== SIDEBAR : END ============================================== --> 
      
      <!-- ============================================== CONTENT ============================================== -->
      <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder"> 
        <!-- ========================================== SECTION – HERO ========================================= -->
		<?php if($slidernaktif -> rowCount() > 0) { ?>
        <?php if($slider -> rowCount() > 0 ){ ?>
        <div id="hero">
          <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
            <!-- /.item -->
            <?php foreach($slider as $row){ ?>
			<a href="<?php echo $row['link']; ?>">
            <div class="item" style="background-image: url(<?php echo $set['siteurl']; ?>/uploads/slider/<?php echo $row['url'];  ?>);">
              <div class="container-fluid">
                <div class="caption bg-color vertical-center text-left">
                  <div class="slider-header fadeInDown-1"><?php echo $row['slogan1']; ?></div>
                  <div class="big-text fadeInDown-1"><?php echo $row['slogan2']; ?> </div>
                  <div class="excerpt fadeInDown-2 hidden-xs"> <span><?php echo $row['slogan3']; ?></span> </div>
                </div>
                <!-- /.caption --> 
              </div>
              <!-- /.container-fluid --> 
            </div>
			</a>
            <!-- /.item --> 
            <?php  } ?>
          </div>
          <!-- /.owl-carousel --> 
        </div>
        <?php } ?>
		<?php } ?>
        <!-- ========================================= SECTION – HERO : END ========================================= --> 
        
        <!-- ============================================== INFO BOXES ============================================== -->
        <div class="info-boxes wow fadeInUp">
          <div class="info-boxes-inner">
            <div class="row">
              <?php echo $anasayfatab1[$set['lang']['active']];?>
              <!-- .col --> 
            </div>
            <!-- /.row --> 
          </div>
          <!-- /.info-boxes-inner --> 
          
        </div>
        <!-- /.info-boxes --> 
        <!-- ============================================== INFO BOXES : END ============================================== --> 
        <!-- ============================================== SCROLL TABS ============================================== -->
		<?php if($yenikatnaktif -> rowCount() > 0) { ?>
        <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
          <div class="more-info-tab clearfix ">
            <h3 class="new-product-title pull-left">Kategorinin En Yenileri</h3>
            <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
              <li><a data-transition-type="backSlide" href="#all" data-toggle="tab">Tüm Kategoriler</a></li>
              <?php if($anakatsCount > 0 ){
				 foreach($anakatsFetch as $row) {
					 $name = unserialize($row['baslik']);
					 echo '<li><a data-transition-type="backSlide" href="#s'.$row['id'].'" data-toggle="tab">'.$name[$set['lang']['active']].'</a></li>';
				 }
			  }?>
			 
            </ul>
            <!-- /.nav-tabs --> 
          </div>
          <div class="tab-content outer-top-xs">
            <div class="tab-pane in active" id="all">
              <div class="product-slider">
                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                 <?php foreach($tumUrunler as $row){ 
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
								$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
								$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
								$urunfiyat =  number_format($degisim,2);
								$ilkfiyat  = number_format($row['yenifiyat'],2);
							}else{
								$urunfiyat = number_format($row['yenifiyat'],2);
								$ilkfiyat  = number_format($row['fiyat'],2);
							}
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
				 ?>
				 <div class="item item-carousel">
                    <div class="products">
                      <div class="product">
                        <div class="product-image">
                          <div class="image"> 
							<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">
								<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>">
							</a> 
						  </div>
                          <!-- /.image -->
                          <?php if($row['yeniurun'] == 1){ ?>
                          <div class="tag new"><span>Yeni</span></div>
						  <?php  }?>
                        </div>
                        <!-- /.product-image -->
                        
                        <div class="product-info text-left">
                          <h3 class="name">
							<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $name[$set['lang']['active']]; ?></a>
						  </h3>
                          <div class="rating rateit-small"></div>
                          <div class="description"></div>
                          <div class="product-price"> 
								<span class="price"> <?php echo number_format($urunfiyat,2); ?> TL</span>
								<?php if($ilkfiyat != 0.00 ){ ?>
								<span class="price-before-discount"><?php echo number_format($ilkfiyat,2);?> TL</span> 
								<?php } ?>
						  </div>
                          <!-- /.product-price --> 
                          
                        </div>
                        <!-- /.product-info -->

                        <!-- /.cart --> 
                      </div>
                      <!-- /.product --> 
                      
                    </div>
                    <!-- /.products --> 
                  </div>
                  <!-- /.item -->
				 <?php } // endforeach ?>
                
                </div>
                <!-- /.home-owl-carousel --> 
              </div>
              <!-- /.product-slider --> 
            </div>
            <!-- /.tab-pane -->
             <?php if($anakatsCount > 0 ){ 
			 foreach($anakatsFetch as $row) {
				 $tabsurun = $conn -> query("
					SELECT * FROM kategori_set
					INNER JOIN 
					urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($row['id'])."");
			 ?>
            <div class="tab-pane" id="s<?php echo $row['id']; ?>">
              <div class="product-slider">
		
				<?php if( $tabsurun -> rowCount() > 0){ ?>
				<div class="owl-carousel home-owl-carousel custom-carousel owl-theme">
					<?php foreach($tabsurun as $row){ 
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
							$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
							$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
							$urunfiyat =  number_format($degisim,2);
							$ilkfiyat  = number_format($row['yenifiyat'],2);
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
					}else{
						$urunfiyat = number_format($row['yenifiyat'],2);
						$ilkfiyat  = number_format($row['fiyat'],2);
					}
					?>
					<div class="item item-carousel">
						<div class="products">
						  <div class="product">
							<div class="product-image">
							  <div class="image"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt=""></a> </div>
							  <!-- /.image -->
							  <?php if($row['yeniurun'] == 1){ ?>
							  <div class="tag new"><span>Yeni </span></div>
								<?php  }?>
							</div>
							<!-- /.product-image -->
							<div class="product-info text-left">
							  <h3 class="name"><a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ofisimo Ürünleri</a></h3>
							  <div class="rating rateit-small"></div>
							  <div class="description"></div>
							  <div class="product-price">
									<span class="price"> <?php echo number_format($urunfiyat,2); ?> TL</span>
									<?php if($ilkfiyat != 0.00 ){ ?>
									<span class="price-before-discount"><?php echo number_format($ilkfiyat,2);?> TL</span> 
									<?php } ?>
							  </div>
							  <!-- /.product-price -->  
							</div>
							<!-- /.product-info -->

						  </div>
						  <!-- /.product --> 
						  
						</div>
						<!-- /.products --> 
					  </div>
					<?php } ?>
                  <!-- /.item --> 
                </div>
                <!-- /.home-owl-carousel --> 
				<?php  } ?>
              </div>
              <!-- /.product-slider --> 
            </div>
            <!-- /.tab-pane -->
			 <?php  } // endforeach ?> 
			<?php }  // endif ?>
            
          </div>
          <!-- /.tab-content --> 
        </div>
		<?php } ?>
        <!-- /.scroll-tabs --> 
        <!-- ============================================== SCROLL TABS : END ============================================== --> 
        <!-- ============================================== WIDE PRODUCTS ============================================== -->
        <?php if($anasayfaReklamlar1 -> rowCount() > 0) { ?>
		<div class="wide-banners wow fadeInUp outer-bottom-xs">
          <div class="row">
            <?php foreach($anasayfaReklamlar1 as $row){ 
				$name = unserialize($row['baslik']);
				$url = unserialize($row['url']);
			?>
			<div class="col-md-<?php echo $row['grid']; ?> col-sm-<?php echo $row['grid']; ?>">
              <div class="wide-banner cnt-strip">
                <div class="image"> 
					<a href="<?php echo $url[$set['lang']['active']]; ?>"  target="<?php echo $row['pencere'] == 0 ? '_self' :  '_target';  ?>" id="">
						<img class="img-responsive" style="width:100%" src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> 
					</a>
				</div>
              </div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col -->
			<?php  } ?>
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.wide-banners --> 
        <?php  } ?>
        <!-- ============================================== WIDE PRODUCTS : END ============================================== --> 
        <!-- ============================================== FEATURED PRODUCTS ============================================== -->
		<?php if($sizinicinnaktif -> rowCount() > 0){?>
       <?php if($secilenler -> rowCount() > 0){?>
	   <section class="section featured-product wow fadeInUp">
          <h3 class="section-title">Sizin İçin Seçtiklerimiz</h3>
          <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
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
							$degisim   = (number_format($row['yenifiyat'],2) / 100 ) * $uyebayi['fiyat'];
							$degisim   =  number_format($row['yenifiyat'],2) - $degisim;
							$urunfiyat =  number_format($degisim,2);
							$ilkfiyat  = number_format($row['yenifiyat'],2);
						}else{
							$urunfiyat = number_format($row['yenifiyat'],2);
							$ilkfiyat  = number_format($row['fiyat'],2);
						}
					}else{
						$urunfiyat = number_format($row['yenifiyat'],2);
						$ilkfiyat  = number_format($row['fiyat'],2);
					}
			 ?>
		    <div class="item item-carousel">
              <div class="products">
                <div class="product">
                  <div class="product-image">
                    <div class="image"> <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">
						<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"></a> 
					</div>
                    <!-- /.image -->
						<?php if($row['yeniurun'] == 1){ ?>
                          <div class="tag new"><span>Yeni</span></div>
						<?php  }?>
                  </div>
                  <!-- /.product-image -->
                  <div class="product-info text-left">
                    <h3 class="name"><a href="detail.html"><?php echo $name[$set['lang']['active']]; ?></a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>
                     <div class="product-price"> 
							<span class="price"> <?php echo number_format($urunfiyat,2); ?> TL</span>
							<?php if($ilkfiyat != 0.00 ){ ?>
							<span class="price-before-discount"><?php echo number_format($ilkfiyat,2);?> TL</span> 
							<?php } ?>
					 </div>
                    <!-- /.product-price --> 
                    
                  </div>
                  <!-- /.product-info -->
                 
                  <!-- /.cart --> 
                </div>
                <!-- /.product --> 
                
              </div>
              <!-- /.products --> 
            </div>
            <!-- /.item -->
			<?php   } ?>
           
          
          </div>
          <!-- /.home-owl-carousel --> 
        </section>
        <!-- /.section --> 
		<?php } ?>
		<?php } ?>
        <!-- ============================================== FEATURED PRODUCTS : END ============================================== --> 
        <!-- ============================================== WIDE PRODUCTS ============================================== -->
           <?php if($anasayfaReklamlar2 -> rowCount() > 0) { ?>
		<div class="wide-banners wow fadeInUp outer-bottom-xs">
          <div class="row">
            <?php foreach($anasayfaReklamlar2 as $row){ 
				$name = unserialize($row['baslik']);
				$url = unserialize($row['url']);
			?>
			<div class="col-md-<?php echo $row['grid']; ?> col-sm-<?php echo $row['grid']; ?>">
              <div class="wide-banner cnt-strip">
                <div class="image"> 
					<a href="<?php echo $url[$set['lang']['active']]; ?>"  target="<?php echo $row['pencere'] == 0 ? '_self' :  '_target';  ?>" id="">
						<img class="img-responsive" style="width:100%" src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"> 
					</a>
				</div>
              </div>
              <!-- /.wide-banner --> 
            </div>
            <!-- /.col -->
			<?php  } ?>
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.wide-banners --> 
        <?php  } ?>
        <!-- ============================================== WIDE PRODUCTS : END ============================================== --> 
        <!-- ============================================== BEST SELLER ============================================== -->
       
        <!-- /.sidebar-widget --> 
        <!-- ============================================== BEST SELLER : END ============================================== --> 
        
        <!-- ============================================== BLOG SLIDER ============================================== -->
		<?php if($blognaktif -> rowCount() > 0){?>
        <?php $blog = $conn -> query("select * from blog order by sira asc");?>
		<section class="section latest-blog outer-bottom-vs wow fadeInUp">
          <h3 class="section-title">Blogdan Son Yazılar</h3>
          <div class="blog-slider-container outer-top-xs">
            <?php if($blog -> rowCount() > 0 ){?>
			<div class="owl-carousel blog-slider custom-carousel">
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
			  <div class="item">
                <div class="blog-post">
                  <div class="blog-post-image">
                    <div class="image"> <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><img src="<?php echo $set['siteurl']; ?>/uploads/blog/thumb/<?php echo $resimler[0]; ?>" alt=""></a> </div>
                  </div>
                  <!-- /.blog-post-image -->
                  <div class="blog-post-info text-left">
                    <h3 class="name"><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>"><?php echo $baslik[$set['lang']['active']]; ?></a></h3>
                    <span class="info"> Eklenme Tarihi : &nbsp;|&nbsp; <?php echo tarih($haber['tarih'],$set['lang']['active']); ?></span>
                    <p class="text">	<?php echo html_entity_decode($giris[$set['lang']['active']]); ?></p>
                    <a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$haber['id']; ?>" class="lnk btn btn-primary">Devamını Oku</a> </div>
                  <!-- /.blog-post-info --> 
                  
                </div>
                <!-- /.blog-post --> 
              </div>
              <!-- /.item -->
					<?php  } ?>
            </div>
            <!-- /.owl-carousel --> 
			<?php  } ?>
          </div>
          <!-- /.blog-slider-container --> 
        </section>
      <?php  } ?>
      </div>
      <!-- /.homebanner-holder --> 
      <!-- ============================================== CONTENT : END ============================================== --> 
    </div>
    <!-- /.row --> 
    <!-- ============================================== BRANDS CAROUSEL ============================================== -->
    <?php $markalar = $conn -> query("select * from marka order by sira asc ");  ?>
	<?php if($markalar -> rowCount() > 0 ) { ?>

    <!-- /.logo-slider --> 
	<?php  } ?>
    <!-- ============================================== BRANDS CAROUSEL : END ============================================== --> 
  </div>
  <!-- /.container --> 
</div>
<!-- /#top-banner-and-menu --> 

<!-- ============================================================= FOOTER ============================================================= -->
<?php include("include/sabit/footer.php"); ?>
<!-- ============================================================= FOOTER : END============================================================= --> 
 <?php _footer(); ?>
<?php _footer_last(); ?>
 </body>
</html>