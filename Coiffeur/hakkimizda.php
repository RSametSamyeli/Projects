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