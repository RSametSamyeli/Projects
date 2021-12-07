<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php");}
if(!isset($_POST)){  exit; }
include('../iyzipay-php-develop/IyzipayBootstrap.php');
include('../iyzipay-php-develop/option.php');
IyzipayBootstrap::init();


$amount = clean($_POST["amount"]);
$amount = str_replace(",","",$amount);
$amount = $amount * 100;
$amouni = explode(".",$amount);
$return = "";
$bin	 = clean($_POST["bin"]);
if(!isset($amount) || !isset($bin)){ exit;}



$sample = new InstallmentSample();
$sample->should_retrieve_installment_info($amount,$bin);


class InstallmentSample
{
    public function should_retrieve_installment_info($x1,$x2)
    {
        # create request class
        $request = new \Iyzipay\Request\RetrieveInstallmentInfoRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setBinNumber($x2);
        $request->setPrice($x1);

        # make request
        $installmentInfo = \Iyzipay\Model\InstallmentInfo::retrieve($request, Sample::options());
         # print result
		$return = '';
		//$resultJson = json_decode( $installmentInfo,true); 
		if($installmentInfo->getStatus() =="success"){
			$detaylar = $installmentInfo->getRawResult();
			$resultJson = json_decode($detaylar,true);
			$detaylar   = $resultJson['installmentDetails'];
			
			$fiyatlar   = $detaylar[0]['installmentPrices'];
			$force3ds   = $detaylar[0]['force3ds'];
			//print_r($resultJson);
			
			
		
			
			$return .= '<div class="installmentOptionsRow">
				<div id="installment-container" class="installment-container">
				';
	
			$return .= '<ul class="installments">';
					foreach($fiyatlar as $row => $value2){
						asort($value2);
						//var_dump($value2);	
						$total    = $value2['totalPrice'] / 100;
						$tax      = $value2['installmentPrice'] / 100;
						$taksit   = $value2['installmentNumber'];			
						if($taksit == 1){
						$return .= '<li class="installment full selected">
								<input type="radio" checked name="installment-option" selected class="installment-option" value="'.$taksit.'">
								<span class="iyzi-inst-label" style="min-width: 47px;"> Peşin</span>
								<span class="iyzi-inst-amount">'.number_format($total,2).'  TL </span>
							</li>';	
						}else{
							$return .= '<li class="installment full">
								<input type="radio" name="installment-option" class="installment-option" value="'.$taksit.'">
								<span class="iyzi-inst-label" style="min-width: 47px;"> '.$taksit.' Taksit</span>
								<span class="iyzi-inst-amount">'.number_format($total,2).'  TL / '.number_format($tax,2).' X '.$taksit.'</span>
							</li>';	
						}
					}
				$return .='</ul>
				</div>
			</div>';
		
			echo $return .= '|x|'.$installmentInfo->getStatus()."|x|".$force3ds;
		}
    }

	
 
}


exit;

/* Eskiler */

$resultJson = array();
$return = "";
$url = "https://iyziconnect.com/installment/v1/";
$params = 'api_id=im078396400048a1e8b21e1453709666&secret=im0788338007d35799e0221453709666&mode=live&amount='.$amount.'&bin_number='.$bin;

$rest = curl_init();  
curl_setopt($rest,CURLOPT_URL,$url);  
curl_setopt($rest,CURLOPT_POST,1);
curl_setopt($rest,CURLOPT_POSTFIELDS,$params);
curl_setopt($rest,CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);  
$response = curl_exec($rest);	   
curl_close($rest); 

	$resultJson = json_decode($response,true);   

	if($resultJson['response']['state'] =="success"){
		$Arr = $resultJson['response']['installment_list'];
		reset($Arr);
		$bank  = key($Arr);
		if($bank =="PARAF"){
		   $bankImg = 'paraf.png';
		}elseif($bank == "MAXIMUM"){
		   $bankImg = 'maximum.png';
		}elseif($bank == "WORLD"){
		   $bankImg = 'world.png';
		}elseif($bank == "FINANS"){
		   $bankImg = 'finans.png';
		}elseif($bank == "ASYA"){
		   $bankImg = 'asya.png';
		}else{
			$bankImg = '';
		}

		$return .= '<div class="installmentOptionsRow">
				<div id="installment-container" class="installment-container">
				';
				if(!empty($bankImg)){
				$return .= '<span class="installment-bank-logo">
					<img alt="brand" src="'.$set['siteurl'].'/assets/images/'.$bankImg.'">
				</span>';
				}
		$return .= '<ul class="installments">';
		foreach($resultJson['response']['installment_list'] as $row => $value){
			asort($value);
			foreach($value as $row => $value2){
				//var_dump($value2);	
				$total    = $value2['total_amount'] / 100;
				$tax      = $value2['installment_amount'] / 100;
				$taksit   = $value2['installment_count'];			
				if($taksit == 1){
				$return .= '<li class="installment full selected">
						<input type="radio" checked name="installment-option" selected class="installment-option" value="'.$taksit.'">
						<span class="iyzi-inst-label" style="min-width: 47px;"> Peşin</span>
						<span class="iyzi-inst-amount">'.number_format($total,2).'  TL </span>
					</li>';	
				}else{
					$return .= '<li class="installment full">
						<input type="radio" name="installment-option" class="installment-option" value="'.$taksit.'">
						<span class="iyzi-inst-label" style="min-width: 47px;"> '.$taksit.' Taksit</span>
						<span class="iyzi-inst-amount">'.number_format($total,2).'  TL / '.number_format($tax,2).' X '.$taksit.'</span>
					</li>';	
				}
			}
		}
			$return .='</ul>
			</div>
		</div>';
	} 
	echo $return .= '|x|'.$resultJson['response']['state']."|x|".$resultJson['account']['card_type']."|x|".$resultJson['account']['issuer_bank_name'];
?>

