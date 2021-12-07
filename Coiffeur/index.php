
<?php require_once 'header.php'; ?>

<div role="main" class="main">

	<?php require_once 'slider.php'; ?>


	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
						<span class="top-sub-title text-color-primary">KENDIMIZDEN BAHSETMEK GEREKIRSE</span>

						<?php 
						$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
						$hakkimizdasor->execute(array(0));
						$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

						?>
						<h2 class="word-rotator letters type font-weight-bold text-5 mb-3">
							<span>HAKKIMIZDA</span> 
						</h2>
					</div>
					<p class="mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo substr($hakkimizdacek['hakkimizda_icerik'],0,550); ?>...</p>

					<div class="d-block d-sm-inline-block text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">
						<a href="hakkimizda.php" class="btn btn-outline btn-rounded btn-primary btn-v-3 btn-h-4 font-weight-bold mt-3 text-0">HAKKIMIZDA</a>
					</div>
				</div>
				<div class="col-10 col-md-5 mx-auto ml-md-auto appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
					<div class="particles d-flex align-items-center pr-0 pr-lg-3 pr-xl-5">
						<svg class="svg-particles d-none d-sm-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 493.72 405.79">
							<g class="g-particles g-particles-group-1 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="500">
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="150.28" y1="108.35" x2="159.03" y2="102.1"/>
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="325.51" y1="118.98" x2="334.26" y2="112.73"/>
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="483.33" y1="94.52" x2="492.08" y2="88.27"/>
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="321.14" y1="279.22" x2="329.89" y2="272.97"/>
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="148.47" y1="279.22" x2="157.22" y2="272.97"/>
								<line class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" x1="11.14" y1="305.17" x2="19.89" y2="298.92"/>
							</g>
							<g class="g-particles g-particles-group-2 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="800">
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M51.78,105.64s-.37-12.75,5.25-3.5.38,7.13,0,7.13" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M229.34,103.24s-.37-12.75,5.25-3.5.38,7.12,0,7.12" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M401,103.24s-.37-12.75,5.25-3.5.38,7.12,0,7.12" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M401,274.1s-.37-12.75,5.25-3.5.38,7.13,0,7.13" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M227.33,276.14s-.37-12.75,5.25-3.5.38,7.13,0,7.13" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M55.49,276.14s-.37-12.75,5.25-3.5.38,7.13,0,7.13" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M97.76,41.59s-2.5,4.83,2.83,2.33.67,2.67.67,2.67" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M448.14,22.85s-2.5,4.83,2.83,2.33.67,2.67.67,2.67" transform="translate(-3.14 -1.85)"/>
								<path class="cls-1" fill="none" stroke="#969da0" stroke-miterlimit="10" d="M246,44.18s.1,5.85,4.41-.28,2.26,1.66,2.26,1.66" transform="translate(-3.14 -1.85)"/>
							</g>
							<g class="g-particles g-particles-group-3 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="1100">
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="4.77" cy="151" r="1.14" transform="translate(-108.51 45.76) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="149.72" cy="30.16" r="1.14" transform="translate(19.39 112.85) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="304.7" cy="3.48" r="1.14" transform="translate(83.64 214.63) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="495.22" cy="155.04" r="1.14" transform="translate(32.28 393.74) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="315.2" cy="163.8" r="1.14" transform="translate(-26.64 269.01) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="153.42" cy="344.7" r="1.14" transform="translate(-201.94 207.59) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="249.61" cy="406" r="1.14" transform="translate(-217.11 293.57) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="313.32" cy="336.94" r="1.14" transform="translate(-149.62 318.39) rotate(-45)"/>
								<circle class="cls-2" fill="#969da0" stroke="#969da0" cx="148.58" cy="172.2" r="1.14" transform="translate(-81.38 153.65) rotate(-45)"/>
							</g>
							<g class="g-particles g-particles-group-4 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="1400">
								<polyline class="cls-3" fill="none" stroke="#969da0" points="200.87 18.34 197.2 18.34 199.03 21"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="179.66 368.64 180.47 364.7 176.12 365.86"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="369.87 368.64 370.67 364.7 366.31 365.86"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="369.31 5.73 371.83 1.9 367.27 1.65"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="217.7 153.19 210.32 153.19 214.01 158.56"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="385.03 153.19 377.66 153.19 381.34 158.56"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="385.03 324.15 377.66 324.15 381.34 329.52"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="213.01 324.15 205.64 324.15 209.32 329.52"/>
								<polyline class="cls-3" fill="none" stroke="#969da0" points="52.35 324.15 44.98 324.15 48.66 329.52"/>
							</g>
							<g class="g-particles g-particles-group-5 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="1700">
								<path class="cls-4" fill="none" stroke="#969da0" d="M264.48,188.12s-4,8.83,3.33,6.17,5.67-.5,5.67-.5-1.33,3.67-2.17,3.5" transform="translate(-3.14 -1.85)"/>
								<path class="cls-4" fill="none" stroke="#969da0" d="M444.52,179.07s-4,8.83,3.33,6.17,5.67-.5,5.67-.5-1.33,3.67-2.17,3.5" transform="translate(-3.14 -1.85)"/>
								<path class="cls-4" fill="none" stroke="#969da0" d="M94.23,196.91s-4,8.83,3.33,6.17,5.67-.5,5.67-.5-1.33,3.67-2.17,3.5" transform="translate(-3.14 -1.85)"/>
								<path class="cls-4" fill="none" stroke="#969da0" d="M92.81,369.86s-2.63,6.55,2.19,4.57,3.73-.37,3.73-.37-.88,2.72-1.43,2.6" transform="translate(-3.14 -1.85)"/>
								<path class="cls-4" fill="none" stroke="#969da0" d="M269.94,368.71c.06-.09,3.2,5.44,4.68,2,2-4.8,2.54-2.76,2.54-2.76s1.15,2.61.66,2.89" transform="translate(-3.14 -1.85)"/>
							</g>
							<g class="g-particles g-particles-group-6 appear-animation" data-appear-animation="expandParticles" data-appear-animation-delay="2000">
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="8.58 76.55 13.71 78.42 12.58 72.8"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="8.58 228.65 13.71 230.53 12.58 224.9"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="178.55 238.99 183.68 240.86 182.55 235.24"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="349.47 240.53 354.59 242.4 353.47 236.78"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="338.72 402.28 343.84 404.15 342.72 398.53"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="147.72 399.46 152.84 401.34 151.72 395.71"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="482.39 209.27 485.95 213.4 487.71 207.94"/>
								<polyline class="cls-5" fill="#969da0" stroke="#969da0" points="349.58 66.58 354.83 68.06 353.29 62.54"/>
							</g>
						</svg>
						<div style="z-index: 0" class="particles-rect bg-primary d-none d-md-block" data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 4, 'transition': true}"></div>
						<img style="z-index: 1" src="images/digital/first.jpg" class="img-fluid" alt="" data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 4, 'horizontal': true, 'transition': true}" />
					</div>
				</div>
			</div>
		</div>
	</section>



	<section class="section call-to-action bg-primary call-to-action-text-light call-to-action-text-background">
		<span class="text-background text-color-light font-primary font-weight-bold appear-animation" data-appear-animation="textBgFadeInUp" data-appear-animation-delay="800">UGURLAYIK</span>
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-lg-9">
					<div class="call-to-action-content text-center text-lg-left appear-animation" data-appear-animation="fadeInLeftShorter">
						<h2 class="font-weight-semibold">Hemen Şimdi Randevu Alın!</h2>
						<p class="font-weight-light mb-0">Hizmetlerimizden faydalanmak için bizi hemen şimdi arayın.</p>
					</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="call-to-action-btn appear-animation" data-appear-animation="fadeInRightShorter">

						<!--Arama Butonu-->

						<a href="tel:<?php echo $ayarcek['ayar_gsm'] ?>" target="_blank" class="btn btn-light btn-outline btn-rounded font-weight-semibold btn-h-3 btn-v-3 text-0">Şimdi Ara<strong class="font-weight-semibold"><i class="fas fa-phone"></i></strong></a>

						<!-- /*/ -->
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="section section-content-pull-top-2">
		<div class="container pb-4 appear-animation" data-appear-animation="fadeInUpShorter">
			<div class="row mt-3">
				<div class="col">
					<div class="row text-center">
						<div class="col">
							<span class="top-sub-title text-color-primary">KUAFORUM UGUR LAYIK</span>
							<h2 class="font-weight-bold">Hizmetlerimiz</h2>
							<p class="lead mb-5 pb-xlg">Vermiş olduğumuz Hizmetler</p>
						</div>
					</div>
					<div class="row align-items-baseline">
						<?php 

						$metinsor=$db->prepare("SELECT * FROM metin order by metin_sira ASC limit 6 ");
						$metinsor->execute(array());

						while($metincek=$metinsor->fetch(PDO::FETCH_ASSOC)) {

							$metin_id=$metincek['metin_id'];
							?>
							<div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300" data-plugin-options="{'accY' : -50}">
								<h3 class="font-weight-bold d-flex align-items-center text-2 pl-1 mb-2">
									<i class="lnr lnr-<?php echo $metincek['metin_icon']; ?> text-color-primary mr-3"></i>
									<?php echo $metincek['metin_ad']; ?>
								</h3>
								<p>	<?php echo $metincek['metin_detay']; ?></p>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!--ÜRÜNLER SAYFASI -->
		<section class="section bg-light-5">
			<div class="container">
				<div class="row text-center">
					<div class="col">
						<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-duration="700ms">
							<span class="top-sub-title text-color-primary"></span>
							<h2 class="font-weight-bold">MÜŞTERİLERİMİZ</h2>
						</div>
						<p class="lead appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">Bizden memnun kalan müşterilerimiz</p>
					</div>
				</div>
				<div class="row align-items-center mb-4">
					<div class="col-md-8 col-lg-9 appear-animation" data-appear-animation="fadeInLeftShorter">
						<ul id="portfolioLoadMoreFilter" class="nav sort-source justify-content-center justify-content-md-start mb-4 mb-md-0" data-sort-id="portfolio" data-option-key="filter" data-plugin-options="{'layoutMode': 'fitRows', 'filter': '*'}"></ul>
					</div>

				</div>
				<div class="row">
					<div class="col-12">
						<div class="sort-destination-loader sort-destination-loader-showing mb-4">
							<div id="portfolioLoadMoreWrapper" class="portfolio-list sort-destination" data-sort-id="portfolio" data-ajax-url="ajax/portfolio-overlay-ajax-load-more.html" data-total-pages="3">
								<?php

                $sayfada = 24; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from referans");
                $sorgu->execute();
                $toplam_referans=$sorgu->rowCount();

                $toplam_sayfa = ceil($toplam_referans / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

			    // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                if($sayfa < 1) $sayfa = 1; 

				// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                $limit = ($sayfa - 1) * $sayfada;

                $referanssor=$db->prepare("select * from referans order by referans_id DESC limit 6");
                $referanssor->execute();

                while($referanscek=$referanssor->fetch(PDO::FETCH_ASSOC)) { ?>
<!-- ÜRÜNLER KULLANIMI BURADA BAŞLIYOR
	Listelenmesini göstermek amacıyla isotope.js kütüphanesini kullandım.
	Yukarıda li'lerin içinde ki data-option-value değerinin karşısında ki target burada eşleniyor.
	isotope-item'den sonra ki değer target değeridir.-->

	<div class="col-md-6 col-lg-4 p-0 isotope-item bft">
		<div class="portfolio-item hover-effect-3d appear-animation" data-appear-animation="fadeInUpShorter" data-plugin-options="{'accY' : -50}">
			
			<span class="image-frame image-frame-style-1 image-frame-effect-1">
				<span class="image-frame-wrapper">
					<img src="<?php echo $referanscek['referans_resimyol']; ?>" class="img-fluid" alt="">
					<span class="image-frame-inner-border"></span>
					<span class="image-frame-action">
						<span class="image-frame-action-icon">
							<i class="lnr lnr-link text-color-light"></i>
						</span>
					</span>
				</span>
			</span>
			
		</div>
	</div>

	<?php } ?>
</div>
</div>
</div>
<div class="col-12 d-flex justify-content-center">
	<div id="portfolioLoadMoreLoader" class="portfolio-load-more-loader">
		<div class="bounce-loader">
			<div class="bounce1"></div>
			<div class="bounce2"></div>
			<div class="bounce3"></div>
		</div>
	</div>

	<button id="portfolioLoadMore" type="button" class="btn btn-primary btn-rounded btn-wide-5 btn-icon-effect-2 outline-none font-weight-semibold text-0">
		<a style="color: #ffffff" href="referanslar"><span>DAHA FAZLA GÖR</span></a>
		<i class="fas fa-ellipsis-h"></i>
	</button>
</div>
</div>
</div>
</section>

<!-- ÜRÜNLER SAYFASI SON -->





</div>


<?php require_once 'footer.php'; ?>