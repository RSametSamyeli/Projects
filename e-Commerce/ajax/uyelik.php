<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include("../lab/function.php");
include("../dil/".$set["lang"]['active'].".php");
include_once('../phpmailer/PHPMailerAutoload.php');
///require_once("../auth/facebook.php"); 

if		( isset($_POST['veri']) ){ $x = $_POST["veri"]; }
else if ( isset($_GET['veri']) ){ $x = $_GET["veri"]; }
else	{ echo "Komut anlaşılamadı"; exit; }
$x = clean($x);
if ($x == "giris"){
	include("uyelik/login.php");
}else if ($x == "cikis"){
	include("uyelik/logout.php");
}else if ($x == "kayit"){	
	include("uyelik/uyelik.php");
}else if ($x == "profilupdate"){
	include("uyelik/profilupdate.php");
}else if ($x == "sifredegistir"){
	include("uyelik/sifredegistir.php");
}else if ($x == "sifremiunuttum"){
	include("uyelik/sifremiunuttum.php");
}else if ($x == "sepetekle"){
	include("sepet/sepetekle.php");
}else if ($x == "sepetguncelle"){
	include("sepet/sepetguncelle.php");
}else if ($x == "sepetsil"){
	include("sepet/sepetsil.php");
}else if ($x == "siparis"){
	include("sepet/siparis.php");
}else if ($x == "bin"){
	include("sepet/bin.php");
}else if ($x == "taksit"){
	include("sepet/taksit.php");
}else if ($x == "reset"){	
	include("uyelik/reset.php");
}else if ($x == "stok"){	
	include("sepet/stok.php");
}else if ($x == "destek"){	
	include("destek/destek.php");
}else if ($x == "destekcevap"){	
	include("destek/cevap.php");
}else if ($x == "varyantstok"){
	include("sepet/varyantstok.php");
}else if ($x == "kupon"){
	include("sepet/kupon.php");
}else if ($x == "kuponsil"){
	include("sepet/kuponsil.php");
}else if ($x == "havalebildirimi"){
	include("uyelik/havalebildirimi.php");
}else if ($x == "puan"){
	include("uyelik/puan.php");
}else if ($x == "kredi"){
	include("uyelik/kredi.php");
}else if ($x == "iade"){
	include("uyelik/iade.php");
}else if ($x == "favorite"){
	include("uyelik/favorite.php");
}else if ($x == "favoritesil"){
	include("uyelik/favoritesil.php");
}else if ($x == "fiyathaber"){
	include("uyelik/fiyathaber.php");
}else if ($x == "fiyatalarmsil"){
	include("uyelik/fiyatalarmsil.php");
}else if ($x == "stokalarmsil"){
	include("uyelik/stokalarmsil.php");
}else if ($x == "stokhaber"){
	include("uyelik/stokhaber.php");
}else if ($x == "siparistakibi"){
	include("uyelik/siparistakibi.php");
}else if ($x == "fiyatver"){
	include("uyelik/fiyatver.php");
}else {
exit;
}
?>