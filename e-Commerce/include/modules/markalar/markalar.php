<?php  if( !defined("SABIT") ){ exit; } 
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM marka WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit; }

$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$markabaslik 		 = $unx_baslik[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
if(empty($title)) {
	$title = $markabaslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];


$varyantkats  = $conn -> query("select * from kategori where modul = 'varyant' ORDER by sira ASC");
$sayfalink = $set['langurl'].'/'.$sef_markalar_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'-'.$bul['id'];

#### Sayfalama  #####
$sayfa	= 1;
$kacar 	= 12;
if( isset($_GET["sayfa"]) ){
	if( !ctype_digit($_GET["sayfa"]) ){ header("Location: ".$set["siteurl"]);exit; }
	$sayfa = intval(@$_GET["sayfa"]);
	if( $sayfa < 1 ){ $sayfa=1; }
}

$page_sprint 	    = $sayfalink."?sayfa=%d";
$fiyat_sprint 	    = $sayfalink."?fiyat=%s";
$filtre_sprint   	= $sayfalink."?filtre=%s";
$orderby_sprint 	= $sayfalink."?orderby=%s";



/* ---------------------  Sidebar ----------------------------- */
function sidebar($ustid){
	global $conn,$set,$sef_urunler_link,$id;

	$katsorgu = $conn -> query("select * from kategori where modul = 'urunler' and ustid = ".intval($ustid)." order by sira asc");	
	$katsorguCount = $katsorgu -> rowCount();
	if($katsorguCount > 0 ){
		echo '<ul>';
		foreach($katsorgu as $row){
			$name = unserialize($row['baslik']);
			$sef  = unserialize($row['sef']);
			$altmenu = $conn -> query("select * from kategori where ustid = '".intval($row['id'])."'");
			echo '<li class="'; 
			if($altmenu -> rowCount() > 0){
				echo 'has ';
			}
			if($row['id'] == $id){
				echo 'active';
			}
			echo '" '; 
			
			echo '><a href="'.$set['siteurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'">- '.$name[$set['lang']['active']].'</a>';
					sidebar($row['id']);
			echo '</li>';
		}
		echo '</ul>';
	}
}
/* ---------------------  Sidebar Bitti ----------------------------- */


/* ---------------------  Filtrele ----------------------------- */

$urunlerYeni = array();

######### Orderby Varsa ##############
if(isset($_GET["orderby"])){ 
	
	$orderby = clean($_GET["orderby"]);
	if($orderby == 3){
		$field = 'yenifiyat'; 
		$short = 'ASC';
	}elseif($orderby == 4){
		$field = 'yenifiyat'; 
		$short = 'DESC';
	}
	
	$page_sprint = $sayfalink."?orderby=".$orderby."&sayfa=%d";
	$kactane	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."'");
	$num 		  = $kactane-> rowCount();
	$sayfasayisi  = ceil($num/$kacar);
	$nerden	      = ($sayfa*$kacar)-$kacar;
	###### Sayfalama  Bitti  #######
	$urunler 	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."' ORDER BY ".$field." ".$short." LIMIT ".$nerden.",".$kacar."");
	$urunlerCount = $urunler -> rowCount();
	foreach($urunler as $key){
		$urunlerYeni[]   = $key;
	}

}

######### Filtre Varsa ##############

if(isset($_GET["filtre"])){
	$filtre   = clean($_GET["filtre"]);
	$parcala  = explode(",",$filtre);
	
	$page_sprint      = $sayfalink."?filtre=".$filtre."&sayfa=%d";
	$fiyat_sprint 	  = $sayfalink."?filtre=".$filtre."&fiyat=%s";
	$orderby_sprint   = $sayfalink."?filtre=".$filtre."&orderby=%s";
	
	$kactane	  = $conn -> query("
	SELECT * FROM 
		urunvaryants 
	INNER JOIN 
		urun on urun.id  = urunvaryants.urunid  
	WHERE varyantdeger IN  (".$filtre.") && marka_id = ".intval($bul['id'])." GROUP BY urun.id
	 ");
	$num 		  = $kactane-> rowCount();
	$sayfasayisi  = ceil($num/$kacar);
	$nerden	      = ($sayfa*$kacar)-$kacar;


	$urunler = $conn -> query("
	SELECT * FROM 
		urunvaryants
	INNER JOIN 
		urun on urun.id  = urunvaryants.urunid
	WHERE varyantdeger IN  (".$filtre.") && marka_id = ".intval($bul['id'])." 
		GROUP BY urun.id
	LIMIT ".$nerden.",".$kacar." 
	");
	$urunlerCount = $urunler -> rowCount();

	foreach($urunler as $key){
		$urunlerYeni[]   = $key;
	}


}

######### Fiyat Varsa ##############
if(isset($_GET["fiyat"])){
	
	$fiyat  = clean($_GET["fiyat"]);
	$parcala = explode(",",$fiyat);
	$min = $parcala[0];
	$max = $parcala[1];
	
	$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat;
	
	if(!isset($_GET["filtre"])){
		
		$page_sprint = $sayfalink."?fiyat=".$min.",".$max."&sayfa=%d";
	
		
		$kactane	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."' AND yenifiyat > $min AND yenifiyat < $max  ");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;
		###### Sayfalama  Bitti  #######
		$urunler 	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."' AND yenifiyat > $min AND yenifiyat < $max  ORDER BY sira ASC LIMIT ".$nerden.",".$kacar."");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
				$urunlerYeni[]   = $key;
			}
			
	}elseif(isset($_GET["fiyat"]) && isset($_GET["filtre"]) && isset($_GET["orderby"]) ){
		$page_sprint 	= $sayfalink."?filtre=".$filtre."&fiyat=".$min.",".$max."&orderby=".$orderby ."&sayfa=%d";
		$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat."&orderby=".$orderby;
		$orderby_sprint = $sayfalink."?filtre=".$filtre."&fiyat=".$fiyat."&orderby=%s";
		$fiyat_sprint 	  = $sayfalink."?filtre=".$filtre."&fiyat=%s&orderby=".$orderby;
		$kactane	  = $conn -> query("
		SELECT * FROM 
			urunvaryants 
		INNER JOIN 
			urun on urun.id  = urunvaryants.urunid  
		WHERE varyantdeger IN  (".$filtre.") && marka_id = ".intval($bul['id'])."  AND urun.yenifiyat > $min AND urun.yenifiyat < $max  GROUP BY urun.id
		 ");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;



		$urunler = $conn -> query("
		SELECT * FROM 
			urunvaryants
		INNER JOIN 
			urun on urun.id  = urunvaryants.urunid
		WHERE varyantdeger IN  (".$filtre.") && marka_id = ".intval($bul['id'])."  AND urun.yenifiyat > $min AND urun.yenifiyat < $max 
			GROUP BY urun.id ORDER BY ".$field." ".$short."
		LIMIT ".$nerden.",".$kacar." 
		");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
				$urunlerYeni[]   = $key;
			}
			
	
	}else{
		$page_sprint = $sayfalink."?filtre=".$filtre."&fiyat=".$min.",".$max."&sayfa=%d";
		$orderby_sprint = $sayfalink."?filtre=".$filtre."&fiyat=".$fiyat."&orderby=%s";
		$kactane	  = $conn -> query("
		SELECT * FROM 
			urunvaryants 
		INNER JOIN 
			urun on urun.id  = urunvaryants.urunid  
		WHERE varyantdeger IN  (".$filtre.") && marka_id = ".intval($bul['id'])."  AND urun.yenifiyat > $min AND urun.yenifiyat < $max  GROUP BY urun.id
		 ");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;



		$urunler = $conn -> query("
		SELECT * FROM 
			urunvaryants
		INNER JOIN 
			urun on urun.id  = urunvaryants.urunid
		WHERE varyantdeger IN  (".$filtre.") && marka_id= ".intval($bul['id'])."  AND urun.yenifiyat > $min AND urun.yenifiyat < $max 
			GROUP BY urun.id
		LIMIT ".$nerden.",".$kacar." 
		");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
			$urunlerYeni[]   = $key;
		}
	
	}
	
}

if( (!isset($_GET["filtre"])) && (!isset($_GET["fiyat"])) &&  (!isset($_GET["orderby"]))   ){
		$kactane	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."'");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;
		$urunler 	  = $conn -> query("SELECT * FROM urun WHERE marka_id = '".intval($bul['id'])."' ORDER BY sira ASC LIMIT ".$nerden.",".$kacar."");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
			$urunlerYeni[]   = $key;
		}

}

seoyaz("".$title."","".$keywords."","".$descripton ."",""); 
$markalar = $conn -> query("SELECT * FROM marka ORDER BY sira ASC");
$link = $set['siteurl'].$_SERVER['REQUEST_URI'];
?>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/bootstrap-slider.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/kategori.css" />
</head>
<body class="cnt-home">
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
<div class="content-page">
			<div class="container">
				<div class="bread-crumb bg-white border radius6">
					<a href="/"><?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a> <span class="color"><?php echo ucfirsttr($katbaslik); ?></span>
				</div>
				<div class="main-content-page">
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-12">
								
								<div class="filter-content">
							<div class="kat-sidebar">
								<div class="title"><h1>Kategoriler</h1></div>
								<?php 
								sidebar(0);
								?>
							</div>
							<?php if($varyantkats -> rowCount() > 0){ 
								foreach($varyantkats as $row) { 
								$name = unserialize($row['baslik']);
								$gosterim = explode(",",$row['gosterim']);
								$varyants = $conn -> query("select * from varyant where kat_id = ".intval($row['id'])." && gosterim = 1 order by sira asc ");
								if(in_array($bul['id'],$gosterim)){ ?>
								<div class="kat-filter">
									<div class="title"><h2><?php echo strtouppertr($name[$set['lang']['active']]); ?></h2></div>
									<div class="input-form">
										<div class="checks">
											<?php 
											if($varyants -> rowCount()  > 0 ){
												foreach($varyants as $row2){ 
												$name = unserialize($row2['baslik']); ?>
													<?php if(isset($_GET["filtre"])) {
															if(in_array($row2['id'],$parcala)){
																$selected = '<i class="fa fa-check"></i>';
																$a_href   = 'javascript:void(0);'; 
																$renk     = 'secili-renk';
															}else {
																$selected = '';
																$renk     = '';
																$a_href   = $set['siteurl']."/".$sef_urunler_link[$set['lang']['active']]."/".$unx_sef[$set['lang']['active']]."-".$bul['id']."?filtre=".$filtre.",".$row2['id'];
																$a_href    = sprintf($filtre_sprint,$filtre.",".$row2['id']);
															} ?>
														<?php if(empty($row2['varyantrenk'])) {?>
														<a href="<?php  echo $a_href; ?>">
															<span><?php echo $selected; ?></span>
														<?php echo strtouppertr($name[$set['lang']['active']]); ?>
														</a>	
														<?php } else { ?>
															<a class="renk" href="<?php echo $a_href; ?>">
																<div class="renk <?php echo $renk; ?> "><p style="background:<?php echo $row2['varyantrenk']; ?>"></p></div>
															</a>
														<?php } ?>
													<?php } else { 
													
														$a_href = sprintf($filtre_sprint,$row2['id']);
														?>
															<?php if(empty($row2['varyantrenk'])) {?>
															<a href="<?php echo $a_href; ?>">
																<span></span>
																<?php echo strtouppertr($name[$set['lang']['active']]); ?>
															</a>
															<?php  } else { ?>
															<a class="renk" href="<?php echo $a_href; ?>">
																<div class="renk"><p style="background:<?php echo $row2['varyantrenk']; ?>"></p></div>
															</a>
															<?php } ?>
													<?php } ?>
												<?php }
											} ?>
										</div>
									</div>
								</div>
								 <?php  } ?>
								<?php } ?>
							<?php  } ?>
							<div class="kat-filter">
								<div class="title"><h2>Fiyat Aralığı</h2></div>
								<div class="input-form">
									<div class="price-inner">
										<?php if(isset($_GET["fiyat"])){ 
										$fiyat  = clean($_GET["fiyat"]);
										$parcala = explode(",",$fiyat);
										$min = $parcala[0];
										$max = $parcala[1];
										?>
											<input id="zr-price" type="text" name="fiyat" class="span2" value="" data-slider-min="10" data-slider-max="5000" data-slider-value="[<?php echo $min; ?>,<?php echo $max; ?>]"/>
										<?php }else { ?>
											<input id="zr-price" type="text" name="fiyat" class="span2" value="" data-slider-min="10" data-slider-max="5000" data-slider-value="[10,5000]"/>
										<?php } ?>
										
										<input type="hidden" name="katid" class="katid" value="<?php echo $bul['id']; ?>" />
									</div>
								</div>
							</div>
							
							<?php if($markalar -> rowCount() > 0){?>
							<div class="kat-sidebar marka-sidebar">
								<div class="title"><h1>Markalar</h1></div>
								<ul>
									<?php foreach($markalar as $row){ 
									 $name = unserialize($row['baslik']);
									 $sef  = unserialize($row['sef']);
									?>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_markalar_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $name[$set['lang']['active']]; ?></a></li>
									
									<?php  } ?>
								</ul>
							</div>
							<?php  } ?>

							
							<?php if(isset($_GET["filtre"]) || isset($_GET["fiyat"])) { ?>	
							<div class="filtre-tutucu">
								<a href="<?php echo $set['langurl']; ?>/<?php echo $sef_urunler_link[$set['lang']['active']]; ?>/<?php echo $unx_sef[$set['lang']['active']]."-".$bul['id']; ?>"><i class="fa fa-times"></i></a>
								<?php if(isset($_GET["filtre"])){
									$filtre = explode(",",$_GET["filtre"]);
									foreach($filtre as $row){
										$filtreCek = $conn-> query("select * from varyant where id = ".intval($row))->fetch();
										$filtreName = unserialize($filtreCek['baslik']);
										echo '<span>'.$filtreName[$set['lang']['active']].'</span>';
									}
								} ?>
								<?php if(isset($_GET["fiyat"])){ 
								 $fiyat = clean($_GET["fiyat"]);
								  ?>
								<span><?php echo  $fiyat; ?></span>
								<?php } ?>
							</div>
							<?php } ?>	
						</div>
								
							</div>
						
						<div class="col-md-9 col-sm-8 col-xs-12">
							<div class="content-shop">
								<div class="sort-pagi-bar">
									<h2 class="title30"><?php echo ucfirsttr($katbaslik); ?></h2>
									<div class="sort-view">
										
										<div class="sort-bar select-box">
											
											
												<select id="input-sort" class="form-control"
									onchange="location = this.value;">
										<option value="" selected="selected">Filtre Seçim</option>
										<option value="<?php echo sprintf($orderby_sprint,3); ?>">Ucuzdan > Pahalıya</option>
										<option value="<?php echo sprintf($orderby_sprint,4); ?>">Pahalıdan > Ucuza</option>
									</select>
											
										</div>
									</div>
								</div>
								<div class="grid-shop">
									<div class="row">
									
									<?php 
								/* Ana */
									if(count($urunlerYeni) > 0) { 
									$i= -0.1;
									$iPlus = 0.1;
									foreach($urunlerYeni as $row){ 
										$name      = unserialize($row['baslik']);
										$aciklama     = unserialize($row['aciklama']);
										$sef       = unserialize($row['sef']);	
										$images    = unserialize($row['resimler']);	
										 if(empty($images)){
											$anaresim = "default.jpg"; 	
										 }else{
											if(empty($row['vitrinresim'])){
												$anaresim = $images[0]; 	
											}else{
												$anaresim = $row['vitrinresim'];
											}
										 }
									 	if(isset($_SESSION["m_oturum"])){
						$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
						if($uyebayi['fiyat'] != 0){
							$degisim   = ($row['yenifiyat'] / 100 ) * $uyebayi['fiyat'];
							$degisim   =  $row['yenifiyat'] - $degisim;
							$urunfiyat =  $degisim;
							$ilkfiyat  = $row['yenifiyat'];
						}else{
							$urunfiyat = $row['yenifiyat'];
							$ilkfiyat  = $row['fiyat'];
						}
					}else{
						$urunfiyat = $row['yenifiyat'];
						$ilkfiyat  = $row['fiyat'];
					}
										$i += $iPlus;
									?> 
									
									
	<div class="col-md-4 col-sm-6 col-xs-12">
											<div class="item-product1 style-border">
												<div class="product-thumb">
													<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" class="product-thumb-link">
														<img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>">
													</a>
													
												</div>
												<div class="product-info">
													<h3 class="product-title"><a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><?php echo $name[$set['lang']['active']]; ?></a></h3>
													<div class="product-price">
													<?php if($row['fiyatgizle']  != 1) {  ?>
														<ins><span><?php echo $urunfiyat; ?> TL</span></ins>
														<?php if($ilkfiyat != 0.00 ){ ?>
														<del><span><?php echo $ilkfiyat; ?> TL</span></del>
														<?php  } ?>	
													</div>
													<?php } ?>
													<div class="product-rate">
														<div class="product-rating" style="width:100%"></div>
													</div>			
													
													
													<?php if(@$main_settings['fiyatgizle'] == 1 ){ ?>
								
															<?php if(isset($_SESSION["m_oturum"])) { ?>
																
																<div class="product-extra-link">
																	<input type="hidden" class="mainurunfiyat" value="<?php echo $urunfiyat; ?>" />
																	<a href="#" class="s-sepeteekle" id="<?php echo $row['id']; ?>">Sepete Ekle</a>
																	<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" class="addcart-link"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Ürünü İncele</span></a>
																	<?php if(isset($_SESSION["m_oturum"])) { ?>
																	<a href="#" class="favori favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
																	<?php  } ?>
																</div>
														
																
															<?php } else {  ?>
															
																<span>Sorunuz</span>
																
															<?php } ?>
															
															
														<?php  } else {  ?>
														
															<div class="product-extra-link">
																<input type="hidden" class="mainurunfiyat" value="<?php echo $urunfiyat; ?>" />
																<a href="#" class="s-sepeteekle" id="<?php echo $row['id']; ?>">Sepete Ekle</a>
																<a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" class="addcart-link"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Ürünü İncele</span></a>
																<?php if(isset($_SESSION["m_oturum"])) { ?>
																<a href="#" class="favori favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
																<?php  } ?>
															</div>
															
														
														<?php }?>
													
													
												</div>
											</div>
										</div>
										<div class="clearfix visible-sm-block"></div><div class="clearfix visible-xs-block"></div>	
									<?php  } 
									} else { ?>
									<div class="clear">
										<div class="kayit-bulunamadi">
											<div class="alert alert-info">
												Ürün Bulunamadı.
											</div>	
										</div>
									</div>
								<?php } ?>
									
										
										
								</div>
								<?php 
								if( (count($urunlerYeni)  > 1) ){ ?>
									<div class="cihaniriboy-sayfalama">
										<div class="cihaniriboy_sayfalama_orta">
									<?php 
										$gorunen = 5;
										if($sayfa > $gorunen+1){
											$onceki	= $sayfa - 1; ?>
											
											<a href="<?php printf($page_sprint,$onceki); ?>" title="önceki sayfa"><i class="fa fa-chevron-left"></i></a><?php 
										}
										for($i= $sayfa - $gorunen; $i < $sayfa + $gorunen + 1; $i++){
											if($i > 0 and $i <= $sayfasayisi){
												if($i == $sayfa){ ?>
													<span class="cihaniriboy-spanaktif"><?php echo $i; ?></span><?php 
												}else{ ?>
													<a href="<?php printf($page_sprint,$i); ?>"><?php echo $i; ?></a><?php 
												}
											}
										}
										if($sayfa != $sayfasayisi){
											$sonraki = $sayfa +1; ?>
											<a href="<?php printf($page_sprint,$sonraki); ?>" title="sonraki sayfa"><i class="fa fa-chevron-right"></i></a>
											
										<?php } ?>
										</div>
									</div><?php 
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="<?php echo $set['siteurl'];  ?>/assets/js/bootstrap-slider.js"></script>
<script type="text/javascript">
	$(function(){
		/* Range */
		var priceSlider = $("#zr-price");
		var content 	=  $(".kat-list .list .products");
		var ajaxShow 	= '<div class="loader"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loader" /></div>';
			 priceSlider.slider();
			 function fiyatCek(fiyat1,fiyat2){
				var katid = $("input.katid").val();
				priceSlider.attr("value", fiyat1 + ',' + fiyat2);
				var deger1 = "<?php printf($fiyat_sprint,"[js_replace]"); ?>";
				var deger2 = deger1.replace("[js_replace]",fiyat1 + ',' + fiyat2);
				window.location.assign(deger2);
			}
			var defaultVAL = priceSlider.attr("data-slider-value").replace("[", "").replace("]", "").split(",");
			 priceSlider.attr("value", defaultVAL[0] + '-' + defaultVAL[1]);
			 priceSlider.on('slideStop', function (ev) {
				var degerAktar = priceSlider.val().split(",");
					fiyatCek(degerAktar[0],degerAktar[1]);
			});
	});
</script>
<?php _footer_last(); ?>
 </body>
</html>