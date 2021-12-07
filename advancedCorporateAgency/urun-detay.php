<?php 

include 'header.php'; 


$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id");
$urunsor->execute(array(
    'urun_id' => $_GET['urun_id']
));

$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

$say=$urunsor->rowCount();

if ($say==0) {

    header("Location:index.php?durum=oynasma");
    exit;
}
?>

<section class="page-hero" style="height: 10%;">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-10">


        </div> 

    </div>
</section>



<div class="site-wrapper">

    <!-- Shop Product -->



    <section class="shop-product pt20 pb40">
        <div class="container"> 
            <div class="row">

                <div class="col-sm-5 mt40 mb40">

                    <div class="image-slider1 owl-carousel navigation-thin pagination-in">
                        <?php
                        $urun_id=$uruncek['urun_id'];
                        $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:urun_id order by urunfoto_sira ASC limit 1,3 ");
                        $urunfotosor->execute(array(
                            'urun_id' => $urun_id
                        ));

                        while($urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC)) {

                            ?>

                            <div><img src="<?php echo $urunfotocek['urunfoto_resimyol'] ?>" class="img-responsive width100" alt="#"></div>

                            <?php } ?>
                        </div> 

                    </div>  

                    <div class="col-sm-7 mt40 mb40 product-details">


                      <?php  

                      $urun_id=$uruncek['kategori_id']; 

                      $kategorisor=$db->prepare("select * from kategori where kategori_ust=:kategori_ust order by kategori_sira");
                      $kategorisor->execute(array(
                        'kategori_ust' => 0
                    ));

                      $kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);

                      ?>

                      <ol class="breadcrumb">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li><a href="kategori-<?=seo($kategoricek["kategori_ad"])?>"><?php echo $kategoricek['kategori_ad']; ?></a></li>
                        <li class="active"><?php echo $uruncek['urun_ad'] ?></li>
                    </ol>
                    <h3><?php echo $uruncek['urun_ad'] ?></h3>
                    <h4 class="price"><?php echo $uruncek['urun_fiyat'] ?> <span class="currency">TL</span><span class="old-price-single"><?php echo $uruncek['urun_fiyat']*1.50 ?> TL</span></h4>
                    <p><?php echo $uruncek['urun_detay'] ?></p> 

                    <hr>

                    <p class="mb0"><strong>Kategori:</strong> <a href="kategori-<?=seo($kategoricek["kategori_ad"])?>" class="highlight"><?php echo $kategoricek['kategori_ad']; ?></a></p>
                    <p class="mb0"><strong>Ürün Kodu:</strong> <span><?php echo $uruncek['urun_id']; ?></p>

                        <?php if (isset($_SESSION['userkullanici_mail'])) {?>

                        <form action="panel/netting/islem.php" method="POST">

                            <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>">

                            <input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id'] ?>">

                            <button type="submit" name="sepetekle"  class="btn btn-dark btn-md btn-appear">Şimdi Satın Al</button>

                        </form>


                        <?php } else {?>
                        <a href="register" class="btn btn-dark btn-lg btn-appear mt20"><span>Hemen Şimdi Üye Ol<i class="ion-android-arrow-forward"></i></span></a>
                        <?php } ?>

                    </div> 

                </div>
            </div>
        </section>
        <!-- End Shop Product -->

        <!-- Related Items -->  
        <section class="pb40">
            <div class="container">
                <div class="row white-bg">    

                    <div class="col-md-12 section-heading">
                        <h5><?php echo $kategoricek['kategori_ad']; ?> Kategorisinde</h5>
                        <h3>Diğer Web Yazılımlarımız</h3>
                    </div> 

                    <div class="pt80 pb20">

                        <ul class="shop-items portfolioContainer columns-4 margin"> 

                            <?php 

                            $kategori_id=$uruncek['kategori_id'];

                            $urunaltsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id order by  rand() limit 4");
                            $urunaltsor->execute(array(
                                'kategori_id' => $kategori_id
                            ));

                            while($urunaltcek=$urunaltsor->fetch(PDO::FETCH_ASSOC)) {

                                ?>

                                <li class="shop-item">
                                    <a href="urun-<?=seo($urunaltcek["urun_ad"]).'-'.$urunaltcek["urun_id"]?>">
                                        <div class="item">
                                            <img src="img/shop/5.jpg" alt="#">
                                            <h4 class="price"><?php echo $uruncek['urun_fiyat'] ?><span class="currency">- TL</span><span class="old-price"><?php echo $uruncek['urun_fiyat']*1.50 ?> TL</span></h4>
                                            <div class="info hover-bottom"> 
                                                <h4><?php echo $urunaltcek['urun_ad'] ?></h4>
                                                <p>Hemen İnceleyin</p>  
                                            </div>
                                        </div>
                                    </a>
                                </li>  

                                <?php } ?>


                            </ul> 

                        </div>

                    </div>
                </div>
            </section>            
            <!-- End Related Items -->  
            <?php require_once "footer.php" ?>
