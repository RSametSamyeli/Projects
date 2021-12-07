<?php  if( !defined("SABIT") ){ exit; } 
if(!empty($get2)) exit;
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_profilim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
seoyaz("".$title."","".$description."","".$keywords ."",""); 
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo ucfirsttr($lang['yardimci']['uyelik_guncelle']); ?></li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->
<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-9 col-xs-12">
					<div class="inner-page">
						<div class="profilim">
							<div class="title">
								<h2>Üyelik Bilgilerim</h2>
							</div>
							<div class="form">
								<form action="" id="cihaniriboy-uyelik" method="POST">
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['ad']; ?> <em>*</em> </label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" value="<?php echo $uyebul['ad']; ?>" name="ad">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['soyad']; ?> <em>*</em> </label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" value="<?php echo $uyebul['soyad']; ?>" name="soyad">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['user']; ?> <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" value="<?php echo $uyebul['name']; ?>"   name="username">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['telefon']; ?> </label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" value="<?php echo $uyebul['telefon']; ?>"   name="telefon">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['email']; ?> <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control"  value="<?php echo $uyebul['email']; ?>"  name="email" >
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['sehir']; ?></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control"  value="<?php echo $uyebul['il']; ?>"  name="sehir">
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
										
										</div>
									</div>
									<div class="send-form">
										<div class="col-md-12">
											<button class="btn btn-primary ci-uyelik-gonder">
													<?php echo $lang["yardimci"]['guncelle']; ?>
											</button>
										</div>
										<input type="hidden" name="veri" value="profilupdate" />
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
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php _footer_last(); ?>
<script type="text/javascript">
$(function(){
	$('#cihaniriboy-uyelik').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            ad :{
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_ad']; ?>'
                    }
                }
            },
			soyad : {
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_soyad']; ?>'
                    }
				}
			},
			username : {
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_username']; ?>'
                    },
					stringLength: {
						min: 5,
						message: '<?php echo $lang['mesaj']['min_user']; ?>'
					},
					stringLength: {
						max: 14,
						message: '<?php echo $lang['mesaj']['min_user']; ?>'
					}
                }
            },
			email: {
				validators: {
					notEmpty: {
						message: '<?php echo $lang['mesaj']['bos_email']; ?>'
					},
					emailAddress: {
						message: '<?php echo $lang['mesaj']['gecersiz_email']; ?>'
					}
				}
		  }
		
        }
    }).on('success.form.bv', function(e) {
            e.preventDefault();
			var data = $("#cihaniriboy-uyelik").serialize();
			$(".ci-uyelik-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
			$.ajax({
				type:'POST',
				url:'ajax/uyelik.php',
				data: data,
				cache:false
			}).done(function(e){
				if( e != "done"){
					$(".ci-uyelik-gonder").html('<?php echo $lang['yardimci']['guncelle'];  ?>');
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