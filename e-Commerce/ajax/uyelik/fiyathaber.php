<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) { exit;}


$urunid     = clean($_POST["furunid"]);
$sure  		= clean($_POST["fsure"]);
$fiyat  	= clean($_POST["ffiyat"]);
$suan		= time();
if(!isset($sure) || !isset($fiyat) || !isset($urunid)) { exit; } 


if(isset($_SESSION["m_oturum"])){
	$kontrol = $conn -> query("select * from fiyatalarm where user_id = ".$_SESSION["m_id"]." && urun_id = ".intval($urunid))->fetch();	
	if($kontrol){
		echo 'Bu Ürün Listenizde Bulunuyor';
		exit;
	}
	if(empty($sure) || empty($fiyat)){
		echo 'Boş Alan Bırakmayınız';
	}
	
	//$ekleniceksure = date('Y-m-d', strtotime($day . " +7 days"));
	
	$sql = $conn -> prepare("INSERT INTO fiyatalarm SET
		user_id		= :user_id,
		urun_id		= :urun_id,
		tarih		= :tarih,
		sure		= :sure,
		fiyat		= :fiyat		
	");
	$ekle = $sql -> execute(array(
		"user_id"	 => $_SESSION["m_id"],
		"urun_id"	 => $urunid,
		"tarih"		 => $suan,
		"sure"		 => $sure,
		"fiyat"		 => number_format($fiyat,2)	
	));
	if($ekle){
		echo 'done';
	}else{
		echo 'Kayıt Edilemedi';
	}
}else{
	echo 'Listenize Eklemek İçin Giriş Yapın';
}


?>