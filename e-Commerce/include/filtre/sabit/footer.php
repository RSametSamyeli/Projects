<?php if( !defined("SABIT") ){ exit; } 
 ?>
<div class="footer">
		<div class="container">
			<div class="col-md-3 col-sm-6"> 
				<div class="foot-box">
					<div class="title"><h3>KURUMSAL</h3></div>
					<ul>
						<li><a href="">Anasayfa</a></li>
						<li><a href="#">Hakkımızda</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-sm-6"> 
				<div class="foot-box">
					<div class="title"><h3>MÜŞTERİ HİZMETLERİ</h3></div>
					<ul>
						<li><a href="">İletişim</a></li>
						<li><a href="#">Gizlilik Sözleşmesi</a></li>
						<li><a href="#">Aynı Gün Kargo</a></li>
						<li><a href="#">Teslimat & İade</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3 col-sm-6"> 
				<div class="foot-box">
					<div class="title"><h3>İLETİŞİM</h3></div>
					<div class="medya-text">Sosyal Medya'dan bizi takip edebilirsinz</div>
					<div class="social">
						<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
						<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
						<a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
						<a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
					</div>
					<div class="telefon">
						<a href="tel: 0 555 552 123"><i class="fa fa-phone"></i><span> 0 555 552 12 23</span></a>
					</div>
					
				</div>
			</div>
			<div class="col-md-3 col-sm-6"> 
				<div class="foot-box">
					<div class="title"><h3>E-BÜLTEN</h3></div>
						<div class="footer-ebulten-text">
							<?php echo $lang['yardimci']['haberdar_ol']; ?>
						</div>
						<div class="footer-ebulten">
							<button type="button" id="cihaniriboy-mail-birak" class="mail-btn"><i class="fa fa-envelope"></i></button>
							<div class="input-inline">
								<input type="text" class="form-control" name="maillist" placeholder="E-Mail Adresinizi Yazınız">
							</div>
							<div class="foot-input"><div class="alert alert-danger"></div></div>
						</div>
				</div>
			</div>
			<div class="bank-logo">
				<img src="<?php echo $set['siteurl']; ?>/assets/images/urunbanks.png" alt="" />
			</div>
		</div>
		<div class="footer-last">
			<div class="container">
				<ul>
					<li><a href="#">İletişim</a></li>
					<li><a href="#">Yardım</a></li>
					<li><span>Copyright &copy; 2017 | Tüm Hakları Saklıdır | site@siteismi.com  </span></li>
				</ul>
				<div class="mod">
					<a href="http://www.modgrafik.com/" title="web tasarım">
						<img src="<?php echo $set['siteurl']; ?>/assets/images/modlogo.png" alt="web tasarım, web yazılım" />
					</a>
				</div>
			</div>
		</div>
	</div>
<div id="mysepet" class="modal fade sepet-alert-content" role="dialog">
  <div class="modal-dialog fadeInDown animated">
  
    <!-- Modal content-->
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div class="modal-body clearfix">
		<div class="alert-body">
			<div class="ci-icon-content">
				<i class="fa fa-check"></i>
			</div>
			<div class="ci-success-text">
				<?php echo $lang['yardimci']["eklendi"]; ?>
			</div>
		</div>
      </div>
      
    </div>

  </div>
</div>
<div class="cihaniriboy-loading"><img src="<?php echo $set['siteurl']; ?>/assets/images/loader.gif" alt="loading" /></div>
<!--/sepetbox-->	