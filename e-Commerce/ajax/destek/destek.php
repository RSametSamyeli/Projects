<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)){ exit; }

$user_id  = clean($_POST["user_id"]);
$konu 	  = clean($_POST["konu"]);
$baslik   = clean($_POST["baslik"]);
$detay    = clean($_POST["detay"]);
$tarih	  = time();
$durum	  = 1;	
$ip       = $_SERVER['REMOTE_ADDR'];

if(!isset($user_id) || !isset($konu) || !isset($baslik) || !isset($detay) ) {
	exit;
}

if(empty($konu ) || empty($baslik) || empty($detay)) {
	echo 'Boş Alan Bırakmayınız';
	exit;
}


$sql = $conn -> prepare("INSERT INTO destek SET
	user_id		= :user_id,
	konu		= :konu,
	baslik		= :baslik,
	detay		= :detay,
	tarih		= :tarih,
	durum		= :durum,
	ip			= :ip	
	");
	
$ekle = $sql -> execute(array(
	"user_id"	=> $user_id ,
	"konu"		=> $konu,
	"baslik"	=> $baslik,
	"detay"		=> $detay,
	"tarih"		=> $tarih,
	"durum"		=> $durum,
	"ip"		=> $ip	
	));
	
	if($ekle) { 
		echo 'done';
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}



?>