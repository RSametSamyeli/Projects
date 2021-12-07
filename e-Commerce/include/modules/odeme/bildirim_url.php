<?php
	include("../../../lab/setting.php");
	$main_settings	 = $conn -> query('select * from siteayar')->fetch();
	$paytr    = unserialize($main_settings['paytr']);
	
	## 2. ADIM için örnek kodlar ##

	## ÖNEMLİ UYARILAR ##
	## 1) Bu sayfaya oturum (SESSION) ile veri taşıyamazsınız. Çünkü bu sayfa müşterilerin yönlendirildiği bir sayfa değildir.
	## 2) Entegrasyonun 1. ADIM'ında gönderdiğniz merchant_oid değeri bu sayfaya POST ile gelir. Bu değeri kullanarak
	## veri tabanınızdan ilgili siparişi tespit edip onaylamalı veya iptal etmelisiniz.
	## 3) Aynı sipariş için birden fazla bildirim ulaşabilir (Ağ bağlantı sorunları vb. nedeniyle). Bu nedenle öncelikle
	## siparişin durumunu veri tabanınızdan kontrol edin, eğer onaylandıysa tekrar işlem yapmayın. Örneği aşağıda bulunmaktadır.

	$post = $_POST;

	####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
	#
	## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
	$merchant_key 	= ''.$paytr['key'].'';
	$merchant_salt	= ''.$paytr['salt'].'';
	###########################################################################
	
	####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
	#
	## POST değerleri ile hash oluştur.
	$hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );
	
	
	#
	## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
	## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.
	if( $hash != $post['hash'] )
		die('PAYTR notification failed: bad hash');
	###########################################################################

	## BURADA YAPILMASI GEREKENLER
	## 1) Siparişin durumunu $post['merchant_oid'] değerini kullanarak veri tabanınızdan sorgulayın.
	## 2) Eğer sipariş zaten daha önceden onaylandıysa veya iptal edildiyse  echo "OK"; exit; yaparak sonlandırın.

	/* Sipariş durum sorgulama örnek
 	   $durum = SQL
	   if($durum == "onay" || $durum == "iptal"){
			echo "OK";
			exit;
		}
	 */
	 $sipbul = $conn -> query("select * from siparis where anadurum = 0 && oid = '".$post['merchant_oid']."'")->fetch();
	 if($sipbul){ 
		echo "OK";
	 }

	if( $post['status'] == 'success' ) { 
		
		## Ödeme Onaylandı

		## BURADA YAPILMASI GEREKENLER
		## 1) Siparişi onaylayın.
		## 2) Eğer müşterinize mesaj / SMS / e-posta gibi bilgilendirme yapacaksanız bu aşamada yapmalısınız.
		## 3) 1. ADIM'da gönderilen payment_amount sipariş tutarı taksitli alışveriş yapılması durumunda
		## değişebilir. Güncel tutarı $post['total_amount'] değerinden alarak muhasebe işlemlerinizde kullanabilirsiniz.
		
		
		//$sipbul = $conn -> query("select * from siparis where anadurum = 0 && oid = '".$post['merchant_oid']."'")->fetch();
		if($sipbul){
			$update = $conn -> prepare("update siparis set anadurum = :anadurum, merchant_oid = :merchant_oid, status = :status, total_amount = :total_amount where id = :id ");
			$update -> execute(array(
			"anadurum" 	   => 1, 
			"merchant_oid" => $post["merchant_oid"], 
			"status" 	   => $post['status'],
			"total_amount" => $post['total_amount'],
			"id" 		   => $sipbul['id'] 
			));
		}


		/*$insert = $conn -> prepare("INSERT INTO siparis SET 
			odemeturu	 	= :odemeturu
		");
	 
		$ekle = $insert -> execute(array(
			"odemeturu" 	=> 'kredikarti'
		));
		
		*/
		
		
	} else { ## Ödemeye Onay Verilmedi

		## BURADA YAPILMASI GEREKENLER
		## 1) Siparişi iptal edin.
		## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
		## $post['failed_reason_code'] - başarısız hata kodu
		## $post['failed_reason_msg'] - başarısız hata mesajı

	}

	## Bildirimin alındığını PayTR sistemine bildir.
	echo "OK";
	exit;
?>