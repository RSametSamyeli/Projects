<?php  if( !defined("SABIT") ){ exit; } 
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_sifre['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];


seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kapak = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 

?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo ucfirsttr($lang['yardimci']['sifremi_degistir']); ?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
	<!--/header-->
	<div class="cihaniriboy-outer-page">
			<div class="cihaniriboy-inner-page">
				<div class="container">
					<div class="col-md-9 col-xs-12">
						<div class="inner-page">
							<div class="profilim">
								<div class="title">
									<h2><?php echo ucfirsttr($lang['yardimci']["sifremi_degistir"]); ?></h2>
								</div>
								<div class="form">
										<form action="" id="cihaniriboy-uyelik" method="POST">
											<?php  if(!isset($_SESSION["fboturum"])) {  ?>
											<div class="form-group">
												<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['sifre']; ?> <em>*</em> </label></div>
												<div class="col-md-6 col-sm-6">
													<input type="password" class="form-control" name="eskisifre">
												</div>
											</div>
											<?php  } ?>
											<div class="form-group">
												<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['yeni_sifre']; ?> <em>*</em> </label></div>
												<div class="col-md-6 col-sm-6">
													<input type="password" class="form-control" name="sifre">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['yeni_sifreteyit']; ?> <em>*</em> </label></div>
												<div class="col-md-6 col-sm-6">
													<input type="password" class="form-control" name="sifreteyit">
													<div class="col-sm-12 no-padding">
														<div class="progress password-progress">
															<div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
														</div>
													</div>
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
											
											<div class="google-capctha">
												
											</div>
											<!--/ sonradan edit-->
											<div class="col-sm-6 col-xs-12">
												<div class="form-errors">
													<?php if(isset($_SESSION["fboturum"]) && $_SESSION["fboturum"] == "tamam") {
														echo '<span>'.$lang['mesaj']['facesifre'].'</span>';
													}?>
												</div>
											</div>
											<div class="send-form">
												<div class="col-md-12">
													<button class="btn btn-primary ci-uyelik-gonder">
															<?php echo $lang["yardimci"]['guncelle']; ?>
													</button>
												</div>
												<input type="hidden" name="veri" value="sifredegistir" />
												<input type="hidden" name="id" value="<?php echo $uyebul['id']; ?>" />
											</div>
										</form>
							</div>
						<!--/form-->
							<div class="cihaniriboy-success-form-content">
								<div class="cihaniriboy-succes-message animated">
									<div class="ci-icon-content">
										<i class="fa fa-check"></i>
									</div>
									<div class="ci-success-text">
										<?php echo $lang['mesaj']["guncelleme_ok"]; ?>
									</div>
								</div>
							</div>
								
								
							</div>
						</div>
					</div>
					<!--/left-->
					<div class="col-md-3 col-xs-12">
						<div class="custom-inner-right">
							<div class="sidebar">
								<?php include('include/sabit/shop-sidebar.php');?>
							</div>
						
						</div>
					</div>
					<!--/right-->
				</div>
			</div>
		</div>
		

	<?php include('include/sabit/footer.php'); ?>	
		<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/zxcvbn.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('#cihaniriboy-uyelik')
        .formValidation({
			  framework: 'bootstrap',
			  icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			   },
			   fields: {
				  <?php if(!isset($_SESSION["fboturum"])) {  ?>
				  eskisifre: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_sifre2']; ?>'
						},
						stringLength: {
							min: 5,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
						stringLength: {
							max: 12,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
					}
				  }  ,
				  <?php  } ?>
				  sifre: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_sifre']; ?>'
						},
						stringLength: {
							min: 5,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
						stringLength: {
							max: 12,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
						identical: {
							field: 'sifreteyit',
							message: '<?php echo $lang['mesaj']['sifreler_eslesmiyor']; ?>'
						},
						callback: {
							 callback: function(value, validator, $field) {
								var password = $field.val();
								if (password == '') {
									return true;
								}

								var result  = zxcvbn(password),
									score   = result.score,
									
									message = '<?php echo $lang['mesaj']["zayif_sifre"]; ?>';
									
								var $bar = $('#strengthBar');
								switch (score) {
									case 0:
										$bar.attr('class', 'progress-bar progress-bar-danger')
											.css('width', '1%');
										break;
									case 1:
										$bar.attr('class', 'progress-bar progress-bar-danger')
											.css('width', '25%');
										break;
									case 2:
										$bar.attr('class', 'progress-bar progress-bar-danger')
											.css('width', '50%');
										break;
									case 3:
										$bar.attr('class', 'progress-bar progress-bar-warning')
											.css('width', '75%');
										break;
									case 4:
										$bar.attr('class', 'progress-bar progress-bar-success')
											.css('width', '100%');
										break;
								}

								// We will treat the password as an invalid one if the score is less than 3
								if (score < 1) {
									return {
										valid: false,
										message: message
									}
								}

								return true;
							}
						}
						
					}
				  },
				  sifreteyit: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_sifre2']; ?>'
						},
						stringLength: {
							min: 5,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
						stringLength: {
							max: 12,
							message: '<?php echo $lang['mesaj']['min_sifre']; ?>'
						},
					}
				  },
		}
        })
        .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

             var $form = $(e.target),
                fv    = $form.data('formValidation');
				var data = $("#cihaniriboy-uyelik").serialize();
				$(".ci-uyelik-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
				$.ajax({
				type:'POST',
				url:'ajax/uyelik.php',
				data: data,
				cache:false
			}).done(function(e){
				console.log(e);
				if( e != "done"){
					$(".ci-uyelik-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
					$('.form-errors').html('<span>'+e+'</span>');
				}else{
					$('.form').slideUp();
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