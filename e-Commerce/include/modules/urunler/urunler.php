<?php if( !defined("SABIT") ){ exit; }
if( (empty($get2)) || ( $get2 == $lang['yardimci']['sayfa'] ) ){  


	## With cat && without cat
	if($def['urunkategori'] == "pasif") { 
		include("include/modules/urunler/main/unkat/kategori.php");
	}else{
		include("include/modules/urunler/main/kat/kategori.php");
	}
	

}elseif((!empty($get2)) && ( $get2 != $lang['yardimci']['sayfa'] )){

	## With cat && without cat

	if($def['urunkategori'] == "pasif") { 
		include("include/modules/urunler/unkat/urunler.php");
	}else{
		include "include/modules/urunler/kat/urunler.php";
	}
	
}else{ 
	## With cat && without cat
	/*if($def['urunkategori'] == "pasif") { 
		include("include/modules/urunler/unkat/tekurunler.php");
	}else{
		include "include/modules/urunler/urunler.php";
	}
	*/
}

?>
