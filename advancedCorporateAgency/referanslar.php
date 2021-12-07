<?php 
$title="Referanslarımız"; 
$ozet="Izbarco.com olarak yaptığımız referans iş modellerinden birkaçını sizlerle paylaşmak istedik. Çünkü biliyoruz ki, bir kurumun kendini gösteren en önemli etken yapmış olduğu icraatleridir.";
$anahtar="web tasarım, grafik tasarım, yazılım, seo, ısparta web tasarım, referanslar";
include 'header.php'; 

?>

<section class="page-hero">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-10">

            <div class="hero-container container pt50">  
                <div class="hero-content text-left scroll-opacity"> 
                    <div class="section-heading">
                        <h1 class="white mb10 animated slideInDown">Referanslar</h1>
                        <h5 class="white pl5 animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?> Olarak Yaptığımız Bazı Çalışmalar</h5>  
                    </div>  
                    <ol class="breadcrumb animated slideInRight">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li style="color: #0CB4CE" class="active">Referanslar</li>
                    </ol>
                </div> 
            </div> 

        </div> 

    </div>
</section>

<div class="site-wrapper"> 

	<!-- Portfolio Section -->
	<section class="pt40 pb60">
		<div class="container">
			<div class="row"> 

				

				<ul class="portfolioContainer columns-2 margin">


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

                <li class="photography video"><a target="_blank" href="<?php echo $referanscek['referans_link']; ?>">
                	<div>
                		<div class="item">
                			<img src="<?php echo $referanscek['referans_resimyol']; ?>" alt="<?php echo $referanscek['referans_aciklama']; ?>">
                			<div class="info hover-bottom"> 
                				<h4><?php echo $referanscek['referans_ad']; ?></h4>
                				<p class="date"><?php echo $referanscek['referans_aciklama']; ?></p>
                			</div>
                		</div>
                	</div></a>
                </li>  
                <?php } ?>


            </ul>

        </div>
    </div>
</section>            
<!-- End Portfolio Section --> 

<?php include 'footer.php'; ?>
