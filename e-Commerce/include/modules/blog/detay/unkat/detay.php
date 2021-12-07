<?php  if( !defined("SABIT") ){ exit; } 
if(empty($get2)){
	 include("include/modules/404/404.php"); exit;
}
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM blog WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}

## cookie

  if (!isset($_COOKIE["oku_{$bul['id']}"])) {
	setcookie("oku_{$bul['id']}","Counted!",time()+604800);
	$conn -> exec("UPDATE blog SET okunma = okunma +1 WHERE id  = '".intval($bul['id'])."'");
   }
$secilenler3       = $conn -> query("select * from urun where yeniurun = 1 order by sira asc limit 6");   
$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_aciklama 	 = unserialize($bul['aciklama']);
$unx_resimler 	 = unserialize($bul['resimler']);
$baslik 		 = $unx_baslik[$set['lang']['active']];
$aciklama 		 = $unx_aciklama[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
$haberler		 = $conn -> query("SELECT * FROM blog ORDER BY sira ASC limit 10")->fetchAll();
if(empty($title)) {
$title = $baslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
@$sresim =  $set['siteurl']."/uploads/blog/thumb/".$unx_resimler[0]."";
seoyaz("".$title."","".$descripton ."","".$keywords."","".@$sresim.""); 
$kapak = glob("uploads/onkapak/haberler/haberler.*");
$arkakapak = glob("uploads/arkakapak/haberler/haberler.*"); 

$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
$secilenler2       = $conn -> query("select * from urun where gununfirsati = 1 order by sira asc limit 6"); 
$secilenler        = $conn -> query("select * from urun order by sira asc limit 6");
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/sayfa.css" />
<body class="product-page">
<div id="page"> 

<?php include('include/sabit/header.php'); ?>
<div class="outer-page">
		<div class="container">
			<ul class="breadcrumb">
					<li><a href="/"><i class="fa fa-home"></i> <?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></li>
					<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_blog_link[$set['lang']['active']]; ?>"><?php echo ucfirsttr($sef_blog_baslik [$set['lang']['active']]); ?></a></li>
					<li><?php echo $baslik; ?></li>
				
		</ul>
		</div>
		<div class="inner-page">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-xs-12">
						<div class="kurumsal-sidebar">
							<div class="title"><h1>Blog Yazıları</h1></div>
							<ul>
								<?php foreach($haberler as $row){ 
											$name = unserialize($row['baslik']);
											$sef  = unserialize($row['sef']);									
											?>	
											<li><a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_blog_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row[0]?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
											<?php } ?>
							</ul>
						</div>
					</div>
					<!--/sol-->
					<div class="col-md-9 col-xs-12">
						<div class="sayfa-content">
						<div class="featured-thumb">
						<img src="<?php echo $set['siteurl']; ?>/uploads/blog/thumb/<?php echo $unx_resimler[0]; ?>"  />
						</div>
							<div class="title"><h2><?php echo $baslik; ?></h2></div>
							<div class="text"><?php echo html_entity_decode($aciklama); ?></div>
						</div>
					</div>
					<!--/sag-->
				</div>
			</div>
		</div>
</div>

<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl']; ?>/assets/js/bootstrapValidator.min.js"></script>
<?php _footer_last(); ?>
<script type="text/javascript">
	$(function(){
		$('#erkaofisimo_font_buyut').click(function(){	   
			curSize= parseInt($('.erkaofisimo_fontsize').css('font-size')) + 2;
			if(curSize<=20)
				$('.erkaofisimo_fontsize').css('font-size', curSize);
			return false;
		});  
		$('#erkaofisimo_font_kucult').click(function(){	   
			curSize= parseInt($('.erkaofisimo_fontsize').css('font-size')) - 2;
			if(curSize>=12)
				$('.erkaofisimo_fontsize').css('font-size', curSize);
			return false;	
		}); 
		$('#erkaofisimo-yorum-form').bootstrapValidator({
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
				yorum: {
					validators: {
						notEmpty: {
							message: '<?php echo $lang['mesaj']['bos_yorum']; ?>'
						},
						 stringLength: {
                            min: 10,
                            message: '<?php echo $lang['mesaj']['min_mesaj']; ?>'
                        }
					}
				}
				
			}
		}).on('success.form.bv', function(e) {
				e.preventDefault();
				var data = $("#erkaofisimo-yorum-form").serialize();
				$(".ci-yorum-gonder").append('<span>&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
				$.ajax({
					type:'POST',
					url:'ajax/yorum.php',
					data: data,
					cache:false
				}).done(function(e){
					if( e != "done"){
						$(".ci-yorum-gonder").html('<?php echo $lang['yardimci']['gonder'];  ?>');
						$('.erkaofisimo-errors').html('<span>'+e+'</span>');
					}else{
						$('.erkaofisimo-yorum-yap').slideUp();
						$('.erkaofisimo-success-msg-content').show();
					}
				}).fail(function(){
					alert("Hata-2");
				});
			});
	});
</script>
<script type="text/javascript">
	function PrintContent() {
		var DocumentContainer = document.getElementById('erkaofisimo-yazdir-content');
		var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
</script>
 </body>
</html>