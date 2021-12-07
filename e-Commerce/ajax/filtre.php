<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include("../lab/function.php");
include("../dil/".$set["lang"]['active'].".php");
include_once('../phpmailer/PHPMailerAutoload.php');
///require_once("../auth/facebook.php"); 

if		( isset($_POST['veri']) ){ $x = $_POST["veri"]; }
else if ( isset($_GET['veri']) ){ $x = $_GET["veri"]; }
else	{ echo "Komut anlaşılamadı"; exit; }
$x = clean($x);
if ($x == "fiyat"){
	include("filtre/fiyat.php");
}else if ($x == "asd"){
}
else {
exit;
}
?>