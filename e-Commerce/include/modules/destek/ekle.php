<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}

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
					<li><?php echo $lang['yardimci']["destek_iste"]; ?></li>
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
								<div class="title hidden-print">
									<h2 class="hidden-print"><?php echo ucfirsttr($lang['yardimci']["destek_iste"]); ?></h2>
								</div>
								<div class="form form-kapa">
									<form action="" id="cihaniriboy-form" method="post">
										<div class="form-group">
											<div class="col-md-4 col-sm-6"><label> Konu </label></div>
											<div class="col-md-6 col-sm-6">
												<select name="konu" id="" class="form-control">
												<option value="">Seçiniz</option>
													<option value="Destek">Destek</option>
													<option value="Yardım">Yardım</option>
													<option value="Şikayet">Şikayet</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4 col-sm-6"><label> Başlık</label></div>
											<div class="col-md-6 col-sm-6">
												<input type="text" class="form-control" name="baslik" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-4 col-sm-6"><label> Detay </label></div>
											<div class="col-md-6 col-sm-6">
												<textarea name="detay" class="form-control" id="" cols="0" rows="0"></textarea>
											</div>
										</div>
										<div class="col-sm-6 col-xs-12">
												<div class="form-errors">
													
												</div>
											</div>
										<div class="form-group">
											<div class="send-form">
												<div class="col-md-10 col-sm-10">
													<button type="submit" class="btn ci-uyelik-gonder btn-primary pull-right">GÖNDER</button>
												</div>
											</div>
										</div>
										<input type="hidden" name="user_id" value="<?php echo $uyebul['id']; ?>" />
										<input type="hidden" name="veri" value="destek" />
									</form>
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
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/validationv5.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('#cihaniriboy-form')
        .formValidation({
			  framework: 'bootstrap',
			  icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			   },
			   fields: {
				  konu: {
					validators: {
						notEmpty: {
							message: 'Konu Alanı Boş Olamaz'
						},
					}
				  },
				  baslik: {
					validators: {
						notEmpty: {
							message: 'Başlık Alanı Boş Olamaz'
						},
					}
				  },
				  detay: {
					validators: {
						notEmpty: {
							message: 'Detay Alanı Boş Olamaz'
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
				var data = $("#cihaniriboy-form").serialize();
				$(".ci-uyelik-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
				$.ajax({
				type:'POST',
				url:'ajax/uyelik.php',
				data: data,
				cache:false
			}).done(function(e){
				if( e != "done"){
					$(".ci-uyelik-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
					$('.form-errors').html('<span>'+e+'</span>');
				}else{
					$('.form-kapa').slideUp();
					setTimeout(function(){
						$('.cihaniriboy-success-form-content').show();
						$('.cihaniriboy-succes-message').addClass('bounceIn');
						
					},100);
					setTimeout(function(){
					window.location.href = '<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>'; 	
					},400);
					
					
				}
			}).fail(function(){
				alert("Hata-2");
			});
        });
	});
</script>
 </body>
</html>