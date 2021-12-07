<?php
ob_start();
session_start();
require_once 'panel/netting/baglan.php';
require_once 'panel/app/ponki.php';

$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
$hakkimizdasor->execute(array(0));
$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

$title="Hakkımızda";

$ozet=substr($hakkimizdacek['hakkimizda_icerik'], 2,280);


require_once "header.php";

?>

<div role="main" class="main">
	<section class="page-header mb-0">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 text-md-left">
					<h1 class="font-weight-bold">Hakkımızda</h1>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumb justify-content-md-end">
						<li><a href="index.php">Anasayfa</a></li>
						<li class="active">Hakkımızda</li>
					</ul>
				</div>
			</div>
		</div>
	</section>


	<section class="section">
		<div class="container pb-md-5 mb-lg-5">
			<div class="row justify-content-center pb-4">
				<div class="col-lg-10 text-center">
					<div class="appear-animation" data-appear-animation="fadeInUpShorter">
						<span class="top-sub-title text-color-primary">Kendimizden Bahsetmek Gerekirse</span>
						<h2 class="font-weight-bold"><?php echo $hakkimizdacek['hakkimizda_baslik']; ?></h2>
					</div>
					<p class="text-color-light-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400"><?php echo $hakkimizdacek['hakkimizda_icerik']; ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- NELER YAPIYORUZ VE RESIMLER BASLANGIC -->

	<section class="section section-content-pull-top pull-top-level-2 pull-top-always bg-primary">
		<div class="container">

			<!--RESIMLER BASLANGIC-->

			<div class="row py-5 mb-5 px-3 px-sm-0">
				<div class="col order-1 scale-1 p-0">
					<img src="img/others/work-5.png" class="img-fluid appear-animation" alt="" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1000" />
				</div>
				<div class="col order-5 scale-1 p-0">
					<img src="img/others/work-4.png" class="img-fluid appear-animation" alt="" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1000" />
				</div>
				<div class="col order-2 scale-2 p-0">
					<img src="img/others/work-3.png" class="img-fluid appear-animation" alt="" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="800" />
				</div>
				<div class="col order-4 scale-2 z-index-1 p-0">
					<img src="img/others/work-2.png" class="img-fluid appear-animation" alt="" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="800" />
				</div>
				<div class="col order-3 scale-3 z-index-2 p-0">
					<img src="img/others/work-1.png" class="img-fluid appear-animation" alt="" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" />
				</div>
			</div>

			<!-- RESIMLER SON -->

			<div class="spacer pt-sm-1 pt-md-4 pt-lg-5"></div>

			<!-- NELER YAPIYORUZ BASLANGIC-->

			<div class="row align-items-baseline mt-5">

				<?php 

				$yanmetinsor=$db->prepare("SELECT * FROM yanmetin where yanmetin_sira<3 order by yanmetin_sira ASC ");
				$yanmetinsor->execute(array());

				while($yanmetincek=$yanmetinsor->fetch(PDO::FETCH_ASSOC)) {

					$yanmetin_id=$yanmetincek['yanmetin_id'];
					?>


					<div class="col-lg-4">
						<div class="icon-box appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
							<div class="icon-box-icon pr-3"><i style="color: #000000" class="lnr lnr-<?php echo $yanmetincek['yanmetin_icon']; ?>"></i></div>
							<div class="icon-box-info">
								<h2 class="font-weight-bold text-color-light text-4 mb-3"><?php echo $yanmetincek['yanmetin_ad']; ?></h2>
								<p class="text-color-light"><?php echo $yanmetincek['yanmetin_detay']; ?></p>
							</div>
						</div>
					</div>

					<?php } ?>

					<?php 

					$yanmetinsor=$db->prepare("SELECT * FROM yanmetin where yanmetin_sira>2 order by yanmetin_sira ASC ");
					$yanmetinsor->execute(array());

					while($yanmetincek=$yanmetinsor->fetch(PDO::FETCH_ASSOC)) {


						?>

						<div class="col-lg-4">
							<div class="icon-box appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
								<div class="icon-box-icon pr-3"><i style="color: #000000" class="lnr lnr-<?php echo $yanmetincek['yanmetin_icon']; ?>"></i></div>
								<div class="icon-box-info">
									<h2 class="font-weight-bold text-color-light text-4 mb-3"><?php echo $yanmetincek['yanmetin_ad']; ?></h2>
									<p class="text-color-light" style="color: #fff"><?php echo $yanmetincek['yanmetin_detay']; ?></p>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</section>

			<!-- NELER YAPIYORUZ VE RESIMLER SON -->

		</div>


		<section class="section call-to-action bg-light-2 call-to-action-text-background">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-6">
						<div class="call-to-action-content text-left text-lg-left appear-animation" data-appear-animation="fadeInLeftShorter">
							<h2 class="font-weight-semibold">Misyonumuz</h2>
							<p class="font-weight-light mb-0"><?php echo $hakkimizdacek['hakkimizda_misyon']; ?></p>
						</div>
					</div>

					<div class="col-md-6 col-lg-6">
						<div class="call-to-action-content text-right text-lg-right appear-animation" data-appear-animation="fadeInLeftShorter">
							<h2 class="font-weight-semibold">Vizyonumuz</h2>
							<p class="font-weight-light mb-0"><?php echo $hakkimizdacek['hakkimizda_vizyon']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>



		<?php require_once 'footer.php'; ?>