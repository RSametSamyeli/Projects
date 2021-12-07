
<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="<?php echo $ayarcek['ayar_zopim'] ?>";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->

<?php 

$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
$hakkimizdasor->execute(array(0));
$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

?>
<!-- Start Footer 1 -->
<footer id="footer-1" class="pt60 pb50 wow animated slideInUp">
    <div class="container">
        <div class="row">

           <div class="col-md-5"> 
            <h4>> Bizi Takip Edin</h4>
            <ul>
                <li><span style="color: #19B6CE"><i class="fa fa-map-marker"></i>    Adres:</span> <address><?php echo $ayarcek['ayar_adres'] ?> <br> <?php echo $ayarcek['ayar_ilce']; ?> - <?php echo $ayarcek['ayar_il']; ?></address></li>
                <li><span style="color: #19B6CE"><i class="fa fa-phone"></i>    Cep Telefonu:</span> <?php echo $ayarcek['ayar_gsm'] ?></li>
                <li><span style="color: #19B6CE"><i class="fa fa-envelope"></i>    Email:</span> <a href="mailto:<?php echo $ayarcek['ayar_mail'] ?>" class="text-decoration-none"><?php echo $ayarcek['ayar_mail'] ?></a></li>
            </ul>
        </div>   

        <div class="col-md-3">
            <img style="max-width: 337px; max-height: 110px;" src="<?php echo $ayarcek['ayar_logo']; ?>" alt="<?php echo $ayarcek['ayar_isim']; ?> Logosu">
           <ul class="footer-1-social" style="padding: 0 0 0 48px;">
                                <li><a href="<?php echo $ayarcek['ayar_twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_facebook']; ?>"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_instagram']; ?>"><i class="fa fa-instagram"></i></a></li>
                            </ul>

        </div>



        <div class="col-md-4" style="text-align: right;">
            <div class="subscription">
            	<span style='display: inline-block !important; text-align: center !important; width: 296px !important;'><a title='İzbarco Yazılım Ve Tasarım Web Tasarım ve Programlama Armut' href='https://armut.com/hizmetveren/izbarco-yazilim-ve-tasarim-isparta-egirdir-web-tasarim-ve-programlama_568327' style='background: none; padding:0; border:0;'><img src='https://cdn.armut.com/images/armut-member-badge-colour@2x.png' style='display: block; margin-bottom: 6px; padding:0; border: 0; width: 279px;' /></a><a href="https://armut.com/hizmetveren/izbarco-yazilim-ve-tasarim-isparta-egirdir-web-tasarim-ve-programlama_568327" style="border:0;font-size: 12px !important; color: rgb(70,130,40) !important; font-family: Trebuchet MS, Helvetica, Arial, sans-serif !important;">İzbarco Yazılım Ve Tasarım Web Tasarım ve Programlama</a></span>
            </div>
        </div>  

    </div>
</div>  

</footer>
<!-- End Footer 1 -->

<!-- Start Back To Top -->
<a id="back-to-top"><i class="icon ion-chevron-up"></i></a>
<!-- End Back To Top -->

</div><!-- Site Wrapper -->

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script src="js/plugins.js"></script>             
<script src="js/scripts.js"></script>  
<!-- BEGIN JIVOSITE CODE {literal} -->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'SxpbYkfkaC';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- {/literal} END JIVOSITE CODE -->
</body>
</html>