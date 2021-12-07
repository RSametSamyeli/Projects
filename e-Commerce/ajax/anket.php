<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}

$cevap	 = clean(@$_POST["oy"]);
$id = intval(1);

if(!isset($_SESSION["oycum"])) { 
	
	if(empty($cevap) && !isset($cevap)){
		echo $lang['mesaj']['sik_sec'];
	}else{
		
		$update = $conn -> exec("update anketcevap set $cevap = $cevap + 1 , soruid = 1 where id= ".$id);
		if( $update > 0){ 
			echo  $lang['mesaj']['oyunuz_kaydedildi'];
			$_SESSION["oycum"] = true;
		}else{
			echo $lang['mesaj']['oyunuz_kaydedilmedi'];
		}
	}
	
}else{
	echo $lang['mesaj']['daha_once_oy_kullanildi'];
}

?>