<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }


$name       	= clean($_POST["name"]);
$adsoyad        = clean($_POST["adsoyad"]);
$telefon        = clean($_POST["telefon"]);
$ulke           = clean($_POST["ulke"]);
$sehir     	    = clean($_POST["sehir"]);
$ilce    		= clean($_POST["ilce"]);
$adres          = clean($_POST["adres"]);
$postakodu      = clean($_POST["postakodu"]);
$user_id		    = clean($_POST["user_id"]);


if(!isset($adsoyad) || !isset($name) || !isset($ulke) || !isset($telefon) || !isset($sehir) || !isset($ilce)) { exit;}

if(empty($name) ||  empty($adsoyad) || empty($telefon) || empty($ulke) || empty($sehir) || empty($ilce) || empty($adres) ){
	echo $lang['mesaj']['bos_alan_birakmayin'];
	exit;
}

/* Kayıt */
$sql = $conn -> prepare("INSERT INTO useraddress SET
	name		= :name,
	adsoyad		= :adsoyad,
	telefon		= :telefon,
	ulke		= :ulke,
	sehir		= :sehir,
	ilce        = :ilce,
	adres		= :adres,
	postakodu 	= :postakodu,
	status		= :status,
	user_id		= :user_id
	");
	
$ekle = $sql -> execute(array(
	"name"      => $name,
	"adsoyad"   => $adsoyad,
	"telefon"	=> $telefon,
	"ulke"		=> $ulke,
	"sehir"		=> $sehir,
	"ilce"		=> $ilce,
	"adres"		=> $adres,
	"postakodu"	=> $postakodu,
	"status"	=> 0,
	"user_id"	=> $user_id  
	));
	
	if($ekle) { 
		echo 'done';
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}
?>