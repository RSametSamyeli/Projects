<?php 
ob_start();
session_start();
include 'baglan.php';
include '../app/fonksiyon.php';




// Giriş Yap & Kaydol

if (isset($_POST['kullanicigiris'])) {


	
	$kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); 
	$kullanici_password=md5($_POST['kullanici_password']); 



	$kullanicisor=$db->prepare("select * from kullanici where kullanici_mail=:mail and kullanici_yetki=:yetki and kullanici_password=:password and kullanici_durum=:durum");
	$kullanicisor->execute(array(
		'mail' => $kullanici_mail,
		'yetki' => 1,
		'password' => $kullanici_password,
		'durum' => 1
	));


	$say=$kullanicisor->rowCount();



	if ($say==1) {

		echo $_SESSION['userkullanici_mail']=$kullanici_mail;

		header("Location:../../basarili.php?durum=ok");

	} else {


		header("Location:../../basarili.php?durum=basarisizgiris");

	}


}



//Yönetim Paneli Giriş Bilgileri

if (isset($_POST['loggin'])) {


	$kullanici_ad=$_POST['kullanici_ad'];
	$kullanici_password=md5($_POST['kullanici_password']);
	
	
	if ($kullanici_ad && $kullanici_password) {


		$kullanicisor=$db->prepare("SELECT * from kullanici where kullanici_ad=:ad and kullanici_password=:password");
		$kullanicisor->execute(array(
			'ad' => $kullanici_ad,
			'password' => $kullanici_password
		));

		$say=$kullanicisor->rowCount();

		if ($say>0) {

			$_SESSION['kullanici_ad'] = $kullanici_ad;


			header('Location:../app/index.php');


		} else {

			header('Location:../app/login.php?durum=no');


		}
	}

}
