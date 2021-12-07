<?php 
$title="Referanslarımız"; 
$ozet="Graptik olarak yaptığımız referans iş modellerinden birkaçını sizlerle paylaşmak istedik. Çünkü biliyoruz ki, bir kurumun kendini gösteren en önemli etken yapmış olduğu icraatleridir.";
$anahtar="web tasarım, grafik tasarım, yazılım, seo";
include 'header.php'; 

?>
<div role="main" class="main">
	<section class="page-header mb-0">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 text-md-left">
					<h1 class="font-weight-bold"><?php echo $ayarcek['ayar_isim']; ?> Olarak Yaptığımız Bazı Çalışmalar</h1>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumb justify-content-md-end">
						<li><a href="index.php">Anasayfa</a></li>
						<li class="active">Referanslar</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<div class="container mb-5 pb-3 pt-3">
		<div class="row justify-content-center mb-5">

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

                $referanssor=$db->prepare("select * from referans order by referans_id DESC");
                $referanssor->execute();

                while($referanscek=$referanssor->fetch(PDO::FETCH_ASSOC)) { ?>

			<div class="col-md-6 mt-3 col-lg-4 mb-5 mb-lg-0">
				<div class="card rounded bg-light border-0">
					<img width="600" height="250" alt="<?php echo $referanscek['referans_aciklama']; ?>" src="<?php echo $referanscek['referans_resimyol']; ?>" class="card-img-top">
					<div class="card-body">
						<a href="<?php echo $referanscek['referans_link']; ?>">
							<h4 class="font-weight-bold"><?php echo $referanscek['referans_ad']; ?></h4>
						</a>

						<p class="mt-3"><?php echo $referanscek['referans_aciklama']; ?></p>
					</div>
				</div>
			</div>

			<?php } ?>
		</div>
	</div>

</div>


<?php require_once 'footer.php'; ?>