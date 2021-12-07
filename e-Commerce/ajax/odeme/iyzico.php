<?php 
		$bankName   		= clean($_POST["bankName"]);	
		$cardAssociation    = clean($_POST["cardAssociation"]);
		$cardType   		= clean($_POST["cardType"]);
		$force3ds 	 		= clean($_POST["force3ds"]);
		
		IyzipayBootstrap::init();
		# create request class
		$options = new \Iyzipay\Options();
		$options->setApiKey($iyziId);
		$options->setSecretKey($iyziKey);
		$options->setBaseUrl($iyziBaseurl);
	    
		$request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice($toplamtutar);
        $request->setPaidPrice($toplamtutar);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setInstallment($taksit);
        $request->setBasketId("B67832");
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
		$paymentCard->setCardHolderName($cardadsoyad);
		$paymentCard->setCardNumber($cardnumber);
		$paymentCard->setExpireMonth($ccay);
		$paymentCard->setExpireYear($ccyil);
		$paymentCard->setCvc($cvc);
		$paymentCard->setRegisterCard(0);
		$request->setPaymentCard($paymentCard);
		
		
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName($uyebul['ad']);
        $buyer->setSurname($uyebul['soyad']);
        $buyer->setGsmNumber($uyebul['telefon']);
		$buyer->setIdentityNumber('10076267290');
        $buyer->setEmail($uyebul['email']);
        $buyer->setRegistrationAddress($adresCek['adres']);
		$buyer->setZipCode("34732");
		$buyer->setCity("Istanbul");
		$buyer->setCountry("Turkey");
        $buyer->setIp(getenv('REMOTE_ADDR'));
        $request->setBuyer($buyer);

        // adres bilgileri
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Demo demo");
        $shippingAddress->setCity("Eskisehir");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("adres satırı");
        $request->setShippingAddress($shippingAddress);
		// fatura adres
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName('contact name');
        $billingAddress->setAddress('adres ');
        $billingAddress->setCity("Eskisehir");
		$billingAddress->setCountry("Turkey");
		$request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName($set['seo']['t']);
        $firstBasketItem->setCategory1($set['seo']['t']);	
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($toplamtutar);
        $basketItems[0] = $firstBasketItem;
		$request->setBasketItems($basketItems);
		
		
		if($force3ds == 1){
			include('iyzico/3d.php');
		}else{
			
			if(isset($_POST["ucd"])){ 
				include('iyzico/3d.php');
				
			}else{
				
				include('iyzico/3dsiz.php');
			} 
		}
?>