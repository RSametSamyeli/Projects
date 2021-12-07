<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
if(!isset($_POST)) { exit;}

$data = clean($_POST["home"]);

if(!isset($data)) { exit;}
$update = $conn -> prepare("update ayarlar set sablon = ? where id = ? ");
$ekle   = $update -> execute(array($data,1));

if($ekle) { 
	echo 'done';
} else {
	echo 'bir sorun oluştu'; 
}
?>