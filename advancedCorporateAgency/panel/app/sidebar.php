    <div class="br-logo"><a href="index.php"><span>[</span>yönetimPaneli.<span>]</span></a></div>
    <div class="br-sideleft overflow-y-auto">

    	<label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">
    		Hoşgeldin <span style="color: #ffff"><?php echo $kullanicicek['kullanici_adsoyad']; ?></span>
    		<br><?php 

    		if ($kullanicicek['kullanici_yetki']==5) {
    			echo "Yetki: Yönetici";
    		} ?></label>

    		<label class="sidebar-label pd-x-15 mg-t-20"><br>Menu</label>

    		<div class="br-sideleft-menu">
    			<a href="index.php" class="br-menu-link">
    				<div class="br-menu-item">
    					<i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
    					<span class="menu-item-label">Anasayfa</span>
    				</div>
    			</a>


    			<a href="#" class="br-menu-link">
    				<div class="br-menu-item">
    					<i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    					<span class="menu-item-label">Ayarlar</span>
    					<i class="menu-item-arrow fa fa-angle-down"></i></div></a>
    					<ul class="br-menu-sub nav flex-column">
    						<li class="nav-item"><a href="genel-ayar.php" class="nav-link">Genel Ayarlar</a></li>
    						<li class="nav-item"><a href="iletisim-ayar.php" class="nav-link">İletişim Ayarlar</a></li>
    						<li class="nav-item"><a href="api-ayar.php" class="nav-link">API Ayarları</a></li>
    						<li class="nav-item"><a href="sosyal-ayar.php" class="nav-link">Sosyal Medya Ayarları</a></li>
    						<li class="nav-item"><a href="mail-ayar.php" class="nav-link">Mail Ayarları</a></li>
    					</ul>


    					<a href="#" class="br-menu-link">
    						<div class="br-menu-item">
    							<i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    							<span class="menu-item-label">Bilgilendirmeler</span>
    							<i class="menu-item-arrow fa fa-angle-down"></i></div></a>
    							<ul class="br-menu-sub nav flex-column">
    								<li class="nav-item"><a href="metin.php" class="nav-link">Slider Altı Metinler</a></li>
                    <li class="nav-item"><a href="yanmetin.php" class="nav-link">Ne Dediler?</a></li>
    								<li class="nav-item"><a href="sayac.php" class="nav-link">Sayaç - Counter</a></li>
    								<li class="nav-item"><a href="alan_bir.php" class="nav-link">Alan Ayarları</a></li>
    							</ul>

    							<a href="hakkimizda.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="menu-item-icon icon ion-ios-book-outline tx-24"></i>
    									<span class="menu-item-label">Hakkımızda</span>
    								</div>
    							</a>

    							<a href="slider.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="menu-item-icon icon ion-ios-photos-outline tx-24"></i>
    									<span class="menu-item-label">Slider İşlemleri</span>
    								</div>
    							</a>

    							<a href="menu.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="fa fa-bars" style="font-size: 20px;"></i>
    									<span class="menu-item-label">Menü İşlemleri</span>
    								</div>
    							</a>

    							<a href="kategori.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="fa fa-bars" style="font-size: 20px;"></i>
    									<span class="menu-item-label">Kategori İşlemleri</span>
    								</div>
    							</a>


    							<a href="urun.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="fa fa-shopping-basket" style="font-size: 20px;"></i>
    									<span class="menu-item-label">Ürün İşlemleri</span>
    								</div>
    							</a>


    							<a href="icerik.php" class="br-menu-link">
    								<div class="br-menu-item">
    									<i class="fa fa-file" style="font-size: 20px;"></i>
    									<span class="menu-item-label">Haber İşlemleri</span>
    								</div>
    							</a>



<!--
         <a href="sss.php" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-help-outline tx-24"></i>
            <span class="menu-item-label">Sık Sorulanlar</span>
          </div>
      </a>-->

      <a href="referans.php" class="br-menu-link">
      	<div class="br-menu-item">
      		<i class="fa fa-plus-square" style="font-size: 20px;"></i>
      		<span class="menu-item-label">Referans İşlemleri</span>
      	</div>
      </a>

        <!--<a href="galeri.php" class="br-menu-link">
          <div class="br-menu-item">
            <i class="fa fa-image" style="font-size: 20px;"></i>
            <span class="menu-item-label">Resim Galeri</span>
          </div>
        </a>

        <a href="video.php" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-videocam-outline tx-24"></i>
            <span class="menu-item-label">Video Galeri</span>
          </div>
      </a>-->

      <a href="kullanici.php" class="br-menu-link">
      	<div class="br-menu-item">
      		<i class="fa fa-user" style="font-size: 20px;"></i>
      		<span class="menu-item-label">Kullanıcılar</span>
      	</div>
      </a>

      <a href="yorum.php" class="br-menu-link">
      	<div class="br-menu-item">
      		<i class="fa fa-comment" style="font-size: 20px;"></i>
      		<span class="menu-item-label">Yorumlar</span>
      	</div>
      </a>

      <br></div></div>
  </div>