<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php");}
if(!isset($_POST)){  exit; }
include('../iyzipay-php-develop/IyzipayBootstrap.php');
include('../iyzipay-php-develop/option.php');
IyzipayBootstrap::init();

$bin = clean($_POST["bin"]);
$pregNo = $bin;
$sample = new BinNumberSample();
$sample->should_retrieve_bin_number($pregNo);

		

class BinNumberSample
{


    public function should_retrieve_bin_number($pregNo)
    {
		$jsonArr = array();
        # create request class
        $request = new \Iyzipay\Request\RetrieveBinNumberRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456");
        $request->setBinNumber($pregNo);

        # make request
        $binNumber = \Iyzipay\Model\BinNumber::retrieve($request, Sample::options());
		$detaylar = $binNumber->getRawResult();
		$resultJson = json_decode($detaylar,true);

		
		//print_r($resultJson);
		//echo json_encode($resultJson);
		 $status      =  $resultJson['status'];
		 $jsonArr['status'] =  $resultJson['status'];
		if($status == "success"){
				$cardtype	 =  $resultJson['cardType'];
				$bin    	 =  $resultJson['binNumber'];
				$brand	 	 =  $resultJson['cardFamily'];
				$issuer	 	 =  $resultJson['cardAssociation'];
				$jsonArr['binNumber']       = $bin; 
				$jsonArr['cardAssociation'] = $issuer; 
				$jsonArr['bankName']		= $resultJson['bankName']; 
				$jsonArr['cardFamily']		= $resultJson['cardFamily']; 
				$jsonArr['cardType']		= $resultJson['cardType']; 
				if($brand == 'Maximum'){
					$connector = 'Isbank';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'maximum.png';
				}
				elseif($brand == 'Bonus'){
					$connector = 'Teb';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'bonus.png';
				}
				elseif($brand == 'World'){
					$connector = 'Vakifbank';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'world.png';
				}
				elseif($brand == 'Paraf'){
					$connector = 'Halkbank';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'paraf.png';
				}
				elseif($brand == 'Asyacard'){
					$connector = 'Bankasya';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'asya.png';
				}
				elseif($brand == 'Cardfinans'){
					$connector = 'Finansbank';
					$jsonArr['connector'] = $connector;
					$jsonArr['bankImg'] = 'finans.png';
				}else{
					$connector = '';
					$jsonArr['connector'] = $connector;
				}
				
				
				
				
				//echo $bin."|x|".$issuer."|x|".$connector;
		}
		echo json_encode($jsonArr);
		
		//echo $detaylar->binNumber();
        //print_r($binNumber->getStatus());
		//print_r($binNumber->getErrorMessage());
    }
}

?>