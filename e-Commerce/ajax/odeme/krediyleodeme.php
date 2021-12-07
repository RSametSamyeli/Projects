<?php  
include("../../lab/function.php");
include('../../iyzipay-php-develop/IyzipayBootstrap.php');
include('../../phpmailer/PHPMailerAutoload.php');
if(!isset($_POST)) { exit; }
if(!isset($_SESSION["m_oturum"])){
	$_SESSION["hata"] = 'Üye Olunuz Yada Giriş Yapınız.';
	header('location:'.$_SERVER['HTTP_REFERER']);
}

unset($_SESSION["hata"]);



$user_id 		  = clean($_POST["userid"]);
$uyebul 		  = $conn -> query("select * from users where id = ".intval($user_id)."")->fetch(); 
if(!$uyebul) { exit; }

## Kargo Ücret 
if(isset($_POST['kargosecenek'])){
	$kar 		= clean($_POST['kargosecenek']);
	$kargobul   = $conn -> query("select * from kargo where  id = ".intval($kar))->fetch();
	$kampanya_durum   =  $kargobul['kampanya_durum'];
	$kampanya_toplam  =  $kargobul['kampanya_toplam'];
	$kargofiyat = $kargobul['kargoucret']; 
	if($kampanya_durum == 1){
		if(number_format($kampanya_toplam,2) < number_format($genelToplam,2)){
			$kargofiyat = 0.00;
		}
	}else{
		$kargofiyat = $kargobul['kargoucret'];
	}	
		
}else{
	$kargofiyat = 0.00;
}

$odemeturu  	  = "Krediyle Ödeme";
$kapidaodemefiyat = 0.00;


$kapidaodemeturu  = "";
$callbackUrl      =  $set['siteurl']."/".$sef_odeme_link['tr'];
$ip 			  =   $_SERVER['REMOTE_ADDR'];

$urunid   			= filter_input(INPUT_POST, 'urunid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$baslik    			= filter_input(INPUT_POST, 'baslik', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$adet      			= filter_input(INPUT_POST, 'adet', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$uvaryant  		    = filter_input(INPUT_POST, 'uvaryant', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantid  		= filter_input(INPUT_POST, 'varyantid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantturler      = filter_input(INPUT_POST, 'varyantturler', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyanttutarlar    = filter_input(INPUT_POST, 'varyanttutarlar', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

$teslimatadresi 		= clean($_POST["teslimatadresi"]);
$adresCek  				= $conn -> query("select * from useraddress where id = ".intval($teslimatadresi ))->fetch();

$faturaadresi 			= clean($_POST["faturaadresi"]);
$kargosecenek 			= $kar;
$siparisnot 			= clean($_POST["siparisnot"]);	
$toplamtutar  			= clean($_POST["toplamtutar"]);

$kdvsiztutar		 	= clean($_POST["kdvsiztutar"]);
$kdv	  				= clean($_POST["kdv"]);
$kargoTutar	  			= $kargofiyat;
$havaletipi	  			= 0;

$oid 	  			    = $_POST["oid"];	

/* Üye Puan  */
if(isset($_SESSION["fs"]["kredi"])){ 
	$parapuan = $_SESSION["fs"]["kredi"];
	$parapuan =  $parapuan  + $kargofiyat;
}else {
	$parapuan = '';
}

/* SESSIONS */
$_SESSION["fs"] 					= array();
$_SESSION["amount"] 				=	$toplamtutar;
$_SESSION["fs"]["oid"] 			    =	$oid;

$_SESSION["fs"]["kredipuan"] 	 	=	$parapuan;	
$_SESSION["fs"]["odemeturu"] 		=	$odemeturu;
$_SESSION["fs"]["urunid"] 			=	$urunid;
$_SESSION["fs"]["baslik"] 			=	$baslik;
$_SESSION["fs"]["uvaryant"] 		=	$uvaryant;
$_SESSION["fs"]["varyantid"] 		=	$varyantturler;
$_SESSION["fs"]["varyanttutarlar"]  =	$varyanttutarlar;
$_SESSION["fs"]["varyanturler"] 	=	$varyantid;
$_SESSION["fs"]["adet"] 			=	$adet;
$_SESSION["fs"]["durum"] 			=	0;
$_SESSION["fs"]["tarih"] 			=	time();
$_SESSION["fs"]["toplamtutar"] 		=	$toplamtutar;
$_SESSION["fs"]["ip"] 				=	getenv("REMOTE_ADDR");
$_SESSION["fs"]["user_id"] 			=	$uyebul['id'];
$_SESSION["fs"]["teslimatadresi"]	=	$teslimatadresi;
$_SESSION["fs"]["faturaadresi"] 	=	$faturaadresi;
$_SESSION["fs"]["havaletipi"] 		=	$havaletipi;
$_SESSION["fs"]["kargo"] 			=	$kargosecenek;
$_SESSION["fs"]["siparisnot"] 		=	$siparisnot;
$_SESSION["fs"]["kdv"] 				=	$kdv;
$_SESSION["fs"]["kargotutar"] 		=	$kargoTutar;
$_SESSION["fs"]["kdvsiztutar"] 		=	$kdvsiztutar;
$_SESSION["fs"]["sipid"] 		    =	$oid;
$_SESSION["fs"]["kapidaodemefiyat"] =	$kapidaodemefiyat;
$_SESSION["fs"]["kapidaodemeturu"] =	$kapidaodemeturu;

$_SESSION['fposts']["faturaadresi"]   = clean($_POST["faturaadresi"]);
$_SESSION['fposts']["teslimatadresi"] = clean($_POST["teslimatadresi"]);
$_SESSION['fposts']["kargosecenek"]   = clean($_POST["kargosecenek"]);
$_SESSION['fposts']["siparisnot"]     = clean($_POST["siparisnot"]);


if(!isset($odemeturu) 
	|| !isset($user_id)
	|| !isset($toplamtutar) 
	|| !isset($kdv) 
	|| !isset($kargoTutar)
	|| !isset($teslimatadresi)
	|| !isset($faturaadresi)
	|| !isset($kargosecenek)
	|| !isset($siparisnot)
	|| !isset($urunid)
	|| !isset($baslik)
	|| !isset($adet)
	|| !isset($kdvsiztutar)
	|| !isset($kdv)
	|| !isset($kargoTutar)
	){ exit; }
	
	
	
	    ## Normal Ödeme ##
	$insert = $conn -> prepare("INSERT INTO siparis SET 
	 odemeturu	= :odemeturu,
	 urunid		= :urunid,
	 baslik		= :baslik,
	 uvaryant   	= :uvaryant,
	 varyantid   	= :varyantid,
	 varyantturler	= :varyantturler,
	 varyanttutarlar = :varyanttutarlar,
	 adet		= :adet,
	 durum		= :durum,
	 tarih       = :tarih,
	 toplamtutar = :toplamtutar, 
	 ip			 = :ip,
	 user_id	 = :user_id,
	 teslimatadresi = :teslimatadresi,
	 faturaadresi   = :faturaadresi,
	 havaletipi     = :havaletipi,
	 kargo			= :kargo,
	 siparisnot		= :siparisnot,
	 kdv			= :kdv,
	 kargotutar     = :kargotutar,
	 kdvsiztutar	= :kdvsiztutar,
	 oid			= :oid,
	 kapidaodemefiyat = :kapidaodemefiyat,
	 kapidaodemeturu  = :kapidaodemeturu,
	 kreditutar		  = :kreditutar
	 ");
	 
	$ekle = $insert -> execute(array(
		"odemeturu" 	=> $odemeturu,
		"urunid" 		=> serialize($urunid),
		"baslik" 		=> serialize($baslik),
		"uvaryant"		=> serialize($uvaryant),
		"varyantid"		=> serialize($varyantid),
		"varyantturler"	=> serialize($varyantturler),
		"varyanttutarlar"	=> serialize($varyanttutarlar),
		"adet"		 	=> serialize($adet),
		"durum" 		=> 0,
		"tarih"			=> time(),
		"toplamtutar"	=> $toplamtutar,
		"ip"			=> $ip,
		"user_id"		=> $user_id,
		"teslimatadresi" => $teslimatadresi,
		"faturaadresi"   => $faturaadresi,
		"havaletipi"	 => $havaletipi,
		"kargo"			 => $kargosecenek,
		"siparisnot"	 => $siparisnot,
		"kdv"			 => $kdv,
		"kargotutar"	 => $kargoTutar,
		"kdvsiztutar"	 =>	$kdvsiztutar,
		"oid"			 => intval($oid),	
		"kapidaodemefiyat" => $kapidaodemefiyat,
		"kapidaodemeturu"  => $kapidaodemeturu,
		"kreditutar"	  => number_format($parapuan,2)
		));

	if($ekle) {
		$_SESSION["sonuc"]['durum']  = 'success';
		header('location:'.$set['langurl'].'/odeme-sonuc');
	}else {
		$_SESSION["hata"] = 'Sipariş Verilirken Sorun Oluştu.';
		header('location:'.$callbackUrl);
		exit;
	}
	

?>