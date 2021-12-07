<?php  if( !defined("SABIT") ){ exit; } 

$unx_seo 	 = unserialize($sef_unuttum['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kapak = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 

?>
<meta name="robots" content="noindex,no-follow" />
</head>
<body>
<div id="cihaniriboy_main" class="cihaniriboy_main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo ucfirsttr($lang['yardimci']["sifremi_unuttum"]); ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page ">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-inner-left cihaniriboy-iletisim-form sifremiunuttum-content">
						<div class="cihaniriboy-page-title">
							<div class="col-sm-12 col-md-12"><h2><?php echo ucfirsttr($lang['yardimci']['sifremi_unuttum']); ?></h2></div>
						</div>
							<div class="form">
								<form action="" id="cihaniriboy-uyelik" method="POST">
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['email']; ?> <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control"   name="email" >
										</div>
									</div>
									<div class="form-group">
										<div class="guvenlik-span"><label> <?php echo $lang['iletisim']['guvenlik_kodu']; ?></label></div>
										<div class="col-md-4 col-xs-12 col-sm-6">
											<img class="cpth" src="<?php echo $set['siteurl']; ?>/captcha/captcha.php" alt="" />
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<input type="text" name="code" class="form-control"/>
										</div>
									</div>
									
									<div class="col-sm-6 col-xs-12">
										<div class="form-errors">
										
										</div>
									</div>
									<div class="send-form">
										<div class="col-md-12">
											<button class="btn btn-primary ci-sifre-gonder" type="button">
													<?php echo $lang["yardimci"]['gonder']; ?>
											</button>
										</div>
										<input type="hidden" name="veri" value="sifremiunuttum" />
										
									</div>
								</form>
							</div>
						<!--/form-->
							
					</div>
					<div class="cihaniriboy-success-form-content">
						<div class="cihaniriboy-succes-message animated">
							<div class="ci-icon-content">
								<i class="fa fa-check"></i>
							</div>
							<div class="ci-success-text">
								<?php echo $lang['mesaj']["sifremiunuttumok"]; ?>
							</div>
						</div>
					</div>
				</div>
				<!--/left-->
			
			</div>
		</div>
	</div>
	

<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){

		$('button.ci-sifre-gonder').click(function(){
			var data = $("#cihaniriboy-uyelik").serialize();
			$(".ci-sifre-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
			$.ajax({
				type:'POST',
				url:'ajax/uyelik.php',
				data: data,
				cache:false
			}).done(function(e){
				if( e != "done"){
					$(".ci-sifre-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
					$('.form-errors').html('<span>'+e+'</span>');
				}else{
					$('.cihaniriboy-iletisim-form').slideUp();
					$('html,body').animate({scrollTop: $('.cihaniriboy-inner-page').position().top-200 },1000);
					setTimeout(function(){
						$('.cihaniriboy-success-form-content').show();
						$('.cihaniriboy-succes-message').addClass('bounceIn');
					},700);
				}
			}).fail(function(){
				alert("Hata-2");
			});
		});
			
	});
</script>
 </body>
</html>