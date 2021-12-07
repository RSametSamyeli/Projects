<?php  if( !defined("SABIT") ){ exit; } 
if($get2 == "ekle") {
	include('include/modules/uyelik/adres/ekle.php');
	exit;
}
if($get2 == "duzenle") {
	include('include/modules/uyelik/adres/duzenle.php');
	exit;
}
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$adresler = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 

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
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo $sef_adres_baslik[$set['lang']['active']]; ?></li>
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
								<h2><?php echo $sef_adres_baslik[$set['lang']['active']]; ?></h2>
							</div>
							<div class="adreslerim">
								<?php if($adresler -> rowCount() > 0){ 
								 foreach($adresler as $row){
								 $sehirRow = $conn -> query("select * from il where ID = ".intval($row['sehir']))->fetch();
								 $ilceRow  = $conn -> query("select * from ilce where ID = ".intval($row['ilce']))->fetch();
								 ?>
								<div class="adres-item" id="a-blok<?php echo $row['id']; ?>">
									<div class="item-outer">
										<h5><?php echo $row['name']; ?></h5>
										<p>
											<?php echo $row['adsoyad']; ?>
											<br>
											<?php echo $row['adres']; ?>
											<br>
										  <?php echo $row['ulke']; ?> / <?php echo $sehirRow['ADI']; ?> / <?php echo $ilceRow['ADI']; ?>
											<br>
											<?php echo $row['telefon']; ?>
										</p>
										<div class="adres-butonlar">
											<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>/duzenle/<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Düzenle</a>
											<a href="#" class="adressil" id="<?php echo $row['id']; ?>"><i class="fa fa-times" aria-hidden="true"></i>Sil</a>
										</div>
									</div>
								</div>
								<!--item/-->
								 <?php  } } ?>
								<div class="adres-item">
									<div class="item-outer">
										<div class="adres-ekle">
											<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>/ekle">Yeni Ekle</a>
										</div>
									</div>
								</div>
							</div>
					  	 <!--/adres-->	
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
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('.adressil').click(function(){
			var id = $(this).attr('id');
			$.ajax({
				type:'POST',
				url:'ajax/adres.php',
				data: 'veri=adressil&id='+id,
				cache:false
			}).done(function(e){
				console.log(e);
				if(e == "done"){
					$('#a-blok'+id).remove();
				}else{
					alert(e);
				}
			}).fail(function(){
				alert("Hata-2");
			});
			return false;
		});
	});
</script>
 </body>
</html>