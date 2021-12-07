<?php
include 'ayar.php';
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
	$merchant_key 	= 'fstC4FmY259UJATe';
	$merchant_salt	= 'SPN134eY6i3fb4Jn';
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

	if( $post['status'] == 'success' ) { ## Ödeme Onaylandı
	$gir=$db->prepare("update odeme set sonuc='1',rand='0' where id='{$post['merchant_oid']}'");
	$gir->execute();
       $uyebul=$db->query("select * from odeme where id='{$post['merchant_oid']}'");
       $uyebul=$uyebul->fetch(PDO::FETCH_ASSOC);
	$eklenecek=$post['total_amount']/100;
	$ekle=$db->prepare("update uye set bakiye=bakiye+'$eklenecek' where id='{$uyebul['uye_id']}'");
	$ekle->execute();


        $tarih=date("Y-m-d H:i:s");
        $kayit=$db->prepare("insert into odeak (tarih,uye,yontem,miktar) values (?,?,?,?)");
        $kayit->execute(array($tarih,$uyebul['uye_id'],"PayTR",$eklenecek));
        
	} else { ## Ödemeye Onay Verilmedi

        $gir=$db->prepare("update odeme set sonuc='0',rand='0' where id='{$post['merchant_oid']}'");
        $gir->execute();



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