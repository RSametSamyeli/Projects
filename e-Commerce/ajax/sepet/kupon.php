<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}


$kuponkod     = clean($_POST["kuponkod"]);
$urunids      = filter_input(INPUT_POST, 'urunids', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$kats  		  = filter_input(INPUT_POST, 'kats', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
$sepettoplam  = clean($_POST["sepettoplam"]);
$sepettoplam = str_replace(",","",$sepettoplam);
if(!isset($kuponkod) || !isset($kats) || !isset($urunids) || !isset($sepettoplam) ) { exit;}
if(empty($kuponkod)){
	 echo 'Kupon Kodu Boş Olamaz';
	 exit;
}else{
	$kuponVarmi = $conn -> query("select * from kuponlar where durum = 1  && kod = ".intval($kuponkod))->fetch();
	if(!$kuponVarmi){
		echo 'Kupon Bulunamadı';
		exit;
	}
	$kuponid    	  = $kuponVarmi['id'];   
	$indirimtipi	  = $kuponVarmi['indirimtipi'];
	$tutar      	  = $kuponVarmi['tutar'];
	$baslangic  	  = $kuponVarmi['baslangic'];
	$bitis      	  = $kuponVarmi['bitis'];
	$uyemaxkullanim   = $kuponVarmi['uyemaxkullanim'];
	$kuponmaxkullanim = $kuponVarmi['kuponmaxkullanim'];

	$sepetlimit       = $kuponVarmi['sepettoplam'];
	$kuponkodu        = $kuponVarmi['kod'];
	function kuponekle(){
		global $kuponkod;
		global $conn;
		global $indirimtipi; 
		global $tutar;
		global $kuponid;
		global $uyemaxkullanim;
		global $kuponmaxkullanim ;
		global $sepettoplam; 
		global $sepetlimit;
		global $kuponkodu;
		$toplamKupon = $conn -> query("select * from kupongecmisi");
		$toplamuyeKupon = $conn -> query("select * from kupongecmisi  where kuponid = ".$kuponid." and userid = ".intval($_SESSION["m_id"]));
		
		$toplamKuponSayi = $toplamKupon->rowCount();
		
		if($toplamKuponSayi > $kuponmaxkullanim) {
			echo 'Kupon Oluşturma Limiti Dolmuştur';
			exit;
		} 
		if( $uyemaxkullanim <= $toplamuyeKupon->rowCount()){
			echo 'Kupon Oluşturma Limitiniz Dolmuştur';
			exit;
		}
		if($sepettoplam < $sepetlimit ){
			$ek = $sepetlimit - $sepettoplam;
			echo 'Bu Kuponu Kullanabilmek için Minumum '.$ek.' TL Değerinde Ürün Ekleyin ';
			exit;
		}
			if($indirimtipi == 1){
				/* Yüzde */
				$birimfiyat = ($sepettoplam * $tutar) / 100;
				$birimfiyat =  number_format($birimfiyat,2);
			}else{	
				$birimfiyat  = $tutar;
			}

	
		$ekle = $conn -> prepare("INSERT INTO kupongecmisi SET 
		 userid 	 = :userid,
		 kuponid	 = :kuponid,
		 tarih 	     = :tarih,
		 indirimtipi = :indirimtipi,
		 durum		 = :durum,
		 tutar       = :tutar,
		 kuponkod	 = :kuponkod	
		 ");
		$ekle-> execute(array(
			"userid" 	=> intval($_SESSION["m_id"]),
			"kuponid"	=> intval($kuponid),
			"tarih"		=> time(),
			"indirimtipi" => $indirimtipi,
			"durum"		  => 1,		
			"tutar"		  => $birimfiyat,
			"kuponkod"	  => $kuponkodu	
		));	
		if($ekle){	
			echo 'done|x|Kupon Kodu Uygulandı|x|'.$birimfiyat.'|x|'.$conn ->lastInsertId();
		}else{
			echo 'Veritabanı Kayıt Sırasında Sorun Oluştu';
		}
		
	}
	
		if($indirimtipi == 1){
			/* Yüzde */
			$birimfiyat      = ($sepettoplam * $tutar) / 100;
			$birimfiyat      =  number_format($birimfiyat,2);
		}else{	
			$birimfiyat  = $tutar;
		}	
		
			
	/****** Kupon Eşleşme Kontrolü  *****/
	if($kuponkod == $kuponVarmi["kod"]) {
		    
			/**** Üye Varmı  *****/
		
			if(!isset($_SESSION["m_oturum"])){
				echo 'Lütfen Giriş Yapın yada Üye Olun';
				exit;
			}else{
			
				/*** Tarih Önceliği ***/
				if( $bitis <   date('Y-m-d') ) {
					echo 'Bu Kuponun Geçerlilik Tarihi Bitmiştir';
				}elseif( $baslangic >   date('Y-m-d') ){
					echo 'Bu Kuponun Geçerliliği Daha Başlamamıştır';
				}else{
					/** Kategori Önceliği **/
					if(empty($kuponVarmi['katsid'])){
						/*** Üye Kontrol ***/
							if($kuponVarmi['userid'] != 0){
								/* Üyeye Özel Kupon */
								if($kuponVarmi['userid'] == $_SESSION["m_id"]){
									kuponekle();
									exit;
								}else{
									echo 'Bu Kupon Belirlenen Kişiler İçindir';
									exit;
								}
							} else{
								/* Herkeze Açık*/
								kuponekle();
								exit;
							}
					}else{
						$kats     = explode(',',$kats);
						$urunids  = explode(',',$urunids);
						$katsArr  = explode(',',$kuponVarmi['katsid']);
						$kullanabilirlik = true;
						for($i = 0; $i < count($kats); $i++){
							/** Ürün Belirtme**/
							if(!in_array($kats[$i],$katsArr)){
								$urunSorgula = $conn -> query("select * from urun where id = ".intval($urunids[$i]))->fetch();
								$urunbaslik  = unserialize($urunSorgula['baslik']); 
								echo 'Bu Hediye Kuponu '.$urunbaslik['tr']." ürün için geçerli değildir.|x|refresh";
								$kullanabilirlik = false;
								exit;
							}
						}
						/*** Tamamsa ***/
						if($kullanabilirlik){
							/*** Üye Kontrol ***/
							if($kuponVarmi['userid'] != 0){
								/* Üyeye Özel Kupon */
								if($kuponVarmi['userid'] == $_SESSION["m_id"]){
									kuponekle();
									exit;
								}else{
									echo 'Bu Kupon Belirlenen Kişiler İçindir';
									exit;
								}
							} else{
								/* Herkeze Açık*/
								kuponekle();
								exit;
							}
						}
						
					}
				}
				
			}		

	}else{
		echo 'Kupon Bulunamadı';
		exit;
	}
}
	
?>