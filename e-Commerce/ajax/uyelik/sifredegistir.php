<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)) exit;
$id 	= clean($_POST["id"]);
if(!$id){ exit; }
$uyebul		 = $conn -> query("select * from users where rutbe = 0 && id = ".intval($id))->fetch();
if(!$uyebul){ exit; }
if(isset($_SESSION["fboturum"])) {  
	$eskisifre   = "";
}else{
	$eskisifre   = clean($_POST["eskisifre"]);
}


$sifre  	 = clean($_POST["sifre"]);
$sifreteyit  = clean($_POST["sifreteyit"]);
$eskimd5     = md5(sha1($eskisifre));    
$yenisifre   = md5(sha1($sifre));
$code		 = clean($_POST["code"]);

		


if(!isset($eskisifre) || !isset($sifre) || !isset($sifreteyit)  ) { exit;}

if(isset($_SESSION["fboturum"])) {  
	
	if( empty($sifre) || empty($sifreteyit) ){
		echo $lang['mesaj']['bos_alan_birakmayin'];
		exit;
	}elseif(strlen($sifre) < 6 || strlen($sifre) > 12){
		echo $lang['mesaj']['min_sifre'];
		exit;
	}elseif(strlen($sifreteyit) < 6 || strlen($sifreteyit) > 12){
		echo $lang['mesaj']['min_sifre'];
		exit;
	}elseif($_SESSION["GKod"] != md5($code)){
		echo $lang['mesaj']['guvenlik_kodu']; 
		
	}

}else{
	if(empty($eskisifre) ||  empty($sifre) || empty($sifreteyit) ){
		echo $lang['mesaj']['bos_alan_birakmayin'];
		exit;
	}elseif($uyebul['password'] != $eskimd5){
		echo $lang['mesaj']['mevcut_sifreyanlis'];
		exit;
	}elseif(strlen($sifre) < 6 || strlen($sifre) > 12){
		echo $lang['mesaj']['min_sifre'];
		exit;
	}elseif(strlen($sifreteyit) < 6 || strlen($sifreteyit) > 12){
		echo $lang['mesaj']['min_sifre'];
		exit;
	}elseif($_SESSION["GKod"] != md5($code)){
		echo $lang['mesaj']['guvenlik_kodu']; 
		exit;
	}

}



/* Kayıt */
$sql = $conn -> prepare("update users SET 
	  password	= :password
	  where 	id = :id
	 ");
	
	$ekle = $sql-> execute(array(
		"password"    => $yenisifre,
		"id" 	  => intval($id)
	)); 
	if($ekle) { 
		echo 'done';
		 if(isset($_SESSION["fboturum"])) { 
			unset($_SESSION["fboturum"]);
		}
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}
?>