<?php 
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)) { exit;}
$id = clean($_POST["id"]);

$sil_sql = $conn -> prepare("delete from kupongecmisi where id = :id");
$sil     = $sil_sql -> execute(array("id" =>$id));
if($sil){
	echo 'done';
}else {
	echo 'Silinemedi';
}

?>