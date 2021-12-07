    <?php 
    $title="Sepet"; 
    require_once 'header.php'; 
    $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
    $kullanicisor->execute(array(
        'mail' => $_SESSION['userkullanici_mail']
    ));
    $say=$kullanicisor->rowCount();
    $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
    

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

    ?>

    <!-- Start Page Hero -->
    <section class="page-hero">
        <div class="page-hero-parallax">

            <div class="hero-image bg-shop">

                <div class="hero-container container pt50">  
                    <div class="hero-content text-left scroll-opacity"> 
                        <div class="section-heading">
                            <h1 class="white mb10">Shoping Cart</h1>
                            <h5 class="white pl5">Save Up To 70% Off Sale</h5>  
                        </div>  
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Shop</a></li>
                            <li class="active">Cart</li>
                        </ol>
                    </div> 
                </div> 

            </div> 

        </div>
    </section>
    <!-- End Page Hero -->

    <div class="site-wrapper">

        <!-- Cart -->
        <section class="cart pt60 pb60">
            <div class="container"> 
                <div class="row">

                    <div class="col-sm-9 mt40 mb40">

                        <h4 class="bag-summary mb20">Your Items</h4>
                        <table class="shop_table cart" cellspacing="0">

                            <thead>
                                <tr>
                                    <th class="product-name">Description</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-subtotal">Subtotal</th>
                                    <th class="product-remove">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr class="cart_item">
                                    <td class="product-name">
                                        <a href="#">Dot Socks</a> 
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">$16</span> 
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">$32</span> 
                                    </td>
                                    <td class="product-remove">
                                        <a href="#" class="remove" title="Remove this item">×</a> 
                                    </td>
                                </tr> 
                            </tbody>

                        </table>  
                        <form class="coupon mb-xs-24">
                            <h5>Add a coupon code:</h5>
                            <input class="coupon-code" type="text" placeholder="Coupon Code">
                            <input class="apply-btn btn-dark" type="submit" value="Apply">
                        </form>
                    </div>  

                    <div class="col-sm-3 mt40 mb40">
                        <h4 class="bag-totals mb20">Cart Totals</h4>
                        <div class="cart_totals">
                            <table cellspacing="0">
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span class="amount">$131</span></td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Shipping</th>
                                        <td><p>Free</p></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="amount">$131</span></strong> </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="wc-proceed-to-checkout">
                                <a href="#" class="btn btn-primary btn-md btn-appear"><span>Cheeckout <i class="ion-bag"></i></span></a> 
                            </div>
                        </div>
                        <a href="shop-4columns.html" class="highlight mt20">Continue Shopping</a>
                    </div> 

                </div>
            </div>
        </section>
        <!-- End Cart -->
        
        <?php 
        require_once 'footer.php'; ?>