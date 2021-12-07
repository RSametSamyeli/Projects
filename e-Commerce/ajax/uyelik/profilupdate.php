<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
$id 			= clean($_POST["id"]);
if(!$id){ exit; }
$uyebul = $conn -> query("select * from users where rutbe = 0 && id = ".intval($id))->fetch();

if(!$uyebul){ exit; }
		

$ad       		= clean($_POST["ad"]);
$soyad       	= clean($_POST["soyad"]);
$username       = clean($_POST["username"]);
$email          = clean($_POST["email"]);
$telefon        = clean($_POST["telefon"]);
$sehir          = clean($_POST["sehir"]);
$ip             = $_SERVER['REMOTE_ADDR'];
$code		    = clean($_POST["code"]);


if(!isset($ad) || !isset($soyad) || !isset($username) || !isset($email) ) { exit;}

if(empty($ad) ||  empty($soyad) || empty($username) ){
	echo $lang['mesaj']['bos_alan_birakmayin'];
	exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email'];
	exit;
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu']; 
	exit;
}elseif(strlen($username) < 5 || strlen($username) > 14){
	echo $lang['mesaj']['min_user'];
	exit;
}

/* Kayıt */
$sql = $conn -> prepare("update users SET 
	  name		= :name,
	  email		= :email,
	  telefon	= :telefon,
	  ad		= :ad,
	  soyad		= :soyad,
	  il		= :il
	  where 	id = :id
	 ");
	
	$ekle = $sql-> execute(array(
		"name"    => $username,
		"email"   => $email,
		"telefon" => $telefon,
		"ad" 	  => $ad,
		"soyad"   => $soyad,
		"il"	  => $sehir,
		"id" 	  => intval($id)
	)); 
	if($ekle) { 
		echo 'done';
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}
?>