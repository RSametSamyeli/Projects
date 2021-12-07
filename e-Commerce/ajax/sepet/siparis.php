<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) {  exit; }

// Kişisel Bilgiler
$userid		    = clean($_POST["userid"]);
$toplamtutar    = clean($_POST["toplamtutar"]);
$odemeturu      = clean(@$_POST["odemetipi"]);
$ip 			=   $_SERVER['REMOTE_ADDR'];


/* Sepet */

$urunid  	        = $_POST["urunid"];
$baslik		        = $_POST["baslik"];
$adet 				= $_POST["adet"];




if(!isset($urunid)
 || !isset($baslik)
 || !isset($adet)
 || !isset($userid)
 || !isset($toplamtutar)
 ){
	echo 'hata1'; exit;
}

/*
if(empty($odemeturu)){
	echo 'Ödeme Türünü Belirtiniz'; exit;
}
*/
$insert = $conn -> prepare("INSERT INTO siparis SET 
 odemeturu	= :odemeturu,
 urunid		= :urunid,
 baslik		= :baslik,
 adet		= :adet,
 durum		= :durum,
 tarih       = :tarih,
 toplamtutar = :toplamtutar, 
 ip			 = :ip,
 user_id	 = :user_id
 ");
 
$ekle = $insert -> execute(array(
	"odemeturu" 	=> $odemeturu,
	"urunid" 		=> serialize($urunid),
	"baslik" 		=> serialize($baslik),
	"adet"		 	=> serialize($adet),
	"durum" 		=> 0,
	"tarih"			=> time(),
	"toplamtutar"	=> $toplamtutar,
	"ip"			=> $ip,
	"user_id"		=> $userid	
 	));

if($ekle) {
	unset($_SESSION["sepet"]);
	echo 'done';
}else {
	echo 'Sipariş Verilirken Bir Sorun Oluştu'; exit;
}


?>