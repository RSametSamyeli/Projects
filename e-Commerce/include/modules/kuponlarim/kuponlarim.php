<?php  if( !defined("SABIT") ){ exit; } 

## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }

$sayfa = intval($get3); 

$unx_seo 	 = unserialize($sef_kuponlarim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
$kuponlarim            = $conn -> query("select * from kuponlar order by id desc");
$kuponlarimFetch	   = $kuponlarim ->fetchAll();
$kuponlarimCount	   = $kuponlarim ->rowCount();
$kupongecmisi          = $conn -> query("select * from kupongecmisi where userid = ".intval($uyebul['id'])." order by id desc");
$puangecmisi 		   = $conn -> query("select * from puangecmisi where uye_id = ".intval($uyebul['id'])." && kullanma = 0 order by id desc");	
$harcanan  			   = 0;
$harcananpuan		   = $conn -> query("select puan_toplam from puangecmisi where uye_id = ".intval($uyebul['id'])." && kullanma = 1 order by id desc");	
foreach($harcananpuan as $key){
	$harcanan = $harcanan + $key['puan_toplam'];
}
			
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/kuponlarim.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/js/datatables/datatables.css" />
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
					<li><?php echo ucfirsttr($sef_kuponlarim_baslik[$set['lang']['active']]); ?></li>
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
								<div class="kuponlarim">
									<div class="title">
										<h2><?php echo ucfirsttr($sef_kuponlarim_baslik[$set['lang']['active']]); ?></h2>
									</div>
									<div class="puanlar">
										<div class="title">
											Puanlarım
										</div>
										<div class="puan-table">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th></th>
														<th>Toplam Kazanılan</th>
														<th>Toplam Harcanan</th>
														<th>Kullanılabilir Puan</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Puan</td>
														<td><?php echo $uyebul['uye_puan']; ?> Puan</td>
														<td><?php echo $harcanan; ?> Puan</td>
														<td><?php echo $uyebul['uye_puan']; ?> Puan</td>
													</tr>
													<tr>
														<td>Şimdiki Puan Değeri</td>
														<td><?php echo puanconvert($uyebul['uye_puan']); ?> TL</td>
														<td><?php echo puanconvert($harcanan); ?> TL</td>
														<td><?php echo puanconvert($uyebul['uye_puan']); ?> TL</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="title">
											Puan Geçmişi
										</div>
										<div class="puan-table table-datatables">
											<table class="table table-bordered table-datatables">
												<thead>
													<tr>
														<th>Tarih</th>
														<th>Puan</th>
														<th>Puan Türü</th>
													</tr>
												</thead>
												<tbody>
											<?php if($puangecmisi -> rowCount() > 0){ 
													foreach($puangecmisi as $row){
													?>
													<tr>
														<td><?php echo date("d.m.Y H:i ",$row['puan_tarih']); ?></td>
														<td><?php echo $row['puan_toplam']; ?> Puan</td>
														<td>
															<?php if($row['puan_tur'] == 0) 
																echo 'Üye Olma';
																elseif($row['puan_tur'] == 1)
																echo 'Sipariş';
																elseif($row['puan_tur'] == 2)
																echo 'Yorum Yapma';
															?>
														</td>
													</tr>
														<?php  }  //endforeach  ?>
													<?php  }  // endif ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="acik-kuponlar">
										<div class="title">
											Açık Kuponlarım
										</div>
										<div class="kupon-table">
											<div class="table-responsive">     
												 <table class="table table-bordered table-datatables">
													<thead>
														<th>Kupon Kodu</th>
														<th>Değer</th>
														<th>Kullanım Alışveriş Sınırı</th>
														<th>Başlangiç Tarihi</th>
														<th>Son Kullanma Tarihi</th>
														<th>Durum</th>
													</thead>
													<tbody>
														<?php 
														if($kuponlarimCount > 0){
														foreach($kuponlarimFetch as $row){ 
															/*  Koşul 1 */
															if(empty($row['userid']) || $row['userid'] == $uyebul['id']){
 														?>
															<tr>
																<td><?php echo $row['kod']; ?></td>
																<td>
																<?php if($row['indirimtipi'] == 1) {
																	echo  " %". number_format($row['tutar'],0)."";
																}else {
																	echo $row['tutar']." TL";
																}?>
																</td>
																<td><?php echo $row['sepettoplam']; ?></td>
																<td><?php echo $row['baslangic']; ?></td>
																<td><?php echo $row['bitis']; ?></td>
																<td>
																	<?php if($row['durum'] == 0) { 
																		echo '<span class="kapali">Kapalı</span>';
																	}else {
																		echo '<span class="acik">Açık</span>';
																	}?>
																</td>
															</tr>
														<?php  }  } } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="gecmis-kuponlarim">
										<div class="title">Geçmiş Kuponlarım</div>
										<div class="kupon-table">
											<div class="table-responsive">     
												 <table class="table table-bordered table-datatables">
													<thead>
														<th>Kupon Kodu</th>
														<th>Değer</th>
														<th>Alışveriş Tutarı</th>
														<th>Kullanım Tarihi</th>
														<th>Durum</th>
														<th>Kullanılan Sipariş</th>
														
													</thead>
													<tbody>
														<?php 
														if($kupongecmisi -> rowCount() > 0){
														foreach($kupongecmisi as $row) {  
														$sipcek = $conn -> query("select * from siparis where oid = ".intval($row['siparisid'])." ")->fetch();
														?>
														<tr>
															<td><?php echo $row['kuponkod']; ?></td>
															<td>
															<?php if($row['indirimtipi'] == 1) {
																	echo  " %". number_format($row['tutar'],0)."";
																}else {
																	echo $row['tutar']." TL";
																}?>
															</td>
															<td><?php echo $sipcek['toplamtutar']; ?> TL</td>
															<td><?php echo date("d.m.Y H:i",$row['tarih']); ?></td>
															<td><?php echo $row['durum'] == 0  ? 'Kullanıldı' :  'Kullanılmadı'; ?></td>
															<td>
															<?php if($sipcek['id'] != 0) {?>
															<a href="<?php echo $set['siteurl']; ?>/<?php echo $detaysef_siparis_link[$set['lang']['active']]; ?>/<?php echo $sipcek['id']; ?>"  class="btn btn-default btn-sm btn-icon icon-left ">
																<i class="fa fa-search"></i>
																Detay	
															</a>
															<?php  } ?>
															</td>
														</tr>
														<?php } } ?>
													</tbody>
												</table>
											</div>
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
<script src="<?php echo $set['siteurl']; ?>/assets/js/select2/select2.min.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/datatables/datatables.js"></script>
<script type="text/javascript">
	$(function(){
		var $zrtable  = $(".table-datatables");
		 $("table.table-datatables").DataTable({
			 searching: false,
			 bLengthChange: false,
		 });
	});
</script>
<?php _footer_last(); ?>
 </body>
</html>