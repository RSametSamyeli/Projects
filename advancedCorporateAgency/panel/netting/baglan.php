<?php 


//kurumsal_veritabani == Veritabanı İsmi
//kullanici_adi == MySQL Kullanıcı Adınız
//sifre == Şifreniz

try {

	$db=new PDO("mysql:host=localhost;dbname=izbarco_ra;charset=utf8",'izbarco','PASSWORD');
	//echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}

 ?>
