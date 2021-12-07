<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}

$id       = clean($_POST["id"]);
$adet     = clean($_POST["adet"]);
$varyant  = clean($_POST["varyant"]);

if(!isset($id) || !isset($adet) || !isset($varyant) ) { exit; }


$urunbul = $conn -> query("select * from urun where id = ".intval($id))->fetch();
if(!$urunbul) { exit; }

$varyantArr = explode(",",$varyant);
if(count($varyantArr) > 0){
	foreach($varyantArr as $sipkey){
		$urunvaryantlar = $conn -> query("select * from urunvaryants where varyantdeger = ".$sipkey."  && urunid = " .intval($urunbul['id']))->fetch();
		$varyantCek 	= $conn -> query("select * from varyant where id = ".intval($urunvaryantlar['varyantdeger']))->fetch();
		$varName 		= unserialize($varyantCek['baslik']);
		$varyantstok    = $urunvaryantlar['varyantstok'];
		$varstokSonuc   = $varyantstok - $adet + 1;
		//echo $varstokSonuc;
		if($varstokSonuc < 1){
			echo 'false|x|';
			echo $varName[$set['lang']['active']]." - Stokda Bulunmuyor";
			exit;	
		}
	}
}

//var_dump($_POST);

//echo $adet;
exit;


$urunvaryantlar = $conn -> query("select * from urunvaryants where urunid = " .intval($urunbul['id']));
foreach($urunvaryantlar->fetchAll() as $row6){ 
	if($row6['varyantdeger'] == $varyant){ 
		$stok = $row6['varyantstok'] - $adet+1;
		echo $stok;
		//echo $row6['varyantstok'];
	}
}
//echo $adet;
?>