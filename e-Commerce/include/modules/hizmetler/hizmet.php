<?php if( !defined("SABIT") ){ exit; }

if($def['hizmetkategori']=="aktif"){
	include "include/modules/hizmetler/detay/kat/detay.php";
}else{
	include "include/modules/hizmetler/detay/unkat/detay.php";
}

	
?>
