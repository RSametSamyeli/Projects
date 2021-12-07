<?php if( !defined("SABIT") ){ exit; }
if( (empty($get2)) || ( $get2 == $lang['yardimci']['sayfa'] ) ){  
	

	## With cat && without cat
	if($def['hizmetkategori'] == "pasif") { 
		include("include/modules/hizmetler/unkat/kategorisiz.php");
	}else{
		include("include/modules/hizmetler/unkat/kategorisiz.php");
	}
	

}elseif((!empty($get2)) && ( $get2 != $lang['yardimci']['sayfa'] )){

	## With cat && without cat

	if($def['hizmetkategori'] == "pasif") { 
		include("include/modules/hizmetler/unkat/kategori.php");
	}else{
		include "include/modules/hizmetler/kat/kategori.php";
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
