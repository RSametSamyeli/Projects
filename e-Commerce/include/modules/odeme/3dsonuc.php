<?php 
	include('../../../lab/function.php');
	include('../../../iyzipay-php-develop/option.php');
	
		
			IyzipayBootstrap::init();
			$options = new \Iyzipay\Options();
			$options->setApiKey($iyziId);
			$options->setSecretKey($iyziKey);
			$options->setBaseUrl($iyziBaseurl);
			# create request class
			$request = new \Iyzipay\Request\CreateThreedsPaymentRequest();
			$request->setLocale(\Iyzipay\Model\Locale::TR);
			$request->setConversationId($_POST["conversationId"]);
			$request->setPaymentId($_POST["paymentId"]);
			$request->setConversationData($_POST["conversationData"]);

			# make request
			$threedsPayment = \Iyzipay\Model\ThreedsPayment::create($request,$options);
		
			# print result
			
			$detaylar = $threedsPayment->getRawResult();
			$resultJson = json_decode($detaylar,true);
			
			
			/* Kayıtlar */  	
			if($threedsPayment ->getStatus() == "success"){
				$insert = $conn -> prepare("INSERT INTO siparis SET 
				 odemeturu	= :odemeturu,
				 urunid		= :urunid,
				 baslik		= :baslik,
				 uvaryant	= :uvaryant,
				 varyantid	= :varyantid,
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
				 siparisturu	= :siparisturu,
				 puantutar		  = :puantutar,
				 kreditutar		  = :kreditutar					 
				 ");
				 
				$ekle = $insert -> execute(array(
					"odemeturu" 	=> $_SESSION["fs"]["odemeturu"],
					"urunid" 		=> serialize($_SESSION["fs"]["urunid"]),
					"baslik" 		=> serialize($_SESSION["fs"]["baslik"]),
					"uvaryant" 		=> serialize($_SESSION["fs"]["uvaryant"]),
					"varyantid" 	=> serialize($_SESSION["fs"]["varyantid"]),
					"varyantturler"	=> serialize($_SESSION["fs"]["varyantturler"]),
					"varyanttutarlar"	=> serialize($_SESSION["fs"]["varyanttutarlar"]),
					"adet"		 	=> serialize($_SESSION["fs"]["adet"]),
					"durum" 		=> 0,
					"tarih"			=> time(),
					"toplamtutar"	=> $_SESSION["fs"]["toplamtutar"],
					"ip"			=> $_SESSION["fs"]["ip"],
					"user_id"		 => $_SESSION["fs"]["user_id"],
					"teslimatadresi" => $_SESSION["fs"]["teslimatadresi"],
					"faturaadresi"   => $_SESSION["fs"]["faturaadresi"],
					"havaletipi"	 => $_SESSION["fs"]["havaletipi"],
					"kargo"			 => $_SESSION["fs"]["kargo"],
					"siparisnot"	 => $_SESSION["fs"]["siparisnot"],
					"kdv"			 => $_SESSION["fs"]["kdv"],
					"kargotutar"	 => $_SESSION["fs"]["kargotutar"],
					"kdvsiztutar"	 =>	$_SESSION["fs"]["kdvsiztutar"],
					"oid"	 		 =>	$_SESSION["fs"]["oid"],
					"kapidaodemefiyat" => $_SESSION["fs"]["kapidaodemefiyat"],
					"kapidaodemeturu"  => $_SESSION["fs"]["kapidaodemeturu"],
					 "siparisturu"	   => $_SESSION["fs"]["siparisturu"],
					"puantutar"		  => number_format($_SESSION["fs"]["parapuan"],2),
					"kreditutar"	  => number_format($_SESSION["fs"]["kredipuan"],2)							 
					));
					
                $_SESSION["siparisid"]       =  $_SESSION["fs"]["oid"];  				  
				$_SESSION["sonuc"]['durum']  = 	$resultJson['status'];
				$_SESSION["sonuc"]['date']	 = 	time();						
				$_SESSION["sonuc"]['amount'] = 	$_SESSION["amount"];
				unset($_SESSION["amount"]);
			}else{
				$_SESSION["sonuc"]['durum']   = $resultJson['status'];
				$_SESSION["sonuc"]['date']    = time();
				$_SESSION["sonuc"]['hata']    = $resultJson['errorMessage'];
				$_SESSION["sonuc"]['amount'] = '';
			
			}
			header('location:'.$set['langurl'].'/odeme-sonuc');
?>