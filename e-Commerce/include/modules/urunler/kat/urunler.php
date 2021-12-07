<?php  if( !defined("SABIT") ){ exit; } 
$last = explode("-",$get2);
$id	  = end($last);
$bul  = $conn -> query("SELECT * FROM kategori WHERE id = '".intval($id)."'")->fetch();
if(!$bul) { include("include/modules/404/404.php");  exit;}

$unx_title		 = unserialize($bul['title']);
$unx_baslik		 = unserialize($bul['baslik']);
$unx_sef 		 = unserialize($bul['sef']);
$unx_keywords	 = unserialize($bul['keywords']);
$unx_description = unserialize($bul['description']);
$unx_resimler 	 = $bul['resimler'];
$katbaslik 		 = $unx_baslik[$set['lang']['active']];
$title 			 = $unx_title[$set['lang']['active']];
if(empty($title)) {
	$title = $katbaslik;
}
$keywords	= $unx_keywords[$set['lang']['active']];
$descripton = $unx_description[$set['lang']['active']];
$secilenler2       = $conn -> query("select * from urun where gununfirsati = 1 order by sira asc limit 4"); 
$secilenler        = $conn -> query("select * from urun order by sira asc limit 4");
$katlar       = $conn -> query("SELECT * FROM kategori WHERE ustid = '".intval($bul['id'])."' order by sira asc");
$varyantkats  = $conn -> query("select * from kategori where modul = 'varyant' ORDER by sira ASC");
$markalar     = $conn -> query("select * from marka order by sira asc");
$sayfalink = $set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$unx_sef[$set['lang']['active']].'-'.$bul['id'];

if(isset($_SESSION["fs"]["kredi"])){
	unset($_SESSION["fs"]["kredi"]);
}
if(isset($_SESSION["fs"]["puan"])){
	unset($_SESSION["fs"]["puan"]);
}
if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
}

#### Sayfalama  #####

$sayfa	= 1;
$kacar 	= $main_settings['urunsayfalama'];
if( isset($_GET["sayfa"]) ){
	if( !ctype_digit($_GET["sayfa"]) ){ header("Location: ".$set["siteurl"]);exit; }
	$sayfa = intval(@$_GET["sayfa"]);
	if( $sayfa < 1 ){ $sayfa=1; }
}
$page_sprint 	    = $sayfalink."?sayfa=%d";
$fiyat_sprint 	    = $sayfalink."?fiyat=%s";
$filtre_sprint   	= $sayfalink."?filtre=%s";
$orderby_sprint 	= $sayfalink."?orderby=%s";

seoyaz("".$title."","".$keywords."","".$descripton ."",""); 

$kats  = $conn -> query("select * from kategori where modul = 'urunler' and ustid = 0 order by sira asc");

/* ---------------------  Sidebar ----------------------------- */
function sidebar($ustid){
	global $conn,$set,$sef_urunler_link,$id;
	$katsorgu = $conn -> query("select * from kategori where modul = 'urunler' and ustid = ".intval($ustid)." order by sira asc");	
	$katsorguCount = $katsorgu -> rowCount();
	if($katsorguCount > 0 ){
		echo '<ul>';
		foreach($katsorgu as $row3){
			$name = unserialize($row3['baslik']);
			$sef  = unserialize($row3['sef']);
			$altmenu = $conn -> query("select * from kategori where ustid = '".intval($row3['id'])."'");
			echo '<ul class="submenu"><li ><a href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row3['id'].'">- '.$name[$set['lang']['active']].'</a>';
					sidebar($row3['id']);
			echo '</li></ul>';
		}
		echo '</ul>';
	}
}
/* ---------------------  Sidebar Bitti ----------------------------- */

/* ---------------------  Filtrele ----------------------------- */

$urunlerYeni = array();

if(isset($_GET["fiyat"])){
	$fiyat   = clean($_GET["fiyat"]);
	$fiyatparcala = explode(",",$fiyat);
	$min 	 = $fiyatparcala[0];
	$max 	 = $fiyatparcala[1];
}
if(isset($_GET["orderby"])){  
	$orderby = clean($_GET["orderby"]);
	if($orderby == 3){
		$field = 'yenifiyat'; 
		$short = 'ASC';
	}elseif($orderby == 4){
		$field = 'yenifiyat'; 
		$short = 'DESC';
	}else{
		$field = 'sira'; 
		$short = 'asc';
	}
}else{
	$field = 'sira'; 
	$short = 'asc';
}

if( isset($_GET["filtre"]) ){ 
	$filtre   = clean($_GET["filtre"]);
	$parcala  = explode(",",$filtre);
}



if(!empty($_GET["fiyat"])){ 
	if(!empty($_GET["filtre"]) && !empty($_GET["orderby"]) ){
		### Fiyat -> Filtre ve Order by var başladı ##
		$page_sprint 	= $sayfalink."?filtre=".$filtre."&fiyat=".$min.",".$max."&orderby=".$orderby ."&sayfa=%d";
		$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat."&orderby=".$orderby;
		$orderby_sprint = $sayfalink."?filtre=".$filtre."&fiyat=".$fiyat."&orderby=%s";
		$fiyat_sprint 	= $sayfalink."?filtre=".$filtre."&fiyat=%s&orderby=".$orderby;
		
		$kactane = $conn -> query("
		SELECT * FROM kategori_set
		INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
		INNER JOIN urun on urun.id = kategori_set.urunid 
			WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
		&& 
		kategori_set.katid = ".intval($bul['id'])." AND urun.yenifiyat >= $min AND urun.yenifiyat <= $max  
		GROUP BY kategori_set.urunid
		");
	
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;

		$urunler = $conn -> query("
		SELECT * FROM kategori_set
		INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
		INNER JOIN urun on urun.id = kategori_set.urunid 
			WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
		&& 
		kategori_set.katid = ".intval($bul['id'])." AND urun.yenifiyat > $min AND urun.yenifiyat < $max  
			GROUP BY urun.id ORDER BY ".$field." ".$short."
		LIMIT ".$nerden.",".$kacar." 
		");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
				$urunlerYeni[]   = $key;
		}
		
		### Fiyat -> Filtre ve Order by var bitti ##
	}elseif(empty($_GET["filtre"]) &&  empty($_GET["orderby"]) ){ 
		### Fiyat -> Sadece Fiyat var ##
			$orderby_sprint = $sayfalink."?fiyat=".$fiyat."&orderby=%s";
			$page_sprint = $sayfalink."?fiyat=".$min.",".$max."&sayfa=%d";
			$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat;
			$kactane = $conn -> query("
				SELECT * FROM kategori_set
				INNER JOIN 
				urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
				AND yenifiyat >= $min AND yenifiyat <= $max
			");
			$num 		  = $kactane-> rowCount();
			$sayfasayisi  = ceil($num/$kacar);
			$nerden	      = ($sayfa*$kacar)-$kacar;
			###### Sayfalama  Bitti  #######
			$urunler 	  = $conn -> query("SELECT * FROM kategori_set
				INNER JOIN 
				urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
				AND yenifiyat >= $min AND yenifiyat <= $max LIMIT ".$nerden.",".$kacar."");
			$urunlerCount = $urunler -> rowCount();
			foreach($urunler as $key){
					$urunlerYeni[]   = $key;
			}
		
		
		### Fiyat -> Sadece Fiyat bitti ##
	}elseif(!empty($_GET["filtre"]) &&  empty($_GET["orderby"]) ){ 
		### Fiyat -> Filtre fiyat başladı ##
			$page_sprint 	= $sayfalink."?filtre=".$filtre."&fiyat=".$min.",".$max."&sayfa=%d";
			$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat;
			$orderby_sprint = $sayfalink."?filtre=".$filtre."&fiyat=".$fiyat."&orderby=%s";
			$fiyat_sprint 	= $sayfalink."?filtre=".$filtre."&fiyat=%s";
			
			$kactane = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." AND urun.yenifiyat > $min AND urun.yenifiyat < $max  
			GROUP BY kategori_set.urunid
			");
		
			$num 		  = $kactane-> rowCount();
			$sayfasayisi  = ceil($num/$kacar);
			$nerden	      = ($sayfa*$kacar)-$kacar;

			$urunler = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." AND urun.yenifiyat > $min AND urun.yenifiyat < $max  
				GROUP BY urun.id ORDER BY ".$field." ".$short."
			LIMIT ".$nerden.",".$kacar." 
			");
			$urunlerCount = $urunler -> rowCount();
			foreach($urunler as $key){
					$urunlerYeni[]   = $key;
			}
		### Fiyat -> Filtre fiyat bitti ##
	}else{
	    ## Fiyat ve order by başladı ##
			$page_sprint 	= $sayfalink."?fiyat=".$min.",".$max."&orderby=".$orderby."&sayfa=%d";
			$filtre_sprint 	= $sayfalink."?filtre=%s&fiyat=".$fiyat;
			$orderby_sprint = $sayfalink."?fiyat=".$fiyat."&orderby=%s";
			$fiyat_sprint 	= $sayfalink."?fiyat=%s&orderby=".$orderby;
			
			$kactane = $conn -> query("
				SELECT * FROM kategori_set
				INNER JOIN 
				urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
				AND yenifiyat >= $min AND yenifiyat <= $max
			");
			$num 		  = $kactane-> rowCount();
			$sayfasayisi  = ceil($num/$kacar);
			$nerden	      = ($sayfa*$kacar)-$kacar;
			###### Sayfalama  Bitti  #######
			$urunler 	  = $conn -> query("SELECT * FROM kategori_set
				INNER JOIN 
				urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
				AND yenifiyat >= $min AND yenifiyat <= $max LIMIT ".$nerden.",".$kacar."");
			$urunlerCount = $urunler -> rowCount();
			foreach($urunler as $key){
					$urunlerYeni[]   = $key;
			}
		## Fiyat ve order by başladı bitti ##
	}
	
}else{
	if(!empty($_GET["filtre"]) && !empty($_GET["orderby"]) ){
		## Fiyatsız Filtre ve Order By Başladı ##
		
		$page_sprint      = $sayfalink."?filtre=".$filtre."&sayfa=%d";
		$fiyat_sprint 	  = $sayfalink."?filtre=".$filtre."&fiyat=%s";
		$orderby_sprint   = $sayfalink."?filtre=".$filtre."&orderby=%s";
		$filtre_sprint    = $sayfalink."?filtre=%s&orderby=".$orderby;
		
		$kactane = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." GROUP BY kategori_set.urunid
		");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;


		$urunler = $conn -> query("
		SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." GROUP BY kategori_set.urunid
			ORDER BY ".$field." ".$short." LIMIT ".$nerden.",".$kacar."
		");

		$urunlerCount = $urunler -> rowCount();

		foreach($urunler as $key){
			$urunlerYeni[]   = $key;
		}
		
		
		
		## Fiyatsız Filtre ve Order By Bitti ##
	}elseif(!empty($_GET["filtre"]) &&  empty($_GET["orderby"]) ){
		
		## Fiyatsız Filtre Var Başladı ##
		$page_sprint      = $sayfalink."?filtre=".$filtre."&sayfa=%d";
		$fiyat_sprint 	  = $sayfalink."?filtre=".$filtre."&fiyat=%s";
		$orderby_sprint   = $sayfalink."?filtre=".$filtre."&orderby=%s";
		
		$kactane = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." GROUP BY kategori_set.urunid
		");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;


		$urunler = $conn -> query("
		SELECT * FROM kategori_set
			INNER JOIN urunvaryants on kategori_set.urunid  = urunvaryants.urunid  
			INNER JOIN urun on urun.id = kategori_set.urunid 
				WHERE  urunvaryants.varyantdeger IN  (".$filtre.")
			&& 
			kategori_set.katid = ".intval($bul['id'])." GROUP BY kategori_set.urunid
		LIMIT ".$nerden.",".$kacar." 
		");

		$urunlerCount = $urunler -> rowCount();

		foreach($urunler as $key){
			$urunlerYeni[]   = $key;
		}
		
		
		## Fiyatsız Filtre Var Bitti  ##
	}elseif(empty($_GET["filtre"]) &&  empty($_GET["orderby"]) ){ 
		### Fiyatsız Hiç Birşey Yok ###
		$kactane = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN 
			urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
		");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;
		$urunler  = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN 
			urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])." LIMIT ".$nerden.",".$kacar."  
		");
		$urunlerCount = $urunler -> rowCount();
			foreach($urunler as $key){
				$urunlerYeni[]   = $key;
			}
		## Fiyatsız Hiç Birşey Yok Bitti ###
	}else{
		## Fiyatsız Order By Var Başladı ##
		$page_sprint = $sayfalink."?orderby=".$orderby."&sayfa=%d";
		$kactane	  = $conn -> query("
			SELECT * FROM kategori_set
			INNER JOIN 
			urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
		");
		$num 		  = $kactane-> rowCount();
		$sayfasayisi  = ceil($num/$kacar);
		$nerden	      = ($sayfa*$kacar)-$kacar;
		$urunler 	  = $conn -> query("
		SELECT * FROM kategori_set
			INNER JOIN 
			urun on urun.id = kategori_set.urunid  WHERE  kategori_set.katid = ".intval($bul['id'])."
		ORDER BY ".$field." ".$short." LIMIT ".$nerden.",".$kacar."");
		$urunlerCount = $urunler -> rowCount();
		foreach($urunler as $key){
			$urunlerYeni[]   = $key;
		}
		## Fiyatsız Order By Bitti ##
	}
}
$anasayfaReklamlar5 = $conn -> query("select * from reklam where  gosterim = 1 && reklamturu = 0 && durum = 1 && pozisyon = 4 order by sira asc limit 1");
$anasayfaReklamlar6 = $conn -> query("select * from reklam where  gosterim = 1 && reklamturu = 0 && durum = 1 && pozisyon = 5 order by sira asc limit 1");
$anasayfaReklamlar7 = $conn -> query("select * from reklam where  gosterim = 1 && reklamturu = 0 && durum = 1 && pozisyon = 5 order by sira asc limit 2 OFFSET 1");

?>
<link href="assets/cekirdek/css/jquery-accordion-menu.css" rel="stylesheet">
		<link href="assets/cekirdek/css/font-awesome.css" rel="stylesheet">
		<style>
			*{
				box-sizing:border-box;
				-moz-box-sizing:border-box; 
				-webkit-box-sizing:border-box;
			}
			body{
				background: #f0f0f0;
			}
			.content{
				width: 260px;
				margin: 100px auto;
			}
			.colors{
				width: 260px;
				float: left;
				margin: 20px auto;
			}
			.colors a{
				width: 43.3px;
				height: 30px;
				float: left;
			}
			.colors .default{ background: #414956; }
			.colors .blue{ background: #4A89DC; }
			.colors .green{ background: #03A678; }
			.colors .red{ background: #ED5565; }
			.colors .white{ background: #fff; }
			.colors .black{ background: #292929; }
		</style>

<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/bootstrap-slider.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/kategori.css" />
</head>
<body class="category-page">
<div id="page">

<?php include('include/sabit/header.php'); ?>
 <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <span> <a href="/"><?php echo ucfirsttr($lang['genel']['anasayfa']); ?></a></span> </li>
            <li class="category1601"> <strong><?php echo ucfirsttr($katbaslik); ?></strong> </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <section class="main-container col2-left-layout bounceInUp animated">
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-sm-push-3">
  
          <article class="col-main">
            <h2 class="page-heading"><span class="page-heading-title"><?php echo ucfirsttr($katbaslik); ?></span></h2>
            <div class="display-product-option">
			
                  <div class="sort-view  col-md-4 pull-right">
										
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
            <div class="category-products">
              <ul class="products-grid">
			  
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
                <li class="item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                  <div class="item-inner">
                    <div class="item-img">
                      <div class="item-img-info"><a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" title="<?php echo $name[$set['lang']['active']]; ?>" class="product-image"><img src="<?php echo $set['siteurl']; ?>/uploads/urun/large/<?php echo $anaresim;  ?>" alt="<?php echo $name[$set['lang']['active']]; ?>"></a>
                        <div class="box-hover">
                          <ul class="add-to-links">
                            <li><a class="link-quickview" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">Ürünü İncele</a> </li>
							<li><a href="#" class="link-wishlist favorite" data-urun-id="<?php echo $row['id']; ?>" id="favorite">Favori Ekle</a> </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="item-info">
                      <div class="info-inner">
                        <div class="item-title"> <a title="Retis lapen casen" href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"> <?php echo $name[$set['lang']['active']]; ?> </a> </div>
                        <div class="item-content">
                          <div class="rating">
                            <div class="ratings">
                              <div class="rating-box">
                                <div style="width:100%" class="rating"></div>
                              </div>
                              
                            </div>
                          </div>
                           <?php if($row['fiyatgizle']  != 1) {  ?>
                      <div class="item-price">
                        <div class="price-box">
					<?php if($ilkfiyat != 0.00 ){ ?>
					<span class="regular-price"> <ins><del class="price"><?php echo $ilkfiyat; ?> TL</del></ins> </span>
					<?php  } ?>
						<span class="regular-price"> <ins><span class="price"><?php echo $urunfiyat; ?> TL</span></ins> </span>
					
						</div>
                      </div>
					  <?php } ?>
                          <div class="action">
                        <a href="<?php echo $set["langurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><button title="" type="button" class="button btn-cart"><span>Ürünü İncele</span> </button></a>
                      </div>
					
                        </div>
                      </div>
                    </div>
                  </div>
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
                </li>

              </ul>
            </div>
            <div class="toolbar">
              <div class="row">
                <div class="col-lg-3 col-md-4">
                  
                </div>
                <div class="col-lg-6 col-sm-7 col-md-5">
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
          </article>
          <!--	///*///======    End article  ========= //*/// --> 
        </div>
        <div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
		<div id="jquery-accordion-menu" class="green jquery-accordion-menu">
				<div class="jquery-accordion-menu-header">Kategoriler</div>
				<ul>
					 <?php 
			  function header_menu12($ustid){
				global $conn,$set,$sef_urunler_link;
				$katsorgu = $conn -> query("select * from kategori where modul = 'urunler' and ustid = ".intval($ustid)." order by sira asc");	
				$katsorguCount = $katsorgu -> rowCount();
				if($katsorguCount > 0){
					echo '<ul class="submenu">';
						foreach($katsorgu as $row){
							$name      = unserialize($row['baslik']);
							$sef       = unserialize($row['sef']);
							$altmenu = $conn -> query("select * from kategori where ustid = '".intval($row['id'])."'");
							echo '<li><a href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'">'.$name[$set['lang']['active']].' </a> ';
								header_menu12($row['id']);
							echo '</li>';
						}
					echo '</ul>';
				}
			}
			   
			   
				
			   ?>
				<?php foreach($anakats1Fetch  as $row) 	{
						$name      = unserialize($row['baslik']);
						$sef       = unserialize($row['sef']);	
						echo '<li><a href="'.$set['langurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'"><span>'.$name[$set['lang']['active']].'</span></a> '; 
						header_menu12($row['id']);
						echo '</li>';
						}
				 ?>
					
				<div class="jquery-accordion-menu-footer">Kategoriler</div>
			</div>
          <aside class="col-left sidebar">
            <div class="filter-content">
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
							<div class="kat-sidebar marka-sidebar hidden">
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
          </aside>
		  <?php foreach($anasayfaReklamlar5 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>
			<div class="hot-banner"><a href="<?php echo $url[$set['lang']['active']]; ?>"><img alt="<?php echo $name[$set['lang']['active']]; ?>" src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>"></a></div>
			<?php } ?>
			 <div class="custom-slider">
              <div>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li class="active" data-target="#carousel-example-generic" data-slide-to="0"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol>
                  <div class="carousel-inner">
				  <?php foreach($anasayfaReklamlar6 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>
                    <div class="item active"><img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>">
                      <div class="carousel-caption">
                        <h3><a title=" Sample Product" href="<?php echo $url[$set['lang']['active']]; ?>"><?php echo $name[$set['lang']['active']]; ?></a></h3>
                        <p><?php echo $altname[$set['lang']['active']]; ?></p>
                        <a class="link" href="<?php echo $url[$set['lang']['active']]; ?>">İncele</a></div>
                    </div>
					<?php } ?>
                    <?php foreach($anasayfaReklamlar7 as $row){ 
				$name = unserialize($row['baslik']);
				$altname = unserialize($row['altbaslik']);
				$url = unserialize($row['url']);
			?>
                    <div class="item"><img src="<?php echo $set['siteurl']; ?>/uploads/reklam/<?php echo $row['image']; ?>" alt="<?php echo $name[$set['lang']['active']]; ?>">
                      <div class="carousel-caption">
                        <h3><a title=" Sample Product" href="<?php echo $url[$set['lang']['active']]; ?>"><?php echo $name[$set['lang']['active']]; ?></a></h3>
                        <p><?php echo $altname[$set['lang']['active']]; ?></p>
                        <a class="link" href="<?php echo $url[$set['lang']['active']]; ?>">İncele</a></div>
                    </div>
					<?php } ?>
                  </div>
                  <a class="left carousel-control" href="#" data-slide="prev"> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#" data-slide="next"> <span class="sr-only">Next</span> </a></div>
              </div>
            </div>
			
        </div>
      </div>
    </div>
  </section>								
	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<script type="text/javascript" src="assets/cekirdek/js/jquery-accordion-menu.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){  
				jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
				jQuery(".colors a").click(function(){
					if($(this).attr("class") != "default"){
						$("#jquery-accordion-menu").removeClass();
						$("#jquery-accordion-menu").addClass("jquery-accordion-menu").addClass($(this).attr("class"));
					}
					else{
						$("#jquery-accordion-menu").removeClass();
						$("#jquery-accordion-menu").addClass("jquery-accordion-menu");
					}
				});
			});
		</script>
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