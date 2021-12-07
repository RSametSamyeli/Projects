<?php  if( !defined("SABIT") ){ exit; } 

## uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	exit;
}
$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$sayfa = intval($get3); 
$unx_seo 	 = unserialize($sef_fiyatalarm['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

seoyaz("".$title."","".$description."","".$keywords ."",""); 
$alarm  = $conn -> query("select * from fiyatalarm where user_id = ".intval($uyebul['id'])." order by id desc");
?>
<meta name="robots" content="noindex,no-follow" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/profilim.css" />
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
					<li><?php echo ucfirsttr($sef_fiyatalarm_baslik[$set['lang']['active']]); ?></li>
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
										<h2><?php echo ucfirsttr($sef_fiyatalarm_baslik[$set['lang']['active']]); ?></h2>
									</div>
									<?php if($alarm ->rowCount()  > 0){  ?>
										<div class="table-responsive">          
										  <table class="table table-datatables">
												<thead>
												  <tr>
													<th>Ürün Adı</th>
													<th>Güncel Fiyat</th>
													<th>Alarm Fiyat</th>
													<th>Süre</th>
													<th>Eklenme Tarih</th>
													<th>İşlem</th>
												  </tr>
												</thead>
												<tbody>
												  <?php foreach($alarm as $row){
													$uruncek = $conn -> query("SELECT * FROM urun where id = ".intval($row['urun_id']))->fetch();
													$urunimg    = unserialize($uruncek['resimler']);
													$baslik = unserialize($uruncek['baslik']);
													$sef        = unserialize($uruncek['sef']);
													?>
												 
												 <tr id="remove<?php echo $row['id']; ?>">
													
													<td><?php echo $baslik[$set['lang']['active']]; ?></td>
													<td><?php echo number_format($uruncek['yenifiyat'],2); ?> <?php echo $lang['yardimci']['tl']; ?></td>
													<td><?php echo $row['fiyat']; ?></td>
													<td><?php echo $row['sure']; ?></td>
													<td><?php echo date("d.m.Y H:i",$row['tarih']); ?></td>
													<td class="islem">
														
														<a id="<?php echo $row['id']; ?>" href="#"  class="btn btn-red btn-sm btn-icon icon-left favori-sil">
															<i class="fa fa-remove" aria-hidden="true"></i>
															Sil
														</a>
													</td>	
												  </tr>
												  <?php  } ?>
												</tbody>
										  </table>
										  </div>
									
									<?php } else{ ?>
										<div class="siparis-yok">
											Listede Ürün Bulunmuyor
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
		$('.favori-sil').click(function(){
			var urunid = $(this).attr('id');
			$.ajax({
				type  : 'POST',
				data  : 'veri=fiyatalarmsil&id='+urunid,
				url   : 'ajax/uyelik.php',
				cache : false,
				success : function(result){	
					if(result != 'done'){
						swal({	
						  type: 'error',
						  title: ''+result+'',
						  confirmButtonColor: '#333',
						});
					}else{
						$('#remove'+urunid).remove();
					}
				}, error: function (xhr, desc, err) {
					console.log("Details: " + desc + "\nError:" + err);
				}
			});
			return false;
		});
		
		var $zrtable  = $(".table-datatables");
		 $("table.table-datatables").DataTable( {
			 searching: false,
			 bLengthChange: false,
			 order:[],
			'aoColumns': [
				 {  bSearchable: false, bSortable:true },
				 {  bSearchable: false, bSortable: false },
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