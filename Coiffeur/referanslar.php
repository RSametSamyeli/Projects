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

	
</div>
</div>
</div>
</section>

<!-- ÜRÜNLER SAYFASI SON -->

</div>


<?php require_once 'footer.php'; ?>