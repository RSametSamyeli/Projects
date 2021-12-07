<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) { exit;}
if(!isset($_SESSION["m_oturum"])) exit;
$puan     = clean($_POST["puan"]);
$durum    = clean($_POST["durum"]);
if(!isset($puan) || !isset($durum)) { exit; }

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$uyePuan = $uyebul['uye_puan'];	
$limit   = $parapuan['puanlimit'];
$done = 'done';


/** Limit **/
if($uyePuan < $limit){
	echo 'Puanlarınızı Kullanmak için Toplam Puanınızın En Az '.$limit.' olması gerekmektedir.';
	exit;
}

/* Sepet Kontrol  */
$genelToplam = 0;
if(isset($_SESSION["sepet"])){   
	foreach($_SESSION["sepet"] as $row){ 
		$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
		$genelToplam += $row['adet'] * $row['arafiyat'];
		if($urunCek['parapuan'] == 0){
			echo 'Sepetinizde Puanla Satın Alınamayan Ürün Bulunmaktadir.';
			exit;
		}
	}
}



## Bakiye büyüksa
if(number_format($genelToplam,2)  <= puanconvert($uyePuan) ) {
	$ilktutar  = puanconvert($uyePuan)  - number_format($genelToplam,2) ;
	$kalanPara = puanconvert($uyePuan)  - $ilktutar  ;
	if($durum == 1){
		$_SESSION["fs"]["puan"]  =  number_format($kalanPara,2);	
	}else{
		unset($_SESSION["fs"]["puan"]);
	}
	$done  = 'yonlendir';
}else{
	$kalanPara = puanconvert($uyePuan);
	if($durum == 1){
		$_SESSION["fs"]["puan"]  =  number_format($kalanPara,2);	
	}else{
		unset($_SESSION["fs"]["puan"]);
	}
}


echo ''.$done.'|x|'.$durum.'|x|'.number_format($kalanPara,2).'|x|'.$puan."|x|";	


?>
