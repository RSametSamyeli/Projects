<?php  if( !defined("SABIT") ){ exit; } 
if(!empty($get3)) exit;
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_adres['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
seoyaz("".$title."","".$description."","".$keywords ."",""); 
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/intlTelInput.css" />
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
					<li><a href="<?php echo $set['siteurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>"><?php echo $sef_adres_baslik[$set['lang']['active']]; ?></a></li>
					<li>Adres Ekle</li>
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
								<h2><?php echo $sef_adres_baslik[$set['lang']['active']]; ?></h2>
							</div>
							<div class="form">
								<form action="" id="adres-ekle" method="POST">
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Adres Başlık <em>*</em> </label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" placeholder="Ev, iş" name="name">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Ad Soyad <em>*</em> </label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control"  name="adsoyad">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Telefon No <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" id="phone" name="telefon">
											
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Ülke </label></div>
										<div class="col-md-6 col-sm-6">
											<select name="ulke" id="" class="form-control">
												<?php foreach($countries as $row){?>
												<option <?php echo $row == "Turkey"  ? ' selected' : null; ?> value="<?php echo $row;?>"><?php echo $row;?></option>
												<?php  } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Şehir <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<select name="sehir" class="form-control" id="iller">
												<option value="">Şehir Seçiniz</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>İlçe <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<select name="ilce" class="form-control" id="ilceler">
												<option value="">Önce Şehir Seçiniz</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Adres</label></div>
										<div class="col-md-6 col-sm-6">
											<textarea name="adres" class="form-control" id="" cols="0" rows="0"></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Posta Kodu</label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" name="postakodu" class="form-control" />
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
													<?php echo $lang["yardimci"]['gonder']; ?>
											</button>
										</div>
										<input type="hidden" name="veri" value="adresekle" />
										<input type="hidden" name="user_id" value="<?php echo $uyebul['id']; ?>" />
									</div>
								</form>
							</div>
						<!--/form-->
						<div class="cihaniriboy-success-form-content">
							<div class="cihaniriboy-succes-message animated">
								<div class="hidden">
									<?php echo $lang['mesaj']["adres_ok"]; ?>
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
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/intlTelInput.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/data.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		function illeriGetir(){
			$.post('ajax/ilcek.php',{ilId: 0},function(output){
				$("#iller").append(output);
			});	
		}
		function ilceleriGetir(){
			if($("#iller").val() != 0){
				$.post('ajax/ilcek.php',{ilId: $("#iller").val()},function(output){
					$("#ilceler option").remove();
					$("#ilceler").append(output);
					console.log($("#iller").val());
				});
			}
			else{
				$("#ilceler option").remove();
				$("#ilceler").append('<option value="0">Önce İl Seçiniz</option>');
			}
		}

		illeriGetir(); 
		$("#iller").bind('change',ilceleriGetir);
		 $("#phone").intlTelInput({
			 utilsScript: '<?php echo $set['siteurl']; ?>/assets/js/phone/utils.js',
			 autoHideDialCode: false,
			 initialCountry: "tr",
			  separateDialCode: true,
		 });
		$('#adres-ekle').formValidation({
			 framework: 'bootstrap',
			  icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			   },
			fields: {
			   name :{
					validators: {
						notEmpty: {
							message: 'Başlık Tanımı Zorunludur'
						}
					}
				},
				adsoyad : {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_adsoyad']; ?>'
						}
					}
				},
				
				 ulke :{
					validators: {
						notEmpty: {
							message: 'Ülke Tanımı Zorunludur'
						}
					}
				},
				 telefon: {
                    validators: {
						notEmpty: {
							message: 'Telefon Tanımı Zorunludur'
						},
						callback: {
                             message: 'Geçersiz Telefon Numarası',
							callback: function(value, validator, $field) {
                                return value === '' || $field.intlTelInput('isValidNumber');
                            }
                        }
                    }
                },
				 sehir :{
					validators: {
						notEmpty: {
							message: 'Şehir Tanımı Zorunludur'
						}
					}
				},
				 ilce :{
					validators: {
						notEmpty: {
							message: 'İlçe Tanımı Zorunludur'
						}
					}
				},
				 adres :{
					validators: {
						notEmpty: {
							message: 'Adres Tanımı Zorunludur'
						}
					}
				}
			
			}
    })
	.on('success.form.fv', function(e) {
			 e.preventDefault();
             var $form = $(e.target);
			 var data = $("#adres-ekle").serialize();
			 $(".ci-uyelik-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
			$.ajax({
				type:'POST',
				url:'ajax/adres.php',
				data: data,
				cache:false
			}).done(function(e){
				if( e != "done"){
					$(".ci-uyelik-gonder").html('<?php echo $lang['yardimci']['guncelle'];  ?>');
					$('.form-errors').html('<span>'+e+'</span>');
				}else{
					window.location.href  = '<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>';
				}
			}).fail(function(){
				alert("Hata-2");
			});
        });
	});
</script>
 </body>
</html>