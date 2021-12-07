
<!--FOOTER BASLANGIC-->


<footer id="footer" class="footer-hover-links-light mt-0">
	<div class="container">

		<div class="row">
			<div class="col-lg-6 ml-auto mt-lg-3 pt-lg-2">
				<ul class="list list-icon list-unstyled mb-0 mb-lg-3">
					<li class="mb-2"><i class="fas fa-angle-right mr-2 ml-1"></i> <span class="text-color-light">Adres:</span>  <?php echo $ayarcek['ayar_adres'] ?> <?php echo $ayarcek['ayar_ilce']." / ".$ayarcek['ayar_il'] ?></li>
					<li class="mb-2"><i class="fas fa-angle-right mr-2 ml-1"></i> <span class="text-color-light">Telefon:</span> <a href="tel:<?php echo $ayarcek['ayar_gsm'] ?>"><?php echo $ayarcek['ayar_gsm'] ?></a></li>
					<li class="mb-2"><i class="fas fa-angle-right mr-2 ml-1"></i> <span class="text-color-light">Email:</span> <a href="mailto:<?php echo $ayarcek['ayar_mail'] ?>" class="link-underline-light"><?php echo $ayarcek['ayar_mail'] ?></a></li>
				</ul>
			</div>

			<div class="col-lg-6 mb-6 mb-md-0 text-md-right">
				<a href="index.html" class="logo">
					<img alt="Graptik Web" class="img-fluid mb-3" src="images/logo-small-light.png">
				</a>
				<p><?php echo substr($hakkimizdacek['hakkimizda_icerik'],0,350); ?></p>
			</div>
		</div>
	</div>

	<div class="footer-copyright">					<div class="container">						<div class="row text-center text-md-left align-items-center">							<div class="col-md-7 col-lg-8">								<ul class="social-icons social-icons-transparent social-icons-icon-light social-icons-lg">									<li class="social-icons-facebook"><a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>									<li class="social-icons-twitter"><a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>									<li class="social-icons-instagram"><a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>								</ul>							</div>							<div class="col-md-5 col-lg-4">								<p class="text-md-right pb-0 mb-0">2019 Graptik</p>							</div>						</div>					</div>				</div>
</footer>
</div>

<!-- Vendor -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="vendor/jquery-cookie/jquery-cookie.min.js"></script>
<script src="master/style-switcher/style.switcher.js" id="styleSwitcherScript" data-base-path="" data-skin-src=""></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/common/common.min.js"></script>
<script src="vendor/jquery.validation/jquery.validation.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
<script src="vendor/isotope/jquery.isotope.min.js"></script>
<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="vendor/vide/vide.min.js"></script>
<script src="vendor/vivus/vivus.min.js"></script>

<!-- JS Ayarlar -->
<script src="js/theme.js"></script>

<!-- Revolution Slider Özellikleri -->
<script src="vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>		<script src="vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

<!-- Özel JS -->
<script src="js/custom.js"></script>

<!-- Tema JS -->
<script src="js/theme.init.js"></script>


</body>
</html>