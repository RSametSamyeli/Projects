<?php  if( !defined("SABIT") ){ exit; } 

## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }

$unx_seo 	 = unserialize($sef_havalebildirimi['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
$destekler = $conn -> query("select * from havalebildirimi where user_id = ".intval($uyebul['id'])." order by id desc");
$desteklerFetch	   = $destekler->fetchAll();
$desteklerCount	   = $destekler->rowCount();

?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
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
										<h2><?php echo $sef_havalebildirimi_baslik[$set['lang']['active']]; ?></h2>
									</div>
									<div class="destek-button">
											<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_havalebildirimi_link[$set['lang']['active']]; ?>" class="btn btn-primary btn-icon btn-sm icon-left hidden-print siparis-list">
												<?php echo $sef_havalebildirimi_baslik[$set['lang']['active']]; ?>
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
																<td><span>Ödeme Yapılan Banka</span></td>
																<td><span>Sipariş No</span></td>
																
																<td><span>İşlem Tarih</span></td>
																<td><span>Durumu</span></td>
																
															</tr>
														</thead>
														<tbody>
															<?php foreach($desteklerFetch as $row) { 
															$bankabul   = $conn -> query("select * from banka where id = ".intval($row['banka_id']))->fetch();
															$siparisbul = $conn -> query("select * from siparis where id = ".intval($row['siparis_id']))->fetch();
															?>	
															<tr>
																<td><?php echo $bankabul['banka_adi']."-".$bankabul['iban']."-".$bankabul['hesap_no']."-".$bankabul['sube_kodu']."-".$bankabul['hesap_adi']; ?></td>
																<td>
																	<a style="font-size:13px; color:#444; text-decoration:underline; " href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_siparis_link[$set['lang']['active']]; ?>/<?php echo $siparisbul['id']; ?>">#<?php echo $siparisbul['oid']; ?></a>
																</td>
																<td><?php echo date("d.m.Y H:i",$row['tarih']); ?></td>
																<td>
																<?php if($row['durum'] ==1 ){
																	echo '<button type="button" class="btn btn-success btn-icon btn-xs">Onayland<i class="entypo-check"></i></button>';
																}elseif($row['durum'] == 0){
																	echo '<button type="button" class="btn btn-primary btn-xs btn-icon">Onay Bekliyor<i class="entypo-cancel"></i></button>';
																}?>
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