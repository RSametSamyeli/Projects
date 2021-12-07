<?php if( !defined("SABIT") ){ exit; }
if( (empty($get2)) || ( $get2 == $lang['yardimci']['sayfa'] ) ){  
	

	## With cat && without cat
	if($def['blogkategori'] == "pasif") { 
		include("include/modules/blog/main/unkat/kategori.php");
		
	}else{
		include("include/modules/blog/main/kat/kategori.php");
	}
	

}elseif((!empty($get2)) && ( $get2 != $lang['yardimci']['sayfa'] )){

	## With cat && without cat

	if($def['blogkategori'] == "pasif") { 
		include("include/modules/blog/unkat/kategori.php");
	}else{
		include "include/modules/blog/kat/kategori.php";
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
