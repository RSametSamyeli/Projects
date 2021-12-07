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

<!-- Start Page Hero -->
<section class="page-hero">
    <div class="page-hero-parallax">

        <div class="hero-image bg-img-5">

            <div class="hero-container container pt50">  
                <div class="hero-content text-left scroll-opacity"> 
                    <div class="section-heading">
                        <h1 class="white mb10 animated slideInDown">Yaratıcı Ekip</h1>
                        <h5 class="white animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?> - <?php echo $ayarcek['ayar_slogan']; ?></h5>  
                    </div>  
                    <ol class="breadcrumb animated slideInRight">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li style="color: #0CB4CE" class="active">Hakkımızda</li>
                    </ol>
                </div> 
            </div>  

        </div> 

    </div>
</section>
<!-- End Page Hero -->

<div class="site-wrapper">            

    <!-- Start About Video Section --> 
    <section class="pt50 pb50"> 
        <div class="container">  
            <div class="row-flex-center">

                <div class="col-md-6 text-left pr30 mt40 mb20">  
                    <div class="section-heading">  
                        <h5 class="pl3">Kendimizden Bahsetmek Gerekirse</h5>
                        <h3 class="underline-left"><?php echo $hakkimizdacek['hakkimizda_baslik']; ?></h3>  
                    </div>
                    <p><?php echo $hakkimizdacek['hakkimizda_icerik']; ?></p> 
                </div>

                <div class="col-md-6 mt40 mb40"> 
                    <div class="video-container">
                        <iframe width="200" height="113" src="https://www.youtube.com/embed/<?php echo $hakkimizdacek['hakkimizda_video']; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End About Video Section -->


    <!-- Start Skills --> 
    <section class="bg-grey pt70 pb70"> 
        <div class="container">   
            <div class="row-flex-center">

                <div class="col-md-5 text-left pr30 mt40 mb40">
                 <div class="progress-bars-3">
                    <p>Web Tasarım</p>
                    <div class="progress white" data-percent="98%">
                        <div class="progress-bar">
                            <span class="progress-bar-tooltip">98%</span>
                        </div>
                    </div>
                    <p>Grafik Tasarım</p>
                    <div class="progress white" data-percent="100%">
                        <div class="progress-bar progress-bar-primary">
                            <span class="progress-bar-tooltip">100%</span>
                        </div>
                    </div>
                    <p>Arama Motoru Optimizasyonu</p>
                    <div class="progress white" data-percent="90%">
                        <div class="progress-bar progress-bar-primary">
                            <span class="progress-bar-tooltip">90%</span>
                        </div>
                    </div>
                    <p>Sunucu Sistemleri</p>
                    <div class="progress white" data-percent="92%">
                        <div class="progress-bar progress-bar-primary">
                            <span class="progress-bar-tooltip">92%</span>
                        </div>
                    </div>  
                </div>
            </div>

            <div class="col-md-7  mt60 mb40 text-right">  
                <div class="section-heading animated fadeInRight">  
                    <h5 class="pl3">Muhteşem</h5>
                    <h3 class="underline-right mt5">Yeteneklerimiz</h3>  
                </div>
                <p>Senelerden itibaren yurtiçi ve yurtdışı gibi çalışmalardan kazandığımız ödüller ve yaptığımız işler sayesinde kendimizi ispatladığımız sektörler hakkında düşüncelerimiz.</p> 
            </div>

        </div>
    </div>
</section>
<!-- End Skills --> 

<section class="pt40 pb30 parallax bg-img-3 bg-overlay"> 
    <div class="container">
        <div class="row">

            <div class="col-md-12 text-center section-heading">
                <h3 style="font-family: 'Poiret One', cursive;" class=" underline-center white">Misyonumuz</h3>
                <h6 class="white" style="font-weight: normal; font-size: 16px;"><?php echo $hakkimizdacek['hakkimizda_misyon']; ?></h6> 
            </div>  

        </div>
    </div>
</section>



<!-- Team Section -->
<section class="pt130 pb90"> 
    <div class="container">    
        <div class="row text-center">  

            <div class="col-md-12 text-center section-heading mb50">  
                <h5>Mucizeler Yaratan </h5>
                <h3 class="underline-center">Takımımızla Tanışın</h3> 
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="team-member">
                    <div class="team-member-image white-bg">
                        <img src="img/team/samet.jpg" class="img-responsive" alt="">
                        <div class="team-member-detail hover-top">   
                         <p class="highlight underline-center">Süleyman Demirel Üniversitesi</p>
                     </div>
                 </div>
             </div>
             <div class="member-info">
                <h4>Samet Samyeli
                    <small>Back End Developer</small>
                </h4>   
            </div>
        </div>            

        <div class="col-md-3 col-sm-6">
            <div class="team-member">
                <div class="team-member-image white-bg">
                    <img src="img/team/hilal.jpg" class="img-responsive" alt="">
                    <div class="team-member-detail hover-top">   
                        <p class="highlight underline-center">Boğaziçi Üniversitesi</p>
                    </div>
                </div>
            </div>
            <div class="member-info">
                <h4>Hilal Efe
                    <small>Graphic Designer</small>
                </h4>   
            </div>
        </div>            

        <div class="col-md-3 col-sm-6">
            <div class="team-member">
                <div class="team-member-image white-bg">
                    <img src="img/team/deniz.jpg" class="img-responsive" alt="">
                    <div class="team-member-detail hover-top">   
                       <p class="highlight underline-center">Akdeniz Üniversitesi</p>
                   </div>
               </div>
           </div>
           <div class="member-info">
            <h4>Deniz Korkmaz
                <small>UI/UX Designer</small>
            </h4>   
        </div>
    </div>            

    <div class="col-md-3 col-sm-6">
        <div class="team-member">
            <div class="team-member-image white-bg">
                <img src="img/team/osman.jpg" class="img-responsive" alt="">
                <div class="team-member-detail hover-top">   
                    <p class="highlight underline-center">Süleyman Demirel Üniversitesi</p>
                </div>
            </div>
        </div>
        <div class="member-info">
            <h4>Osman Çetinkaya
                <small>Front-End Developer</small>
            </h4>   
        </div>
    </div>            


</div>  
</div>
</section>
<!-- End Team Section -->



<!-- Clients Section -->
<section class="pt20 pb70">
    <div class="container"> 
        <div class="row">    

            <div id="clients-slider-2" class="owl-carousel dark-pagination">
                <div><img src="img/clients/1.jpg" class="img-responsive" alt="#"></div>  
                <div><img src="img/clients/2.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/3.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/4.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/5.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/6.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/7.jpg" class="img-responsive" alt="#"></div> 
                <div><img src="img/clients/8.jpg" class="img-responsive" alt="#"></div> 
            </div>

        </div>
    </div>
</section>
<!-- End Clients -->    

<?php require_once "footer.php" ?>