<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}
$id   = clean($_POST["id"]);
$adet = clean($_POST["adet"]);
if(!isset($id) || !isset($adet) ) { exit; }
$urunbul = $conn -> query("select * from urun where id = ".intval($id))->fetch();
if(!$urunbul) { exit; }

$stok = $urunbul['stok'];
echo $stok-$adet; 
?>