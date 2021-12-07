<?php if( !defined("SABIT") ){ exit; }

if($def['urunkategori']=="aktif"){
		if($def['urundetaytema'] =="small") {
			include "include/modules/urunler/detay/kat/urun.php";
		}elseif($def['urundetaytema'] == "full"){	
			include "include/modules/urunler/detay/kat/urunv2.php";
		}elseif($def['urundetaytema'] == "nosidebar"){
			include "include/modules/urunler/detay/kat/nosidebarurun.php";
		} 
}else{
	if($def['urundetaytema'] =="small") {
			include "include/modules/urunler/detay/unkat/urun.php";
		}elseif($def['urundetaytema'] == "full"){	
			include "include/modules/urunler/detay/unkat/urunv2.php";
		}elseif($def['urundetaytema'] == "nosidebar"){
			include "include/modules/urunler/detay//unkat/nosidebarurun.php";
		} 	
	
}

	
?>
