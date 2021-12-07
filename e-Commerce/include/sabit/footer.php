<?php if( !defined("SABIT") ){ exit; } 
$footmoduller= $conn -> query("select * from modul where durum = 1 && footer = 1 order by sira asc");
 $sayfalar = $conn -> query("select * from sayfa order by sira asc") -> fetchAll();
 $sayfalar2 = $conn -> query("select * from sayfa order by sira asc") -> fetchAll();
$anakats          = $conn -> query("select * from kategori where modul = 'urunler' and ustid = 0 order by sira asc");
$anakatsCount     = $anakats->rowCount();
$anakatsFetch     = $anakats ->fetchAll();
 ?>

 <footer>
<div class="newsletter-block">
 <div class="container">
<div class="newsletter-wrap">

                <h4>E-Bülten</h4>
                <form for="exampleInputEmail1" method="post" action="#">
                  <div id="container_form_news">
                    <div id="container_form_news2">
                      <input type="text" class="input-text required-entry validate-email" value="Güncel Ürün Ve haberler için Kayıt Ol" onFocus=" this.value='' " title="Güncel Ürün Ve haberler için Kayıt Ol" id="exampleInputEmail1"  name="maillist">
                      <button class="button subscribe" title="Subscribe" id="mail-birak" type="submit"><span>Kayıt Ol</span> </button>
                    </div>
                  </div>
                </form>
              </div>
</div>
</div>
    <div class="footer-inner">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-xs-12 col-lg-8 col-md-8">
            <div class="footer-column pull-left">
              <h4>KURUMSAL</h4>
              <ul class="links">
               <?php foreach($sayfalar as $row) { 
				  $name  = unserialize($row['baslik']);
				  $sef   = unserialize($row['sef']);
				?>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_kurumsal_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]; ?>"><?php echo $name[$set['lang']['active']]?></a></li>
              <?php  } ?>
									
              </ul>
            </div>
            <div class="footer-column pull-left">
              <h4>HIZLI YÖNETİM</h4>
              <ul class="links">
                <li class="first"><a title="coppyright" href="/">Ana Sayfa</a> </li>
                <li><a title="Blog" href="tr/blogliste">Blog</a> </li>
                <li><a title="Sss" href="<?php echo $set['langurl']; ?>/<?php echo $sef_sss_link[$set['lang']['active']]; ?>">Sıkca Sorulan Sorular</a> </li>
                <li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_iletisim_link[$set['lang']['active']]; ?>">İletişim</a></li>
              </ul>
            </div>
            <div class="footer-column pull-left">
              <h4>MÜŞTERİ YÖNETİMİ</h4>
              <ul class="links">
                <li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>">Hesabım</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>">Sepetim</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>">Destek Sistemi</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>" target="_blank">Siparişlerim</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="footer-column-last">
              
              <div class="social">
                <h4>Sosyal Medyada Biz</h4>
                <ul class="link">
				
								<?php if(!empty($veriler['facebook'])){ ?>
								<li class="fb pull-left"> <a href="<?php echo $veriler['facebook'];?>"></a> </li>		
								<?php } ?>
								<?php if(!empty($veriler['twitter'])){ ?>
								<li class="tw pull-left"> <a href="<?php echo $veriler['twitter'];?>"></a> </li>
								<?php } ?>
								<?php if(!empty($veriler['google'])){ ?>
								<li class="googleplus pull-left"> <a href="<?php echo $veriler['google'];?>"></a> </li>
								<?php } ?>
								<?php if(!empty($veriler['pinterest'])){ ?>
								<li class="pintrest pull-left"> <a href="<?php echo $veriler['pinterest'];?>"></a> </li>
								<?php } ?>
								<?php if(!empty($veriler['linkedin'])){ ?>
								<li class="linkedin pull-left"> <a href="<?php echo $veriler['linkedin'];?>"></a> </li>
								<?php } ?>
                </ul>
              </div>
              <div class="payment-accept">
<h4>Ödeme Yöntemleri</h4>
                <div><img src="assets/tema/images/payment-1.png" alt="odeme yöntemleri"> <img src="assets/tema/images/payment-2.png" alt="odeme yöntemleri"> <img src="assets/tema/images/payment-3.png" alt="odeme yöntemleri"> <img src="assets/tema/images/payment-4.png" alt="odeme yöntemleri"> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-middle">
      <div class="container">
        <div class="row">
          <div style="text-align:center"> <a href="index.html"><img src="assets/images/footerlogo.png" alt="<?php echo $set['seo']['t']; ?>"> </a> </div>
		  <?php 
				$footUnx_adres   = unserialize($veriler['adres']);
				$footUnx_telefon = unserialize($veriler['telefon']);
				$footUnx_fax     = unserialize($veriler['faks']);
				$footUnx_mail    = unserialize($veriler['mail']);
				?>
          <address>
          <i class="fa fa-map-marker"></i> <?php echo reset($footUnx_adres)[1]; ?> <i class="fa fa-mobile"></i><span> <?php echo reset($footUnx_telefon)[1]; ?></span> <i class="fa fa-envelope"></i><span> <?php echo reset($footUnx_mail)[1]; ?></span>
          </address>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-5 col-xs-12 coppyright"><?php echo $anabaslik13[$set['lang']['active']]; ?>.</div>
        </div>
      </div>
    </div>
  </footer>
	</div>
<div id="mysepet" class="modal fade sepet-alert-content" role="dialog">
  <div class="modal-dialog fadeInDown animated">
    <!-- Modal content-->
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-body clearfix">
		<div class="alert-body">
			<div class="ci-icon-content">
				<i class="fa fa-check"></i>
			</div>
			<div class="ci-success-text">
				<?php echo $lang['yardimci']["eklendi"]; ?>
			</div>
			<div class="modal-buttons">
				<a href="/">Alışverişe Devam Et</a>
				<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>">Siparişi Tamamla</a>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="mobile-menu">
  <ul>
    <li>
      <div class="mm-search">
        <form>
                <input type="text" placeholder="Ürün Ara..." value="" maxlength="70" name="s" id="search">
                <button type="button" value="" name="s" class="search-btn-bg"></button>
              </form>
      </div>
    </li>
	 <li class="mega-menu"> <a class="level-top" href="/"><span>Ana Sayfa</span></a> </li>
		  <li class="level0 nav-6 level-top drop-menu"><a class="level-top" href="#"><span>Hakkımızda</span></a>
								<ul class="sub-menu">
								<?php foreach($sayfalar2 as $row) { 
				  $name  = unserialize($row['baslik']);
				  $sef   = unserialize($row['sef']);
				?>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_kurumsal_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]; ?>"><?php echo $name[$set['lang']['active']]?></a></li>
									<?php  } ?>
								</ul>
							</li>
							<?php 
			  function header_menu1($ustid){
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
								header_menu1($row['id']);
							echo '</li>';
						}
					echo '</ul>';
				}
			}
			   
			   
				
			   ?>
				<?php foreach($anakatsFetch  as $row) 	{
						$name      = unserialize($row['baslik']);
						$sef       = unserialize($row['sef']);	
						echo '<li class="level0 nav-6 level-top drop-menu"><a class="level-top" href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'"><span>'.$name[$set['lang']['active']].'</span></a> '; 
						header_menu1($row['id']);
						echo '</li>';
						}
				 ?>
		  <li><a title="Blog" href="tr/blogliste"><span>Blog</span></a> </li>
		  <li class="mega-menu"> <a class="level-top" href="tr/iletisim"><span>İletişim</span></a> </li>
</ul>
  <div class="top-links">
    <ul class="links">
      <li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>">Hesabım</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>">Sepetim</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>">Destek Sistemi</a></li>
				<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>" target="_blank">Siparişlerim</a></li>
				
      
    </ul>
  </div>
</div>	


<!--/sepetbox-->	