    <?php 
    $title="İletişim Sayfası"; 
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

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/1.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>19.99<span class="old-price">26.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>The Over Shirt</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li>  

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/2.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>13.99<span class="old-price">20.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Script Sweatshirt</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/3.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>16.99<span class="old-price">22.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Splatter Tank Top</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/4.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>12.99<span class="old-price">25.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Consume T-Shirt</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/5.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>15.99<span class="old-price">27.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Script Tank Top</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/6.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>18.99<span class="old-price">23.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>The Deadline</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/7.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>14.99<span class="old-price">20.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Dark Shirt Logo</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/8.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>17.99<span class="old-price">29.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Nowhere T-Shirt</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

                <li class="shop-item">
                    <a href="shop-product.html">
                        <div class="item">
                            <img src="img/shop/9.jpg" alt="#">
                            <h4 class="price"><span class="currency">$</span>12.99<span class="old-price">21.95</span></h4>
                            <div class="info hover-bottom"> 
                                <h4>Ping Sweatshirt</h4>
                                <p>View Details</p>  
                            </div>
                        </div>
                    </a>
                </li> 

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