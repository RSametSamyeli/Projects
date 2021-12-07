<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) { exit;}
$urunid     = clean($_POST["urunid"]);
if(!isset($urunid)) { exit; }
if(isset($_SESSION["m_oturum"])){
	$kontrol = $conn -> query("select * from favorite where user_id = ".$_SESSION["m_id"]." && urun_id = ".intval($urunid))->fetch();	
	if($kontrol){
		echo 'Bu Ürün Listenizde Bulunuyor';
		exit;
	}

	$sql = $conn -> prepare("INSERT INTO favorite SET
		user_id		= :user_id,
		urun_id		= :urun_id,
		tarih		= :tarih	
	");
	$ekle = $sql -> execute(array(
		"user_id"	 => $_SESSION["m_id"],
		"urun_id"	 => $urunid,
		"tarih"		 => time()	
	));
	if($ekle){
		echo 'done';
	}else{
		echo 'Kayıt Edilemedi';
	}
}else{
	echo 'Favorilerinize Eklemek İçin Giriş Yapın';
}


?>