  <?php 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

    exit("Bu sayfaya erişim yasak");

}

?>
        <!-- Hero Slider -->
        <section class="hero-fullscreen">
            <div class="hero-slider hero-parallax-fullscreen owl-carousel navigation-thin">


                <?php 

                $slidersor=$db->prepare("select * from slider where slider_durum=? order by slider_sira limit 25");
                $slidersor->execute(array(1));

                while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <!-- Slide 1 -->
                    <div class="slide samet-<?php $say=rand(1,6); echo $say; ?>"> 
                        <div class="hero-container container">  
                            <div class="hero-content scroll-opacity"> 
                                <div class="appear container text-center"> 
                                    <p class="subheading white mt90"><?php echo $ayarcek['ayar_slogan']; ?></p>  
                                    <h2 style="font-size: 40px;" class="heading white mb5"><?php echo $slidercek['slider_ad']; ?></h2>     
                                    <p class="white hidden-xs"><?php echo $slidercek['slider_aciklama']; ?></p>
                                    <a href="hakkimizda" class="btn btn-md btn-ghost-white btn-scroll mt60 hidden-xs">Hakkımızda</a>
                                    <a href="#features" class="scroll-btn"><i class="ion-chevron-down"></i></a>
                                </div>
                            </div> 
                        </div>   
                    </div>
                    <!-- End Slide 1 -->
    <?php } ?>
                </div>
            </section>
            <!-- End Hero Slider -->
