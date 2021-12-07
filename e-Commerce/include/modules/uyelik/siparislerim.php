<?php  if( !defined("SABIT") ){ exit; } 

## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	exit;
}
$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_siparislerim['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
$siparislerim = $conn -> query("select * from siparis where user_id = ".intval($uyebul['id'])." && siparisturu = 0 order by id desc");

?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/js/datatables/datatables.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="/"> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
				<li><?php echo ucfirsttr($lang['yardimci']["siparislerim"]); ?></li>
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
								<div class="siparislerim">
									<div class="s-title">
										<h2><?php echo ucfirsttr($lang['yardimci']["siparislerim"]); ?></h2>
									</div>
									<?php if($siparislerim->rowCount()  > 0){  ?>
										<div class="">          
										  <table class="">
												<thead>
												  <tr>
													<th># <?php echo $lang['yardimci']['siparisno']; ?></th>
													<th><?php echo $lang['yardimci']['urun']; ?></th>
													<th><?php echo $lang['yardimci']['siparistarihi']; ?></th>
													
													<th><?php echo $lang['yardimci']['durum']; ?></th>
													<th><?php echo $lang['yardimci']['tutar']; ?></th>
													
													<th><?php echo $lang['yardimci']['islem']; ?></th>
													
												  </tr>
												</thead>
												<tbody>
												  <?php foreach($siparislerim as $row){
													$basliklar  = unserialize($row['baslik']);
													$sipdurum     = $conn -> query("select * from siptanimla where id  = ".intval($row['durum']))->fetch();
													$sipdurumName =  unserialize($sipdurum['baslik']);												 
												 ?>
												  <tr>
													<td><?php echo $row['oid']; ?></td>
													<td>
														<?php foreach($basliklar as $row2){
															echo $row2." <br/>";
														}?>
													</td>
													<td><?php echo date("d-m-Y H:i",$row['tarih']); ?></td>
													
													<td>
														<?php echo $sipdurumName['tr']; ?>
													</td>
													<td>
													<?php if($row['kreditutar'] >=  $row['toplamtutar'] ) {
															$toplamTutar = $row['toplamtutar'] + $row['kargotutar'];
														}else {
															$toplamTutar = $row['toplamtutar'];
														} ?>
														
													<?php echo number_format($toplamTutar,2); ?> 
													<?php echo $lang["yardimci"]['tl']; ?></td>
													<td class="islem">
													<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_siparis_link[$set['lang']['active']]; ?>/<?php echo $row['id']; ?>"  class="btn btn-default btn-sm btn-icon icon-left ">
															<i class="fa fa-search"></i>
															Detay	
														</a>	
													</td>
													
												  </tr>
												  <?php  } ?>
												</tbody>
										  </table>
										  </div>
									
									<?php } else{ ?>
										<div class="siparis-yok">
											Siparişiniz Bulunmuyor
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
<script src="<?php echo $set['siteurl']; ?>/assets/js/select2/select2.min.js"></script>
<script src="<?php echo $set['siteurl']; ?>/assets/js/datatables/datatables.js"></script>
<script type="text/javascript">
	$(function(){
	
		var $zrtable  = $(".table-datatables");
		 $("table.table-datatables").DataTable( {
			 searching: false,
			 bLengthChange: false,
			 order:[],
			'aoColumns': [
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
				 {  bSearchable: false, bSortable: true },
				 { 	 bSearchable: false, bSortable: false },
		   ],
		 });
	});
</script>
<?php _footer_last(); ?>
 </body>
</html>