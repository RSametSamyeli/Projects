<?php
ob_start();
session_start();
require_once 'header.php'; ?>
        
        <!-- Start Coming Soon Section -->
        <section id="login" class="bg-img-9"> 
            <div class="login-container"> 
                
                <div class="container text-center">
                    
                    <div class="col-md-12 dark">
				        <h3 class="white mb5"><?php echo $ayarcek['ayar_isim']; ?> Giriş Yapın</h3> 
                        <p class="subheading white"><?php echo $ayarcek['ayar_slogan']; ?></p>
				        <div class="login-form pt30 pb30">


				            <form action="panel/netting/islem.php" method="POST">
								<input class="form-email bg-transparent" type="text" name="kullanici_mail" placeholder="E-Posta Adresiniz">
								<input class="form-password bg-transparent" type="password" name="kullanici_password" placeholder="Şifreniz"> 

								<input class="btn btn-primary btn-login" name="kullanicigiris" type="submit" value="Giriş Yap">
				            </form>  


				        </div> 
                        <p>Hesabınız yok mu? Şimdi, <a style="color: #0CB4CE" href="register.php">kayıt olun.</a></p>
                        <p class="terms">Giriş yaptığınızda <a href="#">Kullanıcı Sözleşmesini ve Gizlilik Politikasını</a> onaylamış olursunuz.</p>
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
