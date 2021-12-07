<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) { exit;}
if(!isset($_SESSION["m_oturum"])) exit;
$kredi     = clean($_POST["kredi"]);
$durum     = clean($_POST["durum"]);
if(!isset($kredi) || !isset($durum)) { exit; }

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }
$uyePuan = $uyebul['uye_kredi'];	
$done	 = 'done';


/* Sepet Kontrol  */
$genelToplam = 0;

if(isset($_SESSION["sepet"])){   
	foreach($_SESSION["sepet"] as $row){ 
		$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
		$varyant = $row['varyant'];
		/* varyant hesapla */
		if(count($varyant) > 0) {	 
			$varAra  	  = 0 ;
			$defvarPlus   = 0;
			$defvarMinus  = 0;
			for($i = 0; $i < count($varyant['varBaslik']); $i++) {
				$varTutar = $varyant['varTutar'][$i];
				$varTur   = $varyant['varTur'][$i];
				if($varTur == 1){
					$defvarPlus  += $varTutar;
					$varAra      = number_format($row['arafiyat'],2) + $defvarPlus;
				}
				if($varTur == 0){
					$defvarMinus  += $varTutar;
					$varAra  = number_format($row['arafiyat'],2) - $defvarMinus;
				}
			}
			$birimfiyat = number_format($varAra,2);
		} else {
			$birimfiyat = number_format($row['arafiyat'],2);
		}
		$genelToplam += $row['adet'] * $birimfiyat;
	}
}




## Bakiye büyüksa
if(number_format($genelToplam,2)  <= number_format($uyePuan,2) ) {
	$ilktutar  = $uyePuan  - number_format($genelToplam,2) ;
	$kalanPara = $uyePuan  - $ilktutar  ;
	if($durum == 1){
		$_SESSION["fs"]["kredi"]  =  number_format($kalanPara,2);	
	}else{
		unset($_SESSION["fs"]["kredi"]);
	}
	$done  = 'yonlendir';
}else{
	$kalanPara = $uyePuan;
	if($durum == 1){
		$_SESSION["fs"]["kredi"]  =  number_format($kalanPara,2);	
	}else{
		unset($_SESSION["fs"]["kredi"]);
	}
}

echo ''.$done.'|x|'.$durum.'|x|'.number_format($kalanPara,2).'|x|'.paraconvert($kredi)."|x|";	

?>
