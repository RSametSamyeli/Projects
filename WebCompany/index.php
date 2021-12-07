<?php require_once 'header.php'; ?>

<?php require_once 'slider.php'; ?>


<div class="site-wrapper">  

   <!-- Start Features -->  
   <section id="features">
    <div class="container">                      
        <div class="row">

            <div class="col-md-12 text-center section-heading mb20">
                <h5>Merhaba Biz <?php  echo $ayarcek['ayar_isim']; ?></h5>
                <h3 class="underline-center">Neler Yapıyoruz?</h3>
            </div>  

            <?php 

            $metinsor=$db->prepare("SELECT * FROM metin order by metin_sira ASC ");
            $metinsor->execute(array());

            while($metincek=$metinsor->fetch(PDO::FETCH_ASSOC)) {

                $metin_id=$metincek['metin_id'];
                ?>


                <div class="col-md-4 col-sm-6 mt30 mb30">
                    <div class="feature-icon">
                        <i class="ion-<?php echo $metincek['metin_icon']; ?> size-2x highlight"></i>
                        <i class="ion-<?php echo $metincek['metin_icon']; ?> back-icon"></i>
                    </div>
                    <div class="feature-info">
                        <h4><?php echo $metincek['metin_ad']; ?></h4>
                        <p><?php echo $metincek['metin_detay']; ?></p>
                    </div>
                </div>

                <?php } ?>



            </div>
        </div>
    </section>
    <!-- End Features -->  

    <!-- Start About --> 
    <section class="pt70 pb70 static bg-img-4"> 
        <div class="container">
            <div class="vertical-align">
                <?php 
                $hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
                $hakkimizdasor->execute(array(0));
                $hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

                ?>
                <div class="col-md-6 text-left section-heading mt40 mb40">
                    <h5 class="mt10">Kendimizden Bahsetmek Gerekirse</h5>
                    <h3 class="underline-left"><b>Hakkımızda</b></h3>          
                    <p><?php echo substr($hakkimizdacek['hakkimizda_icerik'],0,550); ?>...</p>
                    <a class="btn btn-primary mt-xl mb-sm" style="float: right;" href="hakkimizda">Devamını Oku <i class="fa fa-angle-right pl-xs"></i></a>
                </div>

                <div class="col-md-6 mt40 mb40">
                    <div class="video-container"> 
                        <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $hakkimizdacek['hakkimizda_video']; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End About Section -->  

            <!-- Ne Dediler -->   
            <section id="testimonials" class="pt130 pb90 parallax bg-img-8"> 
                <div class="container">
                    <div class="row">

                        <div class="col-md-12 text-center section-heading">
                            <img src="img/assets/quotes-color.png" alt="ne dediler" class="img-responsive quote-logo">
                            <h5 class="white">MÜŞTERİLERİMİZ BİZİM HAKKIMIZDA</h5>
                            <h3 class="underline-center white">Ne Dediler?</h3> 
                        </div>

                        <div class="col-md-8 col-md-offset-2 text-center">
                            <div id="owl-testimonials" class="owl-carousel light-pagination">
<?php 

                            $yanmetinsor=$db->prepare("SELECT * FROM yanmetin where yanmetin_sira order by yanmetin_sira ASC ");
                            $yanmetinsor->execute(array());

                            while($yanmetincek=$yanmetinsor->fetch(PDO::FETCH_ASSOC)) {

                                $yanmetin_id=$yanmetincek['yanmetin_id'];
                                ?>
                                <!-- Testimonial 1 -->
                                <div class="testimonial-slide">
                                    <p><?php echo $yanmetincek['yanmetin_detay']; ?></p>
                                    <h4 class="highlight"><?php echo $yanmetincek['yanmetin_ad']; ?></h4>
                                </div> 
<?php } ?>
                                

                            </div>
                        </div> 

                    </div>
                </div>
            </section>

    <!-- Start Fun Facts Section -->
    <section class="pt10">
     <div class="container">

         <div class="counter-row row text-center wow fadeInUp">

             <?php 

             $sayacsor=$db->prepare("SELECT * FROM sayac order by sayac_sira ASC ");
             $sayacsor->execute(array());

             while($sayaccek=$sayacsor->fetch(PDO::FETCH_ASSOC)) {

                $sayac_id=$sayaccek['sayac_id'];
                ?>
                <div class="col-md-3 col-sm-6 fact-container">
                 <div class="fact">
                     <span class="counter highlight"><?php echo $sayaccek['sayac_detay']; ?></span>
                     <h4><?php echo $sayaccek['sayac_ad']; ?></h4>
                     <!--<p>Sibh <span class="highlight">vulputate</span> vivamus</p>-->
                 </div>
             </div>
             <?php } ?>
<span><h1></h1></span>




         </div> 

     </div>
 </section>
 <!-- End Fun Facts Section --> 


 <section id="portfolio-agency">   
    <ul class="portfolioContainer columns-3 nomargin mb0 white-hovers" style="position: relative; height: 592.938px; opacity: 1;">

     <?php 

     $referanssor=$db->prepare("SELECT * FROM referans where referans_onecikar=:referans_onecikar  limit 6");
     $referanssor->execute(array(
        'referans_onecikar' => 1

    ));
    while ($referanscek=$referanssor->fetch(PDO::FETCH_ASSOC)){ ?>

    <li class="photography branding" style="position: absolute; left: 0px; top: 0px;">
     <a href="<?php echo $referanscek['referans_resimyol']; ?>" class="gallery-item">
         <div class="item">
             <img src="<?php echo $referanscek['referans_resimyol']; ?>" alt="<?php echo $referanscek['referans_ad']; ?> Çalışması">
             <div class="info hover-bottom"> 
                 <h4><?php echo $referanscek['referans_ad']; ?></h4>
                 <p><?php echo $referanscek['referans_aciklama']; ?></p>  
             </div>
         </div>
     </a>
 </li>   

 <?php } ?>
</ul> 
</section>



<section class="pt50 pb50">
    <div class="container">
        <div class="row"> 

            <div class="col-md-12 text-center section-heading mb20">
                <h3 class="underline-center">Blog</h3>
            </div>  


            <?php 

            $iceriksor=$db->prepare("SELECT * FROM icerik where icerik_durum=:icerik_durum and icerik_onecikar=:icerik_onecikar order by icerik_id desc limit 3");
            $iceriksor->execute(array(
                'icerik_durum' => 1,
                'icerik_onecikar' => 1

            ));

            while ($icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC)){ ?>
            <div class="col-md-4 mb30" style="max-height: 367px;">
                <a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>" class="a-box box-hover">
                    <div class="box bg-grey"> 
                        <h5><?php echo $icerikcek['icerik_ad']; ?></h5> 
                        <h3><small><?php echo substr($icerikcek['icerik_ozet'],0,50); ?></small></h3>
                        <p><?php echo substr($icerikcek['icerik_detay'],0,150); ?>...</p>  
                    </div>
                </a>
            </div> 
            <?php } ?>


        </div>
    </div>
</section>




<!-- Get Connected -->
<section id="get-connected" class="pt100 pb90 parallax bg-img-3 bg-overlay"> 
    <div class="container">
        <div class="row">

            <div class="col-md-12 text-center section-heading">
                <h5 class="mt10 white">En iyi yaptığımız işi biliyoruz ve onu yapıyoruz.</h5>
                <h1 style="font-family: 'Poiret One', cursive;" class=" underline-center white"><strong><?php echo $ayarcek['ayar_il']; ?> Web Tasarım</strong></h1>
                <h6 class="white" style="font-weight: normal; font-size: 16px;"><em><?php echo $ayarcek['ayar_isim']; ?></em> ailesi olarak, ödüllü kadromuz ile merkezimiz <?php echo $ayarcek['ayar_il']; ?>'dan yurtişi ve yurtdışına hizmetler veriyoruz.</h6> 


            </div>  


        </div>
    </div>
</section>
<!-- End Get Connected -->  




<section id="subscribe" class="pt50 pb20">
 <div class="container">
     <div class="row text-center">

         <div class="col-md-12 section-heading mb40">
             <i class="icon-heart size-6x highlight"></i>

             <h3 class="mb20 highlight underline-center"><small>Bizi Arayın</small></h3>


             <h3><a class="highlight" href="tel:05051563083">505 156 30 83</a></h3>

             <p><?php echo $ayarcek['ayar_slogan']; ?> düşüncesi ile profesyonel çözüm ortağınız olmaya hazırız. </p>

         </div>
     </div>
 </div>
</section>   

<?php require_once 'footer.php'; ?>