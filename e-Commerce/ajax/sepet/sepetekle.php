<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}


$urunid       = clean($_POST["id"]);
$urunadet     = clean($_POST["adet"]);
$gelenfiyat     = clean($_POST["fiyat"]);

//$varyantArr   = filter_input(INPUT_POST, 'varyant', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);


if(!isset($urunid) || !isset($urunadet)) { 
	echo 'hata-6'; exit;
}

$urunbul  = $conn -> query("select * from urun where id = ".intval($urunid))->fetch();
$urunad   = unserialize($urunbul['baslik']);
$images   = unserialize($urunbul['resimler']);
$kalanstok     = $urunbul['stok'] - $urunadet;
if(empty($images[0])) { 
	$images[0] = "";
}


$varArray     = array();
$secArray    = array();

$siparistarih = '';
$siparissaat  = '';
$kargodurum   = '';

/*  Sipariş Saat */
if(isset($_POST["siparistarih"])){  
	$siparistarih = $_POST["siparistarih"];
}
if(isset($_POST["siparissaat"])){  
	$siparissaat = $_POST["siparissaat"];
}
if(isset($_POST["kargodurum"])){  
	$kargodurum = $_POST["kargodurum"];
}

if(isset($_POST["bastarih"])){  
	$bastarih = $_POST["bastarih"];
}else{
	$bastarih = '';
}


if(isset($_POST["bittarih"])){  
	$bittarih = $_POST["bittarih"];
}else{
	$bittarih = '';
}


if(isset($_POST["kargodurum"])){  
	$kargodurum = $_POST["kargodurum"];
}


/* Seçenekler */
if(isset($_POST["secenekler"])){ 
	for($i = 0;  $i < count($_POST["secenekler"]); $i++ ){
		$secArray[$_POST["seceneklerid"][$i]] = $_POST["secenekler"][$i];
	}

}




if(isset($_POST["varyant"])){
	foreach($_POST["varyant"] as $varkey){ 	
		if(!empty($varkey)){
			$varParca = explode("|x|",$varkey);
			$varBaslik = $varParca[0];
			$varTur    = $varParca[1];
			$varTutar  = $varParca[2];
			$varId     = $varParca[3];
			$varyantCek 	 =  $conn -> query("select * from varyant where id = ".intval($varId))->fetch();
			$varyantKat 	 =  $conn -> query("select * from kategori where id = ".intval($varyantCek['kat_id']))->fetch();
			$varyantKatName  = unserialize($varyantKat['baslik']);
			$varyantKatName  = $varyantKatName[$set['lang']['active']];
			$urunvaryantlar  = $conn -> query("select * from urunvaryants where  varyantdeger = ".$varId." && urunid = " .intval($urunid))->fetch();
			if($urunvaryantlar){
				$kalan = $urunvaryantlar['varyantstok'] - $urunadet;
				if($kalan < 0){
					echo 'nostok|x|';
					exit;
				}
			}
			$varArray['varBaslik'][]    = $varBaslik;
			$varArray['varTur'][] 		= $varTur;
			$varArray['varTutar'][] 	= $varTutar;
			$varArray['varid'][] 		= $varId ;
			$varArray['varKat'][] 		= $varyantKatName ;
			
	
		}

	}
}

/* Stok Kontrol */
if( $kalanstok < 0){
	echo 'nostok|x|';
	exit;
}



if($urunbul['firsaturun'] == 1 ){
	if($urunbul['firsatzaman'] <= time() ){
		$urunFiyat = $gelenfiyat;
	}else{
		$firsattutar = ( $urunbul['yenifiyat'] * $urunbul['firsatyuzde'] )   / 100;
		$kalantutar  = $urunbul['yenifiyat']  - $firsattutar ;
		$urunFiyat   = $kalantutar;
	}
}else{
	$urunFiyat = $gelenfiyat;
}


if(isset($_SESSION["m_oturum"])){
	$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
	$uyebayi = $conn -> query("select * from uyebayi where id = ".intval($uyebul['uyebayi']))->fetch();
	if($uyebayi['fiyat'] != 0){
		$degisim = ( $urunFiyat / 100 ) * $uyebayi['fiyat'];
		$degisim =  $urunFiyat - $degisim;
		$urunFiyat = $degisim;
	}else{
		$urunFiyat = $urunFiyat;
	}
}else{
	$urunFiyat   = $urunFiyat;
}





$arafiyat =  $urunFiyat;


$sepetDizi = array(
	'sepetid'		  => $urunid,
	'baslik'		  => $urunad[$set['lang']['active']],
 	'arafiyat'		  => $arafiyat,
	'adet'			  => $urunadet,
	'urunresmi'       => $images[0],
	'varyant'		  => $varArray,
	'secenekler'	  => $secArray,	
	'siparistarih'    => $siparistarih,
	'siparissaat'	  => $siparissaat,
	'kargodurum'	  => $kargodurum,
	'bastarih'		  => $bastarih,
    'bittarih'		  => $bittarih	
);
	
if(isset($_SESSION["sepet"][$urunid])){

	$found = false;
	
	foreach($_SESSION["sepet"] as $row => $value)  { 

		if($value['sepetid'] == $urunid) {
			
			$_SESSION["sepet"][$row]['baslik'] 	  = $urunad['tr'];
			$_SESSION["sepet"][$row]['arafiyat']  = $arafiyat;
			$_SESSION["sepet"][$row]['adet']  	  = $urunadet;
			$_SESSION["sepet"][$row]['urunresmi'] = $images[0];
			$_SESSION["sepet"][$row]['varyant']   = $varArray;
			$_SESSION["sepet"][$row]['siparistarih']   = $siparistarih;
			$_SESSION["sepet"][$row]['siparissaat']   = $siparissaat;
			$_SESSION["sepet"][$row]['secenekler']   = $secArray;
			$_SESSION["sepet"][$row]['kargodurum']   = $kargodurum;
			$_SESSION["sepet"][$row]['bastarih']   = $bastarih;
			$_SESSION["sepet"][$row]['bittarih']   = $bittarih;
			$found = true;
		}
	}
	if(!$found) {
		
		$_SESSION["sepet"][$urunid] =  $sepetDizi;
	}
	
}else{
	$_SESSION["sepet"][$urunid] = $sepetDizi;
}	



echo 'done|x|';
$genelToplam = 0;
foreach($_SESSION["sepet"] as $row){
	$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
	$varyant = $row['varyant'];
	if(count($varyant) > 0) {	 
		$defvarPlus   = 0;
		$defvarMinus  = 0;
		$varAra 	  = $row['arafiyat'];
		$varAra       = str_replace(",","",$varAra);
		for($i = 0; $i < count($varyant['varBaslik']); $i++) {
			$varTutar = $varyant['varTutar'][$i];
			$varTur   = $varyant['varTur'][$i];
				if($varTur == 1){
					$defvarPlus  += $varTutar;
				}
				if($varTur == 0){
					$defvarMinus  += $varTutar;
				}	
		}
		$varAra = $varAra + $defvarPlus;
		$varAra = $varAra - $defvarMinus;
		$birimfiyat = $varAra;
	} else {
		$birimfiyat = $row['arafiyat'];
	}
	$genelToplam += $row['adet'] * $birimfiyat;
	$sef = unserialize($urunCek['sef']);
	echo '<li class="sepet-item basket'.$row['sepetid'].'">
			<div class="figure">
				<a href="'.$map.'/'.$detaysef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['sepetid'].'">
					<img src="'.$set['siteurl'].'/uploads/urun/thumb/'.$row['urunresmi'].'" alt="'.$row['baslik'].'">
				</a>
			</div>
			<div class="detail">
				<div class="urun-name">
					'.$row['baslik'].'  '; 
					if(count($varyant) > 0) {	
						for($i = 0; $i < count($varyant['varBaslik']); $i++) {
							echo '
							<span class="var-desc">'.$varyant['varKat'][$i].' - '.$varyant['varBaslik'][$i].'</span>';
						}
					}
				echo '
				</div>
				<div class="urun-adet"> <span>'.$row['adet'].'</span>  x  </div>
				<div class="urun-fiyat"> <span>'.$birimfiyat.'</span> TL</div>
			</div>
			<div class="remove-sepet">
				<a href="#" id="'.$row['sepetid'].'"><i class="fa fa-remove"></i></a>
			</div>
		</li>	';
}
$kdv 	 = kdv_ekle($genelToplam,18);
$anaTutar =   $genelToplam;
echo '<li class="border-none">
		<div class="toplam-fiyat">
			<div class="fiyat-item"><span>Sipariş Tutarı  </span><em>:</em><span class="ara-fiyat">'.number_format($genelToplam,2) .' TL</span></div>
			<div class="fiyat-item"><span>Kdv  </span><em>:</em><span class="kdv"><p>'.$kdv.'</p> TL</span></div>
			<div class="fiyat-item"><span class="genel-tutar">Sepet Toplamı </span><em>:</em><span class="genel-tutar">'.number_format($anaTutar,2).' TL</span> </div>
										
		</div>
	</li>
	<li class="border-none">
		<div class="sepete-git">
			<a href="'.$set['langurl'].'/'.$sef_sepet_link[$set['lang']['active']].'">'.$lang['yardimci']['sepetegit'].'</a>
		</div>
	</li>';
echo '|x|';
echo count(@$_SESSION["sepet"]);

 ?>