<?php 


//kurumsal_veritabani == Veritabanı İsmi
//kullanici_adi == MySQL Kullanıcı Adınız
//sifre == Şifreniz

try {

	$db=new PDO("mysql:host=localhost;dbname=izbarco_graptik;charset=utf8",'izbarco','Samy3li.32');
	//echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}

 ?>