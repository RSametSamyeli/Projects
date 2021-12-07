<?php require_once 'header.php'; ?>

<div role="main" class="main">

	<?php require_once 'slider.php'; ?>


	<!-- SLIDER ALTI -->

	<section class="section pb-0">
		<div class="container">
			<div class="row text-center pb-2 mb-4">
				<div class="col">
					<div class="overflow-hidden">
						<span class="top-sub-title text-color-primary d-block appear-animation" data-appear-animation="maskUp">GRAPTIK OLARAK</span>
					</div>
					<div class="overflow-hidden">
						<h2 class="font-weight-bold appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">Hizmetlerimiz</h2>
					</div>
				</div>
			</div>
			<div class="row justify-content-center pb-5 mb-5">

				<?php 

				$metinsor=$db->prepare("SELECT * FROM metin order by metin_sira ASC limit 5 ");
				$metinsor->execute(array());

				while($metincek=$metinsor->fetch(PDO::FETCH_ASSOC)) {

					$metin_id=$metincek['metin_id'];
					?>

					<div class="col-9 col-sm-6 col-md-5 col-lg-4 col-xl-1-5 mb-4">
						<div class="card card-style-2 card-style-3 bg-light-5 border-0 text-center appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
							<div class="card-body p-4">
								<i class="lnr lnr-<?php echo $metincek['metin_icon']; ?> text-color-dark text-10"></i>
								<h3 class="font-weight-bold text-2 mt-2"><?php echo $metincek['metin_ad']; ?></h3>
							</div>
						</div>
					</div>

					<?php } ?>
				</div>
			</div>
		</section>
		<!--SLIDER ALTI SON-->

		<!-- VIDEO BASLANGIC -->

		<div class="section bg-dark-5 py-5 py-md-4 py-lg-5">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
							<span class="top-sub-title text-color-primary">GRAPTIK HAKKINDA</span>

							<?php 
							$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
							$hakkimizdasor->execute(array(0));
							$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

							?>

							<h2 class="word-rotator letters type font-weight-bold text-color-light text-5 mb-3">
								<span><?php echo $hakkimizdacek['hakkimizda_baslik']; ?></span> 
							</h2>
						</div>
						<p class="lead mb-3 appear-animation text-color-light-2" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">Graptik, profesyonel reklama ve web hizmetleri veren sade, hoş ve güçlü bir kuruluştur.</p>

						<p class="mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo substr($hakkimizdacek['hakkimizda_icerik'],0,550); ?>...</p>
						<br>
						<div class="d-block d-sm-inline-block text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">
							<a href="hakkimizda" class="btn btn-outline btn-rounded btn-primary text-color-light btn-v-3 btn-h-4 font-weight-bold mt-3 text-0">HAKKIMIZDA</a>
						</div><br>
					</div>
					<div class="col-md-5 ml-auto appear-animation" data-appear-animation="fadeInRightShorter">
						<div class="card card-style-4 border-0 absolute-y-center">
							<div class="image-frame rounded">
								<span class="image-frame-wrapper">
									<img src="images/video-resim.jpg" class="card-img-top rounded" alt="" />
									<span class="image-frame-info image-frame-info-show flex-column align-items-center">
										<a href="<?php echo $hakkimizdacek['hakkimizda_video']; ?>m">
											<span class="icon-box icon-box-style-4 hover-anim hover-anim-effect-1">
												<span class="icon-box-icon bg-primary">
													<i class="fas fa-play text-5"></i>
												</span>
											</span>
										</a>
									</span>
								</span>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- VIDEO SON -->


		<!--Neler Yapıyoruz Başlangıç-->
		<section id="neler" class="section">
			<div class="container">
				<div class="row text-center mt-4">
					<div class="col">
						<div class="overflow-hidden">
							<span class="top-sub-title text-color-primary d-block appear-animation" data-appear-animation="maskUp">GRAPTIK OLARAK</span>
						</div>
						<div class="overflow-hidden mb-3">
							<h2 class="font-weight-bold mb-3 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">Neler Yapıyoruz?</h2>
						</div>

					</div>
				</div>
				<div class="row">

					<div class="col-md-10 col-lg-4 mx-auto mt-lg-5 mt-xl-4 pt-xl-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">

						<?php 

						$yanmetinsor=$db->prepare("SELECT * FROM yanmetin where yanmetin_sira<3 order by yanmetin_sira ASC ");
						$yanmetinsor->execute(array());

						while($yanmetincek=$yanmetinsor->fetch(PDO::FETCH_ASSOC)) {

							$yanmetin_id=$yanmetincek['yanmetin_id'];
							?>

							<div class="icon-box icon-box-style-4 mb-4 mb-lg-4 text-md-right">

								<div class="icon-box-info">
									<div class="icon-box-info-title">
										<h3 class="text-3"><?php echo $yanmetincek['yanmetin_ad']; ?></h3>
									</div>
									<p><?php echo $yanmetincek['yanmetin_detay']; ?></p>
								</div>
								<div class="icon-box-icon bg-primary ml-3">
									<i class="lnr lnr-<?php echo $yanmetincek['yanmetin_icon']; ?>"></i>
								</div>
							</div>

							<?php } ?>
						</div>

						<!-- ORTADAKI RESIM-->

						<div class="col-md-10 col-lg-4 text-center mx-auto my-4 mt-lg-5 mt-xl-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300">
							<img src="images/orta.png" class="img-fluid" alt="" />
						</div>

						<!-- ORTADAKI RESIM SON -->

						<div class="col-md-10 col-lg-4 mx-auto mt-lg-5 mt-xl-4 pt-xl-3 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">

							<?php 

							$yanmetinsor=$db->prepare("SELECT * FROM yanmetin where yanmetin_sira>2 order by yanmetin_sira ASC ");
							$yanmetinsor->execute(array());

							while($yanmetincek=$yanmetinsor->fetch(PDO::FETCH_ASSOC)) {


								?>

								<div class="icon-box icon-box-style-4 mb-4 mb-lg-4">
									<div class="icon-box-icon bg-primary">
										<i class="lnr lnr-<?php echo $yanmetincek['yanmetin_icon'];?>"></i>
									</div>
									<div class="icon-box-info">
										<div class="icon-box-info-title">
											<h3 class="text-3"><?php echo $yanmetincek['yanmetin_ad'];?></h3>
										</div>
										<p><?php echo $yanmetincek['yanmetin_detay'];?></p>
									</div>
								</div>

								<?php } ?>

							</div>
						</div>
					</div>
				</section>

				<!-- NELER YAPIYORUZ SON-->


				<section class="section call-to-action bg-light-5 call-to-action-text-light call-to-action-text-background">

					<div class="container">
						<div class="row text-center mt-4">
							<div class="col">
								<div class="overflow-hidden">
									<span class="top-sub-title text-color-primary d-block appear-animation" data-appear-animation="maskUp">HABERLER</span>
								</div>
								<div class="overflow-hidden mb-3">
									<h2 class="font-weight-bold mb-3 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">BLOG</h2>
								</div>

							</div>
						</div>
						<div class="container mb-5 pb-3 pt-3">
							<div class="row justify-content-center mb-5">

								<?php 

								$iceriksor=$db->prepare("SELECT * FROM icerik where icerik_durum=:icerik_durum and icerik_onecikar=:icerik_onecikar order by icerik_id desc limit 6");
								$iceriksor->execute(array(
									'icerik_durum' => 1,
									'icerik_onecikar' => 1

								));

								while ($icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC)){ ?>

								<div class="col-md-6 mt-3 col-lg-4 mb-5 mb-lg-0">
									<div class="card rounded bg-light border-0">
										<img width="600" height="250" src="<?php echo $icerikcek['icerik_resimyol']; ?>" class="card-img-top" alt="">
										<div class="card-body">
											<a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>">
												<h4 class="font-weight-bold"><?php echo $icerikcek['icerik_ad']; ?>
												</h4>
											</a>
											<span class="top-sub-title"><?php echo $icerikcek['icerik_zaman']; ?>
											</span>

											<p class="mt-3"><?php echo substr($icerikcek['icerik_detay'],0,150); ?>...</p>
										</div>
									</div>
								</div>

								<?php } ?>
							</div>
						</div>
					</section>

					<!-- Footer Üstü Arama Section Başlangıç -->

					<section class="section call-to-action bg-primary call-to-action-text-light call-to-action-text-background">
						<span class="text-background text-color-light font-primary font-weight-bold appear-animation" data-appear-animation="textBgFadeInUp" data-appear-animation-delay="800">GRAPTIK</span>
						<div class="container">
							<div class="row">
								<div class="col-md-9 col-lg-9">
									<div class="call-to-action-content text-center text-lg-left appear-animation" data-appear-animation="fadeInLeftShorter">
										<h2 class="font-weight-semibold">Hemen Şuanda Bize Ulaşın!</h2>
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

					<!-- Arama Section Son -->
				</div>
				
				<?php require_once 'footer.php'; ?>