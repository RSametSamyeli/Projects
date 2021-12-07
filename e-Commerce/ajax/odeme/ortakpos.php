<?php 
 /*** Halk Bankası ***/
	 $hashparams    = $_POST["HASHPARAMS"];
	 $hashparamsval = $_POST["HASHPARAMSVAL"];
	 $hashparam     = $_POST["HASH"];
	 $storekey      = "".$anapos['storekey']."";
	 $paramsval     = "";
	 $index1 = 0;
	 $index2 = 0;
	 while($index1 < strlen($hashparams))
	 {
		$index2 = strpos($hashparams,":",$index1);
		$vl = $_POST[substr($hashparams,$index1,$index2- $index1)];
		if($vl == null)
		$vl = "";
		$paramsval = $paramsval . $vl; 
		$index1 = $index2 + 1;
	}
	$hashval = $paramsval.$storekey;
	$hash = base64_encode(pack('H*',sha1($hashval)));
	
	if($paramsval != $hashparamsval || $hashparam != $hash) 	
	echo "<h4>Güvenlik Uyarisi. Sayisal Imza Geçerli Degil</h4>";

	$name     = "".$anapos['apiuser']."";    // Api User   	
	$password = "".$anapos['apisifre']."";    // Api Şifre		
	$clientid = $_POST["clientid"];  		//Is yeri numarasi
	$mode = "".$anapos['mode'].""; 
	$type = "Auth";
	$expires = $_POST["Ecom_Payment_Card_ExpDate_Month"]."/".$_POST["Ecom_Payment_Card_ExpDate_Year"]; //Kredi Karti son kullanim tarihi mm/yy formatindan olmali
	$tutar = $_POST["amount"];
	$lip  = GetHostByName($_SERVER["REMOTE_ADDR"]);  	//Son kullanici IP adresi
	$email="";  				//Email
	
	 //Provizyon alinamadigi durumda taksit sayisi degistirilirse sipari numarasininda
	   //degistirilmesi gerekir.
	$mdStatus=$_POST['mdStatus'];       // 3d Secure işleminin sonucu mdStatus 1,2,3,4 ise başarılı 5,6,7,8,9,0 başarısızdır
										// 3d Decure işleminin sonucu başarısız ise işlemi provizyona göndermeyiniz (XML göndermeyiniz).
	$xid  = $_POST['xid'];                 // 3d Secure özel alani PayerTxnId
	$eci  = $_POST['eci'];                 // 3d Secure özel alani PayerSecurityLevel
	$cavv = $_POST['cavv'];               // 3d Secure özel alani PayerAuthenticationCode
	$md   = $_POST['md'];                   // Eğer 3D işlembaşarılısya provizyona kart numarası yerine md değeri gönderilir.
										// Son kullanma tarihi ve cvv2 gönderilmez.
	if($mdStatus =="1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4")
{ 	
	
	// XML request sablonu
	$request= "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>".
	"<CC5Request>".
	"<Name>{NAME}</Name>".
	"<Password>{PASSWORD}</Password>".
	"<ClientId>{CLIENTID}</ClientId>".
	"<IPAddress>{IP}</IPAddress>".
	"<Email>{EMAIL}</Email>".
	"<Mode>P</Mode>".
	"<OrderId>{OID}</OrderId>".
	"<GroupId></GroupId>".
	"<TransId></TransId>".
	"<UserId></UserId>".
	"<Type>{TYPE}</Type>".
	"<Number>{MD}</Number>".
	"<Expires></Expires>".
	"<Cvv2Val></Cvv2Val>".
	"<Total>{TUTAR}</Total>".
	"<Currency>949</Currency>".
	"<Taksit>{TAKSIT}</Taksit>".
	"<PayerTxnId>{XID}</PayerTxnId>".
	"<PayerSecurityLevel>{ECI}</PayerSecurityLevel>".
	"<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>".
	"<CardholderPresentCode>13</CardholderPresentCode>".
	"<BillTo>".
	"<Name></Name>".
	"<Street1></Street1>".
	"<Street2></Street2>".
	"<Street3></Street3>".
	"<City></City>".
	"<StateProv></StateProv>".
	"<PostalCode></PostalCode>".
	"<Country></Country>".
	"<Company></Company>".
	"<TelVoice></TelVoice>".
	"</BillTo>".
	"<ShipTo>".
	"<Name></Name>".
	"<Street1></Street1>".
	"<Street2></Street2>".
	"<Street3></Street3>".
	"<City></City>".
	"<StateProv></StateProv>".
	"<PostalCode></PostalCode>".
	"<Country></Country>".
	"</ShipTo>".
	"<Extra></Extra>".
	"</CC5Request>";


      $request=str_replace("{NAME}",$name,$request);


      $request=str_replace("{PASSWORD}",$password,$request);
      $request=str_replace("{CLIENTID}",$clientid,$request);
      $request=str_replace("{IP}",$lip,$request);
      $request=str_replace("{OID}",$oid,$request);
      $request=str_replace("{TYPE}",$type,$request);
      $request=str_replace("{XID}",$xid,$request);
      $request=str_replace("{ECI}",$eci,$request);
      $request=str_replace("{CAVV}",$cavv,$request);
      $request=str_replace("{MD}",$md,$request);
      $request=str_replace("{TUTAR}",$tutar,$request);
      $request=str_replace("{TAKSIT}",$taksit,$request);


     

	// Sanal pos adresine baglanti kurulmasi
	 // https://entegrasyon.asseco-see.com.tr/fim/est3Dgate
	//https://entegrasyon.asseco-see.com.tr/fim/api 
        if($anapos['mode'] == "T"){
			$url = "https://entegrasyon.asseco-see.com.tr/fim/api";  //TEST
		}else{
			$url = "".$anapos['ucdurl']."";  //TEST
		}
		

		$ch = curl_init();    // initialize curl handle
		
		curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
		curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields



        // Buraya mdStatusa göre bir kontrol koymalisiniz.
        // 3d Secure işleminin sonucu mdStatus 1,2,3,4 ise başarılı 5,6,7,8,9,0 başarısızdır
        // 3d Decure işleminin sonucu başarısız ise işlemi provizyona göndermeyiniz (XML göndermeyiniz).

		$result = curl_exec($ch); // run the whole process
//echo htmlspecialchars($result);
echo "<br>";

       if (curl_errno($ch)) {
           print curl_error($ch);
       } else {
           curl_close($ch);
       }


 $Response ="";
 $OrderId ="";
 $AuthCode  ="";
 $ProcReturnCode    ="";
 $ErrMsg  ="";
 $HOSTMSG  ="";
 $HostRefNum = "";
 $TransId="";

$response_tag="Response";
$posf = strpos (  $result, ("<" . $response_tag . ">") );
$posl = strpos (  $result, ("</" . $response_tag . ">") ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$Response = substr (  $result, $posf, $posl - $posf) ;

$response_tag="OrderId";
$posf = strpos (  $result, ("<" . $response_tag . ">") );
$posl = strpos (  $result, ("</" . $response_tag . ">") ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$OrderId = substr (  $result, $posf , $posl - $posf   ) ;

$response_tag="AuthCode";
$posf = strpos (  $result, "<" . $response_tag . ">" );
$posl = strpos (  $result, "</" . $response_tag . ">" ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$AuthCode = substr (  $result, $posf , $posl - $posf   ) ;

$response_tag="ProcReturnCode";
$posf = strpos (  $result, "<" . $response_tag . ">" );
$posl = strpos (  $result, "</" . $response_tag . ">" ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$ProcReturnCode = substr (  $result, $posf , $posl - $posf   ) ;

$response_tag="ErrMsg";
$posf = strpos (  $result, "<" . $response_tag . ">" );
$posl = strpos (  $result, "</" . $response_tag . ">" ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$ErrMsg = substr (  $result, $posf , $posl - $posf   ) ;

$response_tag="HostRefNum";
$posf = strpos (  $result, "<" . $response_tag . ">" );
$posl = strpos (  $result, "</" . $response_tag . ">" ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$HostRefNum = substr (  $result, $posf , $posl - $posf   ) ;

$response_tag="TransId";
$posf = strpos (  $result, "<" . $response_tag . ">" );
$posl = strpos (  $result, "</" . $response_tag . ">" ) ;
$posf = $posf+ strlen($response_tag) +2 ;
$$TransId = substr (  $result, $posf , $posl - $posf   ) ;


?>
	
<?php


if ( $Response === "Approved")
{
	  
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
	 siparisturu	  = :siparisturu,
     puantutar		  = :puantutar,
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
		"oid"			 => $oid,
		"kapidaodemefiyat" => $kapidaodemefiyat,
		"kapidaodemeturu"  => $kapidaodemeturu,
		"siparisturu"	   => $siparisturu,
		"puantutar"		  => number_format($parapuan,2),
		"kreditutar"	  => number_format($kredipuan,2)		
		));

	if($ekle) {
		$_SESSION["sonuc"]['durum']  = 'success';
		$_SESSION["siparisid"] = $oid;
		$_SESSION["sonuc"]['date']	 = 	time();						
		$_SESSION["sonuc"]['amount'] = 	$_SESSION["amount"];
		
		header('location:/odeme-sonuc');
	}else {
		$_SESSION["hata"] = 'Sipariş Verilirken Sorun Oluştu.';
		header('location:'.$callbackUrl);
		exit;
	}
}
else
{
		$_SESSION["hata"] = 'Ödeme isleminiz gerçeklestirilmedi.Hata='.$ErrMsg;
		header('location:'.$callbackUrl);   
}

}
else{
	$_SESSION["hata"] = '3D islemi onay almadi.';
	header('location:'.$callbackUrl);
	exit;
}





?>									
