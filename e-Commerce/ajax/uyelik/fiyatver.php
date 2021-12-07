<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}

$bastarih = clean($_POST["bastarih"]);
$bittarih = clean($_POST["bittarih"]);
$fiyat    = clean($_POST["urunfiyat"]);

$tarih1	   = new DateTime($bastarih);
$tarih2	   = new DateTime($bittarih);
$interval  = $tarih1->diff($tarih2);

//echo $interval->format('%a');


$geridonus =  $fiyat * $interval->format('%a');
if($interval->format('%a') == 0 ){
	echo $fiyat;
}else{ 
    echo number_format($geridonus,2) ;
}


	//$kontrol = $conn -> query("select * from fiyatalarm where user_id = ".$_SESSION["m_id"]." && urun_id = ".intval($urunid))->fetch();	



?>