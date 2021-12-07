<?php 
ob_start();
session_start();
require_once 'panel/netting/baglan.php';
require_once 'panel/app/ponki.php';

$iceriksor=$db->prepare("SELECT * from icerik where icerik_id=:icerik_id");
$iceriksor->execute(array(
    'icerik_id' => $_GET['icerik_id']
));

$a=$icerikcek['icerik_ad'];

$icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC);

$title=$icerikcek['icerik_ad'];

$ozet=substr($icerikcek['icerik_ozet'], 0,280);

$anahtar=$icerikcek['icerik_keyword'];

$resim=$icerikcek['icerik_resimyol'];

$link=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];



include 'header.php'; 

?>
<section class="page-hero">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-13">

            <div class="hero-container container pt50">  
                <div class="hero-content text-left scroll-opacity"> 
                    <div class="section-heading">
                        <h3 class="white mb10 animated slideInDown"><?php echo $icerikcek['icerik_ad']; ?></h3>
                        <div class="p15 animated slideInUp">
                            <a style="color: #FFFFFF" href="index.php">Anasayfa</a> /
                            <a style="color: #FFFFFF" href="haberler">Haberler</a> /
                            <span style="color: #0CB4CE" class="active"><?php echo $icerikcek['icerik_ad']; ?></span>
                        </div>
                    </div>  
                </div> 
            </div> 

        </div> 

    </div>
</section>

<div class="site-wrapper">

    <section class="pt50 pb50">
        <div class="container">
            <div class="row">

                <!-- Blog Content -->

                <div class="blog-post"> 


                    <div class="col-md-8">
                      <h1 style="color: #0CB4CE; font-size: 26px;"> <?php echo $icerikcek['icerik_ad']; ?></h1><br> 
                      <span class="author"><strong>Tarih:</strong> <?php echo $icerikcek['icerik_zaman']; ?></span>   
                      <br><br>
                      <p><?php echo $icerikcek['icerik_detay']; ?></p>
                      <div class="blog-widget blog-tags">
                        <ul class="tags-list">
                            <?php 

                            $etiketler=explode(', ',$icerikcek['icerik_keyword']); 



                            foreach ($etiketler as $etiketbas) {?>
                            <li><a href="#"><?php echo $etiketbas; ?></a></li>
                            <?php }         
                            ?>
                        </ul>
                    </div> 
                </div>

                <div class="col-md-4">
                    <div class="mb20">
                        <img style="border-radius: 10px;" src="<?php echo $icerikcek['icerik_resimyol']; ?>" class="img-responsive width100 animated slideInUp" alt="<?php echo $icerikcek['icerik_ad']; ?>" >
                    </div>
                </div>
            </div> 


                      
                        
                    </div>
                </div>
            </section> 
            <?php include 'footer.php'; ?>
