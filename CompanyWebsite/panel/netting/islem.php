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



//Site Genel Ayarlar 

if (isset($_POST['genelayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_siteurl=:siteurl,
		ayar_title=:title,
		ayar_description=:description,
		ayar_keywords=:keywords,
		ayar_author=:author
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'siteurl' => $_POST['ayar_siteurl'],
		'title' => $_POST['ayar_title'],
		'description' => $_POST['ayar_description'],
		'keywords' => $_POST['ayar_keywords'],
		'author' => $_POST['ayar_author']
	));

	if ($update) {

		Header("Location:../app/genel-ayar.php?durum=ok");

	} else {

		Header("Location:../app/genel-ayar.php?durum=no");
	}

}


//İletişim Bilgileri

if (isset($_POST['iletisimayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_tel=:tel,
		ayar_gsm=:gsm,
		ayar_faks=:faks,
		ayar_mail=:mail,
		ayar_adres=:adres,
		ayar_ilce=:ilce,
		ayar_il=:il,
		ayar_mesai=:mesai
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'tel' => $_POST['ayar_tel'],
		'gsm' => $_POST['ayar_gsm'],
		'faks' => $_POST['ayar_faks'],
		'mail' => $_POST['ayar_mail'],
		'adres' => $_POST['ayar_adres'],
		'ilce' => $_POST['ayar_ilce'],
		'il' => $_POST['ayar_il'],
		'mesai' => $_POST['ayar_mesai']
	));

	if ($update) {

		Header("Location:../app/iletisim-ayar.php?durum=ok");

	} else {

		Header("Location:../app/iletisim-ayar.php?durum=no");
	}

}


//API Sistemleri

if (isset($_POST['apiayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_recapctha=:recapctha,
		ayar_goooglemap=:goooglemap,
		ayar_zopim=:zopim,
		ayar_analystic=:analystic
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'recapctha' => $_POST['ayar_recapctha'],
		'goooglemap' => $_POST['ayar_goooglemap'],
		'zopim' => $_POST['ayar_zopim'],
		'analystic' => $_POST['ayar_analystic']
	));

	if ($update) {

		Header("Location:../app/api-ayar.php?durum=ok");

	} else {

		Header("Location:../app/api-ayar.php?durum=no");
	}

}

//Sosyal Ağ Paketi

if (isset($_POST['sosyalayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_facebook=:facebook,
		ayar_twitter=:twitter,
		ayar_google=:google,
		ayar_youtube=:youtube
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'facebook' => $_POST['ayar_facebook'],
		'twitter' => $_POST['ayar_twitter'],
		'google' => $_POST['ayar_google'],
		'youtube' => $_POST['ayar_youtube']
	));

	if ($update) {

		Header("Location:../app/sosyal-ayar.php?durum=ok");

	} else {

		Header("Location:../app/sosyal-ayar.php?durum=no");
	}

}


if (isset($_POST['mailayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_smtphost=:smtphost,
		ayar_smtpuser=:smtpuser,
		ayar_smtppassword=:smtppassword,
		ayar_smtpport=:smtpport
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'smtphost' => $_POST['ayar_smtphost'],
		'smtpuser' => $_POST['ayar_smtpuser'],
		'smtppassword' => $_POST['ayar_smtppassword'],
		'smtpport' => $_POST['ayar_smtpport']
	));

	if ($update) {

		Header("Location:../app/mail-ayar.php?durum=ok");

	} else {

		Header("Location:../app/mail-ayar.php?durum=no");
	}

}


//Hakkımızda Sayfası

if (isset($_POST['hakkimizdakaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE hakkimizda SET
		hakkimizda_baslik=:baslik,
		hakkimizda_icerik=:icerik,
		hakkimizda_video=:video,
		hakkimizda_vizyon=:vizyon,
		hakkimizda_misyon=:misyon
		WHERE hakkimizda_id=0");
	$update=$ayarkaydet->execute(array(
		'baslik' => $_POST['hakkimizda_baslik'],
		'icerik' => $_POST['hakkimizda_icerik'],
		'video' => $_POST['hakkimizda_video'],
		'vizyon' => $_POST['hakkimizda_vizyon'],
		'misyon' => $_POST['hakkimizda_misyon']
	));

	if ($update) {

		Header("Location:../app/hakkimizda.php?durum=ok");

	} else {

		Header("Location:../app/hakkimizda.php?durum=no");
	}

}


//Slider Bilgileri

if (isset($_POST['sliderkaydet'])) {


	$uploads_dir = '../../dimg/slider';
	@$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
	@$name = $_FILES['slider_resimyol']["name"];
	$benzersizsayi1=rand(20000,32000);
	$benzersizsayi2=rand(20000,32000);
	$benzersizsayi3=rand(20000,32000);
	$benzersizsayi4=rand(20000,32000);
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");
	
	$kaydet=$db->prepare("INSERT INTO slider SET
		slider_ad=:ad,
		slider_aciklama=:aciklama,
		slider_link=:link,
		slider_sira=:sira,
		slider_durum=:durum,
		slider_resimyol=:resimyol");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['slider_ad'],
		'aciklama' => $_POST['slider_aciklama'],
		'link' => $_POST['slider_link'],
		'sira' => $_POST['slider_sira'],
		'durum' => $_POST['slider_durum'],
		'resimyol' => $refimgyol
	));

	if ($insert) {

		Header("Location:../app/slider.php?durum=ok");

	} else {

		Header("Location:../app/slider.php?durum=no");
	}

}


if ($_GET['slidersil']=="ok") {
	
	$sil=$db->prepare("DELETE from slider where slider_id=:slider_id");
	$kontrol=$sil->execute(array(
		'slider_id' => $_GET['slider_id']
	));

	if ($kontrol) {

		$resimsilunlink=$_GET['slider_resimyol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/slider.php?durum=ok");

	} else {

		Header("Location:../app/slider.php?durum=no");
	}

}


if (isset($_POST['sliderduzenle'])) {

	
	if($_FILES['slider_resimyol']["size"] > 0)  { 


		$uploads_dir = '../../dimg/slider';
		@$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
		@$name = $_FILES['slider_resimyol']["name"];
		$benzersizsayi1=rand(20000,32000);
		$benzersizsayi2=rand(20000,32000);
		$benzersizsayi3=rand(20000,32000);
		$benzersizsayi4=rand(20000,32000);
		$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
		$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
		@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

		$duzenle=$db->prepare("UPDATE slider SET
			slider_ad=:ad,
			slider_aciklama=:aciklama,
			slider_link=:link,
			slider_sira=:sira,
			slider_durum=:durum,
			slider_resimyol=:resimyol	
			WHERE slider_id={$_POST['slider_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['slider_ad'],
			'aciklama' => $_POST['slider_aciklama'],
			'link' => $_POST['slider_link'],
			'sira' => $_POST['slider_sira'],
			'durum' => $_POST['slider_durum'],
			'resimyol' => $refimgyol,
		));
		

		$slider_id=$_POST['slider_id'];

		if ($update) {

			$resimsilunlink=$_POST['slider_resimyol'];
			unlink("../../$resimsilunlink");

			Header("Location:../app/slider-duzenle.php?slider_id=$slider_id&durum=ok");

		} else {

			Header("Location:../app/slider-duzenle.php?durum=no");
		}



	} else {

		$duzenle=$db->prepare("UPDATE slider SET
			slider_ad=:ad,
			slider_aciklama=:aciklama,
			slider_link=:link,
			slider_sira=:sira,
			slider_durum=:durum		
			WHERE slider_id={$_POST['slider_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['slider_ad'],
			'aciklama' => $_POST['slider_aciklama'],
			'link' => $_POST['slider_link'],
			'sira' => $_POST['slider_sira'],
			'durum' => $_POST['slider_durum']
		));

		$slider_id=$_POST['slider_id'];

		if ($update) {

			Header("Location:../app/slider-duzenle.php?slider_id=$slider_id&durum=ok");

		} else {

			Header("Location:../app/slider-duzenle.php?durum=no");
		}
	}

}

#İçerik İşlemleri

if (isset($_POST['icerikkaydet'])) {


	$uploads_dir = '../../dimg/icerik';
	@$tmp_name = $_FILES['icerik_resimyol']["tmp_name"];
	@$name = $_FILES['icerik_resimyol']["name"];
	$benzersizsayi1=rand(20000,32000);
	$benzersizsayi2=rand(20000,32000);
	$benzersizsayi3=rand(20000,32000);
	$benzersizsayi4=rand(20000,32000);
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");


	$tarih=$_POST['icerik_tarih'];
	$saat=$_POST['icerik_saat'];
	$zaman = $tarih." ".$saat;

	
	$kaydet=$db->prepare("INSERT INTO icerik SET
		icerik_ad=:ad,
		icerik_detay=:detay,
		icerik_keyword=:keyword,
		icerik_durum=:durum,
		icerik_onecikar=:onecikar,
		icerik_ozet=:ozet,
		icerik_resimyol=:resimyol,
		icerik_zaman=:zaman");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['icerik_ad'],
		'detay' => $_POST['icerik_detay'],
		'keyword' => $_POST['icerik_keyword'],
		'durum' => $_POST['icerik_durum'],
		'onecikar' => $_POST['icerik_onecikar'],
		'ozet' => $_POST['icerik_ozet'],
		'resimyol' => $refimgyol,
		'zaman' => $zaman
	));

	if ($insert) {

		Header("Location:../app/icerik.php?durum=ok");

	} else {

		Header("Location:../app/icerik.php?durum=no");
	}

}


if (isset($_POST['icerikduzenle'])) {

	
	if($_FILES['icerik_resimyol']["size"] > 0)  { 


		$uploads_dir = '../../dimg/icerik';
		@$tmp_name = $_FILES['icerik_resimyol']["tmp_name"];
		@$name = $_FILES['icerik_resimyol']["name"];
		$benzersizsayi1=rand(20000,32000);
		$benzersizsayi2=rand(20000,32000);
		$benzersizsayi3=rand(20000,32000);
		$benzersizsayi4=rand(20000,32000);
		$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
		$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
		@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

		$tarih=$_POST['icerik_tarih'];
		$saat=$_POST['icerik_saat'];
		$zaman = $tarih." ".$saat;

		$kaydet=$db->prepare("UPDATE icerik SET
			icerik_ad=:ad,
			icerik_detay=:detay,
			icerik_keyword=:keyword,
			icerik_durum=:durum,
			icerik_onecikar=:onecikar,
			icerik_ozet=:ozet,
			icerik_resimyol=:resimyol,
			icerik_zaman=:zaman
			WHERE icerik_id={$_POST['icerik_id']}");
		$update=$kaydet->execute(array(
			'ad' => $_POST['icerik_ad'],
			'detay' => $_POST['icerik_detay'],
			'keyword' => $_POST['icerik_keyword'],
			'durum' => $_POST['icerik_durum'],
			'onecikar' => $_POST['icerik_onecikar'],
			'ozet' => $_POST['icerik_ozet'],
			'resimyol' => $refimgyol,
			'zaman' => $zaman
		));


		$icerik_id=$_POST['icerik_id'];

		if ($update) {

			$resimsilunlink=$_POST['icerik_resimyol'];
			unlink("../../$resimsilunlink");

			Header("Location:../app/icerik-duzenle.php?icerik_id=$icerik_id&durum=ok");

		} else {

			Header("Location:../app/icerik-duzenle.php?durum=no");
		}



	} else {

		$tarih=$_POST['icerik_tarih'];
		$saat=$_POST['icerik_saat'];
		$zaman = $tarih." ".$saat;

		$kaydet=$db->prepare("UPDATE icerik SET
			icerik_ad=:ad,
			icerik_detay=:detay,
			icerik_keyword=:keyword,
			icerik_durum=:durum,
			icerik_onecikar=:onecikar,
			icerik_ozet=:ozet,
			icerik_zaman=:zaman
			WHERE icerik_id={$_POST['icerik_id']}");
		$update=$kaydet->execute(array(
			'ad' => $_POST['icerik_ad'],
			'detay' => $_POST['icerik_detay'],
			'keyword' => $_POST['icerik_keyword'],
			'durum' => $_POST['icerik_durum'],	
			'onecikar' => $_POST['icerik_onecikar'],
			'ozet' => $_POST['icerik_ozet'],
			'zaman' => $zaman
		));


		$icerik_id=$_POST['icerik_id'];

		if ($update) {

			Header("Location:../app/icerik-duzenle.php?icerik_id=$icerik_id&durum=ok");

		} else {

			Header("Location:../app/icerik-duzenle.php?durum=no");
		}

		

	}

}

if ($_GET['iceriksil']=="ok") {
	
	$sil=$db->prepare("DELETE from icerik where icerik_id=:icerik_id");
	$kontrol=$sil->execute(array(
		'icerik_id' => $_GET['icerik_id']
	));

	if ($kontrol) {

		$resimsilunlink=$_GET['icerik_resimyol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/icerik.php?durum=ok");

	} else {

		Header("Location:../app/icerik.php?durum=no");
	}

}


#İçerik İşlemleri


if (isset($_POST['menukaydet'])) {

	
	$kaydet=$db->prepare("INSERT INTO menu SET
		menu_ust=:ust,
		menu_ad=:ad,
		menu_url=:url,
		menu_detay=:detay,
		menu_sira=:sira,
		menu_durum=:durum");
	$insert=$kaydet->execute(array(
		'ust' => $_POST['menu_ust'],
		'ad' => $_POST['menu_ad'],
		'url' => $_POST['menu_url'],
		'detay' => $_POST['menu_detay'],
		'sira' => $_POST['menu_sira'],
		'durum' => $_POST['menu_durum']
	));

	if ($insert) {

		Header("Location:../app/menu.php?durum=ok");

	} else {

		Header("Location:../app/menu.php?durum=no");
	}

}


if (isset($_POST['menuduzenle'])) {

	$menu_id=$_POST['menu_id'];

	
	$kaydet=$db->prepare("UPDATE menu SET
		menu_ust=:ust,
		menu_ad=:ad,
		menu_url=:url,
		menu_detay=:detay,
		menu_sira=:sira,
		menu_durum=:durum
		WHERE menu_id={$_POST['menu_id']}");
	$update=$kaydet->execute(array(
		'ust' => $_POST['menu_ust'],
		'ad' => $_POST['menu_ad'],
		'url' => $_POST['menu_url'],
		'detay' => $_POST['menu_detay'],
		'sira' => $_POST['menu_sira'],
		'durum' => $_POST['menu_durum']
	));

	if ($update) {

		Header("Location:../app/menu-duzenle.php?durum=ok&menu_id=$menu_id");

	} else {

		Header("Location:../app/menu-duzenle.php?durum=no&menu_id=$menu_id");
	}

}

if ($_GET['menusil']=="ok") {
	
	$sil=$db->prepare("DELETE from menu where menu_id=:menu_id");
	$kontrol=$sil->execute(array(
		'menu_id' => $_GET['menu_id']
	));

	if ($kontrol) {

		Header("Location:../app/menu.php?durum=ok");

	} else {

		Header("Location:../app/menu.php?durum=no");
	}

}




if (isset($_POST['logoduzenle'])) {



	$uploads_dir = '../../dimg';
	@$tmp_name = $_FILES['ayar_logo']["tmp_name"];
	@$name = $_FILES['ayar_logo']["name"];
	$benzersizsayi4=rand(20000,32000);
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

	$duzenle=$db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
	$update=$duzenle->execute(array(
		'logo' => $refimgyol
	));



	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/genel-ayar.php?durum=ok");

	} else {

		Header("Location:../app/genel-ayar.php?durum=no");
	}

}



if (isset($_POST['kresimduzenle'])) {

	$uploads_dir = '../../dimg/kullanici';
	@$tmp_name = $_FILES['kullanici_resim']["tmp_name"];
	@$name = $_FILES['kullanici_resim']["name"];
	$benzersizsayi4=rand(20000,32000);
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

	$duzenle=$db->prepare("UPDATE kullanici SET
		kullanici_resim=:resim
		WHERE kullanici_id={$_POST['kullanici_id']}");
	$update=$duzenle->execute(array(
		'resim' => $refimgyol
	));



	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/kullanici-profil.php?durum=ok");

	} else {

		Header("Location:../app/kullanici-profil.php?durum=no");
	}

}


if (isset($_POST['kullaniciprofilkaydet'])) {


	$kullanici_password=md5($_POST['kullanici_password']);
	
	$ayarkaydet=$db->prepare("UPDATE kullanici SET

		kullanici_adsoyad=:adsoyad,
		kullanici_password=:password
		WHERE kullanici_id={$_POST['kullanici_id']}");
	$update=$ayarkaydet->execute(array(
		
		'adsoyad' => $_POST['kullanici_adsoyad'],
		'password' => $kullanici_password
	));

	if ($update) {

		Header("Location:../app/kullanici-profil.php?durum=ok");

	} else {

		Header("Location:../app/kullanici-profil.php?durum=no");
	}

}


#referans işlemleri

if (isset($_POST['referanskaydet'])) {


	$uploads_dir = '../../dimg/referans';
	@$tmp_name = $_FILES['referans_resimyol']["tmp_name"];
	@$name = $_FILES['referans_resimyol']["name"];
	$benzersizsayi1=rand(20000,32000);
	$benzersizsayi2=rand(20000,32000);
	$benzersizsayi3=rand(20000,32000);
	$benzersizsayi4=rand(20000,32000);
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");
	
	$kaydet=$db->prepare("INSERT INTO referans SET
		referans_ad=:ad,
		referans_link=:link,
		referans_aciklama=:referans_aciklama,
		referans_resimyol=:resimyol");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['referans_ad'],
		'link' => $_POST['referans_link'],
		'referans_aciklama' => $_POST['referans_aciklama'],
		'resimyol' => $refimgyol
	));

	if ($insert) {

		Header("Location:../app/referans.php?durum=ok");

	} else {

		Header("Location:../app/referans.php?durum=no");
	}

}

if (isset($_POST['referansduzenle'])) {

	
	if($_FILES['referans_resimyol']["size"] > 0)  { 


		$uploads_dir = '../../dimg/referans';
		@$tmp_name = $_FILES['referans_resimyol']["tmp_name"];
		@$name = $_FILES['referans_resimyol']["name"];
		$benzersizsayi1=rand(20000,32000);
		$benzersizsayi2=rand(20000,32000);
		$benzersizsayi3=rand(20000,32000);
		$benzersizsayi4=rand(20000,32000);
		$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
		$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
		@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

		$duzenle=$db->prepare("UPDATE referans SET
			referans_ad=:ad,
			referans_link=:link,
			referans_aciklama=:referans_aciklama,
			referans_onecikar=:referans_onecikar,
			referans_resimyol=:resimyol	
			WHERE referans_id={$_POST['referans_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['referans_ad'],
			'link' => $_POST['referans_link'],
			'referans_aciklama' => $_POST['referans_aciklama'],
			'referans_onecikar' => $_POST['referans_onecikar'],
			'resimyol' => $refimgyol
		));
		

		$referans_id=$_POST['referans_id'];

		if ($update) {

			$resimsilunlink=$_POST['referans_resimyol'];
			unlink("../../$resimsilunlink");

			Header("Location:../app/referans-duzenle.php?referans_id=$referans_id&durum=ok");

		} else {

			Header("Location:../app/referans-duzenle.php?durum=no");
		}



	} else {

		$duzenle=$db->prepare("UPDATE referans SET
			referans_ad=:ad,
			referans_link=:link,
			referans_aciklama=:referans_aciklama,
			referans_onecikar=:referans_onecikar
			WHERE referans_id={$_POST['referans_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['referans_ad'],
			'link' => $_POST['referans_link'],
			'referans_aciklama' => $_POST['referans_aciklama'],
			'referans_onecikar' => $_POST['referans_onecikar']
		));

		$referans_id=$_POST['referans_id'];

		if ($update) {

			Header("Location:../app/referans-duzenle.php?referans_id=$referans_id&durum=ok");

		} else {

			Header("Location:../app/referans-duzenle.php?durum=no");
		}
	}

}


if ($_GET['referanssil']=="ok") {
	
	$sil=$db->prepare("DELETE from referans where referans_id=:referans_id");
	$kontrol=$sil->execute(array(
		'referans_id' => $_GET['referans_id']
	));

	if ($kontrol) {

		$resimsilunlink=$_GET['referans_resimyol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/referans.php?durum=ok");

	} else {

		Header("Location:../app/referans.php?durum=no");
	}

}


#sss işlemleri

if (isset($_POST['ssskaydet'])) {

	$kaydet=$db->prepare("INSERT INTO sss SET
		sss_ad=:ad,
		sss_detay=:detay,
		sss_sira=:sira");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['sss_ad'],
		'detay' => $_POST['sss_detay'],
		'sira' => $_POST['sss_sira']));

	if ($insert) {

		Header("Location:../app/sss.php?durum=ok");

	} else {

		Header("Location:../app/sss.php?durum=no");
	}

}


if ($_GET['ssssil']=="ok") {
	
	$sil=$db->prepare("DELETE from sss where sss_id=:sss_id");
	$kontrol=$sil->execute(array(
		'sss_id' => $_GET['sss_id']
	));

	

}


if(isset($_POST['galerisil'])) {


	$checklist = $_POST['galerisec'];

	foreach($checklist as $list) {

		$sil=$db->prepare("DELETE from galeri where galeri_id=:galeri_id");
		$kontrol=$sil->execute(array(
			'galeri_id' => $list
		));
	}

	if ($kontrol) {

		Header("Location:../app/galeri.php?durum=ok");

	} else {

		Header("Location:../app/galeri.php?durum=no");
	}


} 

if(isset($_POST['videosil'])) {


	$checklist = $_POST['videosec'];

	foreach($checklist as $list) {

		$sil=$db->prepare("DELETE from video where video_id=:video_id");
		$kontrol=$sil->execute(array(
			'video_id' => $list
		));
	}

	if ($kontrol) {

		Header("Location:../app/video.php?durum=ok");

	} else {

		Header("Location:../app/video.php?durum=no");
	}


} 


//Metin İşlemleri

if (isset($_POST['metinkaydet'])) {

	
	$kaydet=$db->prepare("INSERT INTO metin SET
		metin_ad=:ad,
		metin_icon=:icon,
		metin_detay=:detay,
		metin_sira=:sira,
		metin_durum=:durum");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['metin_ad'],
		'icon' => $_POST['metin_icon'],
		'detay' => $_POST['metin_detay'],
		'sira' => $_POST['metin_sira'],
		'durum' => $_POST['metin_durum']
	));

	if ($insert) {

		Header("Location:../app/metin.php?durum=ok");

	} else {

		Header("Location:../app/metin.php?durum=no");
	}

}


if (isset($_POST['metinduzenle'])) {

	$metin_id=$_POST['metin_id'];

	
	$kaydet=$db->prepare("UPDATE metin SET
		metin_ad=:ad,
		metin_icon=:icon,
		metin_detay=:detay,
		metin_sira=:sira,
		metin_durum=:durum
		WHERE metin_id={$_POST['metin_id']}");
	$update=$kaydet->execute(array(
		'ad' => $_POST['metin_ad'],
		'icon' => $_POST['metin_icon'],
		'detay' => $_POST['metin_detay'],
		'sira' => $_POST['metin_sira'],
		'durum' => $_POST['metin_durum']
	));

	if ($update) {

		Header("Location:../app/metin-duzenle.php?durum=ok&metin_id=$metin_id");

	} else {

		Header("Location:../app/metin-duzenle.php?durum=no&metin_id=$metin_id");
	}

}

if ($_GET['metinsil']=="ok") {
	
	$sil=$db->prepare("DELETE from metin where metin_id=:metin_id");
	$kontrol=$sil->execute(array(
		'metin_id' => $_GET['metin_id']
	));

	if ($kontrol) {

		Header("Location:../app/metin.php?durum=ok");

	} else {

		Header("Location:../app/metin.php?durum=no");
	}

}

// Metin İşlemleri Bitiş

// Yan Metin İşlemleri Başla

if (isset($_POST['yanmetinkaydet'])) {

	
	$kaydet=$db->prepare("INSERT INTO yanmetin SET
		yanmetin_ad=:ad,
		yanmetin_icon=:icon,
		yanmetin_detay=:detay,
		yanmetin_sira=:sira,
		yanmetin_durum=:durum");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['yanmetin_ad'],
		'icon' => $_POST['yanmetin_icon'],
		'detay' => $_POST['yanmetin_detay'],
		'sira' => $_POST['yanmetin_sira'],
		'durum' => $_POST['yanmetin_durum']
	));

	if ($insert) {

		Header("Location:../app/yanmetin.php?durum=ok");

	} else {

		Header("Location:../app/yanmetin.php?durum=no");
	}

}


if (isset($_POST['yanmetinduzenle'])) {

	$yanmetin_id=$_POST['yanmetin_id'];

	
	$kaydet=$db->prepare("UPDATE yanmetin SET
		yanmetin_ad=:ad,
		yanmetin_icon=:icon,
		yanmetin_detay=:detay,
		yanmetin_sira=:sira,
		yanmetin_durum=:durum
		WHERE yanmetin_id={$_POST['yanmetin_id']}");
	$update=$kaydet->execute(array(
		'ad' => $_POST['yanmetin_ad'],
		'icon' => $_POST['yanmetin_icon'],
		'detay' => $_POST['yanmetin_detay'],
		'sira' => $_POST['yanmetin_sira'],
		'durum' => $_POST['yanmetin_durum']
	));

	if ($update) {

		Header("Location:../app/yanmetin-duzenle.php?durum=ok&yanmetin_id=$yanmetin_id");

	} else {

		Header("Location:../app/yanmetin-duzenle.php?durum=no&yanmetin_id=$yanmetin_id");
	}

}

if ($_GET['yanmetinsil']=="ok") {
	
	$sil=$db->prepare("DELETE from yanmetin where yanmetin_id=:yanmetin_id");
	$kontrol=$sil->execute(array(
		'yanmetin_id' => $_GET['yanmetin_id']
	));

	if ($kontrol) {

		Header("Location:../app/yanmetin.php?durum=ok");

	} else {

		Header("Location:../app/yanmetin.php?durum=no");
	}

}

// Yanmetin İşlemleri Bitiş

//Sayaç İşlemleri

if (isset($_POST['sayackaydet'])) {

	
	$kaydet=$db->prepare("INSERT INTO sayac SET
		sayac_ad=:ad,
		sayac_icon=:icon,
		sayac_detay=:detay,
		sayac_sira=:sira,
		sayac_durum=:durum");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['sayac_ad'],
		'icon' => $_POST['sayac_icon'],
		'detay' => $_POST['sayac_detay'],
		'sira' => $_POST['sayac_sira'],
		'durum' => $_POST['sayac_durum']
	));

	if ($insert) {

		Header("Location:../app/sayac.php?durum=ok");

	} else {

		Header("Location:../app/sayac.php?durum=no");
	}

}


if (isset($_POST['sayacduzenle'])) {

	$sayac_id=$_POST['sayac_id'];

	
	$kaydet=$db->prepare("UPDATE sayac SET
		sayac_ad=:ad,
		sayac_icon=:icon,
		sayac_detay=:detay,
		sayac_sira=:sira,
		sayac_durum=:durum
		WHERE sayac_id={$_POST['sayac_id']}");
	$update=$kaydet->execute(array(
		'ad' => $_POST['sayac_ad'],
		'icon' => $_POST['sayac_icon'],
		'detay' => $_POST['sayac_detay'],
		'sira' => $_POST['sayac_sira'],
		'durum' => $_POST['sayac_durum']
	));

	if ($update) {

		Header("Location:../app/sayac-duzenle.php?durum=ok&sayac_id=$sayac_id");

	} else {

		Header("Location:../app/sayac-duzenle.php?durum=no&sayac_id=$sayac_id");
	}

}

if ($_GET['sayacsil']=="ok") {
	
	$sil=$db->prepare("DELETE from sayac where sayac_id=:sayac_id");
	$kontrol=$sil->execute(array(
		'sayac_id' => $_GET['sayac_id']
	));

	if ($kontrol) {

		Header("Location:../app/sayac.php?durum=ok");

	} else {

		Header("Location:../app/sayac.php?durum=no");
	}

}

// Sayaç İşlemleri Bitiş

// Yönetim Panelinde ki Kullanıcı Kodları Başlangıç ----------------------------------------------------------------------------------
// Yönetici Kullanıcı Düzenle 

if (isset($_POST['kullaniciduzenle'])) {

	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET

		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_gsm=:kullanici_gsm,
		kullanici_durum=:kullanici_durum,
		kullanici_password=:kullanici_password,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce

		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_adsoyad' => $_POST['kullanici_adsoyad'],
		'kullanici_gsm'=> $_POST['kullanici_gsm'],
		'kullanici_durum' => $_POST['kullanici_durum'],
		'kullanici_password'=>$_POST['kullanici_password'],
		'kullanici_adres'=>$_POST['kullanici_adres'],
		'kullanici_il'=>$_POST['kullanici_il'],
		'kullanici_ilce'=>$_POST['kullanici_ilce']
	));

	if ($update) {
		header("Location:../app/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
	}else{
		header("Location:../app/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
	}

}

//Yönetici - Kullanıcı Sil

if ($_GET['kullanicisil']=="ok"){

	$sil=$db->prepare("DELETE FROM kullanici WHERE kullanici_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kullanici_id']
	));

	if ($kontrol) {
		header("Location:../app/kullanici.php?sil=ok");
	}else{
		header("Location:../app/kullanici.php?sil=no");
	}
}


//Yönetici - Yönetici Giriş
if (isset($_POST['admingiris'])) {

	$kullanici_mail=$_POST['kullanici_mail'];
	$kullanici_password=md5($_POST['kullanici_password']);

	$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail and kullanici_password=:sifre and kullanici_yetki=:yetki");
	$kullanicisor->execute(array(
		'mail'=>$kullanici_mail,
		'sifre'=>$kullanici_password,
		'yetki'=>5
	));
	$say = $kullanicisor->rowCount();
	if ($say==1) {
		$_SESSION['kullanici_mail']=$kullanici_mail;
		$_SESSION['kullanici_password']=$kullanici_password;
		header("Location:../app/index.php");
	}else{
		header("Location:../app/login.php?durum=no");
	}

}


//Yönetici - Kullanıcı Giriş

/*
if (isset($_POST['kullanicigiris'])) {

	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); 
	echo $kullanici_password=md5($_POST['kullanici_password']); 

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
		header("Location:../../");
	} else {
		header("Location:../../musteri-panel.php?durum=basarisizgiris");
	}
}*/
//Yönetici Kullanıcı Kodları Bitiş  ---------------------------------------------------------------


// SİTE İÇİ KULLANICI İŞLEMLERİ

if (isset($_POST['kullanicibilgiguncelle'])) {

	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_gsm=:kullanici_gsm,
		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_password=:kullanici_password,
		kullanici_adres=:kullanici_adres

		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_gsm'=>$_POST['kullanici_gsm'],
		'kullanici_adsoyad' => $_POST['kullanici_adsoyad'],
		'kullanici_il' => $_POST['kullanici_il'],
		'kullanici_ilce' => $_POST['kullanici_ilce'],
		'kullanici_password' => $_POST['kullanici_password'],
		'kullanici_adres'=> $_POST['kullanici_adres']
	));


	if ($update) {

		Header("Location:../../hesabim.php?durum=ok");

	} else {

		Header("Location:../../hesabim.php?durum=no");
	}

}


if (isset($_POST['kullanicikaydet'])) {

	
	echo $kullanici_adsoyad=htmlspecialchars($_POST['kullanici_adsoyad']); echo "<br>";
	echo $kullanici_gsm=htmlspecialchars($_POST['kullanici_gsm']); echo "<br>";
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); echo "<br>";

	echo $kullanici_passwordone=$_POST['kullanici_passwordone']; echo "<br>";
	echo $kullanici_passwordtwo=$_POST['kullanici_passwordtwo']; echo "<br>";


	if ($kullanici_passwordone==$kullanici_passwordtwo) {

		if (strlen($kullanici_passwordone)>=6) {

			$kullanicisor=$db->prepare("select * from kullanici where kullanici_mail=:mail");
			$kullanicisor->execute(array(
				'mail' => $kullanici_mail
			));

			//dönen satır sayısını belirtir
			$say=$kullanicisor->rowCount();



			if ($say==0) {

				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;

			//Kullanıcı kayıt işlemi yapılıyor...
				$kullanicikaydet=$db->prepare("INSERT INTO kullanici SET
					kullanici_adsoyad=:kullanici_adsoyad,
					kullanici_gsm=:kullanici_gsm,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_adsoyad' => $kullanici_adsoyad,
					'kullanici_gsm' => $kullanici_gsm,
					'kullanici_mail' => $kullanici_mail,
					'kullanici_password' => $password,
					'kullanici_yetki' => $kullanici_yetki
				));

				if ($insert) {


					header("Location:../../basarili.php?durum=loginbasarili");


				//Header("Location:../app/genel-ayarlar.php?durum=ok");

				} else {


					header("Location:../../basarili.php?durum=basarisiz");
				}

			} else {

				header("Location:../../register.php?durum=mukerrerkayit");



			}

		} else {


			header("Location:../../register.php?durum=eksiksifre");


		}



	} else {



		header("Location:../../register.php?durum=farklisifre");
	}
	


}

//KATEGORİ ve ÜRÜN 

if (isset($_POST['kategori_logoduzenle'])) {

	$uploads_dir = '../../dimg';
	@$tmp_name = $_FILES['kategori_logo']["tmp_name"];
	@$name = $_FILES['kategori_logo']["name"];
	$benzersizsayi4=rand(20000,32000);
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

	$duzenle=$db->prepare("UPDATE kategori SET
		kategori_logo=:logo
		WHERE kategori_id={$_POST['kategori_id']}");
	$update=$duzenle->execute(array(
		'logo' => $refimgyol
	));



	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../app/kategori.php?durum=ok");

	} else {

		Header("Location:../app/kategori.php?durum=no");
	}

}



if (isset($_POST['kategoriduzenle'])) {

	$kategori_id=$_POST['kategori_id'];
	$kategori_seourl=seo($_POST['kategori_ad']);


	$kaydet=$db->prepare("UPDATE kategori SET
		kategori_ad=:ad,
		kategori_durum=:kategori_durum,	
		kategori_seourl=:seourl,
		kategori_sira=:sira
		WHERE kategori_id={$_POST['kategori_id']}");
	$update=$kaydet->execute(array(
		'ad' => $_POST['kategori_ad'],
		'kategori_durum' => $_POST['kategori_durum'],
		'seourl' => $kategori_seourl,
		'sira' => $_POST['kategori_sira']
	));

	if ($update) {

		Header("Location:../app/kategori-duzenle.php?durum=ok&kategori_id=$kategori_id");

	} else {

		Header("Location:../app/kategori-duzenle.php?durum=no&kategori_id=$kategori_id");
	}

}


if (isset($_POST['kategoriekle'])) {

	$uploads_dir = '../../dimg/kategori';
	@$tmp_name = $_FILES['kategori_resimyol']["tmp_name"];
	@$name = $_FILES['kategori_resimyol']["name"];
	$benzersizsayi1=rand(2000,3200);
	$benzersizsayi2=rand(2000,3200);
	$benzersizsayi4=rand(2000,3200);
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$kategori_seourl=seo($_POST['kategori_ad']);

	$kaydet=$db->prepare("INSERT INTO kategori SET
		kategori_ad=:ad,
		kategori_durum=:kategori_durum,	
		kategori_seourl=:seourl,
		kategori_sira=:sira");
	$insert=$kaydet->execute(array(
		'ad' => $_POST['kategori_ad'],
		'kategori_durum' => $_POST['kategori_durum'],
		'seourl' => $kategori_seourl,
		'sira' => $_POST['kategori_sira']	
	));

	if ($insert) {

		Header("Location:../app/kategori.php?durum=ok");

	} else {

		Header("Location:../app/kategori.php?durum=no");
	}

}



if ($_GET['kategorisil']=="ok") {

	$sil=$db->prepare("DELETE from kategori where kategori_id=:kategori_id");
	$kontrol=$sil->execute(array(
		'kategori_id' => $_GET['kategori_id']
	));

	if ($kontrol) {

		Header("Location:../app/kategori.php?durum=ok");

	} else {

		Header("Location:../app/kategori.php?durum=no");
	}

}

if ($_GET['urunsil']=="ok") {

	$sil=$db->prepare("DELETE from urun where urun_id=:urun_id");
	$kontrol=$sil->execute(array(
		'urun_id' => $_GET['urun_id']
	));

	if ($kontrol) {

		Header("Location:../app/urun.php?durum=ok");

	} else {

		Header("Location:../app/urun.php?durum=no");
	}

}



if (isset($_POST['urunekle'])) {

	$urun_seourl=seo($_POST['urun_ad']);

	$kaydet=$db->prepare("INSERT INTO urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_durum=:urun_durum,	
		urun_seourl=:seourl		
		");
	$insert=$kaydet->execute(array(
		'kategori_id' => $_POST['kategori_id'],
		'urun_ad' => $_POST['urun_ad'],
		'urun_detay' => $_POST['urun_detay'],
		'urun_durum' => $_POST['urun_durum'],
		'seourl' => $urun_seourl

	));

	if ($insert) {

		Header("Location:../app/urun.php?durum=ok");

	} else {

		Header("Location:../app/urun.php?durum=no");
	}

}

if (isset($_POST['urunduzenle'])) {

	$urun_id=$_POST['urun_id'];
	$urun_seourl=seo($_POST['urun_ad']);

	$kaydet=$db->prepare("UPDATE urun SET
		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_durum=:urun_durum,
		urun_seourl=:seourl		
		WHERE urun_id={$_POST['urun_id']}");
	$update=$kaydet->execute(array(
		'kategori_id' => $_POST['kategori_id'],
		'urun_ad' => $_POST['urun_ad'],
		'urun_detay' => $_POST['urun_detay'],
		'urun_durum' => $_POST['urun_durum'],
		'seourl' => $urun_seourl

	));

	if ($update) {

		Header("Location:../app/urun-duzenle.php?durum=ok&urun_id=$urun_id");

	} else {

		Header("Location:../app/urun-duzenle.php?durum=no&urun_id=$urun_id");
	}

}

if(isset($_POST['urunfotosil'])) {

	$urun_id=$_POST['urun_id'];


	echo $checklist = $_POST['urunfotosec'];


	foreach($checklist as $list) {

		$sil=$db->prepare("DELETE from urunfoto where urunfoto_id=:urunfoto_id");
		$kontrol=$sil->execute(array(
			'urunfoto_id' => $list
		));
	}

	if ($kontrol) {

		Header("Location:../app/urun-galeri.php?urun_id=$urun_id&durum=ok");

	} else {

		Header("Location:../app/urun-galeri.php?urun_id=$urun_id&durum=no");
	}


} 

// YÖNETİCİ YORUM PANEL

if (isset($_POST['yorumkaydet'])) {


	$ayarekle=$db->prepare("INSERT INTO yorumlar SET
		adsoyad=:adsoyad,
		email=:email,
		gsm=:gsm,
		konu=:konu,
		kullanici_id=:kullanici_id,
		yorum_detay=:yorum_detay

		");

	$insert=$ayarekle->execute(array(
		'adsoyad'=>htmlspecialchars($_POST['adsoyad']),
		'email'=>htmlspecialchars($_POST['email']),
		'gsm'=>htmlspecialchars($_POST['gsm']),
		'konu'=>htmlspecialchars($_POST['konu']),
		'kullanici_id' => $_POST['kullanici_id'],
		'yorum_detay' => htmlspecialchars($_POST['yorum_detay'])

	));


	if ($insert) {

		Header("Location:../../iletisim.php?durum=ok");

	} else {

		Header("Location:../../iletisim.php?durum=no");
	}

}


if ($_GET['yorumsil']=="ok"){

	$sil=$db->prepare("DELETE FROM yorumlar WHERE yorum_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['yorum_id']
	));

	if ($kontrol) {
		header("Location:../app/yorum.php?sil=ok");
	}else{
		header("Location:../app/yorum.php?sil=no");
	}
}


// ALAN BİR ve ALAN İKİ KAYDET İŞLEMLERİ

if (isset($_POST['genelkategorikaydet'])) {

	$kategorikaydet=$db->prepare("UPDATE kategori SET
		kategori_baslik=:baslik,
		kategori_detay=:detay
		WHERE kategori_id=0");
	$update=$kategorikaydet->execute(array(
		'baslik' => $_POST['kategori_baslik'],
		'detay' => $_POST['kategori_detay']
	));

	if ($update) {

		Header("Location:../app/alan_bir.php?durum=ok");

	} else {

		Header("Location:../app/alan_bir.php?durum=no");
	}

}

if (isset($_POST['genelalanbirkaydet'])) {

	$alanbirkaydet=$db->prepare("UPDATE alanbir SET
		alanbir_baslik=:baslik,
		alanbir_detay=:detay,
		alanbir_detay3=:detay3,
		alanbir_detay4=:detay4,
		alanbir_detay5=:detay5,
		alanbir_detay6=:detay6
		WHERE alanbir_id=0");
	$update=$alanbirkaydet->execute(array(
		'baslik' => $_POST['alanbir_baslik'],
		'detay' => $_POST['alanbir_detay'],
		'detay3' => $_POST['alanbir_detay3'],
		'detay4' => $_POST['alanbir_detay4'],
		'detay5' => $_POST['alanbir_detay5'],
		'detay6' => $_POST['alanbir_detay6']
	));

	if ($update) {

		Header("Location:../app/alan_bir.php?durum=ok");

	} else {

		Header("Location:../app/alan_bir.php?durum=no");
	}

}


if (isset($_POST['genelalanikikaydet'])) {

	$alanikikaydet=$db->prepare("UPDATE alaniki SET
		alaniki_baslik=:baslik,
		alaniki_detay=:detay,
		alaniki_detay3=:detay3,
		alaniki_detay4=:detay4,
		alaniki_detay5=:detay5,
		alaniki_detay6=:detay6
		WHERE alaniki_id=0");
	$update=$alanikikaydet->execute(array(
		'baslik' => $_POST['alaniki_baslik'],
		'detay' => $_POST['alaniki_detay'],
		'detay3' => $_POST['alaniki_detay3'],
		'detay4' => $_POST['alaniki_detay4'],
		'detay5' => $_POST['alaniki_detay5'],
		'detay6' => $_POST['alaniki_detay6']
	));

	if ($update) {

		Header("Location:../app/alan_bir.php?durum=ok");

	} else {

		Header("Location:../app/alan_bir.php?durum=no");
	}

}


//Sipariş İşlemleri


if (isset($_POST['sepetekle'])) {


	$ayarekle=$db->prepare("INSERT INTO sepet SET
		kullanici_id=:kullanici_id,
		urun_id=:urun_id	
		
		");

	$insert=$ayarekle->execute(array(
		'kullanici_id' => $_POST['kullanici_id'],
		'urun_id' => $_POST['urun_id']
		
	));


	if ($insert) {

		Header("Location:../../sepet?durum=ok");

	} else {

		Header("Location:../../sepet?durum=no");
	}

}



if (isset($_POST['bankasiparisekle'])) {


	$siparis_tip="Banka Havalesi";


	$kaydet=$db->prepare("INSERT INTO siparis SET
		kullanici_id=:kullanici_id,
		siparis_tip=:siparis_tip,	
		siparis_banka=:siparis_banka,
		siparis_toplam=:siparis_toplam
		");
	$insert=$kaydet->execute(array(
		'kullanici_id' => $_POST['kullanici_id'],
		'siparis_tip' => $siparis_tip,
		'siparis_banka' => $_POST['siparis_banka'],
		'siparis_toplam' => $_POST['siparis_toplam']		
	));

	if ($insert) {

		//Sipariş başarılı kaydedilirse...

		echo $siparis_id = $db->lastInsertId();

		echo "<hr>";


		$kullanici_id=$_POST['kullanici_id'];
		$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
		$sepetsor->execute(array(
			'id' => $kullanici_id
		));

		while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {

			$urun_id=$sepetcek['urun_id']; 
			$urun_adet=$sepetcek['urun_adet'];

			$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:id");
			$urunsor->execute(array(
				'id' => $urun_id
			));

			$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
			
			echo $urun_fiyat=$uruncek['urun_fiyat'];


			
			$kaydet=$db->prepare("INSERT INTO siparis_detay SET
				
				siparis_id=:siparis_id,
				urun_id=:urun_id,	
				urun_fiyat=:urun_fiyat,
				urun_adet=:urun_adet
				");
			$insert=$kaydet->execute(array(
				'siparis_id' => $siparis_id,
				'urun_id' => $urun_id,
				'urun_fiyat' => $urun_fiyat,
				'urun_adet' => $urun_adet

			));


		}

		if ($insert) {

			

			//Sipariş detay kayıtta başarıysa sepeti boşalt

			$sil=$db->prepare("DELETE from sepet where kullanici_id=:kullanici_id");
			$kontrol=$sil->execute(array(
				'kullanici_id' => $kullanici_id
			));

			
			Header("Location:../../siparislerim?durum=ok");
			exit;


		}

		




	} else {

		echo "başarısız";

		//Header("Location:../production/siparis.php?durum=no");
	}



}

?>


