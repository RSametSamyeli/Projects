<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }


$json     = array();
$email    = clean(trim($_POST["username"]));
$password = clean(trim($_POST["password"]));
$yenipass = md5(sha1($password));

$query 	  = $conn -> query('select * from users where email = "'.$email.'" && password = "'.$yenipass.'" && kayit  = 1 && rutbe  = 0') -> fetch();
if(!$query){ $giris_durumu = 'gecersiz'; }



if(!isset($email) || !isset($password) ) { 
	$giris_durumu	   = 'gecersiz'; 
	$json['hatamesaj'] = 'Hata -1';

}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	$giris_durumu 	   = 'gecersiz'; 
	$json['hatamesaj'] =  $lang['mesaj']['gecersiz_email'];
}elseif(empty($email) || empty($password)){
	$giris_durumu = 'gecersiz'; 
	$json['hatamesaj'] = $lang['mesaj']['bos_alan_birakmayin'];
}elseif(strlen($password) < 6 || strlen($password) > 12){
	$giris_durumu = 'gecersiz'; 
	$json['hatamesaj'] = $lang['mesaj']['min_sifre'];
}else{
		if($email == $query["email"] && $yenipass == $query["password"]){
			$giris_durumu = 'gecerli'; 	
			$_SESSION["m_oturum"] = true;	
			$_SESSION["m_user"]  = $query["name"];
			$_SESSION["m_id"] 	 = $query["id"]; 	
			$_SESSION['m_anahtar'] 	 = md5($_SERVER['HTTP_USER_AGENT']);	
			
			$giris_durumu = 'gecerli'; 	
		}else{
			$json['hatamesaj'] = $lang['mesaj']['gecersiz_giris'];
			$giris_durumu = 'gecersiz'; 	
		}
	
}



$json['giris_durumu'] = $giris_durumu;
	
echo json_encode($json);


?>