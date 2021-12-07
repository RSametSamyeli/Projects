<?php  if( !defined("SABIT") ){ exit; } 

## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	exit;
}
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }


$unx_seo 	 = unserialize($sef_destek['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
$destekler = $conn -> query("select * from destek where user_id = ".intval($uyebul['id'])." order by id desc");
$desteklerFetch	   = $destekler->fetchAll();
$desteklerCount	   = $destekler->rowCount();
if($get2 == $detaysef_destek_link[$set['lang']['active']]){
	include('include/modules/destek/ekle.php');
	exit;
}elseif(!empty($get2) && $get2 != $detaysef_destek_link[$set['lang']['active']]) {
	include('include/modules/destek/detay.php');
	exit;
}
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
</head>
<body class="cnt-home">
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
									<div class="destek-button">
											<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>/<?php echo $detaysef_destek_link[$set['lang']['active']]; ?>" class="btn btn-primary btn-icon btn-sm icon-left hidden-print siparis-list">
												<?php echo $lang['yardimci']['destek_iste']; ?>
												<i class="fa fa-plus" aria-hidden="true"></i>
											</a>
									</div>
									<?php if($desteklerCount > 0){  ?>
										<div class="destek-table">
											<div class="table-responsive"> 
												<div class="table">
													<table>
														<thead>
															<tr>
																<td><span>ID</span></td>
																<td><span>Başlık</span></td>
																<td><span>Konu</span></td>
																<td><span>Tarih</span></td>
																<td><span>Durumu</span></td>
																<td class="text-center"><span>İşlem</span></td>
															</tr>
														</thead>
														<tbody>
															<?php foreach($desteklerFetch as $row) {  ?>	
															<tr>
																<td><?php echo $row['id']; ?></td>
																<td><?php echo $row['baslik']; ?></td>
																<td><?php echo $row['konu']; ?></td>
																<td><?php echo date("d.m.Y H:i",$row['tarih']); ?></td>
																<td>
																<?php if($row['durum'] ==1 ){
																	echo '<button type="button" class="btn btn-info btn-icon btn-xs">Cevap Bekliyor<i class="entypo-help"></i></button>';
																}elseif($row['durum'] == 0){
																	echo '<button type="button" class="btn btn-primary btn-xs btn-icon">Kapalı<i class="entypo-cancel"></i></button>';
																}elseif($row['durum'] == 2){
																	echo '<button type="button" class="btn btn-green btn-xs btn-icon">Cevaplandı<i class="entypo-check"></i></button>';
																}?>
																</td>
																<td class="text-center durum-content"><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>/<?php echo $row['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
																	
																</td>
																
															</tr>
															<?php  } ?>
														</tbody>
													</table>
												</div>
											</div>
										
										</div>
									
									<?php } else{ ?>
										<div class="siparis-yok">
											Kayıt Bulunmuyor
											
										</div>
									<?php } ?>
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
<?php _footer_last(); ?>
 </body>
</html>