<?php  if( !defined("SABIT") ){ exit; } 
$sayfa = intval($get3); 
include('ajax/sozlesme/sozlesme.php');
if(isset($_SESSION["m_oturum"])){
	header("Location:".$set['langurl'].'/'.$sef_hesap_link[$set['lang']['active']]);
}
$unx_seo 	 = unserialize($sef_uyelik['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/intlTelInput.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/uyelik.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/-->
	<div class="page-content">
		<div class="cihaniriboy-outer-page">
			<div class="cihaniriboy-uyelik-content">
				<div class="container">
						<div class="cihaniriboy-uyelik-page">
							<div class="col-md-6 col-xs-12 col-sm-12">
								<div class="cihaniriboy-uyelik-sol cihaniriboy-iletisim-form">
									<div class="title">
										<h2>HIZLI ÜYELİK</h2>
									</div>
									<div class="form">
										<form action="" id="cihaniriboy-uyelik" class="form-horizontal" method="POST">
											
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" placeholder="<?php echo $lang["iletisim"]['ad']; ?>"  name="ad">
												</div>
											</div>
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" placeholder="<?php echo $lang["iletisim"]['soyad']; ?>"  name="soyad">
												</div>
											</div>
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" placeholder="<?php echo $lang["iletisim"]['email']; ?> " name="email">
												</div>
											</div>
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="password" placeholder="<?php echo $lang["iletisim"]['sifre']; ?>" class="form-control" name="sifre">
													
												</div>
											</div>
											
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="password" class="form-control" placeholder="<?php echo $lang["iletisim"]['sifreteyit']; ?>" name="sifreteyit">
													<div class="col-sm-12 no-padding">
														<div class="progress password-progress">
															<div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" id="phone" name="telefon">
													
												</div>
											</div>
										
											
											<div class="form-group">
												<div class="guvenlik-span"><label> <?php echo $lang['iletisim']['guvenlik_kodu']; ?></label></div>
												<div class="col-md-4 col-xs-12 col-sm-6">
													<img class="cpth" src="<?php echo $set['siteurl']; ?>/captcha/captcha.php" alt="captcha" />
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input type="text" name="code" class="form-control"/>
												</div>
											</div>
											<div class="sozlesme">
												<div class="form-group">
													<label>
														<input type="checkbox" name="kosul" value="1">
														<a href="javascript:void(0)" data-toggle="modal" data-target="#kSozlesme"><?php echo $lang['mesaj']['uyelik_kabul']; ?></a>
														<?php echo $lang['mesaj']['uyelik_kabul2']; ?>
													</label>
												</div>
											</div>
											<div class="google-capctha">
												
											</div>
											<!--/ sonradan edit-->
											<div class="form-errors">
												
											</div>
											<div class="send-form">
												<div class="col-md-12">
													<button class="btn btn-primary ci-uyelik-gonder">
															<?php echo $lang["yardimci"]['uye_ol']; ?>
													</button>
												</div>
											<input type="hidden" name="veri" value="kayit" />
											</div>
										</form>
									</div>
								</div>
								<div class="cihaniriboy-success-form-content">
									<div class="cihaniriboy-succes-message animated">
										<div class="ci-icon-content">
											<i class="fa fa-check"></i>
										</div>
										<div class="ci-success-text">
											<?php echo $lang['mesaj']["uye_ok"]; ?>
										</div>
									</div>
								</div>
							</div>
							<!--/left-->
							<div class="col-md-6 col-xs-12 col-sm-12">
								<div class="cihaniriboy-uyelik-sag">
									<div class="title">
										<h2><?php echo strtouppertr($lang["yardimci"]['giris_yap']); ?></h2>
									</div>
									<div class="form">
										<form action="" method="post" id="cihaniriboy-giris">
											<div class="form-group clearfix">
											   
												<div class="col-md-12">
													<input type="email" class="form-control" placeholder="<?php echo $lang["iletisim"]['email']; ?> " id="username" name="email" >
												</div>
											</div>
											<div class="form-group clearfix">
												
												<div class="col-md-12">
													<input type="password" class="form-control" placeholder="<?php echo $lang["iletisim"]['sifre']; ?>" id="password" name="password">
												</div>
											</div>
											<div class="form-group clearfix">
												<div class="col-md-12 submit-items">
													<button  class="btn btn-primary login"><?php echo $lang["yardimci"]['giris_yap']; ?></button>
													<a class="btn btn-link" href="<?php echo $set['langurl']; ?>/<?php echo $sef_unuttum_link[$set['lang']['active']]; ?>"><?php echo $lang["yardimci"]['sifremi_unuttum']; ?></a>
												</div>
											</div>
											<div class="form-group">
												<div class="form-errors"></div>
											</div>
											<div class="form-group hidden">
												<div class="yada">
													<span>Yada</span>
												</div>
											</div>
											<div class="form-group hidden">
												<div class="col-sm-12">
			
													<a href="<?php echo $loginUrl; ?>" class="facebook" rel="nofollow">
														<i class="fa fa-facebook"></i>
														Facebook ile Bağlan
														
													</a>
												</div>
												
											</div>
											
											<input type="hidden" name="veri" id="verigiris" value="giris" />
										</form>
									</div>
								</div>
								<div class="cihaniriboy-giris-success">
									<div class="giris-content animated">
										<div class="ci-icon-content">
											<i class="fa fa-check"></i>
										</div>
										<div class="ci-success-text"><?php echo $lang["yardimci"]['giris_basarili']; ?> <span>5</span> <?php echo $lang['yardimci']['yonlenme']; ?></div>
									</div>
								</div>
							</div>
							<!--/right-->
						</div>
			
				</div>
			</div>
		</div>
	</div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<div id="kSozlesme" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Kullanıcı Sözleşmesi</h4>
		  </div>
		  <div class="modal-body">
				<div class="modal-text">
					<?php echo html_entity_decode($usersozlesme); ?>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['yardimci']['kapat']; ?></button>
		  </div>
		</div>

	  </div>
	</div>
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/zxcvbn.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/intlTelInput.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/data.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
			
			
			 $("#phone").intlTelInput({
				 utilsScript: '<?php echo $set['siteurl']; ?>/assets/js/phone/utils.js',
				 autoHideDialCode: false,
				 initialCountry: "tr",
				 separateDialCode: true,
				 placeholderNumberType: false
			 });
		 
		var uSayi  = $('.list-mini-cart-item').length;

		$('#cihaniriboy-giris').submit(function(e){
			$('button.login').html('<i class="fa fa-refresh fa-spin"></i>');
			$.ajax({
				type :'POST',
				 data: {
					username: $("input#username").val(),
					password: $("input#password").val(),
					veri: $("input#verigiris").val()
				},
				dataType : 'json',
				url : AJAX_URL+'/ajax/uyelik.php',
			}).done(function(result){
					if(result.giris_durumu == "gecerli"){
						$('.cihaniriboy-uyelik-sag').slideUp();
						$('html,body').animate({scrollTop: $('.cihaniriboy-uyelik-content').position().top-200 },1000);
						setTimeout(function(){
						$('.cihaniriboy-giris-success').show();
						$('.cihaniriboy-giris-success .giris-content').addClass('bounceIn');
					},700);
						var basla = 2;
						$.saydir = function(){
							if(basla > 1 ){
								basla--;
								$('.ci-success-text').find('span').html(basla);
							}else{
								if(uSayi > 0 ){
									window.location = '/tr/sepetim';
								}else{
									window.location = '/';
								}
								
							}
							$('.ci-success-text').find('span').html(basla);
						}
						setInterval("$.saydir()",1000);
					}else{
						$("button.login").html('<?php echo $lang['yardimci']['giris_yap'];  ?>');
						$('.cihaniriboy-uyelik-sag .form-errors').html('<span><i class="fa fa-warning" aria-hidden"true"=""></i>'+result.hatamesaj+'</span>');
					
					}

					
			}).fail(function(){
				alert("Hata-4");
			});
			e.preventDefault();
		});
		
	$('#cihaniriboy-uyelik')
        .formValidation({
			  framework: 'bootstrap',
			  icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			   },
			   fields: {
				ad: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_ad']; ?>'
						}
					}
			  },
			  soyad: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_soyad']; ?>'
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
			  },
			  telefon: {
                    validators: {
                        callback: {
                            message: 'geçersiz telefon numarası',
                            callback: function(value, validator, $field) {
                                return value === '' || $field.intlTelInput('isValidNumber');
                            }
                        }
                    }
                },
			  sifre: {
				validators: {
					notEmpty: {
						message: '<?php echo $lang['mesaj']['bos_sifre']; ?>'
					},
					stringLength: {
						min: 6,
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
							if (score < 0) {
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
	
			  kosul : {
				validators: {
					notEmpty: {
						message: '<?php echo $lang['mesaj']['sozlesme']; ?>'
					}
				}
			},
		}
        })
        .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();
			$('.cihaniriboy-loading').show();
             var $form = $(e.target),
                fv    = $form.data('formValidation');
				var data = $("#cihaniriboy-uyelik").serialize();
				$(".ci-uyelik-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
				$.ajax({
					type:'POST',
					url: AJAX_URL+'/ajax/uyelik.php',
					data: data,
					cache:false
				}).done(function(e){
					if( e != "done"){
						$('.cihaniriboy-loading').hide();
						$(".ci-uyelik-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
						$('.cihaniriboy-uyelik-sol .form-errors').html('<span>'+e+'</span>');
					}else{
						$('.cihaniriboy-iletisim-form').slideUp();
						window.location = '/';
						/*$('html,body').animate({scrollTop: $('.cihaniriboy-uyelik-content').position().top-200 },1000);
						setTimeout(function(){
							$('.cihaniriboy-success-form-content').show();
							$('.cihaniriboy-succes-message').addClass('bounceIn');
						},700);*/
					}
				}).fail(function(){
					alert("Hata-2");
				});
        });
		
	});
</script>
 </body>
</html>