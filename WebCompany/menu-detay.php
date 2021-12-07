<?php 
ob_start();
session_start();
require_once 'panel/netting/baglan.php';
require_once 'panel/app/ponki.php';

$menusor=$db->prepare("SELECT * from menu where menu_id=:menu_id");
$menusor->execute(array(
    'menu_id' => $_GET['menu_id']
));

$a=$menucek['menu_ad'];

$menucek=$menusor->fetch(PDO::FETCH_ASSOC);

$title=$menucek['menu_ad'];

$ozet=substr($menucek['menu_detay'], 2,280);

$anahtar=$menucek['menu_keyword'];


include 'header.php'; 



?>
<section class="page-hero">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-13">

            <div class="hero-container container pt50">  
                <div class="hero-content text-left scroll-opacity"> 
                    <div class="section-heading">
                        <h3 class="white mb10 animated slideInDown"><?php echo $menucek['menu_ad']; ?></h3>
                        <h5 class="white pl5 animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?></h5>  
                    </div>  
                    <ol class="breadcrumb animated slideInRight">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li style="color: #0CB4CE" class="active"><?php echo $menucek['menu_ad']; ?></li>
                    </ol>
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


                    <div class="col-md-12">
                      <h1 style="color: #0CB4CE; font-size: 26px;"> <?php echo $menucek['menu_ad']; ?></h1><br> 
                      <p><?php echo $menucek['menu_detay']; ?></p>
                      <div class="blog-widget blog-tags">
                        <ul class="tags-list">
                            <?php 

                            $etiketler=explode(', ',$menucek['menu_keyword']); 



                            foreach ($etiketler as $etiketbas) {?>
                            <li><a href="#"><?php echo $etiketbas; ?></a></li>
                            <?php }         
                            ?>
                        </ul>
                    </div> 
                </div>

            </div> 
                        
                    </div>
                </div>
            </section> 
    <?php require_once "footer.php" ?>
