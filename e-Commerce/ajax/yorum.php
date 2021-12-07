<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include_once('../phpmailer/class.phpmailer.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}
$adsoyad	 = clean($_POST["adsoyad"]);
$email 		 = clean($_POST["email"]);
$yorum 		 = clean($_POST["yorum"]);
$icerik 	 = clean($_POST["icerik"]);	
$url 	 	 = clean($_POST["url"]);
$urlisim 	 = clean($_POST["urlisim"]);	
$code		 = clean($_POST["code"]);
$userid		 = clean($_POST["userid"]);
$tarih 		 = date("d.m.y H:i");
$durum 		 = 0;
$tur         = clean($_POST["tur"]); 
$ip 		 = GetIP(); 


if(!isset($adsoyad)  || !isset($email)  || !isset($yorum)) { exit;}
if(empty($adsoyad)  || empty($email)  || empty($yorum)){
	echo $lang['mesaj']['bos_alan_birakmayin'];
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email'];
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu']; exit;
}else {
	
	$sql = $conn -> prepare("INSERT INTO yorumlar SET
		adsoyad 	= :adsoyad,
		mail 		= :mail,
		mesaj 		= :mesaj,
		tarih 		= :tarih,
		durum		= :durum,
		tur			= :tur,
		icerik		= :icerik,
		ip  		= :ip,
		url			= :url,
		urlisim		= :urlisim,
		userid		= :userid
	");
	
	$ekle = $sql -> execute(array(
		"adsoyad" => $adsoyad,
		"mail"    => $email,
		"mesaj"   => $yorum,
		"tarih"   => $tarih,
		"durum"   => 0,
		"tur"	  => $tur,
		"icerik"  => $icerik,
		"ip"	  => $ip,
		"url"	  => $url,
		"urlisim" => $urlisim,
		"userid"  => intval($userid)		
	));
	if($ekle) { 
		echo 'done';
	} else { echo 'bir sorun oluştu'; }
}
?>