<?php 


//kurumsal_veritabani == Veritabanı İsmi
//kullanici_adi == MySQL Kullanıcı Adınız
//sifre == Şifreniz

try {

	$db=new PDO("mysql:host=localhost;dbname=izbarco_kuafor;charset=utf8",'ID','PASSWORD');
	//echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}
