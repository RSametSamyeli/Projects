<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../phpmailer/class.phpmailer.php');
include_once('../lab/function.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}

$email = clean($_POST["maillist"]);
$durum = 0;
$tarih = date("d.m.Y H:i");
$ip    = getenv($_SERVER["REMOTE_ADDR"]);
if(!isset($email)) { exit; }
$mailbul = $conn -> query("SELECT *from maillist WHERE mail = '".$email."'");
if(empty($email)){
	echo $lang['mesaj']['bos_email']; exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email']; exit;
}elseif($mailbul -> rowCount() > 0){
	echo $lang['mesaj']['retry_email']; exit;
}else{
	$ekle = $conn -> prepare("INSERT INTO maillist (mail,tarih,ip,durum) VALUES (?,?,?,?)");
	$ekle -> execute(array($email,$tarih,$ip,0));
	if($ekle) { 
		echo 'ok';
	} else {
		echo 'bir sorun oluştu'; 
	}
}
?>