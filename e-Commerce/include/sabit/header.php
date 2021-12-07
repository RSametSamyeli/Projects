<?php if( !defined("SABIT") ){ exit; } 
include('ajax/yazi/extrayazi.php');
$anakats1          = $conn -> query("select * from kategori where vitrin = 1 and modul = 'urunler' and ustid = 0 order by sira asc");
$anakats1Count     = $anakats1->rowCount();
$anakats1Fetch     = $anakats1 ->fetchAll();
$anakats          = $conn -> query("select * from kategori where modul = 'urunler' and ustid = 0 order by sira asc");
$anakatsCount     = $anakats->rowCount();
$anakatsFetch     = $anakats ->fetchAll();
$aktifdil 	   = $conn -> query("select dilismi from dil where dilurl = '".$_SESSION["lang"]."'")->fetch();
$encokSatanlar = $conn -> query("select * from urun order by sira asc limit 6");
$tumUrunler    = $conn -> query("select * from urun order by sira asc limit 6");
$sayfalar = $conn -> query("select * from sayfa order by sira asc") -> fetchAll();
?>
<script type="text/javascript">
	var AJAX_URL	 = "<?php echo $set['siteurl']; ?>"; 
	var warningtitle = "Hata"; 
	var successtitle = "Başarılı";
	var secimyapiniz = "Seçim Yapınız";
	var bilgilerguncellendi  = "Bilgiler Başarıyla Güncellendi Yönlendiriliyorsunuz";
	var bilgilereklendi  = "Bilgiler  Başarıyla Eklendi Yönlendiriliyorsunuz";
	var yetersizstok	 = "Stok Miktarı Yetersiz";
	var yetersizkredi	 = "Kredi Miktarınız Bulunmamaktadır.";
	var talepeklendi 	 = "Talep Başarıyla Eklendi";
	var odemeeklendi     = "Ödeme Formu Başarıyla Gönderilmiştir."
	var hesapok  	     = "<?php echo $lang['mesaj']["guncelleme_ok"]; ?>";	
	var basarilicikis    = "Başarıyla Çıkış Yaptınız";
	var hesapok  	     = "<?php echo $lang['mesaj']["guncelleme_ok"]; ?>";	
	var yorumok 	     = "Yorumunuz Admin Onayından Sonra Yayınlanacaktır.";
	var profil_url       = "<?php echo $set['langurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>";
</script>

<header>
    <div class="header-container">
      <div class="header-top">
        <div class="container">
          <div class="row"> 
            <!-- Header Language -->
            <div class="col-xs-12 col-sm-6">
              <!-- End Header Currency -->
              <div class="welcome-msg"> <?php echo $anabaslik4[$set['lang']['active']]; ?> </div>
            </div>
            <div class="col-xs-6 hidden-xs"> 
              <!-- Header Top Links -->
              <div class="toplinks">
                <div class="links">
                  <div class="demo"><a title="Blog" href="tr/blogliste"><span class="hidden-xs">Blog</span></a> </div>
                  <!-- Header Company -->
				  <?php if(!isset($_SESSION["m_oturum"])) {  ?>
                  <div class="dropdown block-company-wrapper hidden-xs"> <a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle" href="#"> Üye İşlemleri <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li role="presentation"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_uyelik_link[$set['lang']['active']]; ?>"> Giriş Yap </a> </li>
                      <li role="presentation"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_uyelik_link[$set['lang']['active']]; ?>"> Kayıt Ol </a> </li>
                    </ul>
                  </div>
				  <?php  } else { 
			$uyeCek = $conn -> query("SELECT * FROM users WHERE id = ".intval($_SESSION["m_id"]))->fetch();
			?>
			
			 <div class="dropdown block-company-wrapper hidden-xs"> <a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle" href="#"> Hoş Geldin <?php echo $uyeCek['ad']. " " .$uyeCek['soyad']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                     <li role="presentation"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_hesap_link[$set['lang']['active']]; ?>"><i class="fa fa-cog"></i><?php echo $sef_hesap_baslik[$set['lang']['active']]; ?></a></li>
					<li role="presentation"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sifre_link[$set['lang']['active']]; ?>"><i class="fa fa-lock" aria-hidden="true"></i><?php echo $sef_sifre_baslik[$set['lang']['active']]; ?> </a></li>
					<li role="presentation"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>"><i class="fa fa-list" aria-hidden="true"></i><?php echo $sef_siparislerim_baslik[$set['lang']['active']]; ?></a></li>
					<li role="presentation"><a href="#" class="log-out"><i class="fa fa-sign-in"></i><?php echo $lang['yardimci']['cikis']; ?></a></li>
                    </ul>
                  </div>
			
			<?php } ?>
                  <!-- End Header Company -->
                  
                  <div class="login"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>"><span class="hidden-xs">Kasaya Git</span></a> </div>
                </div>
              </div>
              <!-- End Header Top Links --> 
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 header-phone">
           <i class="fa fa-mobile"></i>  <?php echo $anabaslik5[$set['lang']['active']]; ?>
          </div>
          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12 logo-block"> 
            <!-- Header Logo -->
            <div class="logo"> <a title="<?php echo $set['seo']['t']; ?>" href="<?php echo $set['siteurl']; ?>"><img alt="<?php echo $set['seo']['t']; ?>" src="<?php echo $set['siteurl']; ?>/uploads/logo/logo.png"> </a> </div>
            <!-- End Header Logo --> 
          </div>
          
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 hidden-xs">
            <div class="search-box">
              <form>
                <input type="text" placeholder="Ürün Ara..." value="" maxlength="70" name="s" id="search">
                <button type="submit" value="" name="s" class="search-btn-bg"><span class="glyphicon glyphicon-search"></span>&nbsp;</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- end header --> 
  
  <!-- Navigation -->
  
  <nav>
    <div class="container">
      <div class="mm-toggle-wrap">
        <div class="mm-toggle"><i class="fa fa-align-justify"></i><span class="mm-label">Menu</span> </div>
      </div>
      <div class="nav-inner"> 
        <!-- BEGIN NAV -->
        <ul id="nav" class="hidden-xs">
          <li class="level0 parent drop-menu" id="nav-home"><a href="<?php echo $set['siteurl']; ?>" class="level-top"><i class="fa fa-home"></i><span class="hidden">Ana Sayfa</span></a>
          </li>
		  <li class="level0 nav-6 level-top drop-menu"><a class="level-top" href="#"><span>Hakkımızda</span></a>
								<ul class="sub-menu">
								<?php foreach($sayfalar as $row) { 
				  $name  = unserialize($row['baslik']);
				  $sef   = unserialize($row['sef']);
				?>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_kurumsal_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]; ?>"><?php echo $name[$set['lang']['active']]?></a></li>
									<?php  } ?>
								</ul>
							</li>
		  <?php 
			  function header_menu($ustid){
				global $conn,$set,$sef_urunler_link;
				$katsorgu = $conn -> query("select * from kategori where modul = 'urunler' and ustid = ".intval($ustid)." order by sira asc");	
				$katsorguCount = $katsorgu -> rowCount();
				if($katsorguCount > 0){
					echo '<ul class="level1">';
						foreach($katsorgu as $row){
							$name      = unserialize($row['baslik']);
							$sef       = unserialize($row['sef']);
							$altmenu = $conn -> query("select * from kategori where ustid = '".intval($row['id'])."'");
							echo '<li '; 
							if($altmenu  -> rowCount() > 0){
								echo ' class="has"';
							}
							echo '><a href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'">'.$name[$set['lang']['active']].' </a> ';
								header_menu($row['id']);
							echo '</li>';
						}
					echo '</ul>';
				}
			}
			   
			   
				
			   ?>
				<?php foreach($anakats1Fetch  as $row) 	{
						$name      = unserialize($row['baslik']);
						$sef       = unserialize($row['sef']);	
						echo '<li class="level0 nav-6 level-top drop-menu"><a class="level-top" href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'"><span>'.$name[$set['lang']['active']].'</span></a> '; 
						header_menu($row['id']);
						echo '</li>';
						}
				 ?>
		  <li class="mega-menu"> <a class="level-top" href="tr/iletisim"><span>İletişim</span></a> </li>
        </ul>
        <!--nav--> 
<div class="top-cart-contain pull-right"> 
              <!-- Top Cart -->
              <div class="mini-cart">
                <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> <a href="shopping_cart.html"> <span class="cart_count"><?php echo count(@$_SESSION["sepet"]); ?></span> </a> </div>
                <div>
                  <div class="top-cart-content"> 
                    
                    <!--block-subtitle-->
                    <ul class="mini-products-list" id="cart-sidebar">
					<?php if(count(@$_SESSION["sepet"]) > 0) {?>
					<?php 
						$genelToplam = 0;
						foreach(@$_SESSION["sepet"] as $row) {
						
						$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
						$varyant = $row['varyant'];
							if(count($varyant) > 0) {	 
								$defvarPlus   = 0;
								$defvarMinus  = 0;
								$varAra 	  = $row['arafiyat'];
								$varAra       = str_replace(",","",$varAra);
								for($i = 0; $i < count($varyant['varBaslik']); $i++) {
									$varTutar = $varyant['varTutar'][$i];
									$varTur   = $varyant['varTur'][$i];
										if($varTur == 1){
											$defvarPlus  += $varTutar;
										}
										if($varTur == 0){
											$defvarMinus  += $varTutar;
										}	
								}
								$varAra = $varAra + $defvarPlus;
								$varAra = $varAra - $defvarMinus;
								$birimfiyat = $varAra;
							} else {
								$birimfiyat = $row['arafiyat'];
							}
							$genelToplam += $row['adet'] * $birimfiyat;
						$sef   = unserialize($urunCek['sef']);
					?>
                      <li class="item first">
                        <div class="item-inner"> <a class="product-image" title="<?php echo $row['baslik']; ?>" href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['sepetid']; ?>"><img alt="<?php echo $row['baslik']; ?>" src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>"> </a>
                          <div class="product-details">
                            
                            <!--access--><strong><?php echo $row['adet']; ?></strong> x <span class="price"><?php echo $birimfiyat; ?><?php echo $lang['yardimci']['tl']; ?></span>
                            <p class="product-name"><a href="#"><?php echo $row['baslik']; ?></a> </p>
                          </div>
                        </div>
                      </li>
					  <?php  } ?> 
                     <?php 
							
							$anaTutar =    number_format($genelToplam,2);
							?>
									<div class="mini-cart-total  clearfix">
										<strong class="pull-left title18">Sepet Toplamı</strong>
										<span class="pull-right color title18"><?php echo $anaTutar; ?> TL</span>
									</div>
									
									<?php } else{ ?>
									<li>
						<div class="sepet-yok">
							<?php echo $lang['yardimci']['sepeturunyok']?>
						</div>
					</li>
								<?php }  ?>	
                    </ul>
                    
                    <!--actions-->
                    <div class="actions">
					  <a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>" class="btn-checkout" title="Checkout" type="button"><span>Sepete Git</span></a>	
					</div>
                  </div>
                </div>
              </div>
              <!-- Top Cart -->
              <div id="ajaxconfig_info" style="display:none"> <a href="#/"></a>
                <input value="" type="hidden">
                <input id="enable_module" value="1" type="hidden">
                <input class="effect_to_cart" value="1" type="hidden">
                <input class="title_shopping_cart" value="Go to shopping cart" type="hidden">
              </div>
            </div>
      </div>
    </div>
  </nav>
  <!-- end nav --> 
    </header>

				  
