<?php  if( !defined("SABIT") ){ exit; } 

$unx_seo 	 = unserialize($sef_siparistakibi['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kapak = glob("uploads/onkapak/urunler/urunler.*");
$arkakapak = glob("uploads/arkakapak/kurumsal/kurumsal.*"); 

?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/siparis-takibi.css" />
</head>
<body>
<div id="cihaniriboy_main" class="cihaniriboy_main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		<div class="cihaniriboy_breadcrumbs">
			<div class="container">
				<ul>
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo ucfirsttr($sef_siparistakibi_baslik[$set['lang']['active']]); ?></li>
				</ul>
			</div>
		</div>
		<div class="cihaniriboy-inner-page">
			<div class="container">
				<div class="col-md-8 col-xs-12">
					<div class="cihaniriboy-inner-left siparis-takibi">
						<div class="cihaniriboy-page-title">
							<h2><?php echo ucfirsttr($sef_siparistakibi_baslik[$set['lang']['active']]); ?></h2>
						</div>
							<div class="form">
								<form action="" id="siparis-takibi" method="POST">
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label><?php echo $lang["iletisim"]['email']; ?> <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control"   name="email" >
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4 col-sm-6"><label>Sipariş No: <em>*</em></label></div>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" name="sipno" >
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
											<button class="btn btn-primary ci-gonder" type="button">
													<?php echo $lang["yardimci"]['gonder']; ?>
											</button>
										</div>
										<input type="hidden" name="veri" value="siparistakibi" />
										
									</div>
								</form>
								
							</div>
						<!--/form-->
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

		$('button.ci-gonder').click(function(){
			var data = $("#siparis-takibi").serialize();
			 $('.cihaniriboy-loading').show();		
			$.ajax({
				type:'POST',
				url:'ajax/uyelik.php',
				data: data,
				cache:false
			}).done(function(e){
				var result = e.split('|x|');
					console.log(result[0]);
					
				$('.cihaniriboy-loading').hide();		
				if(jQuery.trim(result[0]) == "done"){
					$('.form').html(result[1]);
				}else{
					swal({
					  type: 'error',
					  title: ''+result[0]+'',
					  confirmButtonColor: '#333',
					});
				}
			}).fail(function(){
				alert("Hata-2");
			});
		});
			
	});
</script>
 </body>
</html>