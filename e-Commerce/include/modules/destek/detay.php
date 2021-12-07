<?php  if( !defined("SABIT") ){ exit; } 
$id = intval($get2);
$bul = $conn -> query("select * from destek where id  = ".intval($id))->fetch();
if(!isset($bul)) { exit; }
$uyecek = $conn -> query("select * from users where id = ".intval($bul['user_id']))->fetch();
$destekcevaplar = $conn -> query("select * from destekcevap where destek_id = ".intval($bul['id']));
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
					<li><?php echo $sef_destek_baslik[$set['lang']['active']]; ?></li>
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
								<div class="siparislerim">
									<div class="s-title">
										<h2><?php echo $sef_destek_baslik[$set['lang']['active']]; ?></h2>
									</div>
									<div class="destek-content">
										<div class="destek-blok clearfix">
											<div class="top-row">
												<span class="icon-helper"><i class="fa fa-user"></i></span>
												<div class="ticket-user"> <?php echo $uyecek['ad']." ".$uyecek['soyad']; ?></div>
												<div class="date"><?php echo date("d.m.y H:i",$bul['tarih']); ?></div>
											</div>
											<div class="mesaj">
												<?php echo $bul['detay']; ?>
												<hr/>
												<p>IP :<?php echo $bul['ip'];  ?></p>
											</div>
										</div>
										<?php if($destekcevaplar -> rowCount() > 0 ) {
											foreach($destekcevaplar as $row){
											$yazar = $conn -> query("select * from users where id = ".intval($row['user_id']))->fetch();
											?>
											<div class="destek-blok clearfix <?php echo $yazar['rutbe'] == 1  ? ' admin-blok' : null;?>">
												<div class="top-row">
													<span class="icon-helper"><i class="fa fa-user"></i></span>
													<div class="ticket-user"> 
														<?php if($yazar['rutbe'] == 1){
															echo 'Admin';
														} else {
															echo $uyecek['ad']." ".$uyecek['soyad'];
														}?>
														
													</div>
													<div class="date"><?php echo date("d.m.y H:i",$row['tarih']); ?></div>
												</div>
												<div class="mesaj">
													<?php echo $row['mesaj']; ?>
													<hr/>
													<p>IP :<?php echo $bul['ip'];  ?></p>
												</div>
											</div>	
											<?php }	
										?>
											
										<?php } ?>
										<div class="destek-cevap">
											<form action="" method="post" id="cihaniriboy-form">
												<div class="destek-form">
													<div class="form-group">
														<div class="col-sm-12 no-padding"><label>Cevap</label></div>
														<div class="col-sm-12 no-padding">
															<textarea class="form-control" name="mesaj" id="" cols="0" rows="0"></textarea>
														</div>
													</div>
													<input type="hidden" name="id" value="<?php echo $get2; ?>" />
													<input type="hidden" name="user_id" value="<?php echo $uyebul['id']; ?>" />
													<input type="hidden" name="veri" value="destekcevap" />
													<div class="form-group">
														<div class="col-md-12">
															<button class="btn btn-primary ci-uyelik-gonder">
																	<?php echo $lang["yardimci"]['gonder']; ?>
															</button>
														</div>
													</div>
												</div>
											</form>
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
					mesaj: {
					validators: {
						notEmpty: {
							message: 'Mesaj Alanı Boş Olamaz'
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
					alert(e);
				}else{
					location.reload();
				}
			}).fail(function(){
				alert("Hata-2");
			});
        });
	});
</script>
 </body>
</html>