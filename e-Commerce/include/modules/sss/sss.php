<?php  if( !defined("SABIT") ){ exit; } 
$unx_seo 	 = unserialize($sef_sss['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];
$kapak = glob("uploads/onkapak/kurumsal/kurumsal.*");
$sss = $conn -> query("SELECT * FROM sss order by sira asc");
seoyaz("".$title."","".$description."","".$keywords."",""); 
$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/sss.css" />
</head>
<body>
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="outer-page">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><?php echo $lang['genel']['sss']; ?></li>
				</ul>
			</div>
		<div class="inner-page">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="inner-page">
							<div class="profilim">
								<div class="title">
									<h2>Sıkça Sorun Sorular</h2>
								</div>
								<div class="sss-content">
									<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									  <?php if($sss -> rowCount() > 0){
										foreach($sss as $s){
										$unx_baslik = unserialize($s['baslik']);
										$unx_aciklama = unserialize($s['aciklama']);						
										?>
									  <div class="panel panel-default is-collapse">
										<div class="panel-heading" role="tab" id="headingOne">
										  <h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#">
											<?php echo $unx_baslik[$set['lang']['active']]; ?>
											</a>
										  </h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										  <div class="panel-body">
											 <?php echo html_entity_decode($unx_aciklama[$set['lang']['active']]); ?>
										  </div>
										</div>
									  </div>
									  <?php } }?>
									</div>
								</div>
								<!--/sss-->
							</div>
						</div>
					</div>
				<!--/left-->
				</div>
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
		$(".panel-heading:first").addClass('panel-opened');
		$('.panel-collapse:first').stop().slideToggle(500);
		$('.is-collapse .panel-heading').on('click', function(e) {
			e.preventDefault();
			var index = $(this).index('.panel-heading');
			$(".panel-heading").not(index).removeClass('panel-opened');
			$(".panel-heading").eq(index).addClass('panel-opened');
			$('.panel-collapse').not(index).stop().slideUp(500);
			$('.panel-collapse').eq(index).stop().slideToggle(500);
		});	
	})
</script>
 </body>
</html>