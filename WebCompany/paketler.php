    <?php 
    $title="Paketlerimiz"; 
    require_once 'header.php'; 
    $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
    $kullanicisor->execute(array(
        'mail' => $_SESSION['userkullanici_mail']
        ));
    $say=$kullanicisor->rowCount();
    $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
    ?>

    <!-- Start Page Hero -->
    <section class="page-hero">
        <div class="page-hero-parallax">

            <div class="hero-image bg-img-12">

                <div class="hero-container container pt50">  
                    <div class="hero-content text-left scroll-opacity"> 
                        <div class="section-heading">
                            <h1 class="white mb10 animated slideInDown">Paketlerimiz</h1>
                        <h5 class="white pl5 animated slideInUp"><?php echo $ayarcek['ayar_isim']; ?> </h5>  
                        </div>  
                        <ol class="breadcrumb">
                            <li><a href="index.php">Anasayfa</a></li>
                            <li style="color: #0CB4CE" class="active">Paketlerimiz</li>
                        </ol>
                    </div> 
                </div>  

            </div> 

        </div>
    </section>
    <!-- End Page Hero -->

    <div class="site-wrapper">            

        <!-- Start Price List -->
        <section id="price-list" class="bg-grey pt130 pb90">
            <div class="container">
                <div class="row"> 

                    <div class="col-md-3 price-list-box mt60 mb40">
                        <div class="price-box"> 
                            <div class="price-table">
                                <h3 class="label">Free</h3>
                                <p class="price"> 
                                    <sup class="currency">$</sup>
                                    <span class="pricing">0</span>
                                    <span class="time-period">Per Month</span>
                                </p>
                                <p class="features"> 
                                    <span class="feature"><strong>100GB</strong> Storage</span>
                                    <span class="feature"><strong>1GB</strong> Bandwidth</span>
                                    <span class="feature"><strong>Free</strong> Upgrades</span>   
                                </p>
                                <a class="button" href="#">SIGN UP NOW!</a>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-3 price-list-box mt40 mb40">
                        <div class="price-box"> 
                            <div class="price-table">
                                <h3 class="label">Starter</h3>
                                <p class="price"> 
                                    <sup class="currency">$</sup>
                                    <span class="pricing">10</span>
                                    <span class="time-period">Per Month</span>
                                </p>
                                <p class="features">
                                    <span class="feature"><strong>24/7</strong> Free Support</span>
                                    <span class="feature"><strong>100GB</strong> Storage</span>
                                    <span class="feature"><strong>1GB</strong> Bandwidth</span>
                                    <span class="feature"><strong>Free</strong> Upgrades</span>   
                                </p>
                                <a class="button" href="#">SIGN UP NOW!</a>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-3 featured price-list-box mt40 mb40">
                        <div class="price-box"> 
                            <div class="price-table">
                                <h3 class="label">Deluxe<span>Best Choice</span></h3>
                                <p class="price">
                                    <sup class="currency">$</sup>
                                    <span class="pricing">89</span>
                                    <span class="time-period">Per Month</span>
                                </p>
                                <p class="features">
                                    <span class="feature"><strong>24/7</strong> Free Support</span>
                                    <span class="feature"><strong>900GB</strong> Storage</span>
                                    <span class="feature"><strong>10GB</strong> Bandwidth</span>
                                    <span class="feature"><strong>Free</strong> Upgrades</span>
                                    <span class="feature"><strong>Unlimited</strong> M Dew</span> 
                                </p>
                                <div class="featured-button">
                                    <a class="button" href="#">SIGN UP NOW!</a>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 price-list-box mt40 mb40">
                        <div class="price-box"> 
                            <div class="price-table">
                                <h3 class="label">Advanced</h3>
                                <p class="price">
                                    <sup class="currency">$</sup>
                                    <span class="pricing">149</span>
                                    <span class="time-period">Per Month</span>
                                </p>
                                <p class="features">
                                    <span class="feature"><strong>24/7</strong> Free Support</span>
                                    <span class="feature"><strong>Unlimited</strong> Storage</span>
                                    <span class="feature"><strong>Unlimited</strong> Bandwidth</span>
                                    <span class="feature"><strong>Unlimited</strong> Twinkies</span>  
                                </p>
                                <a class="button" href="#">SIGN UP NOW!</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>        
        <!-- End Price List -->   
        <?  require_once 'footer.php'; ?>