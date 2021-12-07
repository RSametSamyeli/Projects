<?php if( !defined("SABIT") ){ exit; }

if($def['blogkategori']=="aktif"){
	include "include/modules/blog/detay/kat/detay.php";
}else{
	include "include/modules/blog/detay/unkat/detay.php";
}

	
?>
