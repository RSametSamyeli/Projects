<?php if($_SESSION['mail']!=""){ ?>
<script src="stil/site.js"></script>
<script src="stil/jquery.cookie.js"></script>
<div class="orta">
    <div class="footic">
        <div class="footel">
            <img src="resimler/logo_3.png" width="200">
            <p>Graptik.biz 2018 yılında kurulmuş olup, sosyal medya alanlarında aktif olarak hizmet veren, Facebook, Youtube, İnstagram, Twitter ve benzeri alanlarda takipçi, beğeni, izlenme satışları sağlayan bir kuruluştur.</p>
            <div class="social">
                <a href="https://www.instagram.com/graptikbiz/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/Graptik/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="https://twitter.com/Graptikbiz" target="_blank"><i class="fab fa-twitter"></i></a>
                <!--                <a href=""><i class="fab fa-youtube"></i></a>-->
            </div>
        </div>
        <div class="footel">
            <h3>Sayfalar</h3>
            <ul>
                <li><a href="/">Anasayfa</a></li>
                <li><a href="hizmetler">Hizmetler</a></li>
                <li><a href="fiyatlar">Fiyatlar</a></li>
                <li><a href="kullanim_klavuzu">Kullanım Klavuzu</a></li>

            </ul>
        </div>
        <div class="footel">
            <h3>Yasal</h3>
            <ul>
                <li><a target="_blank" href="kullanim_sozlesmesi.html">Kullanım Sözleşmesi</a></li>
                <li><a target="_blank" href="gizlilik_sozlesmesi.html">Gizlilik Sözleşmesi</a></li>

            </ul>
        </div>
        <div class="footel">
            <h3>İletişim</h3>
            <div class="iletel">
                <p><i class="fas fa-envelope-open"></i> Mail</><span>bilgi@graptik.net</span></p>
                <p><i class="fab fa-whatsapp"></i> Whatsapp<span>+90 242 326 58 10</span></p>
            </div>
        </div>
    </div>
    <div class="son">
        <p>Tüm Hakları Saklıdır &copy</p>
    </div>
</div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118453103-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-118453103-1');
    </script>

    </div>
</body>
</html>
<?php }else {
    header("location:/");
}?>