<?php  
include("../../lab/function.php");
include('../../iyzipay-php-develop/IyzipayBootstrap.php');
include('../../phpmailer/PHPMailerAutoload.php');
if(!isset($_POST)) { exit; }

if(!isset($_SESSION["m_oturum"])){
	$_SESSION["hata"] = 'Üye Olunuz Yada Giriş Yapınız.';
	header('location:'.$_SERVER['HTTP_REFERER']);
}

if($_POST["siparisturu"] == 1){
	include('kredisatinal.php');
	exit;
}

unset($_SESSION["hata"]);

$odemeturu  	  = clean($_POST["odemeturu"]);

if(!empty($_POST["kapidaodemefiyat"])){
	$kapidaodemefiyat = clean($_POST["kapidaodemefiyat"]);
}else{
	$kapidaodemefiyat = 0.00;
}




if(isset($_POST["secenekler"])){	
	$secenekler  = $_POST["secenekler"];
}else{
	$secenekler  = array();
}


$kapidaodemeturu  = clean($_POST["kapidaodemeturu"]);


$callbackUrl    =  $set['langurl']."/".$sef_odeme_link['tr'];
$succesUrl		=  $set['langurl']."/odeme-sonuc";

$user_id 		= clean($_POST["user_id"]);
$uyebul 		= $conn -> query("select * from users where id = ".intval($user_id)."")->fetch();
if(!$uyebul){ exit; }
$ip 				=   $_SERVER['REMOTE_ADDR'];

$urunid     = filter_input(INPUT_POST, 'urunid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$baslik     = filter_input(INPUT_POST, 'baslik', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$adet       = filter_input(INPUT_POST, 'adet', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$uvaryant   = filter_input(INPUT_POST, 'uvaryant', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantid  = filter_input(INPUT_POST, 'varyantid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantturler    = filter_input(INPUT_POST, 'varyantturler', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyanttutarlar = filter_input(INPUT_POST, 'varyanttutarlar', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$siparistarih  = filter_input(INPUT_POST, 'siparistarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$siparissaat   =  filter_input(INPUT_POST, 'siparissaat', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bitistarihi   =  filter_input(INPUT_POST, 'bitistarihi', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bastarih  =  filter_input(INPUT_POST, 'bastarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bittarih  =  filter_input(INPUT_POST, 'bittarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);



$teslimatadresi 		= clean($_POST["teslimatadresi"]);
$adresCek  				= $conn -> query("select * from useraddress where id = ".intval($teslimatadresi ))->fetch();

$faturaadresi 			= clean($_POST["faturaadresi"]);
$kargosecenek 			= clean($_POST["kargosecenek"]);
$siparisnot 			= clean($_POST["siparisnot"]);	
$toplamtutar  			= clean($_POST["toplamtutar"]);
$toplamtutar  			= str_replace(",","",$_POST["toplamtutar"]);


$kdvsiztutar		 	= clean($_POST["kdvsiztutar"]);
$kdvsiztutar 			= str_replace(",","",$_POST["kdvsiztutar"]);
$kdv	  				= clean($_POST["kdv"]);
$kdv 					= str_replace(",","",$_POST["kdv"]);
$kargoTutar	  			= clean($_POST["kargotutar"]);
$havaletipi	  			= clean($_POST["havaletipi"]);

$oid 	  			    = $_POST["oid"];	
$siparisturu		    = 0;


/* Stok Kontrolü */

/* Üye Puan  */
if(isset($_SESSION["fs"]["puan"])){ 
	$parapuan = $_SESSION["fs"]["puan"];
}else {
	$parapuan = 0.00;
}

/* Üye Kredi  */
if(isset($_SESSION["fs"]["kredi"])){ 
	$kredipuan = $_SESSION["fs"]["kredi"];
}else {
	$kredipuan = 0.00;
}

/* İndirim Kupon */
if(isset($_POST["indirimkupon"])){
	$indirimkupon = $_POST["indirimkupon"];
}else{
	$indirimkupon = '';
}

/* SESSIONS */
$_SESSION["fs"] 					= array();
$_SESSION["amount"] 				=	$toplamtutar;
$_SESSION["fs"]["oid"] 			    =	$oid;
$_SESSION["fs"]["indirimkupon"] 	=	$indirimkupon;
$_SESSION["fs"]["parapuan"] 	 	=	$parapuan;
$_SESSION["fs"]["kredipuan"] 	 	=	$kredipuan;	
$_SESSION["fs"]["odemeturu"] 		=	$odemeturu;
$_SESSION["fs"]["urunid"] 			=	$urunid;
$_SESSION["fs"]["baslik"] 			=	$baslik;
$_SESSION["fs"]["secenekler"] 		=	$secenekler;
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
$_SESSION["fs"]["kapidaodemefiyat"]  =	$kapidaodemefiyat;
$_SESSION["fs"]["kapidaodemeturu"]   =	$kapidaodemeturu;
$_SESSION["fs"]["siparisturu"]	     =	$siparisturu;
$_SESSION['fposts']["faturaadresi"]   = $_POST["faturaadresi"];
$_SESSION['fposts']["teslimatadresi"] = $_POST["teslimatadresi"];
$_SESSION['fposts']["kargosecenek"]   = $_POST["kargosecenek"];
$_SESSION['fposts']["siparisnot"]     = $_POST["siparisnot"];
$_SESSION['fposts']["siparistarih"]   =  $siparistarih;
$_SESSION['fposts']["siparissaat"]     = $siparissaat;

 
	


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


if(!isset($_POST["sozlesme1"])){
	$_SESSION["hata"] = 'Ön Bilgilendirme Formunu Kabul Etmeniz Gerekmektedir.';
	header('location:'.$callbackUrl);
	exit;
}
if(!isset($_POST["sozlesme2"])){
	$_SESSION["hata"] =   'Mesafeli Satış Sözleşmesini Kabul Etmeniz Gerekmektedir.';
	header('location:'.$callbackUrl);
	exit;
}


if($odemeturu == "kredikarti"){
	
		$cardadsoyad = clean($_POST["cardadsoyad"]);
		//$cardnumber = "4921307043416839";
		$cardnumber  = clean($_POST["pan"]);
		$cardnumber  = str_replace(" ","",$cardnumber);
		$ccay 		 = clean($_POST["Ecom_Payment_Card_ExpDate_Month"]);	
		$ccyil 		 = clean($_POST["Ecom_Payment_Card_ExpDate_Year"]);	
		$cvc 		 = clean($_POST["cv2"]);
		
		if(empty($cardadsoyad) || empty($cardnumber) || empty($cvc) || empty($ccay) || empty($ccyil)) {
			$_SESSION["hata"] = 'Bazı Alanlar Boş Bırakıldı';
			header('location:'.$_SERVER['HTTP_REFERER']);
		}
		
		
		###### AYRAÇLAR #########
		
		
	/*	$cardadsoyad = "John Doe";
		$cardnumber  = "5890040000000016";
		$ccay 		 = "12";	
		$ccyil 		 = "2030";	
		$cvc 		 = "123";
		
	*/
		
	
		if(isset($_POST["installment-option"])){
			$taksit = $_POST["installment-option"];
		}else{
			$taksit = '';
		}
		
		if($iyziDurum == 1 ){ 
			include('iyzico.php');
		}else{
			/*** Halk Bankası ***/	
			include('halkpos.php');	 
			/*** Halk Bankası ***/	
		}
		
}else{
     ## Normal Ödeme ##
	$insert = $conn -> prepare("INSERT INTO siparis SET 
	 odemeturu	 	= :odemeturu,
	 urunid		 	= :urunid,
	 baslik		 	= :baslik,
	 uvaryant   	= :uvaryant,
	 varyantid   	= :varyantid,
	 varyantturler	= :varyantturler,
	 varyanttutarlar = :varyanttutarlar,
	 adet		 	= :adet,
	 durum		 	= :durum,
	 tarih       	= :tarih,
	 toplamtutar	= :toplamtutar, 
	 ip			 	= :ip,
	 user_id	 	= :user_id,
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
	 siparisturu	  = :siparisturu,
	 puantutar		  = :puantutar,
	 kreditutar		  = :kreditutar,
	 anadurum		  = :anadurum,
	 secenekler	 	  = :secenekler,
	 teslimattarih    = :teslimattarih,
	 teslimatsaat     = :teslimatsaat,
	 bitistarihi      = :bitistarihi,
	 bastarih         = :bastarih,
	 bittarih		  = :bittarih,
	 uyeturu		  = :uyeturu
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
		"kdvsiztutar"	   => $kdvsiztutar,
		"oid"			   => intval($oid),	
		"kapidaodemefiyat" => $kapidaodemefiyat,
		"kapidaodemeturu"  => $kapidaodemeturu,
		"siparisturu"	   => $siparisturu,
		"puantutar"		  => number_format($parapuan,2),
		"kreditutar"	  => number_format($kredipuan,2),
		"anadurum"		  => 1,
		"secenekler"	  => serialize($secenekler),
		"teslimattarih"	  => serialize($siparistarih),
		"teslimatsaat"	  => serialize($siparissaat),
		"bitistarihi"	  => serialize($bitistarihi),
		"bastarih"		 => serialize($bastarih),	 
		"bittarih"		 => serialize($bittarih),
		"uyeturu"		=> 1	
		));
		
	if($ekle) {
		$_SESSION["sonuc"]['durum']  = 'success';
			header('location:'.$succesUrl);
	}else {
		$_SESSION["hata"] = 'Sipariş Verilirken Sorun Oluştu.';
		//var_dump($ekle -> errorInfo() );
		header('location:'.$callbackUrl);
		exit;
	}
	
	
}


 ?>