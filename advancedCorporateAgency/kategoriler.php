<?php 
include 'header.php'; 

       $sayfada = 6; // sayfada gösterilecek içerik miktarını belirtiyoruz.
       $sorgu=$db->prepare("select * from kategori");
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



                     //aşağısı bir önceki default kodumuz...
       if (isset($_GET['sef'])) {


        $kategorisor=$db->prepare("SELECT * FROM kategori where kategori_seourl=:seourl");
        $kategorisor->execute(array(
         'seourl' => $_GET['sef']
     ));

        $kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);

        $kategori_id=$kategoricek['kategori_id'];


        $urunsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id order by urun_id DESC limit $limit,$sayfada");
        $urunsor->execute(array(
         'kategori_id' => $kategori_id
     ));

        $say=$urunsor->rowCount();

    } else {

        $urunsor=$db->prepare("SELECT * FROM urun order by urun_id DESC limit $limit,$sayfada");
        $urunsor->execute();

    }






    if ($toplam_icerik==0) {
        echo "Bu kategoride ürün bulunamadı";
    }




    ?>

    <!-- Start Page Hero -->
    <section class="page-hero">
        <div class="page-hero-parallax">

            <div class="hero-image bg-shortcodes">

                <div class="hero-container container pt50">  
                    <div class="hero-content text-left scroll-opacity"> 
                        <div class="section-heading">
                            <h3 class="white mb10 animated slideInDown">Web Yazılımlarımız</h3>
                            <h5 class="white pl5 animated slideInUp">Hazır scriptlerimiz ile yayına geçin</h5>  
                        </div>  
                        <ol class="breadcrumb animated slideInRight">
                            <li><a href="index.php">Anasayfa</a></li>
                            <li style="color: #0CB4CE" class="active">Web Yazılımlarımız</li>
                        </ol>
                    </div> 
                </div> 

            </div> 

        </div>
    </section>
    <!-- End Page Hero -->

    <div class="site-wrapper">

        <!-- Shop Section -->
        <section class="shop pt60 pb40">
            <div class="container">
                <div class="row white-bg">   

                    <p class="shop-result-count">Hepsini Gösteriliyor</p>

                    <span>Kategori:</span>
                    <select class="shop-sorting">

                      <?php

                $sayfada = 24; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from kategori");
                $sorgu->execute();
                $toplam_kategori=$sorgu->rowCount();

                $toplam_sayfa = ceil($toplam_kategori / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

          // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                if($sayfa < 1) $sayfa = 1; 

        // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                $limit = ($sayfa - 1) * $sayfada;

                $kategorisor=$db->prepare("select * from kategori order by kategori_id ASC limit $limit,$sayfada");
                $kategorisor->execute();

                while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) { ?>

                <a href="kategori-<?=seo($kategoricek["kategori_ad"])?>"><option><?php echo $kategoricek['kategori_ad']; ?></option></a>
                <?php } ?>    
            </select>     

            <ul class="shop-items portfolioContainer columns-3 margin">

             <?php

             while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {

                 $urun_id=$uruncek['urun_id'];
                 $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1 ");
                 $urunfotosor->execute(array(
                  'urun_id' => $urun_id
              ));

                 $urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
                 ?>
                 <li class="shop-item">
                    <a href="urun-<?=seo($uruncek["urun_ad"]).'-'.$uruncek["urun_id"]?>">
                        <div class="item">
                            <img src="img/shop/9.jpg" alt="#">
                            <h4 class="price"><?php echo $uruncek['urun_fiyat'] ?><span class="currency">- TL</span><span class="old-price"><?php echo $uruncek['urun_fiyat']*1.50 ?> TL</span></h4>
                            <div class="info hover-bottom"> 
                                <h4><?php echo $uruncek['urun_ad'] ?></h4>
                                <p>Detaylı İncele</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <?php } ?>


            </ul>

            <!-- Pagination -->
            <div class="col-md-12 text-center"> 
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class="ion-ios-arrow-thin-left"></i></span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="ion-ios-arrow-thin-right"></i></span>
                        </a>
                    </li>
                </ul> 
            </div>
            <!-- End Pagination -->

        </div>
    </div>
</section>            
<!-- End Shop Section -->  

<?php require_once 'footer.php'; ?>