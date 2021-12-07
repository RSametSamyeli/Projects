<?php  
include("../../lab/function.php");
include('../../iyzipay-php-develop/IyzipayBootstrap.php');
@include('../../phpmailer/PHPMailerAutoload.php');


if(!isset($_POST)) { exit; }
$callbackUrl    =  $set['langurl']."/uyeliksiz-siparis";


#### Üyelik Oluştur 

$adres_ad      = clean($_POST["adres_ad"]);
$adres_soyad   = clean($_POST["adres_soyad"]);
$adres_dogumt  = clean($_POST["adres_dogumt"]);
$adres_telefon = clean($_POST["adres_telefon"]);
$adres_telefon   = str_replace("(","",$adres_telefon);
$adres_telefon   = str_replace(")","",$adres_telefon);
$adres_telefon   = str_replace("-","",$adres_telefon);
$adres_telefon   = str_replace(" ","",$adres_telefon);

$adres_mail    = clean($_POST["adres_mail"]);
$adres_mesaj   = clean($_POST["adres_mesaj"]);
$varsayilanUye  = $main_settings['varsayilanuye'];
$sehir		   = clean($_POST["sehir"]);
$semt_mahalle  = clean($_POST["semt_mahalle"]);
$acikadres	   = clean($_POST["acikadres"]);
$uyeMailBul     = $conn -> query("SELECT email FROM users WHERE email = '".$adres_mail."' ")->fetch();


if(!isset($adres_ad) || !isset($adres_soyad) || !isset($adres_dogumt) ) { exit; }



## Stok Kontrolller 

foreach(@$_SESSION["sepet"] as $row) { 
	$urunCek  			 = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
	$urunad  	   	     = unserialize($urunCek['baslik']);
	$kalanstok     = $urunCek['stok'] - $row['adet'];
	if( $kalanstok < 0){
		$_SESSION["hata"] = $urunad[$set['lang']['active']].' Ürününde Yeterli Stok Bulunmamaktadır.';
		header('location:'.$callbackUrl);
		exit;
	}
	
}	


if(	empty($adres_ad) 
	|| empty($adres_soyad)
	|| empty($adres_dogumt)
	|| empty($adres_telefon) 
	|| empty($adres_mail)
	|| empty($sehir)
	|| empty($semt_mahalle)
	) {
		$_SESSION["hata"] = 'Boş Alan Bırakmayınız.';
		header('location:'.$callbackUrl);
		exit;
	}
	/*if($uyeMailBul){
		$_SESSION["hata"] = 'Daha Önce Bu E-Mail Adresinden Sipariş Verilmiş.';
		header('location:'.$callbackUrl);
		exit;
	}*/


$uyesql = $conn -> prepare("INSERT INTO users SET
	name		= :name,
	password	= :password,
	email		= :email,
	telefon		= :telefon,
	rutbe		= :rutbe,
	ad          = :ad,
	soyad		= :soyad,
	tarih		= :tarih,
	dogumtarih  = :dogumtarih,
	adres		= :adres,
	uyebayi     = :uyebayi,
	tc			= :tc,
	uyeliktipi  = :uyeliktipi,
	firmabaslik  = :firmabaslik,
	vergidairesi = :vergidairesi,
	vergino		 = :vergino,
	firmatel	 = :firmatel,
	kayit		 = :kayit,
	mesaj		 = :mesaj,
	msehir		 = :msehir,
	msemt		 = :msemt,
	macikadres	 = :macikadres,
	uyeturu      = :uyeturu
	");
	
$uyeekle = $uyesql -> execute(array(
	"name"      => "",
	"password"  => "",
	"email"     => $adres_mail,
	"telefon"	=> $adres_telefon,
	"rutbe"		=> 0,
	"ad"		=> $adres_ad,
	"soyad"		=> $adres_soyad,
	"tarih"		 => time(),
	"dogumtarih" => strtotime($adres_dogumt),
	"adres"		 => "",	
	"uyebayi"    => $varsayilanUye,
	"tc"		 => '',
	"uyeliktipi" => 0,
	"firmabaslik" => "",
	"vergidairesi" => "",
	"vergino"	   => "",
	"firmatel"	   => "",
	"kayit"		   => 0,
	"mesaj"		   => $adres_mesaj,
	"msehir"	   => $sehir,
	"msemt"		   => $semt_mahalle,
	"macikadres"   => $acikadres,
	"uyeturu"	 => 0	
	));
	
	if($uyeekle){
		$eklenenid  =  $conn -> lastInsertId();
		$_SESSION["misafir_id"] = $eklenenid;
		$uyebul 	=  $conn -> query("select * from users where id = '".intval($eklenenid)."'")->fetch();
	}




#### Üyelik Oluştur Bitti


unset($_SESSION["hata"]);

$odemeturu  	  = clean($_POST["odemeturu"]);

if(!empty($_POST["kapidaodemefiyat"])){
	$kapidaodemefiyat = clean($_POST["kapidaodemefiyat"]);
	$kapidaodemefiyat = str_replace(",",".",$kapidaodemefiyat);
}else{
	$kapidaodemefiyat = 0.00;
}


$kapidaodemeturu  = clean($_POST["kapidaodemeturu"]);
$user_id 		= $eklenenid;
$uyebul 		= $conn -> query("select * from users where id = ".intval($user_id)."")->fetch();
if(!$uyebul){ exit; }
$ip 		  	  =   $_SERVER['REMOTE_ADDR'];
$urunid    		  = filter_input(INPUT_POST, 'urunid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$baslik   		  = filter_input(INPUT_POST, 'baslik', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$adet     	 	  = filter_input(INPUT_POST, 'adet', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$uvaryant  		  = filter_input(INPUT_POST, 'uvaryant', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantid  	  = filter_input(INPUT_POST, 'varyantid', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyantturler    = filter_input(INPUT_POST, 'varyantturler', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$varyanttutarlar  = filter_input(INPUT_POST, 'varyanttutarlar', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$siparistarih  = filter_input(INPUT_POST, 'siparistarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$siparissaat   =  filter_input(INPUT_POST, 'siparissaat', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bitistarihi   =  filter_input(INPUT_POST, 'bitistarihi', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bastarih   =  filter_input(INPUT_POST, 'bastarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$bittarih   =  filter_input(INPUT_POST, 'bittarih', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
/*
echo '<pre>';
var_dump($varyanttutarlar);
echo '</pre>';
exit;
*/
$teslimatadresi 		= clean($_POST["teslimatadresi"]);
$adresCek  				= $conn -> query("select * from useraddress where id = ".intval($teslimatadresi ))->fetch();

$faturaadresi 			= clean($_POST["faturaadresi"]);
$kargosecenek 			= clean($_POST["kargosecenek"]);

$toplamtutar  			= clean($_POST["toplamtutar"]);
$toplamtutar  			= str_replace(",","",$_POST["toplamtutar"]);


$kdvsiztutar		 	= clean($_POST["kdvsiztutar"]);
$kdvsiztutar 			= str_replace(",","",$_POST["kdvsiztutar"]);
$kdv	  				= clean($_POST["kdv"]);
$kdv 					= str_replace(",","",$_POST["kdv"]);
$kargoTutar	  			= clean($_POST["kargotutar"]);


$siparisnot 			= clean($_POST["siparisnot"]);	
$kargoTutar	  			= clean($_POST["kargotutar"]);
$havaletipi	  			= clean($_POST["havaletipi"]);
$siparisturu		    = 0;


if(isset($_POST["secenekler"])){	
	$secenekler  = $_POST["secenekler"];
}else{
	$secenekler  = array();
}



$oid 	  			    = $_POST["oid"];	
$siparisturu		    = 0;

/* Stok Kontrolü */

/* Üye Puan  */
if(isset($_SESSION["fs"]["puan"])){ 
	$puanpara = $_SESSION["fs"]["puan"];
}else {
	$puanpara = 0.00;
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
$_SESSION['fposts']["bastarih"]     = $bastarih;
$_SESSION['fposts']["bittarih"]     = $bittarih;

	


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
	 bittarih		  = :bittarih
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
		"puantutar"		  => $parapuan,
		"kreditutar"	  => $kredipuan,
		"anadurum"		  => 1,
		"secenekler"	  => serialize($secenekler),
		"teslimattarih"	  => serialize($siparistarih),
		"teslimatsaat"	  => serialize($siparissaat),
		"bitistarihi"	  => serialize($bitistarihi),
		"bastarih"		 => serialize($bastarih),	 
		"bittarih"		 => serialize($bittarih)
		));
		
		
	if($ekle) {
		$_SESSION["sonuc"]['durum']  = 'success';
		header('location:'.$set['langurl'].'/m-odeme-sonuc');
	}else{
		$_SESSION["hata"] = 'Sipariş Verilirken Sorun Oluştu.';
		//var_dump($insert -> errorInfo() );
		header('location:'.$callbackUrl);
		exit;
	}
	
	
}


 ?>