<?php if( !defined("SABIT") ){ exit; } 
@include("ajax/yazi/iletisimyazi.php");
$unx_seo 	 = unserialize($sef_iletisim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak = glob("uploads/onkapak/iletisim/iletisim.*");
$iletisimayar    = $conn -> query('select * from iletisimayar');

$veriler 		 = $conn -> query('select * from iletisim where id = 1')->fetch();
## Meta 
seoyaz("".$title."","".$description."","".$keywords."","");
?>
</head>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/iletisim.css" />
<body>

<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
<!--/header-->
	<div class="outer-page">
				<div class="container">
					<ul class="breadcrumb">
						<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
						<li><?php echo $lang['yardimci']['bize_ulasin']; ?></li>
					</ul>
				</div>
			<div class="inner-page">
				<div class="container">
					<div class="row">
						<div class="col-md-7 col-xs-12">
							<div class="iletisim-sol">
								<div class="gmap">
									<div id="google-map" style="height:400px"></div>
								</div>
								<div class="is-bloklar">
								 <?php foreach($iletisimayar as $ay){
									
									$key = (string)$ay['id'];
									$unx_baslik   = unserialize($veriler['baslik']);
									$unx_resimler = unserialize($veriler['resimler']);
									$unx_adres    = unserialize($veriler['adres']);
								
									$unx_telefon  = unserialize($veriler['telefon']);
									$unx_mail     = unserialize($veriler['mail']);
									$unx_faks     = unserialize($veriler['faks']);
									$unx_website  = unserialize($veriler['website']);
									?>
									 <div class="is-tekli-blok">
										
										<div class="col-md-12">
											<div class="blok-baslik"><h2><?php echo $unx_baslik[$key][1]; ?></h2></div>
											<div class="iletisim-blog-bilgiler">
												<?php 
													if($ay['adres'] !==0){
														for($i = 1; $i <= $ay['adres']; $i++){
													echo '<div class="iletisim-item"><i class="fa fa-home"></i>'.$unx_adres[$key][$i].'</div>';
													} }
												?>
												<?php 
													if($ay['telefon'] !==0){
														for($i = 1; $i <= $ay['telefon']; $i++){
													echo '<div class="iletisim-item"><i class="fa fa-phone"></i>'.$unx_telefon[$key][$i].'</div>';
													} }
												?>
												<?php 
													if($ay['mail'] !==0){
														for($i = 1; $i <= $ay['mail']; $i++){
													echo '<div class="iletisim-item"><a href="mailto:'.$unx_mail[$key][$i].'"><i class="fa fa-envelope"></i>'.$unx_mail[$key][$i].'</a></div>';
													} }
												?>
												<?php 
													if($ay['faks'] !==0){
														for($i = 1; $i <= $ay['faks']; $i++){
													echo '<div class="iletisim-item"><i class="fa fa-fax"></i>'.$unx_faks[$key][$i].'</div>';
													} }
												?>
												<?php 
													if($ay['website'] !==0){
														for($i = 1; $i <= $ay['website']; $i++){
													echo '<div class="iletisim-item"><i class="fa fa-globe"></i>'.$unx_website[$key][$i].'</div>';
													} }
												?>
											</div>
										</div>
										<!--/sag item-->
									 </div>
								 <?php } ?>
								 </div>
							</div>
						</div>
						<!--/left-->
						<div class="col-md-5 col-xs-12">
							<div class="iletisim-sag">
								<div class="iletisim-form">
									<div class="iletisim-form-title">
										<h3><?php echo $lang['iletisim']['iletisim_formu']; ?></h3>
									</div>
									<div class="iletisim-form-body">
										<form action="#" id="is-iletisim-form" method="POST">
											<div class="form-group">
												<label><?php echo $lang['iletisim']['adsoyad']; ?></label>
												<input type="text" name="adsoyad" class="form-control"/>
											</div>
											<div class="form-group">
												<label><?php echo $lang['iletisim']['telefon']; ?></label>
												<input type="text" name="telefon" class="form-control"/>
											</div>
											<div class="form-group">
												<label>E-Mail</label>
												<input type="text" name="email" class="form-control"/>
											</div>
											<div class="form-group">
												<label><?php echo $lang['iletisim']['konu']; ?></label>
												<input type="text" name="konu" class="form-control"/>
											</div>
											<div class="form-group">
												<label><?php echo $lang['iletisim']['mesaj']; ?></label>
												<textarea name="mesaj" id="" cols="0" rows="0" class="form-control"></textarea>
											</div>
											<div class="form-group">
												<label> <?php echo $lang['iletisim']['guvenlik_kodu']; ?></label>
												<div class="col-md-4 col-xs-12">
													<div class="row">
														<img src="<?php echo $set['siteurl']; ?>/captcha/captcha.php" alt="" />
													</div>
												</div>
												<div class="col-md-5 col-xs-6 no-padding">
													<input type="text" name="code" class="form-control"/>
												</div>
											</div>
											<div class="form-group">
												<div class="iletisim-send">
													<button class="ci-iletisim-gonder"><?php echo $lang['yardimci']['gonder'];  ?></button>
												</div>
											</div>
											<div class="is-errors">
												
											</div>
										</form>
									</div>
								</div>
								<!--/form-->
								<div class="is-success-msg-content">
									<div class="is-succes-message animated">
										<div class="ci-icon-content">
											<i class="fa fa-check"></i>
										</div>
										<div class="ci-success-text">
											<?php echo $lang['mesaj']["iletisim_ok"]; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--right-->
					</div>
					
				</div>
			</div>
	</div>
	
<?php include('include/sabit/footer.php'); ?>
<!--/footer-->
</div>
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/gmap3.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=<?php echo $main_settings['mapkey']; ?>"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('#google-map').gmap3({
			 map:{
				options:{
				 center: [<?php echo $veriler['xkordinat']; ?>, <?php echo $veriler['ykordinat']; ?>],
				 zoom: 15,
				 mapTypeId: "style1",
				 mapTypeControlOptions: {
				   mapTypeIds: ["style1", "style2"]
				},
				 scrollwheel: false
				}
			 },
			 styledmaptype:{
			    id: "style1",
			  options:{
				name: "Harita"
			  },
			  styles: [
					{
						"featureType": "water",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#a0d6d1"
							},
							{
								"lightness": 17
							}
						]
					},
					{
						"featureType": "landscape",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#ffffff"
							},
							{
								"lightness": 20
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#dedede"
							},
							{
								"lightness": 17
							}
						]
					},
					{
						"featureType": "road.highway",
						"elementType": "geometry.stroke",
						"stylers": [
							{
								"color": "#dedede"
							},
							{
								"lightness": 29
							},
							{
								"weight": 0.2
							}
						]
					},
					{
						"featureType": "road.arterial",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#dedede"
							},
							{
								"lightness": 18
							}
						]
					},
					{
						"featureType": "road.local",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#ffffff"
							},
							{
								"lightness": 16
							}
						]
					},
					{
						"featureType": "poi",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#f1f1f1"
							},
							{
								"lightness": 21
							}
						]
					},
					{
						"elementType": "labels.text.stroke",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "#ffffff"
							},
							{
								"lightness": 16
							}
						]
					},
					{
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"saturation": 36
							},
							{
								"color": "#333333"
							},
							{
								"lightness": 40
							}
						]
					},
					{
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "geometry",
						"stylers": [
							{
								"color": "#f2f2f2"
							},
							{
								"lightness": 19
							}
						]
					},
					{
						"featureType": "administrative",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"color": "#fefefe"
							},
							{
								"lightness": 20
							}
						]
					},
					{
						"featureType": "administrative",
						"elementType": "geometry.stroke",
						"stylers": [
							{
								"color": "#fefefe"
							},
							{
								"lightness": 17
							},
							{
								"weight": 1.2
							}
						]
					}
				]
			},
			marker:{
			  latLng:[<?php echo $veriler['xkordinat']; ?>, <?php echo $veriler['ykordinat']; ?>],
			  options: {
				 icon: new google.maps.MarkerImage("<?php echo $set['siteurl']; ?>/assets/images/marker.png"),
				 animation: google.maps.Animation.DROP
				}
			}
		});
	$('#is-iletisim-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            adsoyad: {
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_ad']; ?>'
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
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_telefon']; ?>'
                    },
					 regexp: {
						message: '<?php  echo $lang['mesaj']['gecersiz_telefon']; ?>',
						regexp: /^[0-9\s\-()+\.]+$/
					}
                }
            },
			konu: {
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_konu']; ?>'
                    }
                }
            },
			mesaj: {
                validators: {
                    notEmpty: {
                        message: '<?php echo $lang['mesaj']['bos_mesaj']; ?>'
                    }
                }
            }
			
        }
    }).on('success.form.bv', function(e) {
            e.preventDefault();
			var data = $("#is-iletisim-form").serialize();
			$(".ci-iletisim-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
			$.ajax({
				type:'POST',
				url:'ajax/iletisim.php',
				data: data,
				cache:false
			}).done(function(e){
				if( e != "done"){
					$(".ci-iletisim-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
					$('.is-errors').html('<span>'+e+'</span>');
				}else{
					$('.iletisim-form').slideUp();
					$('html,body').animate({scrollTop: $('.inner-page').position().top-200 },1000);
					$('.is-success-msg-content').show();
					$('.is-succes-message').addClass('bounceIn');
				}
			}).fail(function(){
				alert("Hata-2");
			});
        });
	});
</script>
	