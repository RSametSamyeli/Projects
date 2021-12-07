<?php
$request->setCallbackUrl($set['siteurl']."/include/modules/odeme/3dsonuc.php");
   # make request
	$threedsInitialize = \Iyzipay\Model\ThreedsInitialize::create($request,$options);
	# print result
   
	$detaylar = $threedsInitialize->getRawResult();
	$resultJson = json_decode($detaylar,true);

	if($resultJson['status'] ==  "failure"){
		$_SESSION["sonuc"]['durum']   = $resultJson['status'];
		$_SESSION["sonuc"]['date']    = time();
		$_SESSION["sonuc"]['hata']    = $resultJson['errorMessage'];
		header('location:/odeme-sonuc');
	}else{	
		//echo $resultJson['threeDSHtmlContent'];
		print_r($threedsInitialize->getHtmlContent());

	}

?>
