<?php  if( !defined("SABIT") ){ exit; } 
if($main_settings['kredisistemi'] == 0) { exit;} 
## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }

$sayfa = intval($get3); 

$unx_seo 	 = unserialize($sef_kredilerim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 

$kredigecmisi 		   = $conn -> query("select * from kredigecmisi where uye_id = ".intval($uyebul['id'])." && kullanma != 1 order by id desc");	
$onaylanankredi 	   = $conn -> query("select SUM(puan_toplam) from kredigecmisi where uye_id = ".intval($uyebul['id'])." && durum = 1 && kullanma = 0")->fetch();	
$bekleyenkredi 	  	   = $conn -> query("select SUM(puan_toplam) from kredigecmisi where uye_id = ".intval($uyebul['id'])." && durum = 0")->fetch();	
$toplamkredi 	  	   = $conn -> query("select SUM(puan_toplam) from kredigecmisi where uye_id = ".intval($uyebul['id'])." && kullanma = 0 && durum = 1")->fetch();	
$kullanabilirkredi     = $conn -> query("select SUM(puan_toplam) from kredigecmisi where uye_id = ".intval($uyebul['id'])." && durum = 1 && kullanma = 0")->fetch();	
$harcanan  			   = 0;
$harcananpuan		   = $conn -> query("select * from kredigecmisi where uye_id = ".intval($uyebul['id'])." && kullanma = 1 && durum = 1 order by id desc");
$harcananpuanFetch     = $harcananpuan -> fetchAll();
$harcananpuanCount	   = $harcananpuan -> rowCount();	
	
foreach($harcananpuanFetch as $key){
	$harcanan = $harcanan + $key['puan_toplam'];
}
## adresler
$adresler      = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 
$adreslerCount =  $adresler -> rowCount();
$adreslerFetch =  $adresler -> fetchAll();

?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/kredilerim.css" />
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
					<li><?php echo ucfirsttr($sef_kredilerim_baslik[$set['lang']['active']]); ?></li>
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
								<div class="kredilerim">
									<div class="title">
										<h2><?php echo ucfirsttr($sef_kredilerim_baslik[$set['lang']['active']]); ?></h2>
									</div>
									<div class="kredi-tabs">
											<ul class="nav nav-tabs " role="tablist">
												<li class="active">
													<a href="#tab1" role="tab" data-toggle="tab">EKLENEN KREDİ</a>
												</li>
												<li>
													<a href="#tab2" role="tab" data-toggle="tab">KULLANILAN KREDİ</a>
												</li>
												<li>
													<a href="#tab3" role="tab" data-toggle="tab">KREDİ SİPARİŞİ</a>
												</li>	
											
											</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab1">
												<div class="kredi-table">
													<table class="table table-bordered table-datatables">
														<thead>
															<tr>
															
																<th>Kredi Tutarı</th>
																<th>Eklenme Tarihi</th>
																<th>Durum</th>
															</tr>
														</thead>
														<tbody>
															<?php if($kredigecmisi -> rowCount() > 0){  ?>
																<?php foreach($kredigecmisi as $row) { ?>
																	<tr>
																		<td><?php echo $row['puan_toplam']; ?></td>
																		<td><?php echo date("d.m.Y H:i",$row['puan_tarih']); ?></td>
																		<td><?php echo $row['durum'] == 1 ?  '<span class="onaylandi">Onaylandı</span>' : '<span class="bekliyor">Bekliyor</span>'; ?></td>
																	</tr>
																<?php } ?>
															<?php  } ?>
														</tbody>
													</table>
												</div>
												<?php if( $kredigecmisi -> rowCount() > 0) { ?>
												<div class="kredi-sonuc col-md-6">
													<div class="col-md-7" style="border-right:1px solid #f5f5f5">Onaylanan Tutar</div>
													<div class="col-md-5" style="border-right:1px solid #f5f5f5"><?php echo $uyebul['uye_kredi']; ?></div>
													<?php  if(!empty($bekleyenkredi['SUM(puan_toplam)'])) { ?>
													<div class="col-md-7" style="border-right:1px solid #f5f5f5">Bekleyen Tutar</div>
													<div class="col-md-5" style="border-right:1px solid #f5f5f5"><?php echo $bekleyenkredi['SUM(puan_toplam)']; ?></div>
													<?php  } ?>
													<?php if(!empty($toplamkredi['SUM(puan_toplam)'])) { ?>
													<div class="col-md-7" style="border-right:1px solid #f5f5f5">Toplam Tutar</div>
													<div class="col-md-5" style="border-right:1px solid #f5f5f5"><?php echo $toplamkredi['SUM(puan_toplam)']; ?></div>
													<?php  } ?>
													<?php if(number_format($harcanan,2) != 0.00){ ?>
													<div class="col-md-7" style="border-right:1px solid #f5f5f5 ; color:red;">Kullanılan Toplam Tutar</div>
													<div class="col-md-5" style="border-right:1px solid #f5f5f5; color:red;"><?php echo number_format($harcanan,2); ?></div>
													<?php  } ?>
													<div class="col-md-7" style="border-right:1px solid #f5f5f5;  color:#00b5ad">Kullanılabilir Toplam Tutar</div>
													<div class="col-md-5" style="border-right:1px solid #f5f5f5; color:#00b5ad"><?php echo $uyebul['uye_kredi']; ?></div>
												</div>
												<?php  } ?>		
											</div>
											<div class="tab-pane" id="tab2">
												<div class="kredi-table">
													<table class="table table-bordered table-datatables">
															<thead>
																<tr>
																
																	<th>Kredi Tutarı</th>
																	<th>Tarih</th>
																	<th>Durum</th>
																</tr>
															</thead>
															<tbody>
																<?php if($harcananpuanCount > 0){  ?>
																	<?php foreach($harcananpuanFetch as $row) { ?>
																		<tr>
																			<td><?php echo $row['puan_toplam']; ?></td>
																			<td><?php echo date("d.m.Y H:i",$row['puan_tarih']); ?></td>
																			<td><?php echo $row['kullanma'] == 1 ?  '<span class="onaylandi">Kullanıldı</span>' : '<span class="bekliyor">Bekliyor</span>'; ?></td>
																		</tr>
																	<?php } ?>
																<?php  } ?>
															</tbody>
														</table>
												 </div>	
											</div>
											<div class="tab-pane" id="tab3">
												<div class="kredi-siparis">
													<div class="title">
														Kredi Siparişi
													</div>
													<div class="form">
														<form action="<?php echo $set['langurl']; ?>/krediodeme" method="post" id="krediForm">
															<div class="form-group">
																<label>Kredi Miktarı (Örnek: 25.00) </label>
																<input type="text" class="kredi-miktar form-control" name="kredimiktar" />
															</div>
															<?php if($adreslerCount > 0) { ?>
															<div class="form-group">
																<label>Fatura Adresi</label>
																<select name="faturaadresi" class="form-control fatura-adresi" id="">
																	<?php foreach($adreslerFetch as $row){?>
																	<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> - <?php echo $row['adres']; ?></option>
																	<?php  } ?>
																</select>
															</div>
															<?php } ?>
															<?php if($adreslerCount > 0) { ?>
															<div class="form-group">
																<button type="button" class="btn btn-success kredi-siparis-ver">SİPARİŞ VER</button>
															</div>
															<?php  } else { ?>
																<div class="adres-tanimla">
																	Kayıtlı Adres Bulunmuyor. <a href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>/ekle">Adres Eklemek İçin Tıklayın.</a>
																</div>
															<?php } ?>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!--/tabs-->
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
		 $(".kredi-miktar").on("keypress keyup blur",function (event) {
			    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
					if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			}); 
            //this.value = this.value.replace(/[^0-9\.]/g,'');
		$('button.kredi-siparis-ver').click(function(){
			var miktar = $('input[name="kredimiktar"]').val();
			if(miktar == ""){
				swal({
				  type: 'error',
				  title: 'Miktar Boş Olamaz',
				  confirmButtonColor: '#333',
				});
				return false;	
			}
			$('#krediForm').submit();
		});
		
		
		var $zrtable  = $(".table-datatables");
		 $("table.table-datatables").DataTable( {
			 searching: false,
			 bLengthChange: false,
			 order:[],
			'aoColumns': [
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
		   ],
		 });
	});
</script>
<?php _footer_last(); ?>
 </body>
</html>