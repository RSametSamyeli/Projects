<?php
ob_start();
session_start();
require_once 'header.php'; ?>

<!-- Start Coming Soon Section -->
<section id="login" class="bg-img-11"> 
    <div class="login-container"> 
        <div class="container text-center">

            <?php require_once 'hesabim-sidebar.php'; ?>



            <div class="row"> 

                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h2 style="color: #0EAAC2;">0</h2>
                    <h3 class="white">Toplam Sipariş</h3>
                    <p class="white">E-Ticaret Paketlerimiz veya Web Yazılımlarımız üzerine yapmış olduğunuz toplam sipariş sayısını gösterir.</p>
                    <a href="#" class="btn btn-ghost-color">Tüm Siparişler</a>
                </div> 

                <div class="col-md-4 col-sm-4 col-xs-4">
                   <h2 style="color: #0EAAC2;">0</h2>
                   <h3 class="white">Destek Mesajı</h3>
                   <p class="white">Firmamıza destek talebi/ticket atmışsanız size geri gelen cevabı gösterir.</p>
                   <a href="#" class="btn btn-ghost-color">Ticket Gönder</a>
               </div> 

               <div class="col-md-4 col-sm-4 col-xs-4">
                <h2 style="color: #0EAAC2;">0 TL</h2>
                <h3 class="white">Kredi Bakiyesi</h3>
                <p class="white">Kredi sistemi sayesinde taksit imkanlı alışveriş yapabilirsiniz. </p>
                <a href="#" class="btn btn-ghost-color">Kredi Ekleyin</a>

            </div>
            <br><br><br><br>
        </div>



    </div>
</div>
</div> 
</section>
<!-- End Coming Soon Section -->   

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script src="js/plugins.js"></script>             
<script src="js/scripts.js"></script>  

</body>
</html>