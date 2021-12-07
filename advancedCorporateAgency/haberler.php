<?php
$title="Haberler"; 
include 'header.php'; 

?>   
<section class="page-hero">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-13">

            <div class="hero-container container pt50">  
                <div class="hero-content text-left scroll-opacity"> 
                    <div class="section-heading">
                        <h1 class="white mb10 animated slideInDown">Haberler</h1>
                        <h5 class="white pl5 animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?> 'dan Haberler</h5>  
                    </div>  
                    <ol class="breadcrumb animated slideInRight">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li style="color: #0CB4CE" class="active">Haberler</li>
                    </ol>
                </div> 
            </div> 

        </div> 

    </div>
</section>

<div class="site-wrapper">

    <section class="pt80 pb50">
        <div class="container">
            <div class="row">

                <!-- Blog Content -->
                <div class="col-md-12 blog-mini-content">

                    <ul class="blog-mini">

                        <?php

                $sayfada = 4; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from icerik");
                $sorgu->execute();
                $toplam_icerik=$sorgu->rowCount();

                $toplam_sayfa = ceil($toplam_icerik / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

                // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                if($sayfa < 1) $sayfa = 1; 

                // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                $limit = ($sayfa - 1) * $sayfada;

                $iceriksor=$db->prepare("select * from icerik order by icerik_zaman DESC limit $limit,$sayfada");
                $iceriksor->execute();

                while($icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC)) { ?>
                <li> 
                    <div class="col-md-5">
                        <a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>"><img src="<?php echo $icerikcek['icerik_resimyol']; ?>" class="img-responsive width100" alt="#"></a>
                    </div>
                    <div class="col-md-7"> 
                        <a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>"><h4 style="color: #0CB4CE"><?php echo $icerikcek['icerik_ad']; ?></h4></a> 
                        <p class="blog-post-data"> 
                            <i class="ion-android-checkmark-circle"></i> <?php echo $icerikcek['icerik_zaman']; ?>
                        </p> 
                        <p><?php echo substr($icerikcek['icerik_detay'],0,300); ?>...</p>
                        <a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>" class="btn btn-xs btn-ghost">Devamını Oku</a>  
                    </div> 
                </li><hr>
                <?php } ?>


            </ul>    
        </div>
        <!-- End Blog Content -->

        <!-- Pagination -->
        <div class="col-md-12"> 
            <ul class="pagination">
                <?php

                $s=0;

                while ($s < $toplam_sayfa) {

                    $s++; ?>

                    <?php 

                    if ($s==$sayfa) {?>
                    <li class="active">
                        <a href="?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                    </li>

                    <?php } else {?>

                    <li>
                        <a href="?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                    </li>
                    <?php   }

                            }

                            ?>
                </ul> 
            </div>
            <!-- End Pagination -->

        </div>
    </div>
</section> 
<?php include 'footer.php'; ?>
