<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include_once('../phpmailer/class.phpmailer.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}

$id 		= intval($_POST['id']); if( $id < 1  ){ echo "hata"; exit; }
$puan 		= intval($_POST["score"]);if( $puan < 1  ){ echo "hata"; exit; }

$q = $conn->query("SELECT * FROM urun WHERE id = '".$id."'")->fetch();
if( !$q ){ echo "hata"; exit; }

$oysayi 	= $q["toplamoy"];
$eskipuan	= $q["puan"];


if( $oysayi < 1 ){
	$fieldToplamoy 	= 1;
	$fieldPuan 		= $puan;
}else{
	
	$ortalama = (($eskipuan * $oysayi) + $puan) / ($oysayi+1);
	$fieldToplamoy 	= $oysayi+1;
	$fieldPuan 		= $ortalama;
}
if(!isset($_SESSION["oycu".$id])) {
	$update = $conn -> exec("update urun set puan=".$fieldPuan.",toplamoy=".$fieldToplamoy." where id=".$id);
	if( $update > 0){
		echo  $lang['mesaj']['oyunuz_kaydedildi'];
		$_SESSION["oycu".$id] = true;
	}else{
		echo $lang['mesaj']['oyunuz_kaydedilmedi'];
	}
}else{
	echo $lang['mesaj']['daha_once_oy_kullanildi'];
}	
?>