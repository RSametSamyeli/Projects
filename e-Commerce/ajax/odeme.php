<?php
//if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include("../lab/function.php");
include("../dil/".$set["lang"]['active'].".php");


if		( isset($_POST['veri']) ){ $x = $_POST["veri"]; }
else if ( isset($_GET['veri']) ){ $x = $_GET["veri"]; }
else	{ echo "Komut anlaşılamadı"; exit; }
$x = clean($x);
if ($x == "kargo"){
	include("odeme/kargo.php");
}else if ($x == "bin"){
	include("odeme/bin.php");
}else if ($x == "taksit"){
	include("odeme/taksit.php");
}else if ($x == "odeme"){
	include("odeme/odeme.php");
}else if ($x == "puan"){
	include("odeme/puan.php");
}
else {
exit;
}
?>